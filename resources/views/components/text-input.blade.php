@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-shuka-line focus:border-shuka-pink focus:ring-shuka-pink rounded-md']) }}>
