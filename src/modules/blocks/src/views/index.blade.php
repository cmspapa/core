@extends(config('app.admin_theme').'::master')
@section('head_scripts')
{{-- Add css or js to header --}}
@endsection
@section('title')
Blocks
@endsection
@section('sub_title')
	{{-- <small>Optional subtitle</small> --}}
@endsection
@section('breadcrumb')
	<li><a href="/admin"><i class="fa fa-dashboard"></i> Admin</a></li>
    <li class="active">Blocks</li>
@endsection
@section('sidebare')
{{-- Add custom blocks to sidebare --}}
@endsection
@section('content')
<form action="{{ action('\Cmspapa\blocks\Controllers\BlocksController@save') }}" method="POST" class="form-inline" role="form">
	@foreach($regions as $region)
		<h3>@if(isset($region['name'])){{ $region['name'] }}@else{{ $region['id'] }}@endif</h3>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Block</th>
						<th>Region</th>
						<th>Order</th>
					</tr>
				</thead>
				<tbody>
					@foreach($region['blocks'] as $block)
					<tr>
						<td>
							@if(isset($block['name']))<p class="text-capitalize text-muted"><abbr title="{{ $block['id'] }}"><b>{{ $block['name'] }}</b></abbr> (<em>{{ $block['module_name'] }} module</em>).</p>@else<p class="text-warning">{{ $block['id'] }}</p>@endif
							@if(isset($block['description']))
								<p class="text-info small">{{ $block['description'] }}<p>
							@endif
						</td>
						<td>
							<div class="form-group">
								<select name="region[{{$block['id']}}]" class="form-control">
									<option value="">- None -</option>
									@foreach($regions as $regionOption)
										<option value="{{$regionOption['id']}}" @if($region['id'] == $regionOption['id']) selected @endif>@if(isset($regionOption['name'])){{ $regionOption['name'] }}@else{{ $regionOption['id'] }}@endif</option>
									@endforeach
								</select>
							</div>
						</td>
						<td>
							<div class="form-group">
								<select name="order[{{$block['id']}}]" class="form-control">
									@for($i = 0; $i < count($region['blocks']); $i++)
										<option value="{{$i}}" @if($block['order'] == $i) selected @endif>{{$i}}</option>
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
	@if(count($noneRegionblocks))
		<h3>None region blocks</h3>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Block</th>
						<th>Region</th>
					</tr>
				</thead>
				<tbody>
					@foreach($noneRegionblocks as $block)
					<tr>
						<td>
							@if(isset($block['name']))<p class="text-capitalize text-muted"><abbr title="{{ $block['id'] }}"><b>{{ $block['name'] }}</b></abbr></p>@else<p class="text-warning">{{ $block['id'] }}</p>@endif
							@if(isset($block['description']))
								<p class="text-info small">{{ $block['description'] }}<p>
							@endif
						</td>
						<td>
							<div class="form-group">
								<select name="region[{{$block['id']}}]" class="form-control">
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