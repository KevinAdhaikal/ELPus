const swal2_mixin = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

const nama_buku = document.getElementById("nama_buku");
const cover_preview = document.getElementById('cover_preview');
const penulis = document.getElementById("penulis");
const penerbit = document.getElementById("penerbit");
const tahun_terbit = document.getElementById("tahun_terbit");

const nama_peminjam = document.getElementById("nama_peminjam");
const tanggal_pinjam = document.getElementById("tanggal_pinjam");
const tanggal_tempo = document.getElementById("tanggal_tempo");
const tanggal_kembali = document.getElementById("tanggal_kembali");
const denda = document.getElementById("denda");

const kembalikan_buku_modal_button = document.getElementById("kembalikan_buku_modal_button");

const peminjaman_table = $("#peminjaman_table").DataTable();
const peminjaman_modal = $("#peminjaman_modal");

peminjaman_table.on('click.button_view', '.action_view', async function () {
    const res = await fetch(`/pinjaman_by_id?id=${this.value}`, {
        method: "GET",
        credentials: "include"
    });

    if (res.status === 200) {
        const res_json = await res.json();
        cover_preview.src = `/cover_buku/${res_json.book.cover_buku}`;

        nama_buku.value = res_json.book.nama_buku;
        penulis.value = res_json.book.penulis;
        penerbit.value = res_json.book.penerbit;
        tahun_terbit.value = res_json.book.tahun_terbit;

        nama_peminjam.value = res_json.user.full_name;
        tanggal_pinjam.value = new Date(res_json.tanggal_pinjam).toLocaleString('id-ID', { day:'2-digit', month:'short', year:'numeric', hour:'2-digit', minute:'2-digit', second:'2-digit' }).replace(/\./g, ':');
        tanggal_tempo.value = new Date(res_json.tanggal_jatuh_tempo).toLocaleString('id-ID', { day:'2-digit', month:'short', year:'numeric', hour:'2-digit', minute:'2-digit', second:'2-digit' }).replace(/\./g, ':');;
        tanggal_kembali.value = res_json.tanggal_kembali ? new Date(res_json.tanggal_kembali).toLocaleString('id-ID', { day:'2-digit', month:'short', year:'numeric', hour:'2-digit', minute:'2-digit', second:'2-digit' }).replace(/\./g, ':') : "Belum Dikembalikan";
        denda.value = res_json.denda;

        kembalikan_buku_modal_button.onclick = () => {
            kembalikan_buku(this.value);
        };

        peminjaman_modal.modal("show");
    }
    else {
        const res_json = await res.json();
                
        swal2_mixin.fire({
            icon: "error",
            title: res_json.errors
        });
    }
});

function kembalikan_buku(id) {
    Swal.fire({
        title: "Kembalikan Buku",
        text: "Apakah buku ini sudah di kembalikan?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes",
        cancelButtonText: "No"
    }).then(async res => {
        if (res.isConfirmed) {
            const res = await fetch("/admin/kembalikan_pinjaman_buku", {
                headers: {
                    "Content-Type": "application/json"
                },
                method: "POST",
                credentials: "include",
                body: JSON.stringify({
                    id
                })
            })

            if (res.status === 200) {
                swal2_mixin.fire({
                    "icon": "success",
                    "title": "Buku berhasil di kembalikan!"
                })

                peminjaman_modal.modal("hide");

                // TODO: untuk table nya juga harus di update ini, dan di draw.
            } else {
                const res_json = await res.json();

                swal2_mixin.fire({
                    icon: "error",
                    title: res_json.errors
                });
            }
        }
    })
}