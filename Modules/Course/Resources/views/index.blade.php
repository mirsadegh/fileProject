    @extends('dashboard::master')

    @section('breadcrumb')
    <li><a href="{{ route('courses.index') }}" title="دوره">دوره</a></li>
    @endsection

    @section('content')

    <div class="tab__box">
    <div class="tab__items">
    <a class="tab__item is-active" href="courses.html">لیست دوره ها</a>
    <a class="tab__item" href="approved.html">دوره های تایید شده</a>
    <a class="tab__item" href="new-course.html">دوره های تایید نشده</a>
    <a href="{{ route('courses.create') }}" title="ایجاد دوره جدید">ایجاد دوره جدید</a>
    </div>
    </div>
    <div class="row no-gutters">
    <div class="col-12 margin-left-10 margin-bottom-15 border-radius-3">
    <p class="box__title">دوره ها</p>
    <div class="table__box">
    <table class="table">
    <thead role="rowgroup">
    <tr role="row" class="title-row">
    <th>ردیف</th>
    <th>ای دی</th>
    <th>بنر</th>
    <th>عنوان</th>
    <th>مدرس</th>
    <th>قیمت</th>
    <th>جزییات</th>
    <th> درصد مدرس</th>
    <th>وضیعت</th>
    <th>وضیعت تایید</th>
    <th>عملیات</th>
    </tr>
    </thead>
    <tbody>
    @foreach($courses as $course)
    <tr role="row" class="">
    <td>{{ $course->priority }}</td>
    <td>{{ $course->id }}</td>
    <td width="80"><img src="{{ $course->banner->thumb }}" alt="" width="80"></td>
    <td><a href=""> {{ $course->title }}</a></td>
    <td><a href=""> {{ $course->teacher->name }}</a></td>
    <td>{{ $course->price }}</td>
    <td><a href="{{ route('courses.details',$course->id) }}">مشاهده</a></td>

    <td>{{ $course->percent }}</td>

    @if ($course->status == 'not-completed')
    <td class="status">@lang($course->status)</td>
    @elseif ($course->status == 'completed' )
    <td class="status text-success">@lang($course->status)</td>
    @elseif ($course->status == 'locked')
    <td class="status text-error">@lang($course->status)</td>
    @endif

    @if ($course->confirmation_status == 'accepted')
    <td class="confirmation_status text-success">@lang($course->confirmation_status)</td>
    @elseif ($course->confirmation_status == 'rejected')
    <td class="confirmation_status text-error">@lang($course->confirmation_status)</td>
    @elseif ($course->confirmation_status == 'pending')
    <td class="confirmation_status text-info">@lang($course->confirmation_status)</td>
    @endif



    <td>
    {{--                                    @can(\Modules\RolePermission\Entities\Permission::PERMISSION_MANAGE_COURSES)--}}

    <a href=""
    onclick="deleteItem(event,'{{ route('courses.destroy',$course->id) }}')"
    class="item-delete mlg-15" title="حذف"></a>
    @if($course->confirmation_status == 'pending')
    <a href="" onclick="updateConfirmationStatus(event,'{{ route('courses.accept',$course->id) }}','آیا از تایید این آیتم اطمینان دارید؟','تایید شده')"
    class="item-confirm mlg-15" title="تایید">
    </a>
    <a href="" onclick="updateConfirmationStatus(event,'{{ route('courses.reject',$course->id) }}','آیا از رد این آیتم اطمینان دارید؟','رد شده')"
    class="item-reject mlg-15" title="رد">
    </a>
    @elseif($course->confirmation_status == 'rejected')
    <a href="" onclick="updateConfirmationStatus(event,'{{ route('courses.accept',$course->id) }}','آیا از تایید این آیتم اطمینان دارید؟','تایید شده')"
    class="item-confirm mlg-15" title="تایید">
    </a>
    @elseif($course->confirmation_status == 'accepted')
    <a href="" onclick="updateConfirmationStatus(event,'{{ route('courses.reject',$course->id) }}','آیا از رد این آیتم اطمینان دارید؟','رد شده')"
    class="item-reject mlg-15" title="رد">
    </a>
    @endif


    @if ($course->status == 'not-completed')

    <a href="" onclick="updateConfirmationStatus(event,'{{ route('courses.completed',$course->id) }}','آیا از تکمیل شدن  این آیتم اطمینان دارید؟'
    ,'تکمیل شده','status')" class="item-slideshow mlg-15" title="تکمیل شده">
    </a>
    <a href="" onclick="updateConfirmationStatus(event,'{{ route('courses.lock',$course->id) }}','آیا از قفل کردن این آیتم اطمینان دارید؟'
    ,'قفل شده','status')" class="item-lock mlg-15" title="قفل">
    </a>

    @elseif ($course->status == 'completed')
    <a href="" onclick="updateConfirmationStatus(event,'{{ route('courses.lock',$course->id) }}','آیا از قفل کردن این آیتم اطمینان دارید؟'
    ,'قفل شده','status')" class="item-lock mlg-15" title="قفل">
    </a>
    @elseif ($course->status == 'locked')
    <a href="" onclick="updateConfirmationStatus(event,'{{ route('courses.completed',$course->id) }}','آیا از تکمیل شدن این آیتم اطمینان دارید؟'
    ,'تکمیل شده','status')" class="item-slideshow mlg-15" title="تکمیل شده">
    </a>

    @endif



    {{--                                    @endcan--}}

    <a href="" target="_blank" class="item-eye mlg-15" title="مشاهده"></a>
    <a href="{{ route('courses.edit',$course->id) }}" class="item-edit mlg-15" title="ویرایش"></a>
    </td>
    </tr>
    @endforeach
    </tbody>
    </table>
    </div>
    </div>
    </div>
    @endsection







