<div>
    @if(empty($filename))
        <img src="{{ asset('images/no-image.png') }}" alt="">
    @else
        <img src="{{ asset('storage/shops/' . $filename) }}" alt="">
    @endif
</div>
