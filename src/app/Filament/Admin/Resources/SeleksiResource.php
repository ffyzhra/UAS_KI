<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SeleksiResource\Pages;
use App\Models\Seleksi;
use App\Models\Pendaftaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Get;
use Filament\Forms\Set;

class SeleksiResource extends Resource
{
    protected static ?string $model = Seleksi::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';
    protected static ?string $navigationGroup = 'Manajemen Beasiswa';
    protected static ?string $label = 'Seleksi';
    protected static ?string $pluralLabel = 'Hasil Seleksi';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nama_mahasiswa')
                ->label('Nama Mahasiswa')
                ->required()
                ->afterStateUpdated(function (string $state, Set $set) {
                    // Cari pendaftaran berdasarkan nama mahasiswa
                    $pendaftaran = Pendaftaran::with('mahasiswa')
                        ->get()
                        ->firstWhere(fn ($p) => strtolower($p->mahasiswa->nama ?? '') === strtolower($state));

                    if ($pendaftaran) {
                        $set('pendaftaran_id', $pendaftaran->id);
                    } else {
                        $set('pendaftaran_id', null);
                    }
                }),

            Forms\Components\Hidden::make('pendaftaran_id')
                ->required(),

            Forms\Components\Select::make('hasil')
                ->label('Hasil Seleksi')
                ->options([
                    'diterima' => 'Diterima',
                    'ditolak' => 'Ditolak',
                ])
                ->required()
                ->native(false),

            Forms\Components\Textarea::make('catatan')
                ->label('Catatan')
                ->maxLength(1000)
                ->rows(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pendaftaran.beasiswa.nama')
                    ->label('Nama Beasiswa')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('pendaftaran.mahasiswa.nama')
                    ->label('Nama Mahasiswa')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('hasil')
                    ->label('Hasil')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'diterima' => 'success',
                        'ditolak' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('catatan')
                    ->label('Catatan')
                    ->limit(50),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Seleksi')
                    ->dateTime('d M Y H:i'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('hasil')
                    ->label('Hasil Seleksi')
                    ->options([
                        'diterima' => 'Diterima',
                        'ditolak' => 'Ditolak',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn (Model $record) => !auth()->user()?->hasRole('mahasiswa')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => !auth()->user()?->hasRole('mahasiswa')),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()?->hasRole('mahasiswa')) {
            return parent::getEloquentQuery()->whereHas('pendaftaran', function ($query) {
                $query->where('mahasiswa_id', auth()->user()->mahasiswa->id ?? 0);
            });
        }

        return parent::getEloquentQuery();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSeleksis::route('/'),
            'create' => Pages\CreateSeleksi::route('/create'),
            'edit' => Pages\EditSeleksi::route('/{record}/edit'),
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