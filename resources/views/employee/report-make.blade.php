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
		<h1>Make Report: {{ $location->farm->code }} - {{ $cat == 'loc' ? $location->has_sublocation == 0 ? $location->location_name : 'Can\'t Create Report' : $location->location->location_name . ' - ' . $location->sub_location_name }}</h1>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				@include('includes.all')
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<form action="{{ route('submit.report') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group text-center">
						<div class="image-upload">
							<input type="file" class="uploadcam" name="upload" id="upload" accept="image/*" capture style="display: none">
							{{-- <input type="file" class="uploadcam" data-id="{{ $l->id }}" id="upload-{{ $l->id }}" name="upload" accept="image/*;capture=camera" style="display: none"> --}}
							<label for="upload">
								<span id="camera" class="btn btn-primary"><i class="fa fa-camera fa-3x"></i></span>
							</label>
						</div>
						<p><small>Multiple Image Upload. One at a time capture.</small></p>
					</div>

					<div class="form-group {{ $errors->first('remarks') ? 'has-error' : ''  }}">
						<label for="remarks">Remarks</label>
						<input type="text" name="remarks" id="remarks" placeholder="Remarks" class="form-control">
						@if($errors->first('remarks'))
            	<span class="help-block"><strong>{{ $errors->first('remarks') }}</strong></span>
            @endif
					</div>

					<div class="form-group text-center">
						<button class="btn btn-primary"><i class="fa fa-upload fa-3x"></i> Submit</button>
					</div>

				</form>
			</div>
		</div>
	</section>
</div>
@endsection

@section('script')

@endsection