<h1 style="text-align: center; font-size:64px">{{$product->title}}</h1>
<p style="font-size: 50px">{!! $product->description !!}</p>
@if(isset($images))
    @foreach($images as $photo)
        <img src="{{ $photo->getPath() }}" style="width: 700px; height: auto; padding: 10px">
    @endforeach
@endif