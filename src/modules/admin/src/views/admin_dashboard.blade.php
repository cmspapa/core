@extends(config('app.admin_theme').'::master')
@section('head_scripts')
{{-- Add css or js to header --}}
@endsection
@section('title')
Dashboard
@endsection
@section('sub_title')
	{{-- <small>Optional subtitle</small> --}}
@endsection
@section('breadcrumb')
	<li><a href="/admin"><i class="fa fa-dashboard"></i> Admin</a></li>
    <li class="active">Dashboard</li>
@endsection
@section('sidebare')
{{-- Add custom blocks to sidebare --}}
@endsection
@section('content')
{{-- Add main page content --}} 
@endsection
@section('footer_right')
{{-- Anything you want --}} 
@endsection
@section('footer_scripts')
{{-- Add css or js to header --}}
@endsection