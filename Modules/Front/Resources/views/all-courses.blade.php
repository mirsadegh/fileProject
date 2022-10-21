@extends("front::layout.master")
@section("content")
<main id="index">
    <article class="container article">
        <div class="ads">
            <a href="" rel="nofollow noopener"><img src="img/ads/1440px/test.jpg" alt=""></a>
        </div>
        <div class="posts">

           @foreach ($courses as $courseItem)

              @include('front::layout.singleCourseBox')
           @endforeach
        </div>
    </article>
</main>
@endsection
