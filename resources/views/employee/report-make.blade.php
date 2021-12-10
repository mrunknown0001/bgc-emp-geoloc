@extends('layouts.app')

@section('title')
	Make Report
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
	<section class="content-header text-center">
		<h1>Make Report: {{ $location->farm->code }} - {{ $cat == 'loc' ? $location->has_sublocation == 1 ? $location->location_name : $location->location->location_name . ' - ' . $location->sub_location_name }}</h1>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				@include('includes.all')
			</div>
		</div>
	</section>
</div>
@endsection

@section('script')

@endsection