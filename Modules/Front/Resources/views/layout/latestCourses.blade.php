<div class="box-filter">
    <div class="b-head">
        <h2>جدید ترین دوره ها</h2>
        <a href="{{ route("allCourse") }}">مشاهده همه</a>
    </div>
    <div class="posts">
      @foreach ($latestCourses as $courseItem)
        @include('front::layout.singleCourseBox')
      @endforeach
    </div>
</div>
