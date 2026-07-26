@props([
    'type' => 'text',
    'name',
    'label' => null,
    'value' => null,
    'required' => false,
])

<div {{ $attributes->only('class')->merge(['class' => '']) }}>
    @if($label)
        <label for="{{ $name }}" class="mb-1.5 block text-sm font-medium text-slate-700">{{ $label }}</label>
    @endif

    @if($type === 'textarea')
        <textarea
            id="{{ $name }}"
            name="{{ $name }}"
            @if($required) required @endif
            {{ $attributes->except('class')->merge(['class' => 'block w-full border-shuka-line text-sm focus:border-shuka-pink focus:ring-shuka-pink']) }}
        >{{ old($name, $value) }}</textarea>
    @elseif($type === 'select')
        <select
            id="{{ $name }}"
            name="{{ $name }}"
            @if($required) required @endif
            {{ $attributes->except('class')->merge(['class' => 'block w-full border-shuka-line text-sm focus:border-shuka-pink focus:ring-shuka-pink']) }}
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
            {{ $attributes->except('class')->merge(['class' => 'block w-full border-shuka-line text-sm focus:border-shuka-pink focus:ring-shuka-pink']) }}
        >
    @endif

    @error($name)
        <p class="mt-1.5 text-sm text-rose-500">{{ $message }}</p>
    @enderror
</div>
