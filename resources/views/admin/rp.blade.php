<?php
use App\Models\Roles;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name') }} | Roles & Permissions</title>
  
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
            <h1 class="m-0">Roles & Permissions</h1>
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
								<button type="button" class="btn btn-success btn-block" onclick="tambah_role_modal()"><i class="fa fa-plus"></i> Add Role</button>
							</div>
							<br>
              <table id="roles_table" style="table-layout: fixed;" class="table table-bordered table-striped table-hover display">
                <thead>
                  <th>Role Name</th>
                  <th>Created At</th>
                  <th>Updated At</th>
                  <th>Action</th>
                </thead>
                <tbody>
                  @foreach ($roles as $role)
                  <tr id="{{ $role->id }}">
                      <td>{{ $role->name }}</td>
                      <td>{{ $role->created_at->format('d M Y H:i:s') }}</td>
                      <td>{{ $role->updated_at->format('d M Y H:i:s') }}</td>
                      <td>
                        <center>
                          <button type="button" class="text-right btn btn-primary action_edit" value="{{ $role->id }}"><i class="fa fa-eye"></i> View/Edit</button>
                          <button type="button" class="text-right btn btn-danger action_delete" value="{{ $role->id }}" {{ $role->id == 1 ? 'disabled' : '' }}><i class="fa fa-trash"></i> Delete</button>
                        </center>
                      </td>
                  </tr>
                  @endforeach
                </tbody>
							</table>
						</div>
					</div>
        </div>
        <div class="modal fade" id="modal_role" style="display: none;" aria-hidden="true">
					<div class="modal-dialog modal-xl modal-dialog-centered">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title" id="modal_role_title">Add Role</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">×</span>
								</button>
							</div>
							<div class="modal-body">
								<div class="form-group">
									<label for="username">Role Name</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-user-tag"></i></span>
										</div>
										<input type="text" class="form-control" id="role_name" placeholder="Role Name" autocomplete="off">
									</div>
								</div>
                <div class="form-group">
                  <label class="hr-text">Hak Akses</label>
                  <div class="row">

                    <!-- AKSES MEMBER -->
                    <div class="col-md-4">
                      <label class="mb-2">Akses Member</label>

                      <div class="icheck-primary">
                        <input class="perm_cb" type="checkbox" id="daftar_buku" value="{{ Roles::DAFTAR_BUKU }}">
                        <label for="daftar_buku">Daftar Buku</label>
                      </div>

                      <div class="icheck-primary">
                        <input class="perm_cb" type="checkbox" id="pinjam_buat" value="{{ Roles::PINJAM_BUAT }}">
                        <label for="pinjam_buat">Ajukan Peminjaman</label>
                      </div>

                      <div class="icheck-primary">
                        <input class="perm_cb" type="checkbox" id="pinjam_lihat_sendiri" value="{{ Roles::PINJAM_LIHAT_SENDIRI }}">
                        <label for="pinjam_lihat_sendiri">Lihat Peminjaman Sendiri</label>
                      </div>

                      <div class="icheck-primary">
                        <input class="perm_cb" type="checkbox" id="pinjam_batal" value="{{ Roles::PINJAM_BATAL }}">
                        <label for="pinjam_batal">Batalkan Peminjaman</label>
                      </div>
                    </div>

                    <!-- MANAJEMEN BUKU -->
                    <div class="col-md-4">
                      <label class="mb-2">Manajemen Buku</label>

                      <div class="icheck-primary">
                        <input class="perm_cb" type="checkbox" id="manajemen_buku_lihat" value="{{ Roles::MANAJEMEN_BUKU_LIHAT }}">
                        <label for="manajemen_buku_lihat">Lihat Buku</label>
                      </div>

                      <div class="icheck-primary">
                        <input class="perm_cb" type="checkbox" id="mnajemen_buku_tambah" value="{{ Roles::MANAJEMEN_BUKU_TAMBAH }}">
                        <label for="mnajemen_buku_tambah">Tambah Buku</label>
                      </div>

                      <div class="icheck-primary">
                        <input class="perm_cb" type="checkbox" id="manajemen_buku_edit" value="{{ Roles::MANAJEMEN_BUKU_EDIT }}">
                        <label for="manajemen_buku_edit">Edit Buku</label>
                      </div>

                      <div class="icheck-primary">
                        <input class="perm_cb" type="checkbox" id="manajemen_buku_hapus" value="{{ Roles::MANAJEMEN_BUKU_HAPUS }}">
                        <label for="manajemen_buku_hapus">Hapus Buku</label>
                      </div>
                    </div>

                    <!-- MANAJEMEN PEMINJAMAN -->
                    <div class="col-md-4">
                      <label class="mb-2">Manajemen Peminjaman</label>

                      <div class="icheck-primary">
                        <input class="perm_cb" type="checkbox" id="pinjam_setujui" value="{{ Roles::PINJAM_SETUJUI }}">
                        <label for="pinjam_setujui">Setujui / Tolak Peminjaman</label>
                      </div>

                      <div class="icheck-primary">
                        <input class="perm_cb" type="checkbox" id="pinjam_kembali" value="{{ Roles::PINJAM_KEMBALI }}">
                        <label for="pinjam_kembali">Pengembalian Buku</label>
                      </div>

                      <div class="icheck-primary">
                        <input class="perm_cb" type="checkbox" id="pinjam_lihat_semua" value="{{ Roles::PINJAM_LIHAT_SEMUA }}">
                        <label for="pinjam_lihat_semua">Lihat Semua Peminjaman</label>
                      </div>
                    </div>

                    <!-- LAINNYA -->
                    <div class="col-md-4 mt-3">
                      <label class="mb-2">Lainnya</label>

                      <div class="icheck-primary">
                        <input class="perm_cb" type="checkbox" id="laporan_lihat" value="{{ Roles::LAPORAN_LIHAT }}">
                        <label for="laporan_lihat">Lihat Laporan</label>
                      </div>

                      <div class="icheck-primary">
                        <input class="perm_cb" type="checkbox" id="denda_kelola" value="{{ Roles::DENDA_KELOLA }}">
                        <label for="denda_kelola">Kelola Denda</label>
                      </div>
                    </div>

                  </div>
                </div>
							</div>
							<div class="modal-footer justify-content-between">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="button" class="btn btn-success" id="modal_role_button">Add Role</button>
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
<!-- Roles & Permissions -->
<script src="{{ asset('dist/js/admin/rp.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
</body>
</html>
