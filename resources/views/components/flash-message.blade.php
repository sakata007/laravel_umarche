@props(['status' => 'info'])

@php
if(session('status') === 'info') { $bgColor = 'bg-blue-300';}
if(session('status') === 'alart') { $bgColor = 'bg-red-300'; }
@endphp

@if(session('message'))
    <div class="{{ $bgColor }} w-1/2 mx-auto p-2 text-black">
        {{ session('message') }}
    </div>
@endif

{{-- {{ $bgColor }} --}}
