<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <title>{{ config('app.name') }} | List Peminjaman</title>

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
            <h1 class="m-0">List Peminjaman</h1>
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
              <table id="list_peminjaman_table" style="table-layout: fixed;" class="table table-bordered table-striped table-hover display">
                <thead>
                  <th>Cover Buku</th>
                  <th>Nama Buku</th>
                  <th>Mulai Pinjam</th>
                  <th>Akhir Pinjam</th>
                  <th>Denda</th>
                  <th>Action</th>
                </thead>
                <tbody>
                  @foreach ($pinjamans as $pinjaman)
                  <tr id="{{ $pinjaman->id }}">
                      <td>{{ $pinjaman->cover_buku }}</td>
                      <td>{{ $pinjaman->nama_buku }}</td>
                      <td>{{ $pinjaman->mulai_pinjam->format('d M Y H:i:s') }}</td>
                      <td>{{ $pinjaman->akhir_pinjam->format('d M Y H:i:s') }}</td>
                      <td>{{ $pinjaman->denda }}</td>
                      <td>
                        <center>
                          <button type="button" class="text-right btn btn-primary action_kembali" value="{{ $user->id }}"><i class="fa fa-undo"></i> Kembalikan Buku</button>
                        </center>
                      </td>
                  </tr>
                  @endforeach
                </tbody>
							</table>
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
<!-- List Peminjaman -->
<script src="{{ asset('dist/js/admin/list_peminjaman.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
</body>
</html>
