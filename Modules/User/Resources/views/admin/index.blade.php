@extends('dashboard::master')
@section('breadcrumb')
    <li><a href="{{ route('admin.users.index') }}" title="کاربران">کاربران</a></li>
@endsection
@section('content')
    <div class="row no-gutters  ">
        <div class="col-12 margin-left-10 margin-bottom-15 border-radius-3">
            <p class="box__title">کاربران</p>
            <div class="table__box">
                <table class="table">
                    <thead role="rowgroup">
                    <tr role="row" class="title-row">
                        <th>شناسه</th>
                        <th>نام و نام خانوادگی</th>
                        <th>ایمیل</th>
                        <th>شماره موبایل</th>
                        <th>سطح کاربری	</th>
                        <th>تاریخ عضویت</th>
                        <th>ای پی</th>
                        <th>وضعیت حساب</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                    <tr role="row" class="">
                        <td><a href="">{{ $user->id }}</a></td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->mobile }}</td>
                        <td>
                            <ul>
                                @foreach($user->roles as $userRole)
                                    <li class="deleteable-list-item">
                                        @lang($userRole->name)
                                        <a href="" class="item-delete mlg-15 d-none" onclick="deleteItem(event, '{{ route('admin.users.removeRole', ['user' => $user->id, 'role' => $userRole->name]) }}','li')" title="حذف"></a>
                                    </li>
                                @endforeach
                                <li class="btn btn-info"><a href="#select-role" rel="modal:open" onclick="setFormAction({{ $user->id }})">افزودن نقش کاربری</a></li>
                            </ul>
                        </td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->ip }}</td>
                        <td class="confirmation_status">{!! $user->hasVerifiedEmail() ? "<span class='text-success'>تایید شده</span>"  : "<span class='text-error'>تایید نشده</span>" !!}</td>
                        <td>
                            <a href="" onclick="deleteItem(event, '{{ route('admin.users.destroy', $user->id) }}')" class="item-delete mlg-15" title="حذف"></a>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="item-edit mlg-15" title="ویرایش"></a>
                            @if (!$user->hasVerifiedEmail())
    <a href="" onclick="updateConfirmationStatus(event, '{{ route('admin.users.manualVerify', $user->id) }}',
                                'آیا از تایید این آیتم اطمینان دارید؟' , 'تایید شده')" class="item-confirm mlg-15" title="تایید"></a>
                            @endif

                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <div id="select-role" class="modal">
                    <form action="{{ route('admin.users.addRole', 0) }}" id="select-role-form" method="post">
                        @csrf
                        <select name="role" id="">
                            <option value="">یک رول را انتخاب کنید.</option>
                            @foreach ($roles as $role)
                               <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-webamooz_net">افزودن</button>
                   </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

<script src="/panel/js/jquery.modal.min.js"></script>
<script>
    function setFormAction(userId) {
        $("#select-role-form").attr('action', '{{ route('admin.users.addRole', 0) }}'.replace('/0/', '/' + userId + '/' ))
    }
    @include('common::layouts.feedbacks')

</script>


@endsection

@section('css')
<link rel="stylesheet" href="/panel/css/jquery.modal.min.css" />

@endsection
