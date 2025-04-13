{{-- resources/views/filament/resources/csv-saves/index.blade.php --}}

<x-filament::page>
    <h2 class="text-2xl font-bold mb-4">Category Spendings</h2>

    <table class="min-w-full border text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 border">Category</th>
                <th class="px-4 py-2 border">Total Spent</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($spendings as $row)
                <tr>
                    <td class="px-4 py-2 border">{{ $row['category'] ?? 'Uncategorized' }}</td>
                    <td class="px-4 py-2 border">{{ number_format($row['total_spent'], 2) }} RON</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-filament::page>
