<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PendaftaranResource\Pages;
use App\Models\Pendaftaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PendaftaranResource extends Resource
{
    protected static ?string $model = Pendaftaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Manajemen Beasiswa';
    protected static ?string $label = 'Pendaftaran';
    protected static ?string $pluralLabel = 'Data Pendaftaran';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('mahasiswa_id')
                ->label('Nama Mahasiswa')
                ->relationship('mahasiswa', 'nama')
                ->searchable()
                ->preload()
                ->required(),

            Forms\Components\Select::make('beasiswa_id')
                ->label('Nama Beasiswa')
                ->relationship('beasiswa', 'nama')
                ->searchable()
                ->preload()
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('mahasiswa.nim')->label('NIM')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('mahasiswa.nama')->label('Nama')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('mahasiswa.nik')->label('NIK')->searchable(),
            Tables\Columns\TextColumn::make('mahasiswa.prodi')
                ->label('Jurusan')
                ->formatStateUsing(fn ($state) => $state ?? '-') // jika null, tampilkan "-"
                ->searchable(),
            Tables\Columns\TextColumn::make('mahasiswa.semester')->label('Semester'),
            Tables\Columns\TextColumn::make('mahasiswa.no_telp')->label('No Telepon'),
            Tables\Columns\TextColumn::make('mahasiswa.email')->label('Email'),
            Tables\Columns\TextColumn::make('beasiswa.nama')->label('Beasiswa')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('created_at')->label('Waktu Daftar')->dateTime('d M Y H:i'),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPendaftarans::route('/'),
            'create' => Pages\CreatePendaftaran::route('/create'),
            'edit' => Pages\EditPendaftaran::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        // Pastikan eager load relasi mahasiswa & beasiswa agar data lengkap
        $query = parent::getEloquentQuery()->with(['mahasiswa', 'beasiswa']);

        if (auth()->user()?->hasRole('mahasiswa')) {
            $query->where('mahasiswa_id', auth()->user()->mahasiswa->id ?? 0);
        }

        return $query;
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
}