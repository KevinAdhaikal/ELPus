<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ELPus | Forgot Password</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="{{ route('login') }}" class="h1"><b>EL</b>Pus</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
      @if(session('success'))
          <div class="alert alert-success">
              {{ session('success') }}
          </div>
      @elseif ($errors->any())
          <div class="alert alert-danger">
              {{ $errors->first() }}
          </div>
      @elseif(session('error'))
          <div class="alert alert-danger">
              {{ session('error') }}
          </div>
      @endif

      @if(!session("code_sended"))
        <form action="{{ route('req_reset_code') }}" method="post">
          @csrf
          <div class="input-group mb-3">
            <input type="email" name="email" value="{{ old('email', '') }}" class="form-control" placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Send reset password code</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
      @else
        <form action="{{ route('forgot_password') }}" method="post">
          <div class="input-group mb-3">
            <input type="email" class="form-control" name="email" value="{{ session('code_sended') }}" placeholder="Email" readonly>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="ver_code" value="{{ old('ver_code', '') }}" placeholder="Verify Code">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-key"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="new_pass" value="{{ old('new_pass', '') }}" placeholder="New Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="new_pass_confirmation" value="{{ old('new_pass_confirmation', '') }}" placeholder="Confirm New Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Change Password</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
      @endif
      <hr class="my-3 border-gray-300">
      <a href="{{ route('login') }}"><-- Back to Login</a>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
</body>
</html>
