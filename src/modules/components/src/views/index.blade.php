@extends(config('app.admin_theme').'::master')
@section('head_scripts')
{{-- Add css or js to header --}}
@endsection
@section('title')
Components
@endsection
@section('sub_title')
	{{-- <small>Optional subtitle</small> --}}
@endsection
@section('breadcrumb')
	<li><a href="/admin"><i class="fa fa-dashboard"></i> Admin</a></li>
    <li class="active">Components</li>
@endsection
@section('sidebare')
{{-- Add custom components to sidebare --}}
@endsection
@section('content')
<form action="{{ action('\Cmspapa\components\Controllers\ComponentsController@save') }}" method="POST" class="form-inline" role="form">
	@foreach($regions as $region)
		<h3>@if(isset($region['name'])){{ $region['name'] }}@else{{ $region['id'] }}@endif</h3>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Component</th>
						<th>Region</th>
						<th>Order</th>
					</tr>
				</thead>
				<tbody>
					@foreach($region['components'] as $component)
					<tr>
						<td>
							@if(isset($component['name']))<p class="text-capitalize text-muted"><abbr title="{{ $component['id'] }}"><b>{{ $component['name'] }}</b></abbr> (<em>{{ $component['module_name'] }} module</em>).</p>@else<p class="text-warning">{{ $component['id'] }}</p>@endif
						</td>
						<td>
							<div class="form-group">
								<select name="region[{{$component['id']}}]" class="form-control">
									<option value="">- None -</option>
									@foreach($regions as $regionOption)
										<option value="{{$regionOption['id']}}" @if($region['id'] == $regionOption['id']) selected @endif>@if(isset($regionOption['name'])){{ $regionOption['name'] }}@else{{ $regionOption['id'] }}@endif</option>
									@endforeach
								</select>
							</div>
						</td>
						<td>
							<div class="form-group">
								<select name="order[{{$component['id']}}]" class="form-control">
									@for($i = 0; $i < count($region['components']); $i++)
										<option value="{{$i}}" @if($component['order'] == $i) selected @endif>{{$i}}</option>
									@endfor
								</select>
							</div>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	@endforeach
	@if(count($noneRegioncomponents))
		<h3>None region components</h3>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Component</th>
						<th>Region</th>
					</tr>
				</thead>
				<tbody>
					@foreach($noneRegioncomponents as $component)
					<tr>
						<td>
							@if(isset($component['name']))<p class="text-capitalize text-muted"><abbr title="{{ $component['id'] }}"><b>{{ $component['name'] }}</b></abbr></p>@else<p class="text-warning">{{ $component['id'] }}</p>@endif
						</td>
						<td>
							<div class="form-group">
								<select name="region[{{$component['id']}}]" class="form-control">
									<option value="" selected>- None -</option>
									@foreach($regions as $regionOption)
										<option value="{{$regionOption['id']}}">@if(isset($regionOption['name'])){{ $regionOption['name'] }}@else{{ $regionOption['id'] }}@endif</option>
									@endforeach
								</select>
							</div>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	@endif

	<button type="submit" class="btn btn-primary">Save</button>
</form>
@endsection
@section('footer_right')
{{-- Anything you want --}} 
@endsection
@section('footer_scripts')
{{-- Add css or js to header --}}
@endsection