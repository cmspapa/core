@extends(config('app.admin_theme').'::master')
@section('head_scripts')
{{-- Add css or js to header --}}
@endsection
@section('title')
	@if(Request::is('admin/contents'))
		List contents
	@else
		Create content
	@endif
@endsection
@section('sub_title')
	{{-- <small>Optional subtitle</small> --}}
@endsection
@section('breadcrumb')
	<li><a href="/admin"><i class="fa fa-dashboard"></i> Admin</a></li>
	<li><a href="/admin/contents"> Contents</a></li>
	@if(Request::is('admin/contents'))
		<li class="active">List contents</li>
	@else
		<li class="active">Create content</li>
	@endif
    
@endsection
@section('sidebare')
{{-- Add custom blocks to sidebare --}}
@endsection
@section('content')
{{-- Add main page content --}} 
<div class="box">
    @foreach($contentTypes as $contentType)
    	<div>
    		@if(Request::is('admin/contents'))
    			<a href="/admin/contents/{{$contentType->ctid}}">List {{$contentType->name}}</a>
    		@else
    			<a href="/admin/contents/{{$contentType->ctid}}/create">Create {{$contentType->name}}</a>
    		@endif
    	</div>
    	<hr>
    @endforeach
</div>
@endsection
@section('footer_right')
{{-- Anything you want --}} 
@endsection
@section('footer_scripts')
{{-- Add css or js to header --}}
@endsection