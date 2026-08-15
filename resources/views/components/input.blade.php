@props([
    'type' => 'text',
    'name',
    'label' => null,
    'value' => null,
    'required' => false,
])

<div {{ $attributes->only('class')->merge(['class' => 'space-y-1']) }}>
    @if($label)
        <label for="{{ $name }}" class="block text-xs font-semibold text-slate-700">{{ $label }} @if($required)<span class="text-rose-500">*</span>@endif</label>
    @endif

    @if($type === 'textarea')
        <textarea
            id="{{ $name }}"
            name="{{ $name }}"
            @if($required) required @endif
            {{ $attributes->except('class')->merge(['class' => 'block w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3 text-slate-900']) }}
        >{{ old($name, $value) }}</textarea>
    @elseif($type === 'select')
        <select
            id="{{ $name }}"
            name="{{ $name }}"
            @if($required) required @endif
            {{ $attributes->except('class')->merge(['class' => 'block w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3 text-slate-900 bg-white']) }}
        >
            {{ $slot }}
        </select>
    @else
        <input
            id="{{ $name }}"
            type="{{ $type }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            @if($required) required @endif
            {{ $attributes->except('class')->merge(['class' => 'block w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3 text-slate-900']) }}
        >
    @endif

    @error($name)
        <p class="text-xs text-rose-600 font-medium">{{ $message }}</p>
    @enderror
</div>
