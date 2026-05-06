<?php

namespace App\Filament\Resources\ExamTypes\Schemas;

use App\Models\ExamType;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ExamTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([

            // ─── Informasi Dasar ───────────────────────────────────────────
            Section::make('Informasi Dasar')
                ->schema([
                    TextInput::make('name')
                        ->label('Nama Tipe Ujian')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->placeholder('Contoh: TOEIC, IELTS, TOEFL iBT'),

                    Textarea::make('description')
                        ->label('Deskripsi')
                        ->maxLength(65535)
                        ->columnSpanFull(),
                ]),

            // ─── Konfigurasi Penilaian ─────────────────────────────────────
            Section::make('Konfigurasi Penilaian')
                ->description('Atur cara sistem menghitung dan menampilkan skor peserta ujian.')
                ->schema([
                    Select::make('scoring_method')
                        ->label('Metode Penilaian')
                        ->required()
                        ->options(ExamType::SCORING_METHODS)
                        ->default('raw')
                        ->helperText('Raw: ujian biasa (0-100) | Weighted: TOEFL iBT (0-120) | Band: IELTS (0.0-9.0) | Per Section: TOEIC (10-990)'),

                    TextInput::make('max_score')
                        ->label('Skor Maksimum')
                        ->required()
                        ->numeric()
                        ->default(100)
                        ->minValue(1)
                        ->helperText('Contoh: TOEIC=990, IELTS=9, TOEFL=120, Ujian Biasa=100'),

                    TextInput::make('passing_score')
                        ->label('Skor Kelulusan (Passing Grade)')
                        ->numeric()
                        ->nullable()
                        ->helperText('Kosongkan jika tidak ada batas kelulusan.'),

                    Toggle::make('show_section_scores')
                        ->label('Tampilkan Skor Per Section')
                        ->helperText('Aktifkan untuk TOEIC/TOEFL agar skor Listening & Reading ditampilkan terpisah.')
                        ->default(false),
                ])->columns(2),
        ]);
    }
}
