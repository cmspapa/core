@extends(config('app.admin_theme').'::master')
@section('head_scripts')
{{-- Add css or js to header --}}
@endsection
@section('title')
Manage {{ $contentTypeName }} fields
@endsection
@section('sub_title')
	{{-- <small>Optional subtitle</small> --}}
@endsection
@section('breadcrumb')
	<li><a href="/admin"><i class="fa fa-dashboard"></i> Admin</a></li>
	<li><a href="/admin/content-types"> Content types</a></li>
    <li class="active">Manage {{ $contentTypeName }} fields</li>
@endsection
@section('sidebare')
{{-- Add custom blocks to sidebare --}}
@endsection
@section('content')
{{-- Add main page content --}} 
<div style="text-align: right;">
	<a href="/admin/content-types/{{ $contentTypeId }}/manage-fields/create" class="btn btn-primary margin-bottom">Create field</a>
</div>
<div class="box">
    @if($fields->count())
	<div class="box-body table-responsive no-padding">
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Field label</th>
					<th>Field id</th>
					{{-- <th>Field type</th> --}}
					<th>Operations</th>
				</tr>
			</thead>
			<tbody>
			@foreach($fields as $field)
				<tr>
					<td>{{ $field->field_label }}</td>
					<td>{{ $field->field_id }}</td>
					{{-- <td>{{ $field->type }}</td> --}}
					<td>
						<a href="">Edit</a>
						<a href="">Delete</a>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
	@endif
</div>
@endsection
@section('footer_right')
{{-- Anything you want --}} 
@endsection
@section('footer_scripts')
{{-- Add css or js to header --}}
@endsection