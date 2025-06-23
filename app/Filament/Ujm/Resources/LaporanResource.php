<?php

namespace App\Filament\Ujm\Resources;

use App\Filament\Ujm\Resources\LaporanResource\Pages;
use App\Models\Dokumen;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class LaporanResource extends Resource
{
    protected static ?string $model = Dokumen::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?string $navigationGroup = 'Evaluasi & Peningkatan';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Laporan & Evaluasi';

    protected static ?string $modelLabel = 'Laporan';

    protected static ?string $pluralModelLabel = 'Laporan';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Laporan')
                ->schema([
                    Forms\Components\TextInput::make('nama')->label('Nama Laporan')->required()->maxLength(255),

                    Forms\Components\Select::make('kategori')
                        ->label('Jenis Laporan')
                        ->options([
                            'laporan_ami' => 'Laporan Hasil AMI',
                            'laporan_survei' => 'Laporan Survei Kepuasan',
                            'analisis_capaian' => 'Analisis Data Capaian',
                            'rtl' => 'Rencana Tindak Lanjut',
                        ])
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(fn($state, Forms\Set $set) => $set('sub_kriteria', null)),

                    Forms\Components\Textarea::make('deskripsi')->label('Deskripsi')->rows(3),

                    Forms\Components\Select::make('sub_kriteria') // Changed from sub_kategori to sub_kriteria
                        ->label('Detail Kategori')
                        ->options(function (callable $get) {
                            return match ($get('kategori')) {
                                'laporan_ami' => [
                                    'ami_internal' => 'AMI Internal',
                                    'ami_eksternal' => 'AMI Eksternal',
                                ],
                                'laporan_survei' => [
                                    'kepuasan_mahasiswa' => 'Kepuasan Mahasiswa',
                                    'kepuasan_dosen' => 'Kepuasan Dosen',
                                    'kepuasan_alumni' => 'Kepuasan Alumni',
                                    'kepuasan_pengguna' => 'Kepuasan Pengguna Lulusan',
                                ],
                                'analisis_capaian' => [
                                    'capaian_pembelajaran' => 'Capaian Pembelajaran',
                                    'capaian_penelitian' => 'Capaian Penelitian',
                                    'capaian_pengabdian' => 'Capaian Pengabdian',
                                ],
                                'rtl' => [
                                    'rtl_pembelajaran' => 'RTL Pembelajaran',
                                    'rtl_penelitian' => 'RTL Penelitian',
                                    'rtl_pengabdian' => 'RTL Pengabdian',
                                    'rtl_tata_kelola' => 'RTL Tata Kelola',
                                ],
                                default => [],
                            };
                        })
                        ->visible(fn(callable $get) => filled($get('kategori')))
                        ->searchable(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Upload Dokumen')->schema([
                Forms\Components\FileUpload::make('path')
                    ->label('File Laporan')
                    ->directory(function (callable $get) {
                        $kategori = $get('kategori') ?? 'laporan';
                        $prodi = Auth::user()->programStudi?->kode ?? 'default';
                        return "laporan/{$prodi}/{$kategori}";
                    })
                    ->acceptedFileTypes(['application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                    ->maxSize(20480) // 20MB
                    ->required()
                    ->downloadable()
                    ->previewable(),
            ]),

            Forms\Components\Section::make('Informasi Tambahan')
                ->schema([
                    Forms\Components\Select::make('kriteria')
                        ->label('Periode')
                        ->options([
                            'semester_ganjil ' . date('Y') => 'Semester Ganjil ' . date('Y'),
                            'semester_genap ' . date('Y') => 'Semester Genap ' . date('Y'),
                            'tahunan_' . date('Y') => 'Tahunan ' . date('Y'),
                            'triwulan_1_' . date('Y') => 'Triwulan 1 ' . date('Y'),
                            'triwulan_2_' . date('Y') => 'Triwulan 2 ' . date('Y'),
                            'triwulan_3_' . date('Y') => 'Triwulan 3 ' . date('Y'),
                            'triwulan_4_' . date('Y') => 'Triwulan 4 ' . date('Y'),
                        ])
                        ->searchable(),

                    Forms\Components\Textarea::make('catatan')->label('Temuan & Rekomendasi')->rows(4)->helperText('Format: TEMUAN: [isi temuan] | REKOMENDASI: [isi rekomendasi]')->columnSpanFull(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Pengaturan')
                ->schema([Forms\Components\Toggle::make('is_visible_to_asesor')->label('Visible to Asesor')->helperText('Centang untuk mengizinkan asesor melihat laporan ini')->default(false), Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true)])
                ->columns(2),

            // Hidden fields
            Forms\Components\Hidden::make('tipe')->default('file'),

            Forms\Components\Hidden::make('level')->default('prodi'),

            Forms\Components\Hidden::make('program_studi_id')->default(fn() => Auth::user()->program_studi_id),

            Forms\Components\Hidden::make('user_id')->default(fn() => Auth::id()),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')->label('Nama Laporan')->searchable()->sortable()->limit(50),

                Tables\Columns\BadgeColumn::make('kategori')
                    ->label('Jenis')
                    ->formatStateUsing(
                        fn(string $state): string => match ($state) {
                            'laporan_ami' => 'Laporan AMI',
                            'laporan_survei' => 'Survei Kepuasan',
                            'analisis_capaian' => 'Analisis Capaian',
                            'rtl' => 'RTL',
                            default => ucwords(str_replace('_', ' ', $state)),
                        },
                    )
                    ->color(
                        fn(string $state): string => match ($state) {
                            'laporan_ami' => 'primary',
                            'laporan_survei' => 'success',
                            'analisis_capaian' => 'warning',
                            'rtl' => 'danger',
                            default => 'gray',
                        },
                    ),

                Tables\Columns\TextColumn::make('sub_kriteria') // Changed from sub_kategori
                    ->label('Detail')
                    ->formatStateUsing(fn(?string $state): string => $state ? ucwords(str_replace('_', ' ', $state)) : '-')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('kriteria')->label('Periode')->toggleable(),

                Tables\Columns\IconColumn::make('is_visible_to_asesor')->label('Visible')->boolean(),

                Tables\Columns\TextColumn::make('created_at')->label('Tanggal Upload')->dateTime('d M Y')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->label('Jenis Laporan')
                    ->options([
                        'laporan_ami' => 'Laporan AMI',
                        'laporan_survei' => 'Survei Kepuasan',
                        'analisis_capaian' => 'Analisis Capaian',
                        'rtl' => 'RTL',
                    ]),

                Tables\Filters\TernaryFilter::make('is_visible_to_asesor')->label('Visible to Asesor'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('download')
                    ->label('Download')
                    ->action(function (Dokumen $record) {
                        return response()->download(storage_path('app/public/' . $record->path));
                    })
                    ->color('success'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])])
            ->defaultSort('created_at', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('level', 'prodi')
            ->where('program_studi_id', Auth::user()->program_studi_id)
            ->whereIn('kategori', ['laporan_ami', 'laporan_survei', 'analisis_capaian', 'rtl']);
    }

    public static function getRelations(): array
    {
        return [
                //
            ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLaporans::route('/'),
            'create' => Pages\CreateLaporan::route('/create'),
            'edit' => Pages\EditLaporan::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()->count();
    }
}
