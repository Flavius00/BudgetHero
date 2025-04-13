<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\File;

class CoursePreview extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $title = 'Lecția Săptămânii';
    protected static ?string $slug = 'course';
    protected static string $view = 'filament.pages.course-page';

    public $course;
    public $lesson;
    public $content = [];

    public function mount()
    {
        // Calea locală către fișierul JSON
        $filePath = public_path('Courses/course1.json');

        if (File::exists($filePath)) {
            $jsonContent = File::get($filePath);
            $data = json_decode($jsonContent, true);

            $this->course = $data['course'] ?? 'Titlu necunoscut';
            $this->lesson = $data['lesson'] ?? 'Fără lecție';
            $this->content = $data['content'] ?? [];
        } else {
            $this->course = 'Fișierul nu a fost găsit';
            $this->lesson = '';
            $this->content = [];
        }
    }
}
