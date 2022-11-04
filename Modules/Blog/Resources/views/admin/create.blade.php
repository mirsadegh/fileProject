@extends("dashboard::master")

@section('breadcrumb')
<li><a href="{{ route('blogs.admin.index') }}" title="مقالات">مقالات</a></li>
<li><a href="create-new-course.html"  class="is-active" >ایجاد مقاله جدید</a></li>
@endsection
@section("content")

    <div class="main-content padding-0">
        <p class="box__title">ایجاد مقاله جدید</p>
        <div class="row no-gutters bg-white">
            <div class="col-12">
                <form action="{{ route("blogs.admin.store") }}" method="post"class="padding-30" id="form" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                     <section class="col-12 mb-2">
                        <div class="form-group">
                            <label for="">عنوان مقاله</label>
                            <input type="text" name="title" class="text form-control col-md-6 mb-4" />
                        </div>
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </section>
                 

                    <section class="col-12 mb-4">
                        <div class="form-group">
                            <label for="">انتخاب دسته</label>
                            <select name="category_id" class="">
                                <option value="">دسته را انتخاب کنید</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" @if(old('category_id') == $category->id) selected @endif>{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('category_id')
                            <span class="invalid-feedback" role="alert">
                                 <strong>
                                     {{ $message }}
                                 </strong>
                            </span>
                        @enderror
                    </section>


                    <section class="col-12  mb-4">
                        <div class="form-group">
                            <label for="status">وضعیت</label>
                            <select name="status" id="status" class="">
                                <option value="0" @if (old('status')== 0) selected  @endif>غیر فعال</option>
                                <option value="1" @if (old('status')== 1) selected  @endif>فعال</option>
                            </select>
                         </div>
                        @error('status')
                        <span class="invalid-feedback" role="alert">
                           <strong>
                               {{ $message }}
                           </strong>
                        </span>
                        @enderror
                    </section>

                    <section class="col-12  mb-4">
                        <div class="form-group">
                            <label for="commentable">امکان درج کامنت</label>
                            <select name="commentable" id="commentable" class="">
                                <option value="0" @if (old('commentable')== 0) selected  @endif>غیر فعال</option>
                                <option value="1" @if (old('commentable')== 1) selected  @endif>فعال</option>
                            </select>
                        </div>

                        @error('commentable')
                            <span class="invalid-feedback" role="alert">
                               <strong>
                                   {{ $message }}
                               </strong>
                            </span>
                        @enderror
                    </section>


                    <section class="col-12 mb-4">
                        <div class="form-group">
                            <label for="">تاریخ انتشار</label>
                            <input type="text" name="published_at" id="published_at" class="d-none">
                            <input type="text" id="published_at_view" class="form-control form-control-sm text" style="margin-top: 0">
                        </div>
                        @error('published_at')
                            <span class="invalid-feedback" role="alert">
                               <strong>
                                   {{ $message }}
                               </strong>
                            </span>
                        @enderror

                    </section>


                    <div class="file-upload my-4">
                        <div class="i-file-upload">
                            <span>آپلود بنر دوره</span>
                            <input type="file" class="file-upload" id="files" name="image"/>
                        </div>
                        <span class="filesize"></span>
                        <span class="selectedFiles">فایلی انتخاب نشده است</span>
                        @error('image')
                            <span class="invalid-feedback" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                            </span>
                        @enderror
                    </div>

                    <section class="col-12 mb-4">
                        <div class="form-group">
                            <label for="tags">تگ ها</label>
                            <input type="hidden"  name="tags" id="tags" value="{{ old('tags') }}">
                            <select class="select2 d-none" id="select_tags" multiple>

                            </select>
                        </div>
                        @error('tags')
                            <span class="invalid-feedback" role="alert">
                              <strong>
                                  {{ $message }}
                              </strong>
                            </span>
                        @enderror
                    </section>



                    <section class="col-12 mb-3">
                        <div class="form-group">
                            <label for="">خلاصه مقاله </label>
                            <textarea name="summary" id="summary" class="form-control form-control-sm" rows="6">{{ old('summary') }}</textarea>
                        </div>
                        @error('summary')
                            <span class="invalid-feedback" role="alert">
                                  <strong>
                                      {{ $message }}
                                  </strong>
                            </span>
                        @enderror

                    </section>
                    <section class="col-12 mb-4">
                        <div class="form-group">

                            <label for="">متن مقاله</label>
                            <textarea name="body" id="body" class="form-control form-control-sm"  rows="6">{{ old('body') }}</textarea>
                        </div>
                        @error('body')
                            <span class="invalid-feedback" role="alert">
                                      <strong>
                                          {{ $message }}
                                      </strong>
                            </span>
                        @enderror
                    </section>

                </div>

                    <button class="btn btn-webamooz_net mb-4" style="float: left;">ایجاد مقاله</button>
                </form>
            </div>
        </div>
    </div>

@endsection


@section("js")
    {{-- <script src="/assets/persianDatePicker/js/persianDatepicker.min.js"></script> --}}
    <script src="/js/select2.min.js"></script>
    <script src="{{ asset('panel/jalalidatepicker/persian-date.min.js') }}"></script>
    <script src="{{ asset('panel/jalalidatepicker/persian-datepicker.min.js') }}"></script>

    <script>
        $(document).ready(function(){
            $('#published_at_view').persianDatepicker({
                format: 'YYYY/MM/DD',
                altField: '#published_at'
            })
        });
    </script>
<script>
    $(document).ready(function(){
        var tags_input = $('#tags');
        var select_tags = $('#select_tags');
        var default_tags = tags_input.val();
        var default_data = null;

        if(tags_input.val()  !== null && tags_input.val().length > 0){
            default_data = default_tags.split(',')

        }
        select_tags.select2({
            placeholder : 'لطفا تگ های خود را وارد نمایید',
            tags: true,
            data: default_data,
            dir:"rtl",

        });

        select_tags.children('option').attr('selected',true).trigger('change');

        $('#form').submit(function(event){
            if(select_tags.val()  !== null && select_tags.val().length > 0){
                var selectedSource = select_tags.val().join(',');
                tags_input.val(selectedSource);
            }
        })
    })
</script>

@endsection

@section("css")

    <link href="/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('panel/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection

