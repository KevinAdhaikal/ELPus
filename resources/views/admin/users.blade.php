<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <title>{{ config('app.name') }} | Users</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <!-- iCheck Bootstrap -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Sweetalert2 -->
  <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <style>
    .hr-text {
        display: flex;
        align-items: center;
        text-align: center;
        font-weight: bold;
        color: currentColor;
    }

    .hr-text::before,
    .hr-text::after {
        content: "";
        flex: 1;
        border-bottom: 1px solid currentColor;
    }

    .hr-text::before {
        margin-right: 10px;
    }

    .hr-text::after {
        margin-left: 10px;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  @include('layouts.navbar')
  <!-- /.navbar -->
  
  <!-- Main Sidebar Container -->
  @include('layouts.sidebar')
  <!-- /.main-sidebar -->
   
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Users</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="card card-primary">
						<div class="card-body">
              <div class="col-3 row">
								<button type="button" class="btn btn-success btn-block" onclick="tambah_user_modal()"><i class="fa fa-plus"></i> Add User</button>
							</div>
							<br>
              <table id="users_table" style="table-layout: fixed;" class="table table-bordered table-striped table-hover display">
                <thead>
                  <th>Username</th>
                  <th>Full Name</th>
                  <th>Created At</th>
                  <th>Updated At</th>
                  <th>Action</th>
                </thead>
                <tbody>
                  @foreach ($users as $user)
                  <tr id="{{ $user->id }}">
                      <td>{{ $user->username }}</td>
                      <td>{{ $user->full_name }}</td>
                      <td>{{ $user->created_at->format('d M Y H:i:s') }}</td>
                      <td>{{ $user->updated_at->format('d M Y H:i:s') }}</td>
                      <td>
                        <center>
                          <button type="button" class="text-right btn btn-primary action_edit" value="{{ $user->id }}"><i class="fa fa-eye"></i> View/Edit</button>
                          <button type="button" class="text-right btn btn-danger action_delete" value="{{ $user->id }}" {{ $user->id == 1 ? 'disabled' : '' }}><i class="fa fa-trash"></i> Delete</button>
                        </center>
                      </td>
                  </tr>
                  @endforeach
                </tbody>
							</table>
						</div>
					</div>
        </div>
        <div class="modal fade" id="modal_user" style="display: none;" aria-hidden="true">
					<div class="modal-dialog modal-xl modal-dialog-centered">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title" id="modal_user_title">Add User</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">×</span>
								</button>
							</div>
							<div class="modal-body">
								<div class="form-group">
									<label for="username">Username</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-at"></i></span>
										</div>
										<input type="text" class="form-control" id="username" placeholder="Username" autocomplete="off">
									</div>
								</div>
								<div class="form-group">
									<label for="full_name">Full Name</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-user"></i></span>
										</div>
										<input type="text" class="form-control" id="full_name" placeholder="Full Name" autocomplete="off">
									</div>
								</div>
                <div class="form-group">
									<label for="full_name">Email</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-envelope"></i></span>
										</div>
										<input type="email" class="form-control" id="email" placeholder="Email" autocomplete="off">
									</div>
								</div>
                <div class="form-group">
									<label for="role">Role</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-user"></i></span>
										</div>
                    <select id="role" name="role" class="form-control">
                    @foreach ($roles as $role)
                      <option value="{{ $role->id }}">
                        {{ $role->name }}
                      </option>
                    @endforeach
                    </select>
									</div>
								</div>
								<div id="password_display" style="display: none;">
                  <label class="hr-text" id="change_password_label" style="display: none;">Change Password</label>
									<div class="form-group">
										<label for="password">Password</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="fas fa-key"></i></span>
											</div>
											<input type="password" class="form-control" id="password" placeholder="Password" autocomplete="off">
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password">
                          <i class="fas fa-eye"></i>
                        </button>
                      </div>
										</div>
									</div>
									<div class="form-group">
										<label for="confirm_password">Confirm Password</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="fas fa-key"></i></span>
											</div>
											<input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password" autocomplete="off">
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="confirm_password">
                          <i class="fas fa-eye"></i>
                        </button>
                      </div>
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer justify-content-between">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close (Esc)</button>
								<button type="button" class="btn btn-success" id="modal_user_button">Add User</button>
							</div>
						</div>
					</div>
				</div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  @include('layouts.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<!-- Sweetalert2 -->
<script src="{{ asset("plugins/sweetalert2/sweetalert2.all.min.js") }}"></script>
<!-- Users -->
<script src="{{ asset('dist/js/admin/users.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
</body>
</html>
