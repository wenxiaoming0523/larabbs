@extends('layouts.app')

@section('content')

@section('styles')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/simditor.css') }}">
@stop
@section('scripts')
  <script type="text/javascript" src="{{asset('jquery.min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('js/module.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/hotkeys.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/uploader.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/simditor.js') }}"></script>
  <script>
    $(document).ready(function() {
      var editor = new Simditor({
        textarea: $('#editor'),
        upload: {
          url: '{{ route('topics.upload_image') }}',
          params: {
            _token: '{{ csrf_token() }}'
          },
          fileKey: 'upload_file',
          connectionCount: 1,
          leaveConfirm: '文件上传中，关闭此页面将取消上传。'
        },
    //    pasteImage: true,
      }); });
  </script>
@stop

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
                <label for="body-field">分类</label>
              <select class="form-control" name="category_id" required>
                <option value="" hidden disabled {{ $topic->id ? '' : 'selected' }}>请选择分类</option>
                @foreach ($categories as $value)
                  <option value="{{ $value->id }}">{{ $value->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
                	<label for="body-field">内容</label>
                	<textarea name="body" id="editor" class="form-control" rows="6" placeholder="至少输入3个字符">{{ old('body', $topic->body ) }}</textarea>
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
