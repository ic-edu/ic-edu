<?php

namespace App\Filament\Resources\CourseModules\Pages;

use App\Filament\Resources\CourseModules\CourseModuleResource;
use App\Filament\Resources\Courses\CourseResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditCourseModule extends EditRecord
{
    protected static string $resource = CourseModuleResource::class;

    public function getTitle(): string | Htmlable
    {
        return "Manage Module: " . $this->getRecord()->title;
    }

    public function getBreadcrumbs(): array
    {
        $course = $this->getRecord()->course;
        return [
            CourseResource::getUrl('index') => 'Courses',
            CourseResource::getUrl('edit', ['record' => $course->id]) => $course->title,
            '#' => 'Manage Module',
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
