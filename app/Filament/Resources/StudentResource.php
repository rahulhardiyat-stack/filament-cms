<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'PPKS';
    protected static ?string $navigationLabel = 'Mahasiswa PPKS';
    protected static ?string $modelLabel = 'Mahasiswa';
    protected static ?string $pluralModelLabel = 'Mahasiswa PPKS';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nim')->label('NIM')->required()->maxLength(30)->unique(ignoreRecord: true),
            Forms\Components\TextInput::make('name')->label('Nama mahasiswa')->required()->maxLength(255),
            Forms\Components\TextInput::make('program_studi')->label('Program studi')->required()->maxLength(255),
            Forms\Components\DatePicker::make('birth_date_password')
                ->label('Tanggal lahir untuk login')
                ->native(false)
                ->displayFormat('d/m/Y')
                ->format('Y-m-d')
                ->maxDate(now()->subDay())
                ->rules(['before:today'])
                ->required(fn (string $operation): bool => $operation === 'create')
                ->afterStateHydrated(fn (Forms\Components\DatePicker $component) => $component->state(null))
                ->dehydrated(fn ($state): bool => filled($state))
                ->helperText('Tanggal lahir disimpan sebagai hash. Saat mengedit, kosongkan jika tidak ingin mengubah kredensial.'),
            Forms\Components\Toggle::make('is_active')->label('Akun aktif')->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('nim')->label('NIM')->searchable(),
            Tables\Columns\TextColumn::make('name')->label('Nama')->searchable(),
            Tables\Columns\TextColumn::make('program_studi')->label('Program studi')->searchable(),
            Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
        ])->actions([Tables\Actions\EditAction::make()]);
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
