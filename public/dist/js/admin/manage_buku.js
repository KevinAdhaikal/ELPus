const swal2_mixin = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

const nama_buku = document.getElementById("nama_buku");
const cover_buku = document.getElementById("cover_buku");
const cover_preview = document.getElementById('cover_preview');
const penulis = document.getElementById("penulis");
const penerbit = document.getElementById("penerbit");
const tahun_terbit = document.getElementById("tahun_terbit");
const stok = document.getElementById("stok");

const manage_buku_modal_title = document.getElementById("manage_buku_modal_title");
const manage_buku_modal_button = document.getElementById("manage_buku_modal_button"); 

const manage_buku_modal = $("#manage_buku_modal");
const manage_buku_table = $("#manage_buku_table").DataTable({
    rowId: 4,
    columns: [
        { data: 0 },
        { data: 1 },
        { data: 2 },
        { data: 3 }
    ],
    columnDefs: [
        { className: "text-center align-middle", targets: 3 }
    ]
});

manage_buku_table.on('click.button_edit', '.action_edit', async function () {
    const res = await fetch(`/buku_by_id?id=${this.value}`, {
        method: "GET",
        credentials: "include",
    });

    if (res.status === 200) {
        manage_buku_modal_title.innerText = "Edit Buku";
        manage_buku_modal_button.innerText = "Edit Buku";
        manage_buku_modal_button.disabled = false;
        manage_buku_modal_button.onclick = () => {
            edit_buku(this.value);
        }
        
        const res_json = await res.json();
        manage_buku_modal_title.innerText = "Tambah Buku";
        manage_buku_modal_button.innerText = "Tambah Buku";
        cover_preview.src = `/cover_buku/${res_json.cover_buku}`;
        cover_buku.value = "";
        console.log(cover_buku.files[0]);

        nama_buku.value = res_json.nama_buku;
        penulis.value = res_json.penulis;
        penerbit.value = res_json.penerbit;
        tahun_terbit.value = res_json.tahun_terbit;
        stok.value = res_json.stok;

        manage_buku_modal.modal("show");
        document.activeElement.blur();
    }
});

manage_buku_table.on('click.button_delete', '.action_delete', async function () {
    Swal.fire({
        title: "Hapus Buku",
        text: "Apakah anda yakin untuk hapus buku ini?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes",
        cancelButtonText: "No"
    }).then(async res => {
        if (res.isConfirmed) {
            let res = await fetch("/admin/manage_buku", {
                method: "DELETE",
                credentials: "include",
                body: new URLSearchParams({
                    "id": this.value,
                })
            })

            if (res.status === 200) {
                swal2_mixin.fire({
                    icon: "success",
                    title: "Buku berhasil di hapus!"
                })
                manage_buku_table.row("#" + this.value).remove().draw();
            } else {
                const res_json = await res.json();
                swal2_mixin.fire({
                    icon: "error",
                    title: res_json.errors
                })
            }
        }
    })
});

cover_buku.addEventListener('change', function(e) {
  const file = e.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      cover_preview.src = e.target.result;
    }
    reader.readAsDataURL(file);
  }
});

function tambah_buku_modal() {
    manage_buku_modal_title.innerText = "Tambah Buku";
    manage_buku_modal_button.innerText = "Tambah Buku";
    cover_preview.src = "/cover_buku/no_cover.svg";
    cover_buku.value = "";

    nama_buku.value = "";
    penulis.value = "";
    penerbit.value = "";
    tahun_terbit.value = "";
    stok.value = "";

    manage_buku_modal_button.onclick = () => tambah_buku();
    manage_buku_modal.modal("show");
}

async function edit_buku(id) {
    const formData = new FormData();
    formData.append("id", id);
    formData.append("nama_buku", nama_buku.value);
    formData.append("penulis", penulis.value);
    formData.append("penerbit", penerbit.value);
    formData.append("tahun_terbit", tahun_terbit.value);
    formData.append("stok", stok.value);

    if (cover_buku.files[0]) {
        formData.append("cover_buku", cover_buku.files[0]);
    }

    const res = await fetch("/admin/manage_buku", {
        method: "PATCH",
        credentials: "include",
        body: formData
    });

    if (res.status === 200) {
        const res_json = await res.json();

        manage_buku_table.row("#" + id).data([
            `<img width="200" height="300" style="object-fit: cover;" src="/cover_buku/${res_json.cover_buku}">`,
            res_json.nama_buku,
            res_json.stok,
            `<div class="text-center align-middle">
                <button type="button" class="text-right btn btn-primary action_edit" value="${res_json.id}"><i class="fa fa-eye"></i> View/Edit</button>
                <button type="button" class="text-right btn btn-danger action_delete" value="${res_json.id}"><i class="fas fa-trash"></i> Hapus</button>
            </div>`,
            res_json.id
        ]).draw();

        swal2_mixin.fire({
            icon: "success",
            title: "Buku berhasil di edit!" 
        })

        manage_buku_modal.modal("hide");
    }
}

async function tambah_buku() {
    const formData = new FormData();
    formData.append("nama_buku", nama_buku.value);
    formData.append("penulis", penulis.value);
    formData.append("penerbit", penerbit.value);
    formData.append("tahun_terbit", tahun_terbit.value);
    formData.append("stok", stok.value);

    if (cover_buku.files[0]) {
        formData.append("cover_buku", cover_buku.files[0]);
    }

    const res = await fetch("/admin/manage_buku", {
        method: "POST",
        credentials: "include",
        body: formData
    });

    if (res.status === 200) {
        const res_json = await res.json();

        manage_buku_table.row.add([
            `<img width="200" height="300" style="object-fit: cover;" src="/cover_buku/${res_json.cover_buku}">`,
            res_json.nama_buku,
            res_json.stok,
            `<div class="text-center align-middle">
                <button type="button" class="text-right btn btn-primary action_edit" value="${res_json.id}"><i class="fa fa-eye"></i> View/Edit</button>
                <button type="button" class="text-right btn btn-danger action_delete" value="${res_json.id}"><i class="fas fa-trash"></i> Hapus</button>
            </div>`,
            res_json.id
        ]).draw();

        swal2_mixin.fire({
            icon: "success",
            title: "Buku berhasil di tambahkan!" 
        })

        manage_buku_modal.modal("hide");
    }
    
}