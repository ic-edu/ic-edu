<?php

namespace App\Filament\Resources\Sections\RelationManagers;

use App\Filament\Resources\Subsections\SubsectionResource;
use App\Imports\BankSoalImport;
use App\Models\Subsection;
use Filament\Actions\Action as PageAction; 
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;

class SubsectionsRelationManager extends RelationManager
{
    protected static string $relationship = 'subsections';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g., Part A: Photographs'),

                Textarea::make('instructions')
                    ->label('Instructions for Subsection')
                    ->maxLength(65535)
                    ->columnSpanFull(),

                FileUpload::make('instruction_audio_path')
                    ->label('Instruction Audio (Optional)')
                    ->directory('instructions/audio')
                    ->acceptedFileTypes(['audio/mpeg', 'audio/wav', 'audio/ogg', 'audio/mp3', 'audio/m4a']),

                FileUpload::make('instruction_image_path')
                    ->label('Instruction Image (Optional)')
                    ->directory('instructions/images')
                    ->image(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('order_position')
                    ->label('Order Position')
                    ->sortable(),

                TextColumn::make('title')
                    ->label('Title Subsection')
                    ->searchable(),
            ])
            ->defaultSort('order_position', 'asc')
            ->reorderable('order_position')
            ->filters([
                TrashedFilter::make(),
            ])
            ->headerActions([
                CreateAction::make(),
                PageAction::make('downloadTemplate')
                    ->label('Download Template')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('primary')
                    ->action(fn () => Excel::download(new \App\Exports\TemplateSoalExport($this->getOwnerRecord()), 'template_soal_ujian.xlsx')),
                PageAction::make('importSoal')
                    ->label('Import Excel & Media')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->color('success')
                    ->form([
                        FileUpload::make('excel_file')
                            ->label('File Template Excel (.xlsx)')
                            ->acceptedFileTypes([
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'text/csv'
                            ])
                            ->required(),

                        FileUpload::make('zip_media')
                            ->label('File ZIP Media (Image & Audio)')
                            ->acceptedFileTypes(['application/zip', 'application/x-zip-compressed'])
                            ->helperText('Merge file media (Image & Audio) in 1 file ZIP.')
                    ])
                    ->action(function (array $data) {
                        try {
                            if (!empty($data['zip_media'])) {
                                $zipPath = \Illuminate\Support\Facades\Storage::disk('local')->path($data['zip_media']);
                                $zip = new ZipArchive;

                                if ($zip->open($zipPath) === TRUE) {
                                    $extractPath = \Illuminate\Support\Facades\Storage::disk('local')->path('imports/temp_extract');
                                    $zip->extractTo($extractPath);
                                    $zip->close();

                                    $files = File::allFiles($extractPath);
                                    foreach ($files as $file) {
                                        $ext = strtolower($file->getExtension());
                                        $filename = $file->getFilename();

                                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                            File::move($file->getRealPath(), \Illuminate\Support\Facades\Storage::disk('public')->path('questions/images/' . $filename));
                                        } elseif (in_array($ext, ['mp3', 'wav', 'ogg', 'm4a'])) {
                                            File::move($file->getRealPath(), \Illuminate\Support\Facades\Storage::disk('public')->path('questions/audios/' . $filename));
                                        }
                                    }
                                    File::deleteDirectory($extractPath);
                                }
                                \Illuminate\Support\Facades\Storage::disk('local')->delete($data['zip_media']);
                            }

                            Excel::import(new BankSoalImport, $data['excel_file'], 'local');

                            \Illuminate\Support\Facades\Storage::disk('local')->delete($data['excel_file']);

                            Notification::make()
                                ->title('Import Berhasil!')
                                ->body('Data sukses masuk ke database.')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Import Gagal')
                                ->body('Error: ' . $e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
                PageAction::make('manage_questions')
                    ->label('Manage Questions')
                    ->icon('heroicon-m-document-text')
                    ->color('success')
                    ->url(fn(Subsection $record): string => SubsectionResource::getUrl('edit', ['record' => $record->id])),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn(Builder $query) => $query
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]));
    }
}
