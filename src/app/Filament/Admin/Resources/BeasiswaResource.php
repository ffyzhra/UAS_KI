<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BeasiswaResource\Pages;
use App\Models\Beasiswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class BeasiswaResource extends Resource
{
    protected static ?string $model = Beasiswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Manajemen Beasiswa';
    protected static ?string $label = 'Beasiswa';
    protected static ?string $pluralLabel = 'Data Beasiswa';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nama')
                ->label('Nama Beasiswa')
                ->required()
                ->maxLength(255),

            Forms\Components\Textarea::make('deskripsi')
                ->label('Deskripsi')
                ->rows(4)
                ->nullable(),

            Forms\Components\TextInput::make('penyelenggara')
                ->label('Penyelenggara')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('nominal')
                ->label('Nominal')
                ->numeric()
                ->required(),

            Forms\Components\Select::make('status')
                ->label('Status')
                ->options([
                    'aktif' => 'Aktif',
                    'nonaktif' => 'Nonaktif',
                ])
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Beasiswa')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('penyelenggara')
                    ->label('Penyelenggara'),

                Tables\Columns\TextColumn::make('nominal')
                    ->label('Nominal')
                    ->money('IDR'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string =>
                        $state === 'aktif' ? 'success' : 'danger'
                    ),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn () => !auth()->user()?->hasRole('mahasiswa')),

                Tables\Actions\DeleteAction::make()
                    ->visible(fn () => !auth()->user()?->hasRole('mahasiswa')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => !auth()->user()?->hasRole('mahasiswa')),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Tambah relasi di sini jika dibutuhkan, seperti: HasMany Pendaftaran
        ];
    }

   public static function getPages(): array
{
    return [
        'index' => Pages\ListBeasiswas::route('/'),
        'create' => Pages\CreateBeasiswa::route('/create'),
        'edit' => Pages\EditBeasiswa::route('/{record}/edit'),
    ];
}


    public static function canCreate(): bool
    {
        return !auth()->user()?->hasRole('mahasiswa');
    }

    public static function canEdit(Model $record): bool
    {
        return !auth()->user()?->hasRole('mahasiswa');
    }

    public static function canDelete(Model $record): bool
    {
        return !auth()->user()?->hasRole('mahasiswa');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return !auth()->user()?->hasRole('mahasiswa');
    }
}