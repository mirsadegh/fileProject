@extends("front::layout.master")


@section("content")

<main id="single">
    <div class="container">
        <article class="article">
            <div class="breadcrumb">
                <ul>
                    <li><a href="" title="خانه">بخش مقالات</a></li>
                    <li><a href="" title="">{{ $blog->title }}</a></li>
                </ul>
            </div>
            <div class="line"></div>
            <div class="post-title">
                <h1>{{ $blog->title }}</h1>
                <span class="like"></span>
            </div>
            <div class="post-details">
                <div class="post-author">نویسنده :  {{ $blog->user->name }}</div>
                <div class="post-date">تاریخ انتشار: {{ \Morilog\Jalali\Jalalian::forge($blog->published_at) }}</div>
            </div>
            <div class="post-img">
                <img src="{{ $blog->media->thumb }}" alt="">
            </div>
            <div class="post-content my-4">
                         {{ $blog->body }}
            </div>
            <div class="tags">
                <ul>
                    @foreach ($blog->convertTagsToArray() as $tag)
                                <li><a href="">{{ $tag }}</a></li>
                    @endforeach
                </ul>
            </div>
        </article>

    </div>
    @include("front::comments.index", ["commentable" => $blog])
</main>

@endsection

@section('js')
             <script src="/js/modal.js"></script>
@endsection

@section("css")
             <link rel="stylesheet" href="/css/modal.css">
@endsection


