@extends(config('app.admin_theme').'::master')
@section('head_scripts')
{{-- Add css or js to header --}}
@endsection
@section('title')
Create content type
@endsection
@section('sub_title')
	{{-- <small>Optional subtitle</small> --}}
@endsection
@section('breadcrumb')
	<li><a href="/admin"><i class="fa fa-dashboard"></i> Admin</a></li>
	<li><a href="/admin/content-types"> Content types</a></li>
    <li class="active">Create content type</li>
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
    <form action="{{ action('\Cmspapa\content\Controllers\ContentTypesController@save') }}" method="POST" class="form-horizontal">
    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="box-body">
			<div class="form-group">
				<label for="name" class="col-sm-2 control-label">Name</label>
				<div class="col-sm-10">
					<input type="text" class="papa-field-name form-control" name="name" id="name" placeholder="Content type name">
					<p class="help-block">This name must be unique. <a class="papa-field-auto-id" href="javascript:void(0)">Id: <span></span></a></p>
				</div>
			</div>

			<div class="form-group papa-field-id-group">
				<label for="id" class="col-sm-2 control-label">Id</label>
				<div class="col-sm-10">
					<input type="text" class="papa-field-id form-control" name="ctid" id="ctid" placeholder="Content type id">
					<p class="help-block">A unique id for this content type. It must only contain lowercase letters, numbers, and underscores.</p>
				</div>
			</div>

			<div class="form-group">
				<label for="description" class="col-sm-2 control-label">Description</label>
				<div class="col-sm-10">
					<textarea class="papa-field-description form-control" name="description" id="description" placeholder="Content type description" rows="3"></textarea>
					<p class="help-block">Describe the content type will help data entry understand the purpose of this type and its guidelines.</p>
				</div>
			</div>
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