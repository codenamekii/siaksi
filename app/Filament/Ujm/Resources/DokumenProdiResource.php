<?php

namespace App\Filament\Ujm\Resources;

use App\Filament\Ujm\Resources\DokumenProdiResource\Pages;
use App\Models\Dokumen;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class DokumenProdiResource extends Resource
{
    protected static ?string $model = Dokumen::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Dokumen Mutu';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Dokumen Mutu Prodi';

    protected static ?string $modelLabel = 'Dokumen Mutu';

    protected static ?string $pluralModelLabel = 'Dokumen Mutu';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Dokumen')
                ->schema([
                    Forms\Components\TextInput::make('nama')->label('Nama Dokumen')->required()->maxLength(255),

                    Forms\Components\Textarea::make('deskripsi')->label('Deskripsi')->rows(3),

                    Forms\Components\Select::make('kategori')
                        ->label('Kategori')
                        ->options([
                            'kebijakan_mutu' => 'Kebijakan Mutu',
                            'standar_mutu' => 'Standar Mutu',
                            'manual_mutu' => 'Manual Mutu',
                            'prosedur_mutu' => 'Prosedur Mutu',
                            'instruksi_kerja' => 'Instruksi Kerja',
                            'formulir' => 'Formulir',
                            'laporan_ami' => 'Laporan AMI',
                            'laporan_survei' => 'Laporan Survei',
                            'evaluasi_diri' => 'Evaluasi Diri',
                            'lkps' => 'LKPS',
                            'sertifikat_akreditasi' => 'Sertifikat Akreditasi',
                            'data_pendukung' => 'Data Pendukung',
                            'kurikulum' => 'Kurikulum',
                            'lainnya' => 'Lainnya',
                        ])
                        ->required()
                        ->searchable(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Upload Dokumen')->schema([
                Forms\Components\Radio::make('tipe')
                    ->label('Tipe Dokumen')
                    ->options([
                        'file' => 'Upload File',
                        'link' => 'Link/URL', // Changed from 'url' to 'link'
                    ])
                    ->default('file')
                    ->required()
                    ->reactive(),

                Forms\Components\FileUpload::make('path')
                    ->label('File')
                    ->directory('dokumen/prodi/' . (Auth::user()->program_studi_id ?? 'default'))
                    ->acceptedFileTypes(['application/pdf', 'image/*'])
                    ->maxSize(10240) // 10MB
                    ->required(fn(callable $get) => $get('tipe') === 'file')
                    ->visible(fn(callable $get) => $get('tipe') === 'file')
                    ->downloadable()
                    ->previewable(),

                Forms\Components\TextInput::make('url')
                    ->label('URL')
                    ->url()
                    ->required(fn(callable $get) => $get('tipe') === 'link') // Changed
                    ->visible(fn(callable $get) => $get('tipe') === 'link') // Changed
                    ->placeholder('https://example.com/dokumen.pdf'),
            ]),

            Forms\Components\Section::make('Kriteria Akreditasi')
                ->schema([
                    Forms\Components\Select::make('kriteria')
                        ->label('Kriteria')
                        ->options([
                            'Visi, Misi, Tujuan dan Strategi' => 'Visi, Misi, Tujuan dan Strategi',
                            'Tata Pamong, Tata Kelola dan Kerjasama' => 'Tata Pamong, Tata Kelola dan Kerjasama',
                            'Mahasiswa' => 'Mahasiswa',
                            'Sumber Daya Manusia' => 'Sumber Daya Manusia',
                            'Keuangan, Sarana dan Prasarana' => 'Keuangan, Sarana dan Prasarana',
                            'Pendidikan' => 'Pendidikan',
                            'Penelitian' => 'Penelitian',
                            'Pengabdian kepada Masyarakat' => 'Pengabdian kepada Masyarakat',
                            'Luaran dan Capaian Tridharma' => 'Luaran dan Capaian Tridharma',
                            'Lainnya' => 'Lainnya',
                        ])
                        ->searchable(),

                    Forms\Components\TextInput::make('sub_kriteria')->label('Sub Kriteria')->maxLength(255),

                    Forms\Components\Textarea::make('catatan')->label('Catatan')->rows(3)->columnSpan(2),
                ])
                ->columns(2),

            Forms\Components\Section::make('Pengaturan')
                ->schema([Forms\Components\Toggle::make('is_visible_to_asesor')->label('Visible to Asesor')->helperText('Centang untuk mengizinkan asesor melihat dokumen ini')->default(false), Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true)])
                ->columns(2),

            // Hidden fields
            Forms\Components\Hidden::make('level')->default('prodi'),

            Forms\Components\Hidden::make('program_studi_id')->default(fn() => Auth::user()->program_studi_id),

            Forms\Components\Hidden::make('user_id')->default(fn() => Auth::id()),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')->label('Nama Dokumen')->searchable()->sortable(),

                Tables\Columns\BadgeColumn::make('kategori')->label('Kategori')->formatStateUsing(fn(string $state): string => ucwords(str_replace('_', ' ', $state))),

                Tables\Columns\IconColumn::make('tipe')->label('Tipe')->icon(
                    fn(string $state): string => match ($state) {
                        'file' => 'heroicon-o-document',
                        'link' => 'heroicon-o-link',
                        'url' => 'heroicon-o-link',
                        default => 'heroicon-o-document',
                    },
                ),

                Tables\Columns\TextColumn::make('kriteria')->label('Kriteria')->limit(30)->toggleable(),

                Tables\Columns\ToggleColumn::make('is_visible_to_asesor')->label('Visible to Asesor'),

                Tables\Columns\ToggleColumn::make('is_active')->label('Aktif'),

                Tables\Columns\TextColumn::make('created_at')->label('Tanggal Upload')->dateTime('d M Y H:i')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->label('Kategori')
                    ->options([
                        'kebijakan_mutu' => 'Kebijakan Mutu',
                        'standar_mutu' => 'Standar Mutu',
                        'manual_mutu' => 'Manual Mutu',
                        'prosedur_mutu' => 'Prosedur Mutu',
                        'instruksi_kerja' => 'Instruksi Kerja',
                        'formulir' => 'Formulir',
                        'laporan_ami' => 'Laporan AMI',
                        'laporan_survei' => 'Laporan Survei',
                        'evaluasi_diri' => 'Evaluasi Diri',
                        'lkps' => 'LKPS',
                        'sertifikat_akreditasi' => 'Sertifikat Akreditasi',
                        'data_pendukung' => 'Data Pendukung',
                        'kurikulum' => 'Kurikulum',
                    ])
                    ->multiple(),

                Tables\Filters\SelectFilter::make('tipe')
                    ->label('Tipe')
                    ->options([
                        'file' => 'File',
                        'link' => 'Link/URL', // Changed
                    ]),

                Tables\Filters\TernaryFilter::make('is_visible_to_asesor')->label('Visible to Asesor'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('download')
                    ->label('Download/Buka')
                    ->action(function (Dokumen $record) {
                        if ($record->tipe === 'link' || $record->tipe === 'url') {
                            return redirect($record->url ?? $record->path);
                        }

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
            ->where('program_studi_id', Auth::user()->program_studi_id);
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
            'index' => Pages\ListDokumenProdis::route('/'),
            'create' => Pages\CreateDokumenProdi::route('/create'),
            'edit' => Pages\EditDokumenProdi::route('/{record}/edit'),
        ];
    }
}
