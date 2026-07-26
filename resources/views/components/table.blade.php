@props(['headers' => []])

<div class="overflow-x-auto border border-shuka-line bg-white">
    <table class="min-w-full divide-y divide-shuka-line text-left text-sm">
        <thead class="bg-slate-50 text-slate-500">
            <tr>
                @foreach ($headers as $header)
                    <th class="whitespace-nowrap px-4 py-3 font-medium">{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody class="divide-y divide-shuka-line text-slate-700">
            {{ $slot }}
        </tbody>
    </table>
</div>
