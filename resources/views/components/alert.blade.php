@if (session('success'))
    <div class="mb-6 border border-shuka-pink/40 bg-shuka-soft px-4 py-3 text-sm text-pink-700">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-6 border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-6 border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
        <p class="font-medium">Periksa kembali isian form.</p>
        <ul class="mt-2 list-disc space-y-1 pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
