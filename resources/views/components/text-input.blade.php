@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge(['class' => 'border-green-700 bg-softwhite text-black-300 focus:border-green-600 focus:ring-green-600 rounded-md shadow-sm']) }}>
