<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Notifications\Notification;
use Illuminate\Http\UploadedFile;
use Filament\Forms\Components\FileUpload;



class ImportData extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-tray';
    protected static ?string $title = 'Import Data';
    protected static string $view = 'filament.pages.import-data';
    public $file;

    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            FileUpload::make('file')
                ->label('Import file')
                ->required()
                ->disk('local') // sau 'public', după cum ai nevoie
                ->directory('imports')
                ->acceptedFileTypes([
                    'text/csv',
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                ])
                ->preserveFilenames()
                ->maxSize(10240)
                ->multiple(false) // ← FĂRĂ multiple!
        ];
    }

    public function submit()
    {
        $data = $this->form->getState();

        $file = $data['file'];

        if (!$file) {
            Notification::make()->title('No file uploaded')->danger()->send();
            return;
        }

        $path = Storage::disk('local')->path($file);

        try {
            $rows = Excel::toArray([], $path)[0];

            // Poți face ce vrei cu $rows: inserare în DB, afișare, validare etc.
            Notification::make()
                ->title('File imported successfully')
                ->body('Rows found: ' . count($rows))
                ->success()
                ->send();
        } catch (\Throwable $e) {
            Notification::make()->title('Import failed')->body($e->getMessage())->danger()->send();
        }
    }
}
