<x-filament::page>
    <div class="relative bg-black min-h-screen p-6">
        <!-- Overlay întunecat -->
        <div class="absolute inset-0 bg-black bg-opacity-60"></div>

        <!-- Conținutul -->
        <div class="relative z-10 p-6 text-white">
            <h1 class="text-3xl font-bold">{{ $course }}</h1>
            <h2 class="text-xl mt-2 text-blue-200">{{ $lesson }}</h2>

            <div class="mt-6 space-y-6">
                @foreach ($content as $section)
                    <div class="bg-blue-500 bg-opacity-30 p-4 rounded-md">
                        <h3 class="text-lg font-semibold">{{ $section['section'] }}</h3>
                        <p class="mt-2">{{ $section['text'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-filament::page>
