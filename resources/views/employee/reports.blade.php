@extends('layouts.app')

@section('title')
	My Reports
@endsection

@section('style')
  <link href="{{ asset('datatables/jquery.dataTables.min.css') }}" rel="stylesheet">
  <link href="{{ asset('datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
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
		<h1>My Reports</h1>
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
			<div class="col-md-12">
	      <table id="reports" class="table cell-border compact stripe hover display nowrap" width="99%">
		      <thead>
	          <tr>
	            <th scope="col">Farm</th>
	            <th scope="col">Location</th>
	            <th scope="col">Date & Time</th>
	            <th scope="col">Action</th>
	          </tr>
	        </thead>
	      </table>
			</div>
		</div>
		<div class="overlay"></div>
	</section>
</div>
@endsection

@section('script')
	<script src="{{ asset('js/dataTables.js') }}"></script>
	<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>

	<script>
		$(document).ready(function () {
			let jotable = $('#reports').DataTable({
		        processing: true,
		        serverSide: true,
		        scrollX: true,
		        columnDefs: [
		          { className: "dt-center", targets: [ 0, 1, 2, 3 ] }
		        ],
				order: [0, 'desc'],
		        ajax: "{{ route('reports') }}",
		        columns: [
		            {data: 'farm', name: 'farm'},
		            {data: 'location', name: 'location'},
		            {data: 'date_time', name: 'date_time'},
		            {data: 'action', name: 'action', orderable: false, searchable: false},
		        ]
	      });


	    $(document).on('click', '#view', function (e) {
	        e.preventDefault();
	        var id = $(this).data('id');
	        // var text = $(this).data('text');
	        Swal.fire({
	          title: 'View Details?',
	          text: '',
	          type: 'question',
	          showCancelButton: true,
	          confirmButtonColor: '#3085d6',
	          cancelButtonColor: '#d33',
	          confirmButtonText: 'Continue'
	        }).then((result) => {
	          if (result.value) {
	            // view here
	            window.location.replace("/a/user/update/" + id);

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
	    });
		});
	</script>
@endsection