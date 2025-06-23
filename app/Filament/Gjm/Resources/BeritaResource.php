<?php

namespace App\Filament\Gjm\Resources;

use App\Filament\Gjm\Resources\BeritaResource\Pages;
use App\Models\Berita;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BeritaResource extends Resource
{
    protected static ?string $model = Berita::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Beranda';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Berita & Pengumuman';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Berita')
                ->schema([
                    Forms\Components\TextInput::make('judul')->required()->maxLength(255)->reactive()->afterStateUpdated(fn(string $state, callable $set) => $set('slug', Str::slug($state))),

                    Forms\Components\TextInput::make('slug')->required()->maxLength(255)->disabled()->dehydrated()->unique(Berita::class, 'slug', ignoreRecord: true),

                    Forms\Components\Select::make('kategori')
                        ->options([
                            'berita' => 'Berita',
                            'pengumuman' => 'Pengumuman',
                            'agenda' => 'Agenda',
                        ])
                        ->required(),

                    Forms\Components\DateTimePicker::make('tanggal_publikasi')->label('Tanggal Publikasi')->required()->default(now())->native(false),
                ])
                ->columns(2),

            Forms\Components\Section::make('Konten')->schema([
                Forms\Components\RichEditor::make('konten')
                    ->required()
                    ->columnSpanFull()
                    ->toolbarButtons(['attachFiles', 'blockquote', 'bold', 'bulletList', 'codeBlock', 'h2', 'h3', 'italic', 'link', 'orderedList', 'redo', 'strike', 'table', 'undo']),
            ]),

            Forms\Components\Section::make('Media')->schema([Forms\Components\FileUpload::make('gambar')->image()->directory('berita')->maxSize(2048)->imageResizeMode('cover')->imageResizeTargetWidth('1200')->imageResizeTargetHeight('630')]),

            Forms\Components\Section::make('Status')
                ->schema([Forms\Components\Toggle::make('is_published')->label('Publish')->default(true), Forms\Components\Toggle::make('is_featured')->label('Featured')->default(false)])
                ->columns(2),

            // Hidden fields
            Forms\Components\Hidden::make('created_by')->default(fn() => Auth::id())->dehydrated(),

            Forms\Components\Hidden::make('updated_by')->default(fn() => Auth::id())->dehydrateStateUsing(fn() => Auth::id()),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('gambar')->label('Gambar')->width(100)->height(60),

                Tables\Columns\TextColumn::make('judul')->searchable()->sortable()->limit(50),

                Tables\Columns\BadgeColumn::make('kategori')->colors([
                    'primary' => 'berita',
                    'warning' => 'pengumuman',
                    'success' => 'agenda',
                ]),

                Tables\Columns\TextColumn::make('tanggal_publikasi')->label('Tanggal')->dateTime('d M Y H:i')->sortable(),

                Tables\Columns\IconColumn::make('is_published')->label('Published')->boolean(),

                Tables\Columns\IconColumn::make('is_featured')->label('Featured')->boolean(),

                Tables\Columns\TextColumn::make('creator.name')->label('Dibuat oleh')->toggleable(),

                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y H:i')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')->options([
                    'berita' => 'Berita',
                    'pengumuman' => 'Pengumuman',
                    'agenda' => 'Agenda',
                ]),

                Tables\Filters\TernaryFilter::make('is_published')->label('Published'),

                Tables\Filters\TernaryFilter::make('is_featured')->label('Featured'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()->mutateFormDataUsing(function (array $data): array {
                    $data['updated_by'] = Auth::id();
                    return $data;
                }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])])
            ->defaultSort('tanggal_publikasi', 'desc');
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
            'index' => Pages\ListBeritas::route('/'),
            'create' => Pages\CreateBerita::route('/create'),
            'edit' => Pages\EditBerita::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_published', false)->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
}
