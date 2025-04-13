<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Filament\Forms;
use Carbon\Carbon;

class QuizPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-clipboard';
    protected static ?string $title = 'Quiz-ul Săptămânii';
    protected static ?string $slug = 'quiz';
    protected static string $view = 'filament.pages.quiz-page';

    public $answers = [];
    public $questions = [];
    public $message = '';

    public function mount()
    {
        $this->loadQuizData();
    }

    private function loadQuizData()
    {
        $week = now()->weekOfYear;

        // Selectăm fișierul JSON în funcție de săptămâna curentă
        $fileName = $week % 2 === 0 ? 'quiz1.json' : 'quiz2.json';
        $path = public_path("quizes/{$fileName}");

        if (File::exists($path)) {
            $json = File::get($path);
            $quiz = json_decode($json, true);
            $this->questions = $quiz['questions'] ?? [];
        } else {
            $this->message = 'Fișierul cu întrebările nu a fost găsit.';
        }
    }


    public function submitQuiz()
    {
        $user = Auth::user();

        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();

        // Verificăm dacă utilizatorul a făcut deja un quiz în săptămâna aceasta
        // if ($user->atempted && $user->updated_at->between($weekStart, $weekEnd)) {
        //     $this->message = 'Ai încercat deja quiz-ul săptămâna aceasta.';
        //     return;
        // }

        $correctCount = 0;

        foreach ($this->questions as $index => $question) {
            $userAnswer = $this->answers[$index] ?? null;
            if ($userAnswer === $question['correct_answer']) {
                $correctCount++;
            }
        }

        $user->atempted = true;

        if ($correctCount >= 3) {
            $user->rewarded_quiz = true;
            $this->message = "Felicitări! Luna aceasta va fi gratuita pentru tine. Ai răspuns corect la $correctCount întrebări din " . count($this->questions) . "!";
        } else {
            $this->message = "Ai răspuns corect la $correctCount întrebări. Mai încearcă săptămâna viitoare!";
        }

        $user->save();
    }

    protected function getFormSchema(): array
    {
        $schema = [];

        foreach ($this->questions as $index => $question) {
            $options = [];
        
            foreach ($question['options'] as $key => $value) {
                $options[$key] = $value; // Ex: 'a' => 'Un plan de cheltuieli'
            }
        
            $schema[] = Forms\Components\Select::make("answers.$index")
                ->label($question['question'])
                ->options($options)
                ->required();
        }
        
        return $schema;
    }
}
