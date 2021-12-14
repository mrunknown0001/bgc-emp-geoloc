@extends('layouts.app')

@section('title')
	Report Details
@endsection

@section('style')
	<link href="https://cdn.bootcss.com/balloon-css/0.5.0/balloon.min.css" rel="stylesheet">
  <link href="{{ asset('magnify/css/jquery.magnify.css') }}" rel="stylesheet">
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
				<p><a href="{{ route('reports') }}" class="btn btn-primary btn-xs"><i class="fa fa-arrow-left"></i> Back to Reports</a></p>
				<p>Location: <strong>{{ $data->farm->code }} - {{ $data->cat == 'loc' ? $data->loc->location_name : $data->sub->location->location_name . ' - ' . $data->sub->sub_location_name }}</strong></p>
				<p>Date &amp; Time: <strong>{{ date('F j, Y h:i:s A', strtotime($data->created_at)) }}</strong></p>
				<p>Remarks: <strong>{{ $data->remarks }}</strong></p>
				@if(count($data->report_images) > 0)
					<h4>Images Uploaded</h4>
					<div class="image-set m-t-20">
						@foreach($data->report_images as $i)
							<a data-magnify="gallery" data-src="" data-caption="{{ $i->image_name }}" data-group="a" href="{{ asset('/uploads/images/' . $i->image_name) }}">
			          <img src="{{ asset('/uploads/images/' . $i->image_name) }}" alt="" height="50px">
			        </a>
						@endforeach
					</div>
				@endif
				<div id="mapholder" style="display: none;"></div>
			</div>
		</div>
		<div class="overlay"></div>
	</section>
</div>
@endsection

@section('script')
	<script src="https://cdn.bootcss.com/prettify/r298/prettify.min.js"></script>
	<script src="{{ asset('magnify/js/jquery.magnify.js') }}"></script>
	<script src="https://maps.google.com/maps/api/js?key=AIzaSyAQvHBXoM12klgegEIh1rTfklVQR3XkAXw"></script>

	<script>

		var lat = {{ $data->latitude }};
		var lon = {{ $data->longitude }};
		// var img_url = "https://maps.googleapis.com/maps/api/staticmap?center="+latlon+"&zoom=14&size=400x300&sensor=false&key=AIzaSyAQvHBXoM12klgegEIh1rTfklVQR3XkAXw";
	  var latlon=new google.maps.LatLng(lat, lon)
	  var mapholder=document.getElementById('mapholder')
	  mapholder.style.height='250px';
	  mapholder.style.width='100%';

	  var myOptions={
	  center:latlon,zoom:14,
	  mapTypeId:google.maps.MapTypeId.ROADMAP,
	  mapTypeControl:false,
	  navigationControlOptions:{style:google.maps.NavigationControlStyle.SMALL}
	  };
	  var map=new google.maps.Map(document.getElementById("mapholder"),myOptions);
	  var marker=new google.maps.Marker({position:latlon,map:map,title:"You are here!"});

		$("#showmap").click(function () {
			$("#mapholder").show();
		});


    window.prettyPrint && prettyPrint();

    var defaultOpts = {
      draggable: true,
      resizable: true,
      movable: true,
      keyboard: true,
      title: true,
      modalWidth: 320,
      modalHeight: 320,
      fixedContent: true,
      fixedModalSize: false,
      initMaximized: false,
      gapThreshold: 0.02,
      ratioThreshold: 0.1,
      minRatio: 0.05,
      maxRatio: 16,
      headToolbar: ['maximize', 'close'],
      footToolbar: ['zoomIn', 'zoomOut', 'prev', 'fullscreen', 'next', 'actualSize', 'rotateRight'],
      multiInstances: true,
      initEvent: 'click',
      initAnimation: true,
      fixedModalPos: false,
      zIndex: 1090,
      dragHandle: '.magnify-modal',
      progressiveLoading: true
    };
	</script>
@endsection