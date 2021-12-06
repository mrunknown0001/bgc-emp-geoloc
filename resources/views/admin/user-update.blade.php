@extends('layouts.app')

@section('title')
	Update User
@endsection

@section('style')

@endsection

@section('header')
	@include('admin.includes.header')
@endsection

@section('sidebar')
	@include('admin.includes.sidebar')
@endsection

@section('content')
	<div class="content-wrapper">
	<section class="content-header">
		<h1>Update User</h1>
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
		</div>
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<h3>User Detail</h3>
				<form id="addUserForm" action="{{ route('admin.post.update.user', ['id' => $user->id]) }}" method="POST" autocomplete="off" multipart/form-data">
					@csrf
					<div class="form-group">
						<label for="first_name">First Name</label>
						<input type="text" placeholder="First Name" value="{{ $user->first_name }}" class="form-control" name="first_name" id="first_name" required>
					</div>
					<div class="form-group">
						<label for="last_name">Last Name</label>
						<input type="text" placeholder="Last Name" value="{{ $user->last_name }}" class="form-control" name="last_name" id="last_name" required>
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" placeholder="Email" value="{{ $user->email }}" class="form-control" name="email" id="email" required>
					</div>
					<div class="form-group">
						<label for="role">Role</label>
						<select class="form-control" id="role" name="role" required>
							<option value="">Select Role</option>
							<option value="2" {{ $user->role_id == 2 ? 'selected' : '' }}>Administrator</option>
							<option value="3" {{ $user->role_id == 3 ? 'selected' : '' }}>Manager</option>
							<option value="4" {{ $user->role_id == 4 ? 'selected' : '' }}>Employee</option>
						</select>
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="text" placeholder="Password" class="form-control" name="password" id="password">
					</div>
					
					<div class="form-group">
						<label for="active">Active?</label>
						<input type="checkbox" name="active" id="active" {{ $user->active == 1 ? 'checked' : '' }}>
					</div>

					<div class="form-group">
						<button class="btn btn-primary">Save</button>
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
    $('#addUserForm').on('submit',(function(e) {
      e.preventDefault();
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
          // Close Upload Animation here
          $("body").removeClass("loading");
          Swal.fire({
            title: 'User Updated!',
            text: "",
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Close'
          });
          // Clear Form
          $("#addUserForm").trigger("reset");
        },
        error: function(data){
          console.log(data.responseJSON);
          $("body").removeClass("loading");
          Swal.fire({
            type: 'error',
            title: 'Error Occured',
            text: 'Please Try Again.',
          });
        }
      });
    }));
  });
</script>
@endsection