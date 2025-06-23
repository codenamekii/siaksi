<?php

namespace App\Filament\Gjm\Resources;

use App\Filament\Gjm\Resources\LaporanResource\Pages;
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

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static ?string $navigationGroup = 'Audit Mutu Internal';

    protected static ?int $navigationSort = 4;

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
                            'laporan_ami_fakultas' => 'Laporan AMI Fakultas',
                            'laporan_monev' => 'Laporan Monitoring & Evaluasi',
                            'laporan_kinerja_fakultas' => 'Laporan Kinerja Fakultas',
                            'analisis_mutu' => 'Analisis Mutu Fakultas',
                            'rtl_fakultas' => 'Rencana Tindak Lanjut Fakultas',
                            'laporan_survei_fakultas' => 'Laporan Survei Kepuasan',
                        ])
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(fn($state, Forms\Set $set) => $set('sub_kriteria', null)),

                    Forms\Components\Textarea::make('deskripsi')->label('Deskripsi')->rows(3),

                    Forms\Components\Select::make('sub_kriteria')
                        ->label('Detail Kategori')
                        ->options(function (callable $get) {
                            return match ($get('kategori')) {
                                'laporan_ami_fakultas' => [
                                    'ami_internal_fakultas' => 'AMI Internal Fakultas',
                                    'ami_eksternal_fakultas' => 'AMI Eksternal Fakultas',
                                    'ami_prodi' => 'Konsolidasi AMI Program Studi',
                                ],
                                'laporan_monev' => [
                                    'monev_pembelajaran' => 'Monev Pembelajaran',
                                    'monev_penelitian' => 'Monev Penelitian',
                                    'monev_pengabdian' => 'Monev Pengabdian',
                                    'monev_tata_kelola' => 'Monev Tata Kelola',
                                ],
                                'laporan_kinerja_fakultas' => [
                                    'kinerja_akademik' => 'Kinerja Akademik',
                                    'kinerja_non_akademik' => 'Kinerja Non-Akademik',
                                    'kinerja_sdm' => 'Kinerja SDM',
                                ],
                                'analisis_mutu' => [
                                    'analisis_standar' => 'Analisis Pencapaian Standar',
                                    'analisis_risiko' => 'Analisis Risiko Mutu',
                                    'analisis_kepuasan' => 'Analisis Kepuasan Stakeholder',
                                ],
                                'rtl_fakultas' => [
                                    'rtl_akademik' => 'RTL Bidang Akademik',
                                    'rtl_penelitian' => 'RTL Bidang Penelitian',
                                    'rtl_pengabdian' => 'RTL Bidang Pengabdian',
                                    'rtl_manajemen' => 'RTL Manajemen Fakultas',
                                ],
                                'laporan_survei_fakultas' => [
                                    'survei_mahasiswa' => 'Survei Kepuasan Mahasiswa',
                                    'survei_dosen' => 'Survei Kepuasan Dosen',
                                    'survei_tendik' => 'Survei Kepuasan Tendik',
                                    'survei_pengguna' => 'Survei Pengguna Lulusan',
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
                        $fakultas = Auth::user()->fakultas?->kode ?? 'fakultas';
                        return "laporan/{$fakultas}/{$kategori}";
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
                            'semester_ganjil_' . date('Y') => 'Semester Ganjil ' . date('Y'),
                            'semester_genap_' . date('Y') => 'Semester Genap ' . date('Y'),
                            'tahunan_' . date('Y') => 'Tahunan ' . date('Y'),
                            'triwulan_1_' . date('Y') => 'Triwulan 1 ' . date('Y'),
                            'triwulan_2_' . date('Y') => 'Triwulan 2 ' . date('Y'),
                            'triwulan_3_' . date('Y') => 'Triwulan 3 ' . date('Y'),
                            'triwulan_4_' . date('Y') => 'Triwulan 4 ' . date('Y'),
                        ])
                        ->searchable(),

                    Forms\Components\Select::make('program_studi_id')->label('Terkait Program Studi')->relationship('programStudi', 'nama', fn(Builder $query) => $query->where('fakultas_id', Auth::user()->fakultas_id))->preload()->searchable()->helperText('Pilih jika laporan terkait program studi tertentu'),

                    Forms\Components\Textarea::make('catatan')->label('Temuan & Rekomendasi')->rows(4)->helperText('Format: TEMUAN: [isi temuan] | REKOMENDASI: [isi rekomendasi]')->columnSpanFull(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Pengaturan')
                ->schema([Forms\Components\Toggle::make('is_visible_to_asesor')->label('Visible to Asesor')->helperText('Centang untuk mengizinkan asesor melihat laporan ini')->default(true), Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true)])
                ->columns(2),

            // Hidden fields
            Forms\Components\Hidden::make('tipe')->default('file'),
            Forms\Components\Hidden::make('level')->default('fakultas'),
            Forms\Components\Hidden::make('fakultas_id')->default(fn() => Auth::user()->fakultas_id),
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
                            'laporan_ami_fakultas' => 'AMI Fakultas',
                            'laporan_monev' => 'Monev',
                            'laporan_kinerja_fakultas' => 'Kinerja',
                            'analisis_mutu' => 'Analisis Mutu',
                            'rtl_fakultas' => 'RTL',
                            'laporan_survei_fakultas' => 'Survei',
                            default => ucwords(str_replace('_', ' ', $state)),
                        },
                    )
                    ->color(
                        fn(string $state): string => match ($state) {
                            'laporan_ami_fakultas' => 'primary',
                            'laporan_monev' => 'info',
                            'laporan_kinerja_fakultas' => 'success',
                            'analisis_mutu' => 'warning',
                            'rtl_fakultas' => 'danger',
                            'laporan_survei_fakultas' => 'gray',
                            default => 'gray',
                        },
                    ),

                Tables\Columns\TextColumn::make('sub_kriteria')->label('Detail')->formatStateUsing(fn(?string $state): string => $state ? ucwords(str_replace('_', ' ', $state)) : '-')->toggleable(),

                Tables\Columns\TextColumn::make('programStudi.nama')->label('Program Studi')->searchable()->sortable()->toggleable(),

                Tables\Columns\TextColumn::make('kriteria')->label('Periode')->toggleable(),

                Tables\Columns\IconColumn::make('is_visible_to_asesor')->label('Visible')->boolean(),

                Tables\Columns\TextColumn::make('user.name')->label('Diupload oleh')->toggleable(),

                Tables\Columns\TextColumn::make('created_at')->label('Tanggal Upload')->dateTime('d M Y')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->label('Jenis Laporan')
                    ->options([
                        'laporan_ami_fakultas' => 'AMI Fakultas',
                        'laporan_monev' => 'Monitoring & Evaluasi',
                        'laporan_kinerja_fakultas' => 'Kinerja Fakultas',
                        'analisis_mutu' => 'Analisis Mutu',
                        'rtl_fakultas' => 'RTL Fakultas',
                        'laporan_survei_fakultas' => 'Survei Kepuasan',
                    ]),

                Tables\Filters\SelectFilter::make('program_studi_id')->label('Program Studi')->relationship('programStudi', 'nama', fn(Builder $query) => $query->where('fakultas_id', Auth::user()->fakultas_id))->preload()->searchable(),

                Tables\Filters\TernaryFilter::make('is_visible_to_asesor')->label('Visible to Asesor'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function (Dokumen $record) {
                        return response()->download(storage_path('app/public/' . $record->path));
                    })
                    ->color('success'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('toggle_visibility')
                        ->label('Toggle Visibility')
                        ->icon('heroicon-o-eye')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->update([
                                    'is_visible_to_asesor' => !$record->is_visible_to_asesor,
                                ]);
                            }
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('level', 'fakultas')
            ->where('fakultas_id', Auth::user()->fakultas_id)
            ->whereIn('kategori', ['laporan_ami_fakultas', 'laporan_monev', 'laporan_kinerja_fakultas', 'analisis_mutu', 'rtl_fakultas', 'laporan_survei_fakultas']);
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
