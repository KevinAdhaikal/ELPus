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
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
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
  <div class="content-wrapper" id="co_wrap">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Profile</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col">
            <div class="card card-primary">
              <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('profile') }}" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                    <div class="col-12 col-sm-auto mb-3">
                      <div class="mx-auto" style="width: 140px;">
                        <div class="d-flex justify-content-center align-items-center rounded" style="height: 140px; background-color: rgb(233, 236, 239);">
                          <span style="color: rgb(166, 168, 170); font: bold 8pt Arial;"><img id="profile_img3" width="140" height="140" src="/profile_img/{{ Auth::user()->profile_img }}"></span>
                          <input type="file" id="profile_img_input" name="profile_img" accept="image/*" hidden onchange="preview_image(event)">
                          <input type="hidden" name="delete_photo" id="delete_photo_input" value="0">
                        </div>
                      </div>
                    </div>
                    <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                      <div class="text-center text-sm-left mb-2 mb-sm-0">
                        <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap" id="full_name_text">{{ Auth::user()->full_name }}</h4>
                        <p class="mb-0">{{ Auth::user()->username }}</p>
                        <div class="text-muted"><small>Updated at: {{ Auth::user()->updated_at->format('d M Y H:i:s') }}</small></div>
                        <div class="mt-2">
                          <button type="button" class="btn btn-primary" onclick="document.getElementById('profile_img_input').click()">
                            <i class="fa fa-fw fa-camera"></i>
                            <span>Change Photo</span>
                          </button>
                          <button id="delete_photo_button" class="btn btn-danger" type="button" onclick="delete_photo_function()" disabled>
                            <i class="fa fa-fw fa-trash"></i>
                            <span>Delete Photo</span>
                          </button>
                        </div>
                        @error('profile_img')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="text-center text-sm-right">
                        <div class="text-muted"><small>Created at: {{ Auth::user()->created_at->format('d M Y H:i:s') }}</small></div>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="form-group col-6">
                      <label for="nama_barang">Full Name</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" onkeypress="check_change()" value="{{ old('full_name', Auth::user()->full_name) }}" oninput="check_change()" placeholder="Full Name" autocomplete="off">
                      </div>
                      @error('full_name')
                          <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                    <div class="form-group col-6">
                      <label for="nama_barang">Username</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-at"></i></span>
                        </div>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" onkeypress="check_change()" value="{{ old('username', Auth::user()->username) }}" oninput="check_change()" placeholder="Username" autocomplete="off">
                      </div>
                      @error('username')
                          <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                  </div>
                  <div class="text-right">
                    <button type="submit" id="change_profile_button" class="text-right btn btn-success" disabled><i class="fa fa-save"></i> Save Profile</button>
                  </div>
                </form>
                <hr>
               <div class="mb-3">
                  <label class="d-block fw-bold">Change Password</label>
                  <small>Update your password to enhance your account security.</small>
                </div>
                <button type="button" class="btn btn-primary" onclick="$('#modal_change_password').modal('show')"><i class="fa fa-key"></i> Change Password</button>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="modal_change_password">
          <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h4 id="title-modal-mk" class="modal-title"><i class="fa fa-key"></i> Change Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="{{ route(name: 'change_password') }}" method="post">
                <div class="modal-body">
                  <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                      </div>
                      <input type="password" name="current_pass" class="form-control @error('current_pass') is-invalid @enderror" id="current_password" placeholder="Current Password" autocomplete="off">
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="current_password">
                          <i class="fas fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    @error('current_pass')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="new_password">New Password</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                      </div>
                      <input type="password" name="new_pass" class="form-control @error('new_pass') is-invalid @enderror" id="new_password" placeholder="New Password" autocomplete="off">
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="new_password">
                          <i class="fas fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    @error('new_pass')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="confirm_new_password">Confirm New Password</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                      </div>
                      <input type="password" name="new_pass_confirmation" class="form-control @error('new_pass_confirmation') is-invalid @enderror" id="confirm_new_password" placeholder="Confirm New Password" autocomplete="off">
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="confirm_new_password">
                          <i class="fas fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    @error('new_pass_confirmation')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary"><i class="fa fa-key"></i> Change Password</button>
                </div>
              </form>
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

@if($errors->has('old_pass') || $errors->has('new_pass'))
<script>
document.addEventListener("DOMContentLoaded", function() {
    $('#modal_change_password').modal('show');
});
</script>
@endif

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- Profile Script -->
<script src="{{ asset('dist/js/profile.js') }}"></script>
</body>
</html>
