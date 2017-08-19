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
	<li><a href="/admin/content-types/{{ $contentTypeId }}/manage-fields"> Manage {{ $contentTypeName }} fields</a></li>
    <li class="active">Create field</li>
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
    <form action="{{ action('\Cmspapa\content\Controllers\ContentTypesController@saveField', $contentTypeId) }}" method="POST" class="form-horizontal">
    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="box-body">
			<div class="form-group">
				<label for="field_label" class="col-sm-2 control-label">Label</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="field_label" id="field_label" placeholder="Field label">
					<p class="help-block">This label must be unique.</p>
				</div>
			</div>

			<div class="form-group">
				<label for="field_id" class="col-sm-2 control-label">Id</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="field_id" id="field_id" placeholder="Field id">
					<p class="help-block">A unique id for this field. It must only contain lowercase letters, numbers, and underscores.</p>
				</div>
			</div>

			<div class="form-group">
				<label for="field_id" class="col-sm-2 control-label">Id</label>
				<div class="col-sm-10">
					<select name="field_type" id="field_type" class="form-control">
						@foreach($fieldsTypes as $fieldTypeValue => $fieldTypeLabel)
							<option value="{{ $fieldTypeValue }}">{{ $fieldTypeLabel }}</option>
						@endforeach
					</select>
					<p class="help-block">A type of field you wish to create.</p>
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