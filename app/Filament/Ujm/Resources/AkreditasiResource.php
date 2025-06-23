<?php

namespace App\Filament\Ujm\Resources;

use App\Filament\Ujm\Resources\AkreditasiResource\Pages;
use App\Models\AkreditasiProdi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Get;
use Illuminate\Support\Facades\Auth;

class AkreditasiResource extends Resource
{
    protected static ?string $model = AkreditasiProdi::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationLabel = 'Status Akreditasi';

    protected static ?string $modelLabel = 'Akreditasi';

    protected static ?string $pluralModelLabel = 'Riwayat Akreditasi Program Studi';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Akreditasi';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Akreditasi')
                ->schema([
                    Forms\Components\Select::make('lembaga_akreditasi')
                        ->options([
                            'BAN-PT' => 'BAN-PT',
                            'LAM-Teknik' => 'LAM-Teknik',
                            'LAM-Infokom' => 'LAM-Infokom',
                            'Lainnya' => 'Lainnya',
                        ])
                        ->required()
                        ->searchable(),
                    Forms\Components\Select::make('status_akreditasi')
                        ->options([
                            'Unggul' => 'Unggul',
                            'Baik Sekali' => 'Baik Sekali',
                            'Baik' => 'Baik',
                            'A' => 'A',
                            'B' => 'B',
                            'C' => 'C',
                            'Tidak Terakreditasi' => 'Tidak Terakreditasi',
                        ])
                        ->required()
                        ->reactive(),
                    Forms\Components\TextInput::make('nomor_sk')->label('Nomor SK')->required()->maxLength(255)->placeholder('Contoh: 123/SK/BAN-PT/Ak/S/V/2024'),
                ])
                ->columns(2),

            Forms\Components\Section::make('Periode Akreditasi')
                ->schema([
                    Forms\Components\DatePicker::make('tanggal_akreditasi')
                        ->required()
                        ->native(false)
                        ->maxDate(now())
                        ->reactive()
                        ->afterStateUpdated(function (Get $get, Forms\Set $set) {
                            if ($get('tanggal_akreditasi')) {
                                $set('tanggal_berakhir', \Carbon\Carbon::parse($get('tanggal_akreditasi'))->addYears(5)->format('Y-m-d'));
                            }
                        }),
                    Forms\Components\DatePicker::make('tanggal_berakhir')->required()->native(false)->after('tanggal_akreditasi')->helperText('Biasanya 5 tahun setelah tanggal akreditasi'), 
                ])
                ->columns(3),

            Forms\Components\Section::make('Dokumen Pendukung')->schema([
                Forms\Components\FileUpload::make('sertifikat')
                    ->label('Sertifikat Akreditasi')
                    ->acceptedFileTypes(['application/pdf'])
                    ->directory(fn() => 'akreditasi/' . Auth::user()->programStudi?->kode)
                    ->maxSize(5120)
                    ->helperText('Upload file sertifikat akreditasi (PDF, Max 5MB)')
                    ->downloadable()
                    ->openable()
                    ->columnSpanFull(),
            ]),

            Forms\Components\Section::make('Status')->schema([Forms\Components\Toggle::make('is_active')->label('Akreditasi Aktif')->default(true)->helperText('Hanya satu akreditasi yang bisa aktif pada satu waktu'), Forms\Components\Hidden::make('program_studi_id')->default(fn() => Auth::user()->program_studi_id)->required()]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lembaga_akreditasi')->label('Lembaga')->searchable(),
                Tables\Columns\TextColumn::make('status_akreditasi')->label('Status')->badge()->color(
                    fn(string $state): string => match ($state) {
                        'Unggul', 'A' => 'success',
                        'Baik Sekali', 'B' => 'info',
                        'Baik', 'C' => 'warning',
                        default => 'gray',
                    },
                ),
                Tables\Columns\TextColumn::make('nomor_sk')->label('Nomor SK')->searchable()->limit(30)->tooltip(fn($record) => $record->nomor_sk),
                Tables\Columns\TextColumn::make('tanggal_akreditasi')->label('Tanggal')->date('d M Y')->sortable(),
                Tables\Columns\TextColumn::make('tanggal_berakhir')->label('Berakhir')->date('d M Y')->sortable()->color(fn($record) => $record->tanggal_berakhir->isPast() ? 'danger' : ($record->tanggal_berakhir->diffInMonths(now()) <= 6 ? 'warning' : 'gray')),
                Tables\Columns\TextColumn::make('sisa_masa_berlaku')
                    ->label('Sisa Masa')
                    ->getStateUsing(function ($record) {
                        if ($record->tanggal_berakhir->isPast()) {
                            return 'Kadaluarsa';
                        }
                        $months = $record->tanggal_berakhir->diffInMonths(now());
                        if ($months > 12) {
                            $years = floor($months / 12);
                            $remainingMonths = $months % 12;
                            return "{$years} tahun {$remainingMonths} bulan";
                        }
                        return "{$months} bulan";
                    })
                    ->badge()
                    ->color(fn($record) => $record->tanggal_berakhir->isPast() ? 'danger' : ($record->tanggal_berakhir->diffInMonths(now()) <= 6 ? 'warning' : 'success')),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('lembaga_akreditasi')->options([
                    'BAN-PT' => 'BAN-PT',
                    'LAM-Infokom' => 'LAM-Infokom',
                    'LAM-Teknik' => 'LAM-Teknik',
                ]),
                Tables\Filters\SelectFilter::make('status_akreditasi')->options([
                    'Unggul' => 'Unggul',
                    'Baik Sekali' => 'Baik Sekali',
                    'Baik' => 'Baik',
                ]),
                Tables\Filters\TernaryFilter::make('is_active')->label('Status Aktif'),
            ])
            ->actions([Tables\Actions\Action::make('download')->label('Download')->icon('heroicon-o-arrow-down-tray')->color('success')->visible(fn($record) => $record->sertifikat)->url(fn($record) => asset('storage/' . $record->sertifikat))->openUrlInNewTab(), Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])])
            ->defaultSort('tanggal_akreditasi', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('program_studi_id', Auth::user()->program_studi_id);
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
            'index' => Pages\ListAkreditasis::route('/'),
            'create' => Pages\CreateAkreditasi::route('/create'),
            'edit' => Pages\EditAkreditasi::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $activeCount = static::getModel()
            ::where('program_studi_id', Auth::user()->program_studi_id)
            ->where('is_active', true)
            ->count();

        return $activeCount > 0 ? $activeCount : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}
