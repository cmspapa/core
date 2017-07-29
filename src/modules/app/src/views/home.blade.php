@extends(config('app.app_theme').'::master')
@section('head_scripts')
{{-- Add css or js to header --}}

@endsection
@section('title')
My title here
@endsection

@foreach($regions as $region)
	@section($region['id'])
		@foreach($region['blocks'] as $block)
			@include($block['id'].'::block')
		@endforeach
	@endsection
@endforeach

@section('footer_scripts')
{{-- Add css or js to footer --}}

@endsection