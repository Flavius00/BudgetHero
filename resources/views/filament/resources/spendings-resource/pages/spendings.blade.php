<x-filament::page>
    <x-filament::tabs>
        <x-filament::tabs.header>
            <x-filament::tabs.tab name="history" label="Spendings History" />
            <x-filament::tabs.tab name="prediction" label="Predicted Spendings" />
        </x-filament::tabs.header>

        <!-- <x-filament::tabs.content name="history">
            <x-filament::widget :widget="\App\Filament\Widgets\SpendingHistoryChart::class" />
        </x-filament::tabs.content> -->

        <x-filament::tabs.content name="prediction">
            <p>Coming soon...</p>
        </x-filament::tabs.content>
    </x-filament::tabs>
</x-filament::page>
