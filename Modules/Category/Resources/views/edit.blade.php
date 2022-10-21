@extends('dashboard::master')

@section('breadcrumb')
<li><a href="{{ route('categories.index') }}" title="دسته بندی">دسته بندی</a></li>
<li><a href="#" title="ویرایش دسته بندی">ویرایش دسته بندی</a></li>
@endsection

@section('content')
    <div class="row no-gutters  ">
       <div class="col-4 bg-white">
        <p class="box__title"> ویرایش دسته بندی</p>
        <form action="{{ route('categories.update', $category->id) }}" method="post" class="padding-30">
            @csrf
            @method('patch')
            <input type="text" name='title' placeholder="نام دسته بندی" class="text" value="{{ $category->title }}">
            <input type="text" name="slug" placeholder="نام انگلیسی دسته بندی" class="text" value="{{ $category->slug }}">
            <div>
            <label for="" class="">دسته والد:</label>
                <input type="text"  class="text mb-3" value="{{ $category->parent }}" disabled>
            </div>
            <button class="btn btn-webamooz_net">بروزرسانی</button>
        </form>
      </div>
    </div>
@endsection
