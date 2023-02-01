@props(['status' => 'info'])

@php
if($status === 'info') { $bgColor = 'bg-blue-300';}
if($status === 'error') { $bgColor = 'bg-red-300'; }
@endphp

@if(session('message'))
    <div class="{{ $bgColor }} w-1/2 mx-auto p-2 text-black">
        {{ session('message') }}
    </div>
@endif

{{-- {{ $bgColor }} --}}
