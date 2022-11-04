
@extends("dashboard::master")

@section('breadcrumb')
<li><a href="{{ route('blogs.admin.index') }}" title="مقالات">مقالات</a></li>
@endsection
@section("content")

    <div class="main-content">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item is-active" href="">لیست مقالات</a>
                <a class="tab__item " href="{{ route("blogs.admin.create") }}">ایجاد مقاله جدید</a>
            </div>
        </div>
        <div class="bg-white padding-20">
            <div class="t-header-search">
                <form action="" onclick="event.preventDefault();">
                    <div class="t-header-searchbox font-size-13">
                        <input type="text" class="text search-input__box font-size-13" placeholder="جستجوی مقاله">
                        <div class="t-header-search-content ">
                            <input type="text"  class="text"  placeholder="نام مقاله">
                            <input type="text"  class="text margin-bottom-20" placeholder="نام نویسنده">
                            <btutton class="btn btn-webamooz_net">جستجو</btutton>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="table__box">
            <table class="table">

                <thead role="rowgroup">
                <tr role="row" class="title-row">
                    <th>شناسه</th>
                    <th>عنوان</th>
                    <th>نویسنده</th>
                    <th>خلاصه متن</th>
                    <th>تاریخ ایجاد</th>
                    <th>تعداد بازدید ها</th>
                    <th>تعداد نظرات</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                   @foreach ($blogs as $blog)
                        <tr role="row" class="">
                            <td>{{ $loop->iteration }}</td>
                            <td><a href="">{{ $blog->title }}</a></td>
                            <td>{{ $blog->user->name }} </td>
                            <td>{{ Str::limit($blog->summary,30) }}</td>
                            <td>{{ \Morilog\Jalali\Jalalian::fromCarbon($blog->created_at) }}</td>
                            <td>101</td>
                            <td>{{ count($blog->comments)  }}</td>
                            <td>

                               <a onclick="deleteItem(event, '{{ route('blogs.admin.destroy', $blog->id) }}')" class="item-delete mlg-15" title="حذف"></a>
                                <a href="{{ route("blogs.admin.edit",$blog->id) }}" class="item-edit" title="ویرایش"></a>
                            </td>
                        </tr>
                   @endforeach




                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
