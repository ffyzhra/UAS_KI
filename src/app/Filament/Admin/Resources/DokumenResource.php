<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\DokumenResource\Pages;
use App\Models\Dokumen;
use App\Models\Pendaftaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DokumenResource extends Resource
{
    protected static ?string $model = Dokumen::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?string $navigationGroup = 'Manajemen Beasiswa';
    protected static ?string $label = 'Dokumen';
    protected static ?string $pluralLabel = 'Dokumen Pendaftar';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('pendaftaran_id')
                ->label('Nama Pendaftar')
                ->relationship('pendaftaran', 'id')
                ->getOptionLabelFromRecordUsing(fn($record) => $record->mahasiswa->nama ?? '-')
                ->searchable()
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
                    $pendaftaran = Pendaftaran::with('beasiswa')->find($state);
                    $set('jenis_beasiswa', optional($pendaftaran?->beasiswa)->nama);
                }),

            Forms\Components\TextInput::make('jenis_beasiswa')
                ->label('Jenis Beasiswa')
                ->disabled()
                ->dehydrated(false)
                ->afterStateHydrated(function ($component, $state, $record) {
                    if ($record && $record->pendaftaran) {
                        $component->state(optional($record->pendaftaran->beasiswa)->nama);
                    }
                }),

            Forms\Components\FileUpload::make('ktp')
                ->label('Upload KTP')
                ->directory('dokumen/ktp')
                ->preserveFilenames()
                ->required(),

            Forms\Components\FileUpload::make('kk')
                ->label('Upload KK')
                ->directory('dokumen/kk')
                ->preserveFilenames()
                ->required(),

            Forms\Components\FileUpload::make('ijazah')
                ->label('Upload Ijazah')
                ->directory('dokumen/ijazah')
                ->preserveFilenames()
                ->required(),

            Forms\Components\FileUpload::make('transkrip_nilai')
                ->label('Upload Transkrip Nilai')
                ->directory('dokumen/transkrip')
                ->preserveFilenames()
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pendaftaran_id')
                    ->label('Nama Pendaftar')
                    ->formatStateUsing(function ($state) {
                        $pendaftaran = \App\Models\Pendaftaran::with('mahasiswa')->find($state);
                        return optional($pendaftaran?->mahasiswa)->nama ?? '-';
                    }),

                Tables\Columns\TextColumn::make('pendaftaran.beasiswa.nama')
                    ->label('Jenis Beasiswa'),

                Tables\Columns\TextColumn::make('ktp')->label('KTP'),
                Tables\Columns\TextColumn::make('kk')->label('KK'),
                Tables\Columns\TextColumn::make('ijazah')->label('Ijazah'),
                Tables\Columns\TextColumn::make('transkrip_nilai')->label('Transkrip Nilai'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Diunggah')
                    ->dateTime('d M Y H:i'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()?->hasRole('mahasiswa')) {
            return parent::getEloquentQuery()->whereHas('pendaftaran', function ($query) {
                $query->where('mahasiswa_id', auth()->user()->mahasiswa->id);
            });
        }

        return parent::getEloquentQuery();
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDokumens::route('/'),
            'create' => Pages\CreateDokumen::route('/create'),
            'edit' => Pages\EditDokumen::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return !auth()->user()?->hasRole('mahasiswa');
    }
}