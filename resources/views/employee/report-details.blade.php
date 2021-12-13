@extends('layouts.app')

@section('title')
	Report Details
@endsection

@section('style')

@endsection

@section('header')
	@include('employee.includes.header')
@endsection

@section('sidebar')
	@include('employee.includes.sidebar')
@endsection

@section('content')
	<div class="content-wrapper">
	<section class="content-header">
		<h1>Report Details</h1>
		<ol class="breadcrumb">
			<li><a href="javascript:void(0)"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">@yield('title')</li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				@include('includes.all')
			</div>
			<div class="col-md-8">
				<p>Location: <strong>{{ $data->farm->code }} - {{ $data->cat == 'loc' ? $data->loc->location_name : $data->sub->location->location_name . ' - ' . $data->sub->sub_location_name }}</strong></p>
			</div>
		</div>
		<div class="overlay"></div>
	</section>
</div>
@endsection

@section('script')

@endsection