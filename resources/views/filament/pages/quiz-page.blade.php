{{-- resources/views/filament/pages/quiz.blade.php --}}
<x-filament::page>
    <div class="relative bg-black min-h-screen p-6">
        <!-- Overlay întunecat -->
        <div class="absolute inset-0 bg-black bg-opacity-60"></div>

        <!-- Conținutul -->
        <div class="relative z-10 p-6 text-white">
            <h1 class="text-3xl font-bold">Quiz-ul Tău Financiar</h1>
            <p class="mt-4 text-lg">
                Bine ai venit la quiz-ul financiar! Răspunde corect și învață mai multe despre economii, credite și investiții.
            </p>

            <!-- Formular pentru quiz -->
            <form wire:submit.prevent="submitQuiz" class="mt-8 space-y-6">
                @foreach ($questions as $index => $question)
                    <div class="bg-blue-500 bg-opacity-30 p-5 rounded-md">
                        <h3 class="font-semibold text-lg mb-3">Întrebarea {{ $index + 1 }}: {{ $question['question'] }}</h3>

                        <div class="space-y-2">
                            @foreach ($question['options'] as $key => $option)
                                <label class="block">
                                    <input
                                        type="radio"
                                        wire:model="answers.{{ $index }}"
                                        value="{{ $key }}"
                                        class="mr-2 text-blue-600 focus:ring-blue-500"
                                    >
                                    {{ $option }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <div>
                    <x-filament::button type="submit" color="success">
                        Trimite Răspunsurile
                    </x-filament::button>
                </div>
            </form>

            @if ($message)
                <div class="mt-6 p-4 bg-green-600 bg-opacity-60 rounded-md text-white shadow-lg">
                    {{ $message }}
                </div>
            @endif
        </div>
    </div>
</x-filament::page>
