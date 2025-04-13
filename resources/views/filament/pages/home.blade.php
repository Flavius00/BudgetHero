<x-filament::page>
    <div class="relative bg-black min-h-screen p-6">
        <!-- Overlay întunecat -->
        <div class="absolute inset-0 bg-black bg-opacity-60"></div>

        <!-- Conținutul -->
        <div class="relative z-10 p-6 text-white">
            <h1 class="text-3xl font-bold">Bine ai venit pe Home Page</h1>
            <p class="mt-4 text-lg">
                Descoperă cum să îți gestionezi mai eficient bugetul, să înveți despre economii, credite și investiții și să îți îmbunătățești cunoștințele financiare prin lecții și provocări săptămânale!
            </p>

            <!-- Distribuitor de buget -->
            <div class="mt-8">
                <br>
                <h2 class="text-2xl font-semibold">Distribuitor de buget</h2>
                <p class="mt-2 text-lg">
                    Utilizatorii pot încărca un extras de cont în format CSV sau XLS, iar aplicația va analiza cheltuielile și va oferi recomandări personalizate pentru un buget eficient.
                </p>
            </div>

            <!-- Provocări financiare -->
            <div class="mt-8">
                <br>
                <h2 class="text-2xl font-semibold">Challenge-uri bazate pe cheltuielile tale</h2>
                <p class="mt-2 text-lg">
                    Provocările financiare personalizate vor fi generate pe baza cheltuielilor tale preluate din extrasul de cont. Scopul este să economisești și să îți gestionezi bugetul mai eficient.
                </p>
            </div>

            <div class="mt-8 flex justify-center">
                <img src="{{ asset('images/panoramic-view-dubai-city-illuminated-neon-spectrum.jpg') }}" alt="Financial City View" class="rounded-xl shadow-lg w-full max-w-3xl">
            </div>

            <!-- Lecții și Quiz-uri -->
            <div class="mt-8">
                <br>
                <h2 class="text-2xl font-semibold">Lecții și Quiz-uri</h2>
                <p class="mt-2 text-lg">
                    Fiecare săptămână aduce o lecție nouă despre economie, credite, dobânzi, investiții și altele. La finalul fiecărei lecții, vei putea răspunde la un quiz pentru a-ți testa cunoștințele.
                </p>
                <p class="mt-2 text-md italic text-gray-200">
                    *Quiz-ul poate fi dat o singură dată pe săptămână. Dacă răspunzi corect la unul din luna curentă, nu mai e nevoie să plătești.
                </p>

                <div class="space-y-4 mt-4">
                    <div class="bg-blue-500 bg-opacity-40 p-4 rounded-md">
                        <h3 class="font-semibold">Lecția săptămânii: Cum să economisești pentru un fond de urgență</h3>
                        <x-filament::button class="mt-2">Vizualizează Lecția</x-filament::button>
                    </div>

                    <div class="bg-green-500 bg-opacity-40 p-4 rounded-md">
                        <h3 class="font-semibold">Quiz: Testează-ți cunoștințele financiare!</h3>
                        <x-filament::button class="mt-2" href="{{ route('quiz') }}">Începe Quiz-ul</x-filament::button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament::page>
