@props(['headers' => []])

<div class="overflow-x-auto border border-slate-200 bg-white rounded-lg shadow-sm">
    <table class="min-w-full divide-y divide-slate-200 text-left text-xs">
        <thead class="bg-slate-50 text-slate-700 uppercase font-bold text-[10px] tracking-wider">
            <tr>
                @foreach ($headers as $header)
                    <th class="whitespace-nowrap px-4 py-3">{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 text-slate-800">
            {{ $slot }}
        </tbody>
    </table>
</div>
