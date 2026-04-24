const swal2_mixin = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

const buku_modal_button = document.getElementById("buku_modal_button");

const nama_buku = document.getElementById("nama_buku");
const cover_preview = document.getElementById('cover_preview');
const penulis = document.getElementById("penulis");
const penerbit = document.getElementById("penerbit");
const tahun_terbit = document.getElementById("tahun_terbit");
const stok = document.getElementById("stok");

const buku_modal = $("#buku_modal");
const daftar_buku_table = $("#daftar_buku_table").DataTable({
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

daftar_buku_table.on('click.button_view', '.action_view', async function () {
    const res = await fetch(`/buku_by_id?id=${this.value}`, {
        method: "GET",
        credentials: "include",
    });

    if (res.status === 200) {
        const res_json = await res.json();
        cover_preview.src = `/cover_buku/${res_json.book.cover_buku}`;

        nama_buku.value = res_json.book.nama_buku;
        penulis.value = res_json.book.penulis;
        penerbit.value = res_json.book.penerbit;
        tahun_terbit.value = res_json.book.tahun_terbit;
        stok.value = res_json.book.stok;

        if (res_json.is_borrowed) {
            buku_modal_button.onclick = () => {};
            buku_modal_button.disabled = true;
        } else {
            buku_modal_button.onclick = () => {
                pinjam_buku(this.nextElementSibling, res_json.book.id, 1)
            }
        }
        

        buku_modal.modal("show");
        
        document.activeElement.blur();
    }
});

function pinjam_buku(ev, id, close_modal = 0) {
    Swal.fire({
        title: "Pinjam Buku",
        text: "Apakah anda ingin meminjam buku ini?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes",
        cancelButtonText: "No"
    }).then(async res => {
        if (res.isConfirmed) {
            const res = await fetch("/pinjam_buku", {
                method: "POST",
                credentials: "include",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    book_id: id
                })
            })

            if (res.status === 200) {
                const res_json = await res.json();
                
                swal2_mixin.fire({
                    icon: "success",
                    title: "Buku berhasil dipinjamkan!"
                });

                if (ev) ev.disabled = true;
                if (close_modal) buku_modal.modal("hide");
                daftar_buku_table.cell("#" + id, 2).data(new Intl.NumberFormat("id-ID").format(res_json.stok)).draw();
            }
            else {
                const res_json = await res.json();
                
                swal2_mixin.fire({
                    icon: "error",
                    title: res_json.errorss
                });
            }
        }
    });
}

daftar_buku_table.on('click.button_borrow', '.action_borrow', async function () {
    pinjam_buku(this, this.value);
})