<?php
// Lokasi file: app/Filament/Gjm/Resources/ProfilFakultasResource.php

namespace App\Filament\Gjm\Resources;

use App\Filament\Gjm\Resources\ProfilFakultasResource\Pages;
use App\Models\Fakultas;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ProfilFakultasResource extends Resource
{
  protected static ?string $model = Fakultas::class;

  protected static ?string $navigationIcon = 'heroicon-o-building-library';

  protected static ?string $navigationLabel = 'Profil Fakultas';

  protected static ?string $modelLabel = 'Profil Fakultas';

  protected static ?string $pluralModelLabel = 'Profil Fakultas';

  protected static ?int $navigationSort = 1;

  protected static ?string $navigationGroup = 'Profil';

  protected static ?string $slug = 'profil-fakultas';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Section::make('Informasi Dasar')
          ->schema([
            Forms\Components\TextInput::make('kode')
              ->required()
              ->maxLength(10)
              ->unique(ignoreRecord: true),
            Forms\Components\TextInput::make('nama')
              ->required()
              ->maxLength(255),
            Forms\Components\TextInput::make('dekan')
              ->label('Nama Dekan')
              ->maxLength(255),
          ])
          ->columns(3),

        Forms\Components\Section::make('Visi, Misi & Tujuan')
          ->schema([
            Forms\Components\RichEditor::make('visi')
              ->required()
              ->toolbarButtons([
                'bold',
                'italic',
                'underline',
                'bulletList',
                'orderedList',
                'redo',
                'undo',
              ]),
            Forms\Components\RichEditor::make('misi')
              ->required()
              ->toolbarButtons([
                'bold',
                'italic',
                'underline',
                'bulletList',
                'orderedList',
                'redo',
                'undo',
              ]),
            Forms\Components\RichEditor::make('tujuan')
              ->required()
              ->toolbarButtons([
                'bold',
                'italic',
                'underline',
                'bulletList',
                'orderedList',
                'redo',
                'undo',
              ]),
          ])
          ->columns(1),

        Forms\Components\Section::make('Kontak & Alamat')
          ->schema([
            Forms\Components\Textarea::make('alamat')
              ->rows(3)
              ->columnSpanFull(),
            Forms\Components\TextInput::make('telepon')
              ->tel()
              ->maxLength(50),
            Forms\Components\TextInput::make('email')
              ->email()
              ->maxLength(255),
            Forms\Components\TextInput::make('website')
              ->url()
              ->prefix('https://')
              ->maxLength(255),
          ])
          ->columns(3),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('kode')
          ->searchable()
          ->sortable(),
        Tables\Columns\TextColumn::make('nama')
          ->searchable()
          ->sortable(),
        Tables\Columns\TextColumn::make('dekan')
          ->searchable()
          ->toggleable(),
        Tables\Columns\TextColumn::make('email')
          ->icon('heroicon-m-envelope')
          ->copyable()
          ->toggleable(),
        Tables\Columns\TextColumn::make('programStudi_count')
          ->counts('programStudi')
          ->label('Jumlah Prodi')
          ->badge(),
        Tables\Columns\TextColumn::make('updated_at')
          ->label('Terakhir Update')
          ->dateTime('d M Y')
          ->sortable()
          ->toggleable(),
      ])
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\ViewAction::make(),
        Tables\Actions\EditAction::make(),
        Tables\Actions\Action::make('struktur')
          ->label('Struktur Organisasi')
          ->icon('heroicon-o-chart-bar')
          ->color('info')
          ->url(fn(Fakultas $record): string => route('filament.gjm.resources.struktur-organisasi-fakultas.index', ['fakultas' => $record->id])),
      ])
      ->bulkActions([
        // No bulk actions for fakultas
      ])
      ->paginated(false); // Usually only one fakultas per GJM
  }

  public static function getRelations(): array
  {
    return [
      //
    ];
  }

  public static function beforeSave($record): void
  {
    // Auto-assign fakultas_id to current GJM user
    $user = Auth::user();
    if ($user && $user->role === 'gjm' && !$user->fakultas_id) {
      User::where('id', $user->id)->update(['fakultas_id' => $record->id]);
    }
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListProfilFakultas::route('/'),
      'create' => Pages\CreateProfilFakultas::route('/create'),
      'edit' => Pages\EditProfilFakultas::route('/{record}/edit'),
      'view' => Pages\ViewProfilFakultas::route('/{record}'),
    ];
  }

  public static function getEloquentQuery(): Builder
  {
    // GJM can only see/edit their own fakultas
    $user = Auth::user();

    return parent::getEloquentQuery()
      ->when($user && $user->fakultas_id, function ($query) use ($user) {
        return $query->where('id', $user->fakultas_id);
      });
  }

  public static function canCreate(): bool
  {
    // Check if fakultas already exists for this GJM
    $user = Auth::user();
    if ($user && $user->fakultas_id) {
      return !Fakultas::where('id', $user->fakultas_id)->exists();
    }

    return true;
  }
}