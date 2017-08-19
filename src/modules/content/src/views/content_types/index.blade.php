@extends(config('app.admin_theme').'::master')
@section('head_scripts')
{{-- Add css or js to header --}}
@endsection
@section('title')
Content types
@endsection
@section('sub_title')
	{{-- <small>Optional subtitle</small> --}}
@endsection
@section('breadcrumb')
	<li><a href="/admin"><i class="fa fa-dashboard"></i> Admin</a></li>
    <li class="active">Content types</li>
@endsection
@section('sidebare')
{{-- Add custom blocks to sidebare --}}
@endsection
@section('content')
{{-- Add main page content --}} 
<div style="text-align: right;">
	<a href="/admin/content-types/create" class="btn btn-primary margin-bottom">Create content type</a>
</div>
<div class="box">
    {{-- <div class="box-header">
      <h3 class="box-title">Responsive Hover Table</h3>

      <div class="box-tools">
        <div class="input-group input-group-sm" style="width: 150px;">
          <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

          <div class="input-group-btn">
            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
          </div>
        </div>
      </div>
    </div> --}}
    <!-- /.box-header -->
    @if($contentTypes->count())
	<div class="box-body table-responsive no-padding">
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Name</th>
					<th>Description</th>
					<th>Operations</th>
				</tr>
			</thead>
			<tbody>
			@foreach($contentTypes as $contentType)
				<tr>
					<td>{{ $contentType->name }} (id: {{ $contentType->ctid }})</td>
					<td>{{ $contentType->description }}</td>
					<td>
						<a href="{{ action('\Cmspapa\content\Controllers\ContentTypesController@manageFields', $contentType->ctid) }}">Manage fields</a>
						{{-- <a href="">Edit</a> --}}
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