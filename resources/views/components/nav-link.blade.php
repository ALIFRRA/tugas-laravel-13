<a {{ $attributes->merge(['class' => 'inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium leading-5 transition duration-150 ease-in-out'])->class([
    'border-shuka-pink text-slate-800' => $active ?? false,
    'border-transparent text-slate-500 hover:border-shuka-line hover:text-slate-700' => ! ($active ?? false),
]) }}>
    {{ $slot }}
</a>
