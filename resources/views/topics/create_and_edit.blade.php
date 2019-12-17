@extends('layouts.app')

@section('content')

<div class="container">
  <div class="col-md-10 offset-md-1">
    <div class="card ">

      <div class="card-header">
        <h2 class="">
          <i class="far fa-edit"></i>
          @if($topic->id)
            编辑话题
            {{--#{{ $topic->id }}--}}
          @else
            新建话题
          @endif
        </h2>
      </div>

      <div class="card-body">
        @if($topic->id)
          <form action="{{ route('topics.update', $topic->id) }}" method="POST" accept-charset="UTF-8">
          <input type="hidden" name="_method" value="PUT">
        @else
          <form action="{{ route('topics.store') }}" method="POST" accept-charset="UTF-8">
        @endif

          @include('common.error')

          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          
                <div class="form-group">
                	<label for="title-field">Title</label>
                	<input class="form-control" type="text" name="title" id="title-field"  placeholder="请填写标题" value="{{ old('title', $topic->title ) }}" />
                </div>

              <div class="form-group">
              <select class="form-control" name="category_id" required>
                <option value="" hidden disabled selected>请选择分类</option>
                @foreach ($categories as $value)
                  <option value="{{ $value->id }}">{{ $value->name }}</option>
                @endforeach
              </select>
            </div>

                <div class="form-group">
                	<label for="body-field">Body</label>
                	<textarea name="body" id="body-field" class="form-control" rows="6" placeholder="至少输入3个字符">{{ old('body', $topic->body ) }}</textarea>
                </div>


          <div class="well well-sm">
            <button type="submit" class="btn btn-primary">
              <i class="far fa-save mr-2" aria-hidden="true"></i>
              Save
            </button>
            {{--<a class="btn btn-link float-xs-right" href="{{ route('topics.index') }}"> <- Back</a>--}}
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
