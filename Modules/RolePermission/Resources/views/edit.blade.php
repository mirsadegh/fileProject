@extends('dashboard::master')

@section('breadcrumb')
    <li><a href="{{ route('role-permissions.index') }}" title="نقشهای کاربری">نقشهای کاربری</a></li>
    <li><a href="#" title="ویرایش">ویرایش</a></li>
@endsection

@section('content')
    <div class="row no-gutters">
        <div class="col-6 bg-white">
            <p class="box__title">بروزرسانی نقش کاربری جدید</p>
            <form action="{{ route('role-permissions.update',$role->id) }}" method="post" class="padding-30">
                @csrf
                @method('patch')
                <input type="text" name="name" required placeholder="نام نقش کاربری" class="text"
                       value="{{ $role->name }}">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                   </span>
                @enderror
                <input type="hidden" name="id" value="{{ $role->id }}">
                <p class="box__title margin-bottom-15"> انتخاب مجوزها </p>

                @foreach($permissions as $permission)
                    <label class="ui-checkbox pt-1">
                        <input type="checkbox" name="permissions[{{ $permission->name }}]" class="sub-checkbox"
                               data-id="1"
                               value="{{ $permission->name }}"
                               @if($role->hasPermissionTo($permission->name)) checked @endif
                        >

                        <span class="checkmark"></span>
                        @lang($permission->name)
                    </label>
                @endforeach

                @error('permissions')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                   </span>
                @enderror
                <hr>

                <button class="btn btn-webamooz_net mt-2">بروزرسانی</button>
            </form>
        </div>
    </div>
@endsection


