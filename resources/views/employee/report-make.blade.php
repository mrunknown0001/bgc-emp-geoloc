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
				<form id="reportform" action="{{ route('submit.report') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
					@csrf
					<input type="hidden" name="id" value="">
					<input type="hidden" name="cat" value="{{ $cat }}">
					<input type="hidden" name="farm" value="{{ $farm->id }}">
					<input type="hidden" name="location_id" value="{{ $location->id }}">
					<input type="hidden" class="lat" name="lat" id="latitude">
					<input type="hidden" class="lon" name="lon" id="longitude">
					<div class="form-group text-center">
						<div class="image-upload">
							<input type="file" class="uploadcam" name="upload" id="upload" accept="image/*" capture style="display: none">
							{{-- <input type="file" class="uploadcam" data-id="{{ $l->id }}" id="upload-{{ $l->id }}" name="upload" accept="image/*;capture=camera" style="display: none"> --}}
							<label for="upload">
								<span id="camera" class="btn btn-primary"><i class="fa fa-camera fa-3x"></i></span>
							</label>
						</div>
						{{-- <p><small>Multiple Image Upload. One at a time capture.</small></p> --}}
						<p><small>Tap to Capture Image.</small></p>
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
<script>
		$(document).ready(function() {
			getLocation();
		  $('#reportform').on('submit',(function(e) {
		    e.preventDefault();
				if ($('#upload').get(0).files.length === 0) {
				    // console.log("No files selected.");
			      Swal.fire({
						  type: 'error',
						  title: 'Image is Required',
						  text: 'Please Capture Image',
						});
						return null;
				}
				// Add Loading Animation here
		  	$("body").addClass("loading"); 
		    var formData = new FormData(this);
		    $.ajax({
		      type:'POST',
		      url: $(this).attr('action'),
		      data:formData,
		      cache:false,
		      contentType: false,
		      processData: false,
		      success:function(data){
		        // console.log("success");
		        // console.log(data);
		        // Close Upload Animation here
		        $("body").removeClass("loading");
		        Swal.fire({
		          title: 'Report Submitted!',
		          text: "",
		          type: 'success',
		          showCancelButton: false,
		          confirmButtonColor: '#3085d6',
		          cancelButtonColor: '#d33',
		          confirmButtonText: 'Close'
		        }).then((result) => {
		          if (result.value) {
		            window.location.replace("{{ route('emp.dashboard') }}");
		          }
		          else {
		            Swal.fire({
		              title: 'Action Cancelled',
		              text: "",
		              type: 'info',
		              showCancelButton: false,
		              confirmButtonColor: '#3085d6',
		              cancelButtonColor: '#d33',
		              confirmButtonText: 'Close'
		            });
		          }
		        });
		        // Clear Form
		        $("#reportform").trigger("reset");
		      },
		      error: function(data){
		        console.log(data);
		        $("body").removeClass("loading");
			      Swal.fire({
						  type: 'error',
						  title: 'Error Occured',
						  text: 'Please Try Again.',
						});
		      }
		    });
		  }));


		  $('#upload').change(function() {

		  });


			var options = {
			  enableHighAccuracy: false,
			  timeout: 30000,
			  maximumAge: 15000
			};

			function getLocation() {
			  if (navigator.geolocation) {
			    navigator.geolocation.getCurrentPosition(showPosition, showError, options);
			  } else { 
		      console.log('Geolocation Error');
			  }
			}

			function showPosition(position) {
				$('.lon').val(position.coords.longitude);
				$('.lat').val(position.coords.latitude)
				// console.log('Longitude:' + position.coords.longitude);
				// console.log('Latitude:' + position.coords.latitude);
			}

			function showError(error) {
				// Error Show on Sweet Alert
			  switch(error.code) {
			    case error.PERMISSION_DENIED:
			      // x.innerHTML = "User denied the request for Geolocation."
			      console.log("User denied the request for Geolocation.");
			      break;
			    case error.POSITION_UNAVAILABLE:
			      // x.innerHTML = "Location information is unavailable."
			      console.log("Location information is unavailable.");
			      break;
			    case error.TIMEOUT:
			      // x.innerHTML = "The request to get user location timed out."
			      console.log("The request to get user location timed out.");
			      break;
			    case error.UNKNOWN_ERROR:
			      // x.innerHTML = "An unknown error occurred."
			      console.log("An unknown error occurred.");
			      break;
			  }
			}


		});
</script>
@endsection