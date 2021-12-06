@extends('layouts.app')

@section('title')
	QR Code Scanner
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
		<h1>QR Code Scanner</h1>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				@include('includes.all')
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 text-center">
				<video id="preview" class="p-1 border" style="width:80%;"></video>
				<div class="btn-group btn-group-toggle mb-5" data-toggle="buttons">
				  <button class="btn btn-success" id="startcamera">
				  	<i class="fa fa-play-circle"></i>
				  </button>
				  <label class="btn btn-primary active">
					<input type="radio" name="options" value="1" autocomplete="off" checked><i class="fa fa-sync"></i> Front
				  </label>
				  <label class="btn btn-warning">
					<input type="radio" name="options" value="2" autocomplete="off"><i class="fa fa-camera"></i> Back
				  </label>
				  <button class="btn btn-danger" id="stopcamera">
				  	<i class="fa fa-stop-circle"></i>
				  </button>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection

@section('script')
  <script src="{{ asset('js/instascan.js') }}"></script>
  <script type="text/javascript">
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 5, mirror: false });
    scanner.addListener('scan',function(content){
      // window.location.href = content;
      var path = content;
      // var getstr = path.substr(0, path.lastIndexOf("/",path.lastIndexOf("/") -1));
      var parts = path.split('/');
      var answer1 = parts[parts.length - 1]; // Last ==> ID of Location or Sub Location 
      var answer2 = parts[parts.length - 2]; // Second to the Last ==> Category
      window.location.href = "/e/location/" + answer2 + "/" + answer1;
    });
    Instascan.Camera.getCameras().then(function (cameras){
      if(cameras.length>0){
        scanner.start(cameras[1]);
        $('[name="options"]').on('change',function(){
          if($(this).val()==1){
            if(cameras[0]!=""){
              scanner.start(cameras[0]);
            }else{
              Swal.fire({
                title: 'No Front camera found!',
                text: "",
                type: 'info',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Close'
              });
            }
          }else if($(this).val()==2){
            if(cameras[1]!=""){
              scanner.start(cameras[1]);
            }else{
              Swal.fire({
                title: 'No Back camera found!',
                text: "",
                type: 'info',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Close'
              });
            }
          }
        });
      }else{
        console.error('No cameras found.');
        Swal.fire({
          title: 'No cameras found.',
          text: "",
          type: 'info',
          showCancelButton: false,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Close'
        });
      }
    }).catch(function(e){
      console.error(e);
      Swal.fire({
        title: 'Error!',
        text: "Please try again.",
        type: 'error',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Close'
      });
    });

    $("#stopcamera").click(function() {
      scanner.stop();
    });
    $("#startcamera").click(function() {
      scanner.start();
    });

    function isUrl(s) {
    var regexp = /(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
    return regexp.test(s);
    }
  </script>
@endsection