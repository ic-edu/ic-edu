<?php

namespace App\Filament\Resources\Exams\Pages;

use App\Filament\Resources\Exams\ExamResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditExam extends EditRecord
{
    protected static string $resource = ExamResource::class;

    public function getTitle(): string | Htmlable
    {
        return $this->getRecord()->title;
    }

    public function getBreadcrumbs(): array
    {
        return [
            ExamResource::getUrl('index') => 'Exams',
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(), 
        ];
    }
}
