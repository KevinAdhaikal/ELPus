<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ELPus | Register</title>

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
<body class="hold-transition register-page">
<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href= {{ route("login") }} class="h1"><b>EL</b>Pus</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Create a new account</p>
      <form action="{{ route('register') }}" method="post">
        @csrf

        @if(session('error'))
          <div class="alert alert-danger">
            {{ session('error') }}
          </div>
        @endif

        <div class="input-group mb-1">
          <input 
            type="text" 
            name="full_name" 
            class="form-control @error('full_name') is-invalid @enderror" 
            placeholder="Full name"
            value="{{ old('full_name') }}"
          >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        @error('full_name')
          <small class="text-danger">{{ $message }}</small>
        @enderror

        <div class="input-group mb-1 mt-3">
          <input 
            type="text" 
            name="username" 
            class="form-control @error('username') is-invalid @enderror" 
            placeholder="Username"
            value="{{ old('username') }}"
          >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        @error('username')
          <small class="text-danger">{{ $message }}</small>
        @enderror

        <div class="input-group mb-1 mt-3">
          <input 
            type="email" 
            name="email" 
            class="form-control @error('email') is-invalid @enderror" 
            placeholder="Email"
            value="{{ old('email') }}"
          >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        @error('email')
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
        @enderror

        <div class="input-group mb-1 mt-3">
          <input 
            type="password" 
            name="password_confirmation" 
            class="form-control @error('password_confirmation') is-invalid @enderror" 
            placeholder="Confirm password"
          >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        @error('password_confirmation')
          <small class="text-danger">{{ $message }}</small>
        @enderror
        <button type="submit" class="btn btn-primary btn-block mt-3">
          Register
        </button>
      </form>
      
      <hr class="my-3 border-gray-300">
      <a href="{{ route('login') }}" class="text-center"><-- Back to Login</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
</body>
</html>
