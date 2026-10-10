<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PpksReportResource\Pages;
use App\Models\PpksReport;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PpksReportResource extends Resource
{
    protected static ?string $model = PpksReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'PPKS';

    protected static ?string $navigationLabel = 'Laporan PPKS';

    protected static ?string $modelLabel = 'Laporan PPKS';

    protected static ?string $pluralModelLabel = 'Laporan PPKS';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Identitas dan laporan')->schema([
                Forms\Components\TextInput::make('reference')->label('Nomor laporan')->disabled()->dehydrated(false),
                Forms\Components\Placeholder::make('reporter_identity')->label('Pelapor')
                    ->content(fn (?PpksReport $record): string => $record?->reporter_type === 'public' ? $record->reporter_name : ($record?->student?->name ?? '').' ? '.($record?->student?->nim ?? '')),
                Forms\Components\Select::make('reporter_type')->label('Jenis pelapor')->options(PpksReport::TYPES)->disabled()->dehydrated(false),
                Forms\Components\Select::make('reporter_role')->label('Peran pelapor')->options(PpksReport::ROLES)->disabled()->dehydrated(false),
                Forms\Components\DatePicker::make('incident_date')->label('Tanggal kejadian')->disabled()->dehydrated(false),
                Forms\Components\TextInput::make('location')->label('Lokasi / media kejadian')->disabled()->dehydrated(false),
                Forms\Components\TextInput::make('reported_person')->label('Terlapor')->disabled()->dehydrated(false),
                Forms\Components\Textarea::make('chronology')->label('Kronologi')->rows(8)->disabled()->dehydrated(false)->columnSpanFull(),
                Forms\Components\TextInput::make('contact')->label('Kontak aman')->disabled()->dehydrated(false),
                Forms\Components\Textarea::make('support_needed')->label('Bantuan yang dibutuhkan')->disabled()->dehydrated(false),
                Forms\Components\ViewField::make('evidence_paths')->view('filament.forms.ppks-evidence')->dehydrated(false)->columnSpanFull(),
            ])->columns(2),
            Forms\Components\Section::make('Tindak lanjut')->schema([
                Forms\Components\Select::make('status')->label('Status')->options(PpksReport::STATUSES)->required(),
                Forms\Components\Textarea::make('response')->label('Tanggapan untuk pelapor')->rows(5)->maxLength(5000)
                    ->helperText('Tanggapan ini ditampilkan kepada pelapor melalui halaman tindak lanjut.'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('reference')->label('Nomor laporan')->searchable()->limit(18)->copyable(),
            Tables\Columns\TextColumn::make('reporter_type')->label('Jenis pelapor')->badge()->formatStateUsing(fn (string $state): string => PpksReport::TYPES[$state] ?? $state),
            Tables\Columns\TextColumn::make('student.nim')->label('NIM')->searchable(),
            Tables\Columns\TextColumn::make('student.name')->label('Mahasiswa')->searchable(),
            Tables\Columns\TextColumn::make('reporter_role')->label('Peran')->formatStateUsing(fn (string $state): string => PpksReport::ROLES[$state] ?? $state),
            Tables\Columns\TextColumn::make('status')->label('Status')->badge()->formatStateUsing(fn (string $state): string => PpksReport::STATUSES[$state] ?? $state),
            Tables\Columns\TextColumn::make('created_at')->label('Dikirim')->dateTime('d/m/Y H:i')->sortable(),
        ])->defaultSort('created_at', 'desc')
            ->filters([Tables\Filters\SelectFilter::make('reporter_type')->label('Jenis pelapor')->options(PpksReport::TYPES), Tables\Filters\SelectFilter::make('status')->label('Status')->options(PpksReport::STATUSES)])
            ->actions([Tables\Actions\EditAction::make()->label('Tindak lanjuti')]);
    }

    public static function canCreate(): bool
    {
        return false;
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
            'index' => Pages\ListPpksReports::route('/'),
            'edit' => Pages\EditPpksReport::route('/{record}/edit'),
        ];
    }
}
