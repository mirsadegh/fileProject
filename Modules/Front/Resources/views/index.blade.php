@extends('front::layout.master')

@section('content')
<main id="index">
    <article class="container article">
        @include('front::layout.header-ads')
        @include('front::layout.top-info')
        @include('front::layout.latestCourses')
        @include('front::layout.popularCourses')
    </article>
    @include('front::layout.latestArticles')
</main>

@endsection

