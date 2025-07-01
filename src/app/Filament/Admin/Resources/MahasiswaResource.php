<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\MahasiswaResource\Pages;
use App\Models\Mahasiswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class MahasiswaResource extends Resource
{
    protected static ?string $model = Mahasiswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Manajemen Beasiswa';
    protected static ?string $label = 'Mahasiswa';
    protected static ?string $pluralLabel = 'Data Mahasiswa';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nim')
                ->label('NIM')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(20),

            Forms\Components\TextInput::make('nama')
                ->label('Nama Lengkap')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('nik')
                ->label('NIK')
                ->required()
                ->maxLength(16),

            Forms\Components\Textarea::make('alamat')
                ->label('Alamat')
                ->maxLength(500)
                ->rows(3),

            Forms\Components\TextInput::make('jurusan')
                ->label('Program Studi')
                ->required()
                ->maxLength(100),

            Forms\Components\TextInput::make('semester')
                ->label('Semester')
                ->numeric()
                ->minValue(1)
                ->maxValue(14)
                ->required(),

            Forms\Components\TextInput::make('ipk')
                ->label('IPK')
                ->numeric()
                ->step(0.01)
                ->minValue(0)
                ->maxValue(4)
                ->required(),

            Forms\Components\TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('no_telp')
                ->label('No. Telepon')
                ->tel()
                ->required()
                ->maxLength(20),

            Forms\Components\Select::make('beasiswa_id')
                ->label('Beasiswa yang Didaftarkan')
                ->relationship('beasiswa', 'nama')
                ->searchable()
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('nim')->label('NIM')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('nama')->label('Nama')->searchable(),
            Tables\Columns\TextColumn::make('nik')->label('NIK'),
            Tables\Columns\TextColumn::make('jurusan')->label('Program Studi'),
            Tables\Columns\TextColumn::make('semester')->label('Semester'),
            Tables\Columns\TextColumn::make('ipk')->label('IPK'),
            Tables\Columns\TextColumn::make('email')->label('Email'),
            Tables\Columns\TextColumn::make('no_telp')->label('No. Telepon'),
            Tables\Columns\TextColumn::make('beasiswa.nama')->label('Beasiswa'),
            Tables\Columns\TextColumn::make('created_at')->label('Didaftarkan')->dateTime('d M Y H:i'),
        ])
        ->filters([])
        ->actions([
            Tables\Actions\EditAction::make()
                ->visible(fn (Model $record) =>
                    auth()->user()?->hasRole('mahasiswa')
                        ? $record->user_id === auth()->id()
                        : true
                ),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMahasiswas::route('/'),
            'create' => Pages\CreateMahasiswa::route('/create'),
            'edit' => Pages\EditMahasiswa::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()?->hasRole('mahasiswa')) {
            return parent::getEloquentQuery()->where('user_id', auth()->id());
        }

        return parent::getEloquentQuery();
    }

    public static function canCreate(): bool
    {
        return !auth()->user()?->hasRole('mahasiswa');
    }

    public static function canDelete(Model $record): bool
    {
        return !auth()->user()?->hasRole('mahasiswa');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->hasRole('mahasiswa')
            ? $record->user_id === auth()->id()
            : true;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return !auth()->user()?->hasRole('mahasiswa');
    }
}