<?php

// 1. app/Filament/Ujm/Resources/BeritaProdiResource.php
namespace App\Filament\Ujm\Resources;

use App\Filament\Ujm\Resources\BeritaProdiResource\Pages;
use App\Models\Berita;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Filament\Forms\Set;
use Illuminate\Support\Facades\Auth;

class BeritaProdiResource extends Resource
{
  protected static ?string $model = Berita::class;

  protected static ?string $navigationIcon = 'heroicon-o-newspaper';

  protected static ?string $navigationLabel = 'Berita & Pengumuman';

  protected static ?string $modelLabel = 'Berita Prodi';

  protected static ?string $pluralModelLabel = 'Berita & Pengumuman Prodi';

  protected static ?int $navigationSort = 1;

  protected static ?string $navigationGroup = 'Konten';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Section::make('Informasi Berita')
          ->schema([
            Forms\Components\TextInput::make('judul')
              ->required()
              ->maxLength(255)
              ->live(onBlur: true)
              ->afterStateUpdated(function (Set $set, ?string $state) {
                if (!$state) return;
                $set('slug', Str::slug($state));
              }),
            Forms\Components\TextInput::make('slug')
              ->required()
              ->maxLength(255)
              ->unique(ignoreRecord: true)
              ->helperText('URL-friendly version dari judul'),
            Forms\Components\Select::make('kategori')
              ->options([
                'berita' => 'Berita',
                'pengumuman' => 'Pengumuman',
              ])
              ->required()
              ->default('pengumuman'),
            Forms\Components\Hidden::make('level')
              ->default('prodi'),
            Forms\Components\Hidden::make('user_id')
              ->default(fn() => Auth::user()->id),
            Forms\Components\Hidden::make('program_studi_id')
              ->default(fn() => Auth::user()->programStudi?->id),
          ])->columns(2),

        Forms\Components\Section::make('Konten')
          ->schema([
            Forms\Components\RichEditor::make('konten')
              ->required()
              ->columnSpanFull()
              ->toolbarButtons([
                'bold',
                'italic',
                'underline',
                'strike',
                'link',
                'orderedList',
                'unorderedList',
                'h2',
                'h3',
                'blockquote',
                'hr',
                'table',
                'undo',
                'redo',
              ]),
          ]),

        Forms\Components\Section::make('Media & Publikasi')
          ->schema([
            Forms\Components\FileUpload::make('gambar')
              ->image()
              ->directory('berita/prodi')
              ->maxSize(2048)
              ->helperText('Maksimal 2MB. Format: JPG, PNG')
              ->columnSpanFull(),
            Forms\Components\Toggle::make('is_published')
              ->label('Publikasikan')
              ->default(false)
              ->reactive(),
            Forms\Components\DateTimePicker::make('published_at')
              ->label('Tanggal Publikasi')
              ->default(now())
              ->visible(fn(Forms\Get $get) => $get('is_published'))
              ->required(fn(Forms\Get $get) => $get('is_published')),
          ])->columns(2),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('judul')
          ->searchable()
          ->limit(50),
        Tables\Columns\TextColumn::make('kategori')
          ->badge()
          ->color(fn(string $state): string => match ($state) {
            'berita' => 'info',
            'pengumuman' => 'warning',
          }),
        Tables\Columns\IconColumn::make('is_published')
          ->label('Status')
          ->boolean()
          ->trueIcon('heroicon-o-check-circle')
          ->falseIcon('heroicon-o-clock')
          ->trueColor('success')
          ->falseColor('gray'),
        Tables\Columns\TextColumn::make('published_at')
          ->label('Tanggal Publikasi')
          ->dateTime('d M Y H:i')
          ->sortable(),
        Tables\Columns\TextColumn::make('created_at')
          ->label('Dibuat')
          ->dateTime('d M Y')
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
      ])
      ->filters([
        Tables\Filters\SelectFilter::make('kategori')
          ->options([
            'berita' => 'Berita',
            'pengumuman' => 'Pengumuman',
          ]),
        Tables\Filters\TernaryFilter::make('is_published')
          ->label('Status Publikasi')
          ->trueLabel('Dipublikasikan')
          ->falseLabel('Draft'),
      ])
      ->actions([
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make(),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
          Tables\Actions\BulkAction::make('publish')
            ->label('Publikasikan')
            ->icon('heroicon-o-check')
            ->color('success')
            ->requiresConfirmation()
            ->action(fn($records) => $records->each->update([
              'is_published' => true,
              'published_at' => now(),
            ]))
            ->deselectRecordsAfterCompletion(),
        ]),
      ])
      ->defaultSort('created_at', 'desc');
  }

  public static function getEloquentQuery(): Builder
  {
    return parent::getEloquentQuery()
      ->where('level', 'prodi')
      ->where('program_studi_id', Auth::user()->programStudi?->id);
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
      'index' => Pages\ListBeritaProdis::route('/'),
      'create' => Pages\CreateBeritaProdi::route('/create'),
      'edit' => Pages\EditBeritaProdi::route('/{record}/edit'),
    ];
  }
}
