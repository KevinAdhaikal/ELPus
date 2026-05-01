<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ELPus | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- Custom CSS for divider -->
  <link rel="stylesheet" href="{{ asset('dist/css/divider.css') }}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="{{ route('login') }}" class="h1"><b>EL</b>Pus</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>
      @if(session('error'))
          <div class="alert alert-danger">
              {{ session('error') }}
          </div>
      @elseif(session('success'))
          <div class="alert alert-success">
              {{ session('success') }}
          </div>
      @endif
      <form action="{{ route('login') }}" method="post">
        <div class="input-group mb-1">
          <input 
            type="text" 
            name="username_or_email" 
            class="form-control @error('username_or_email') is-invalid @enderror" 
            placeholder="Username / Email"
            value="{{ old('username_or_email') }}"
          >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        @error('username_or_email')
          <small class="text-danger">{{ $message }}</small>
        @enderror

        <div class="input-group mb-1 mt-3">
          <input 
            type="password" 
            name="password" 
            class="form-control @error('password') is-invalid @enderror" 
            placeholder="Password"
          >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        @error('password')
          <small class="text-danger">{{ $message }}</small>
          <br>
        @enderror
        <br>
        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
        <hr class="my-3 border-gray-300">
      </form>
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="{{ route('forgot_password') }}">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="{{ route('register') }}" class="text-center">Create an account</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
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
