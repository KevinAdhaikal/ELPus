<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <title>{{ config('app.name') }} | Manage Buku</title>

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
            <h1 class="m-0">Manage Buku</h1>
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
								<button type="button" class="btn btn-success btn-block" onclick="tambah_buku_modal()"><i class="fa fa-plus"></i> Tambah Buku</button>
							</div>
							<br>
              <table id="manage_buku_table" style="table-layout: fixed;" class="table table-bordered table-striped table-hover display">
                <thead>
                  <th>Cover Buku</th>
                  <th>Nama Buku</th>
                  <th>Stok</th>
                  <th>Action</th>
                </thead>
                <tbody>
                  @foreach ($books as $book)
                  <tr id="{{ $book->id }}">
                    <td><img width="100" height="150" style="object-fit: cover;" src="/cover_buku/{{ $book->cover_buku }}"></td>
                    <td>{{ $book->nama_buku }}</td>
                    <td>{{ $book->stok }}</td>
                    <td>
                      <button type="button" class="text-right btn btn-primary action_edit" value="{{ $book->id }}"><i class="fa fa-eye"></i> View/Edit</button>
                      <button type="button" class="text-right btn btn-danger action_delete" value="{{ $book->id }}"><i class="fas fa-trash"></i> Hapus</button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
							</table>
						</div>
					</div>
        </div>
        <div class="modal fade" id="manage_buku_modal" aria-hidden="true">
          <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">

              <div class="modal-header">
                <h4 class="modal-title" id="manage_buku_modal_title">Tambah Buku</h4>
                <button type="button" class="close" data-dismiss="modal">
                  <span>×</span>
                </button>
              </div>

              <div class="modal-body">
                <div class="row">

                  <!-- COVER -->
                  <div class="col-md-4 text-center">
                    <label>Cover Buku</label>
                    <div class="mb-2">
                      <img id="cover_preview" src="https://via.nplaceholder.com/200x300?text=No+Image" width="200" height="300" style="object-fit: cover;" class="img-fluid rounded border">
                    </div>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="fas fa-image"></i>
                        </span>
                      </div>
                      <input type="file" class="form-control" id="cover_buku" accept="image/*">
                    </div>
                  </div>

                  <!-- FORM -->
                  <div class="col-md-8">

                    <!-- NAMA -->
                    <div class="form-group">
                      <label>Nama Buku</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fas fa-book"></i>
                          </span>
                        </div>
                        <input type="text" class="form-control" id="nama_buku" placeholder="Nama Buku">
                      </div>
                    </div>

                    <!-- PENULIS -->
                    <div class="form-group">
                      <label>Penulis</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fas fa-user"></i>
                          </span>
                        </div>
                        <input type="text" class="form-control" id="penulis" placeholder="Nama Penulis">
                      </div>
                    </div>

                    <!-- PENERBIT -->
                    <div class="form-group">
                      <label>Penerbit</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fas fa-building"></i>
                          </span>
                        </div>
                        <input type="text" class="form-control" id="penerbit" placeholder="Nama Penerbit">
                      </div>
                    </div>

                    <!-- TAHUN & STOK -->
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Tahun Terbit</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text">
                                <i class="fas fa-calendar"></i>
                              </span>
                            </div>
                            <input type="number" class="form-control" id="tahun_terbit" placeholder="2024">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Stok</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text">
                                <i class="fas fa-box"></i>
                              </span>
                            </div>
                            <input type="number" class="form-control" id="stok" placeholder="Jumlah stok">
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close (Esc)</button>
                <button type="button" class="btn btn-success" id="manage_buku_modal_button">
                  Simpan
                </button>
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
<!-- Manage Buku -->
<script src="{{ asset('dist/js/admin/manage_buku.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
</body>
</html>
