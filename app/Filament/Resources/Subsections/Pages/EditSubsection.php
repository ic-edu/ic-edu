<?php

namespace App\Filament\Resources\Subsections\Pages;

use App\Filament\Resources\Exams\ExamResource;
use App\Filament\Resources\Sections\SectionResource;
use App\Filament\Resources\Subsections\SubsectionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditSubsection extends EditRecord
{
    protected static string $resource = SubsectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->successRedirectUrl(fn($record) => SectionResource::getUrl('edit', ['record' => $record->section_id])),
        ];
    }

    public function getTitle(): string | Htmlable
    {
        return $this->getRecord()->title;
    }

    public function getBreadcrumbs(): array
    {
        $subsection = $this->getRecord();
        $section = $subsection->section;
        $exam = $section->exam;

        return [
            ExamResource::getUrl('index') => 'Exams',
            ExamResource::getUrl('edit', ['record' => $exam->id]) => $exam->title,
            SectionResource::getUrl('edit', ['record' => $section->id]) => $section->title,
        ];
    }
}
