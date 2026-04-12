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
        buku_modal_button.onclick = () => {
            pinjam_buku(this.value);
        }
        
        const res_json = await res.json();
        cover_preview.src = `/cover_buku/${res_json.cover_buku}`;

        nama_buku.value = res_json.nama_buku;
        penulis.value = res_json.penulis;
        penerbit.value = res_json.penerbit;
        tahun_terbit.value = res_json.tahun_terbit;
        stok.value = res_json.stok;

        buku_modal.modal("show");
        document.activeElement.blur();
    }
});

daftar_buku_table.on('click.button_borrow', '.action_borrow', async function () {
    pinjam_buku(this.value)
})

async function pinjam_buku(id) {
    console.log("result:", id);
}