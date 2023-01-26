@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700']) }}>
    {{-- null合体演算子 --}}
    {{-- 一つ目の値がnull出ないなら２つ目を実装 --}}
    {{ $value ?? $slot }}
</label>
