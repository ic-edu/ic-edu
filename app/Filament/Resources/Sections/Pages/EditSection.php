<?php

namespace App\Filament\Resources\Sections\Pages;

use App\Filament\Resources\Exams\ExamResource;
use App\Filament\Resources\Sections\SectionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditSection extends EditRecord
{
    protected static string $resource = SectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->successRedirectUrl(fn($record) => ExamResource::getUrl('edit', ['record' => $record->exam_id])),
        ];
    }

    public function getTitle(): string | Htmlable
    {
        return $this->getRecord()->title;
    }

    public function getBreadcrumbs(): array
    {
        $section = $this->getRecord();
        $exam = $section->exam;

        return [
            ExamResource::getUrl('index') => 'Exams',

            ExamResource::getUrl('edit', ['record' => $exam->id]) => $exam->title,
        ];
    }
}
