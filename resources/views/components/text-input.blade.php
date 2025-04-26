@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge(['class' => 'border-green-300 dark:border-green-700 dark:bg-softwhite dark:text-black-300 focus:border-indigo-500 dark:focus:border-green-600 focus:ring-indigo-500 dark:focus:ring-green-600 rounded-md shadow-sm']) }}>
