<article class="container blog">
    <div class="b-head">
        <h2>آخرین مقالات</h2>
        <a href="">مشاهده همه</a>
    </div>
    <div class="articles">

        @foreach ($blogs as $blog)

            <div class="col">
                <a href="{{ route("blogs.single",$blog->slug) }}">
                    <div class="card-img"><img src="{{ $blog->media->thumb }}"></div>
                    <div class="card-title">
                        <h2>{{ $blog->title }} </h2>
                    </div>
                    <div class="card-body">
                    </div>
                    <div class="card-details">
                        <span class="b-view">80</span>
                        <span class="b-category">دسته بندی : {{ $blog->category->title }}</span>
                    </div>
                </a>
            </div>
        @endforeach

    </div>
</article>
