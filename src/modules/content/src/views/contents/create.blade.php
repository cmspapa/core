@extends(config('app.admin_theme').'::master')
@section('head_scripts')
{{-- Add css or js to header --}}
@endsection
@section('title')
Create {{$contentTypeId}}
@endsection
@section('sub_title')
	{{-- <small>Optional subtitle</small> --}}
@endsection
@section('breadcrumb')
	<li><a href="/admin"><i class="fa fa-dashboard"></i> Admin</a></li>
	<li><a href="/admin/contents"> Contents</a></li>
	<li><a href="/admin/contents/create"> Create content</a></li>
    <li class="active">Create {{$contentTypeId}}</li>
@endsection
@section('sidebare')
{{-- Add custom blocks to sidebare --}}
@endsection
@section('content')
{{-- Add main page content --}} 
<div class="box">
    {{-- <div class="box-header with-border">
      <h3 class="box-title"></h3>
    </div> --}}
    <form action="{{ action('\Cmspapa\content\Controllers\ContentsController@save', $contentTypeId) }}" method="POST" class="form-horizontal">
    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="box-body">
			{{-- check for fields type --}}
			@foreach($fields as $field)
			<div class="form-group">
				<label for="{{$field->field_id}}" class="col-sm-2 control-label">{{$field->field_label}}</label>
				<div class="col-sm-10">
					@if($field->field_type == 'text')
						<textarea name="{{$field->field_id}}" id="{{$field->field_id}}" class="form-control" rows="3" placeholder="Content {{$field->field_label}}"></textarea>
					@else
						<input type="text" class="form-control" name="{{$field->field_id}}" id="{{$field->field_id}}" placeholder="Content {{$field->field_label}}">
					@endif
					{{-- <p class="help-block">This {{$field->field_label}} must be unique.</p> --}}
				</div>
			</div>
			@endforeach
		</div>
		<div class="box-footer">
			<button type="submit" class="btn btn-primary pull-right">Save</button>
		</div>
    </form>
</div>
@endsection
@section('footer_right')
{{-- Anything you want --}} 
@endsection
@section('footer_scripts')
{{-- Add css or js to header --}}
@endsection