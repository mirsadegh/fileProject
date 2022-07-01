<p class="box__title">ایجاد دسته بندی جدید</p>
<form action="{{ route('admin.categories.store') }}" method="post" class="padding-30">
    @csrf
    <input type="text" name='title' placeholder="نام دسته بندی" class="text @error('title') is-invalid @enderror" value="{{ old('title') }}">
    @error('title')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror


    <input type="text" name="slug" placeholder="نام انگلیسی دسته بندی" class="text @error('slug') is-invalid @enderror" value="{{ old('slug') }}">

    @error('slug')
          <div class="alert alert-danger">{{ $message }}</div>
    @enderror


    <p class="box__title margin-bottom-15">انتخاب دسته والد</p>
    <select name="parent_id" id="parent_id" class="@error('parent_id') is-invalid @enderror" >
        <option value="">ندارد</option>
         @foreach ($categories as $category)
           <option value="{{ $category->id }}"  @if ($category->id == old('parent_id')) selected @endif  >{{ $category->title }}</option>
         @endforeach
    </select>
    @error('parent_id')
       <div class="alert alert-danger">{{ $message }}</div>
    @enderror


    <button class="btn btn-webamooz_net">اضافه کردن</button>
</form>
