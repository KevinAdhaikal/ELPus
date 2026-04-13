const swal2_mixin = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

const modal_role_title = document.getElementById("modal_role_title");
const modal_role_button = document.getElementById("modal_role_button");
const role_name = document.getElementById("role_name");
const perm_cb = document.querySelectorAll(".perm_cb");

const roles_table = $("#roles_table").DataTable({
    rowId: 4,
    columns: [
        {
            data: 0,
            render: $.fn.dataTable.render.text()
        },
        { data: 1 },
        { data: 2 },
        { data: 3 }
    ],
});

const modal_role = $("#modal_role");

roles_table.on('click.button_edit', '.action_edit', async function () {
    const res = await fetch(`/admin/rp_by_id?id=${this.value}`, {
        method: "GET",
        credentials: "include",
    });

    if (res.status === 200) {
        modal_role_title.innerText = "Edit Role";
        modal_role_button.innerText = "Edit Role";
        modal_role_button.disabled = false;
        modal_role_button.onclick = () => {
            edit_role(this.value);
        }
        
        const res_json = await res.json();
        role_name.value = res_json.name;

        if (res_json.id === 1) {
            perm_cb.forEach(cb => {
                cb.disabled = true;
                cb.checked = true;
            })
            modal_role_button.disabled = true;
        } else {
            perm_cb.forEach(cb => {
                const val = Number(cb.value);
                cb.checked = (res_json.permission_level & val) === val;
                cb.disabled = false;
            });
        }
        

        modal_role.modal("show");
        document.activeElement.blur();
    }
});

roles_table.on('click.button_delete', '.action_delete', async function () {
    console.log(this.value);
    Swal.fire({
        title: "Delete Role",
        text: "Apakah anda yakin untuk hapus role ini?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes",
        cancelButtonText: "No"
    }).then(async res => {
        if (res.isConfirmed) {
            let res = await fetch("/admin/rp", {
                method: "DELETE",
                credentials: "include",
                body: new URLSearchParams({
                    "id": this.value,
                })
            })

            if (res.status === 200) {
                swal2_mixin.fire({
                    icon: "success",
                    title: "Role berhasil di hapus!"
                })
                roles_table.row("#" + this.value).remove().draw();
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


function tambah_role_modal() {
    perm_cb.forEach(cb => {
        cb.checked = false;
        cb.disabled = false;
    });
    role_name.value = "";

    modal_role_title.innerText = "Tambah Role";
    modal_role_button.innerText = "Tambah Role";
    modal_role_button.onclick = () => {
        tambah_role();
    }
    modal_role_button.disabled = false;

    modal_role.modal("show");
}

async function tambah_role() {
    let res_perm = 0;
    perm_cb.forEach(cb => {
        if (cb.checked) res_perm += Number(cb.value);
    });

    const res = await fetch("/admin/rp", {
        method: "POST",
        credentials: "include",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            name: role_name.value,
            permission_level: res_perm
        })
    })

    if (res.status === 200) {
        const res_json = await res.json();

        swal2_mixin.fire({
            icon: "success",
            title: "Role berhasil ditambahkan!"
        })

        roles_table.row.add([
            res_json.data.name,
            new Date(res_json.data.created_at).toLocaleString('en-GB', {day: '2-digit',month: 'short',year: 'numeric',hour: '2-digit',minute: '2-digit',second: '2-digit',hour12: false}),
            new Date(res_json.data.updated_at).toLocaleString('en-GB', {day: '2-digit',month: 'short',year: 'numeric',hour: '2-digit',minute: '2-digit',second: '2-digit',hour12: false}),
            `
            <center>
              <button type="button" class="text-right btn btn-primary action_edit" value="${res_json.data.id}"><i class="fa fa-eye"></i> View/Edit</button>
              <button type="button" class="text-right btn btn-danger action_delete" value="${res_json.data.id}"><i class="fa fa-trash"></i> Delete</button>
            </center>`,
            res_json.data.id
        ]).draw();

        modal_role.modal("hide");
    } else {
        const res_json = await res.json();
        swal2_mixin.fire({
            icon: "error",
            title: res_json.errors
        })
    }
}

async function edit_role(id) {
    let res_perm = 0;
    perm_cb.forEach(cb => {
        if (cb.checked) res_perm += Number(cb.value);
    });

    const res = await fetch("/admin/rp", {
        method: "PATCH",
        credentials: "include",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            id,
            name: role_name.value,
            permission_level: res_perm
        })
    })

    if (res.status === 200) {
        const res_json = await res.json();

        swal2_mixin.fire({
            icon: "success",
            title: "Role berhasil diedit!"
        });

        roles_table.row("#" + res_json.data.id).data([
            res_json.data.name,
            new Date(res_json.data.created_at).toLocaleString('en-GB', {day: '2-digit',month: 'short',year: 'numeric',hour: '2-digit',minute: '2-digit',second: '2-digit',hour12: false}),
            new Date(res_json.data.updated_at).toLocaleString('en-GB', {day: '2-digit',month: 'short',year: 'numeric',hour: '2-digit',minute: '2-digit',second: '2-digit',hour12: false}),
            `
            <center>
              <button type="button" class="text-right btn btn-primary action_edit" value="${res_json.data.id}"><i class="fa fa-eye"></i> View/Edit</button>
              <button type="button" class="text-right btn btn-danger action_delete" value="${res_json.data.id}"><i class="fa fa-trash"></i> Delete</button>
            </center>`,
            res_json.data.id
        ]).draw();

        modal_role.modal("hide");
    } else {
        const res_json = await res.json();
        swal2_mixin.fire({
            icon: "error",
            title: res_json.errors
        })
    }
}