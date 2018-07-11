<a href="{{ route('banner.click',$banner) }}">
    <img width="{{ $banner->getWidth() }}" height="{{ $banner->getHeight() }}" src="{{ asset('storage/'.$banner->file) }}" />
</a>