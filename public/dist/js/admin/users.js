const swal2_mixin = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

const modal_user_title = document.getElementById("modal_user_title");
const modal_user_button = document.getElementById("modal_user_button");
const username = document.getElementById("username");
const full_name = document.getElementById("full_name");
const email = document.getElementById("email");
const password_display = document.getElementById("password_display");
const password = document.getElementById("password");
const confirm_password = document.getElementById("confirm_password");
const role = $('#role').select2({
    theme: 'bootstrap4',
    dropdownParent: $('#modal_user')
});
const modal_user = $("#modal_user");
const users_table = $("#users_table").DataTable({
    rowId: 5,
    columns: [
        {
            data: 0,
            render: $.fn.dataTable.render.text()
        },
        {
            data: 1,
            render: $.fn.dataTable.render.text()
        },
        { data: 2 },
        { data: 3 },
        { data: 4 }
    ],
});

document.querySelectorAll(".toggle-password").forEach(btn => {
    btn.addEventListener("click", function () {
        const input = document.getElementById(this.dataset.target);
        const icon = this.querySelector("i");
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    });
});

modal_user.on('shown.bs.modal', function () {
    username.focus();
});

users_table.on('click.edit_user', '.action_edit', async function () {
    role.prop("disabled", false);
    username.disabled = false;
    full_name.disabled = false;
    password_display.style = "";
    password.value = "";
    confirm_password.value = "";
    modal_user_button.disabled = false;

    let data = this.value;

    let res = await fetch(`/admin/user_by_id?id=${data}`, {
        method: "GET",
        credentials: "include"
    })

    if (res.status === 200) {
        const res_json = await res.json();
        data = Number(data);

        if (data === 1) {
            role.prop("disabled", true);
            username.disabled = true;
            full_name.disabled = true;
            email.disabled = true;
            password_display.style = "display: none;";
            modal_user_button.disabled = true;
        }
        
        role.val(res_json.role_id).trigger("change");
        email.value = res_json.email;
        username.value = res_json.username;
        full_name.value = res_json.full_name;
    } else if (res.status === 404) {
        return swal2_mixin.fire({
            icon: "error",
            title: "The user is not exists! Please refresh the page."
        })
    } else {
        const res_code = await res.text();

        if (res_code === "0") {
            return swal2_mixin.fire({
                icon: "error",
                title: "You are not authorized to perform this action."
            });
        }
        else {
            return swal2_mixin.fire({
                icon: "error",
                title: "Something went wrong! Please try again later or contact admin."
            })
        }
    }

    modal_user_title.innerText = "View/Edit User";
    modal_user_button.innerText = "Edit User (Enter)";

    password.type = "password";
    confirm_password.type = "password";

    document.getElementById("change_password_label").style = "";

    document.querySelectorAll(".toggle-password i").forEach(e => {
        e.classList.remove("fa-eye-slash")
        e.classList.add("fa-eye");
    });
    
    modal_user_button.onclick = function() {edit_user(data)};

    modal_user.modal("show");
    document.activeElement.blur();
});

users_table.on('click.delete_user', '.action_delete', async function () {
    Swal.fire({
        title: "Delete User Account",
        text: "Are you sure to delete this user account?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes",
        cancelButtonText: "No"
    }).then(async res => {
        if (res.isConfirmed) {
            let res = await fetch("/admin/user", {
                method: "DELETE",
                headers: {
                    "token": localStorage.getItem("token")
                },
                body: new URLSearchParams({
                    "id": this.value
                })
            })

            if (res.status === 200) {
                swal2_mixin.fire({
                    icon: "success",
                    title: "User account has been deleted!"
                });
                users_table.row("#" + this.value).remove().draw();
                
            } else {
                const res_code = await res.text();
            }
        }
    });
});

document.addEventListener("keydown", document_keydown);

async function sse_handler(data) {
    if (data.type === 1) {
        switch(data.code) {
            case "REFRESH_USERS": {
                await fetch_users();
                break;
            }
            case "REFRESH_RP": {
                await fetch_roles();
                break;
            }
        }
    }
}

function document_keydown(e) {
    switch(e.key) {
        case "Enter": {
            if (modal_user.hasClass("show")) {
                if (e.target.tagName === 'BUTTON') return;
                modal_user_button.click();
            }
            break;
        }
        case "Escape": {
            if (modal_user.hasClass("show")) {
                modal_user.modal("hide");
            }
            break;
        }
    }
}

function tambah_user_modal() {
    modal_user_title.innerText = "Add User";
    modal_user_button.innerText = "Add User (Enter)";
    password_display.style = "";
    modal_user_button.onclick = function() {tambah_user()};

    role.prop("disabled", false);
    username.disabled = false;
    full_name.disabled = false;
    email.disabled = false;
    email.value = "";
    password_display.style = "";
    modal_user_button.disabled = false;

    username.value = "";
    full_name.value = "";
    password.value = "";
    confirm_password.value = "";

    document.getElementById("change_password_label").style = "display: none;";

    password.type = "password";
    confirm_password.type = "password";

    document.querySelectorAll(".toggle-password i").forEach(e => {
        e.classList.remove("fa-eye-slash")
        e.classList.add("fa-eye");
    })

    modal_user.modal("show");
    document.activeElement.blur();
}

async function tambah_user() {
    if (password.value.length < 8 ||  confirm_password.value.length < 8) return swal2_mixin.fire({
        icon: "error",
        title: "Password & Confirm Password length at least 8 characters"
    });
    if (password.value !== confirm_password.value) return swal2_mixin.fire({
        icon: "error",
        title: "Confirm password must match the new password."
    });

    if (!/^[a-z0-9_]+$/.test(username.value)) {
        return swal2_mixin.fire({
            icon: "error",
            title: "Invalid username! Use lowercase letters, numbers, or underscore"
        })
    }

    let res = await fetch("/admin/user", {
        method: "POST",
        headers: {
            "token": localStorage.getItem("token")
        },
        body: new URLSearchParams({
            "username": username.value,
            "full_name": full_name.value,
            "email": email.value,
            "password": password.value,
            "role_id": role.val()
        })
    })

    if (res.status === 200) {
        swal2_mixin.fire({
            icon: "success",
            title: "User account has been created!"
        });
        modal_user.modal("hide");
    } else {
        const res_json = await res.json();

        swal2_mixin.fire({
            icon: "error",
            title: res_json.errors
        })
    }
}

async function edit_user(id) {
    if (password.value) {
        if (password.value.length < 8 ||  confirm_password.value.length < 8) return swal2_mixin.fire({
            icon: "error",
            title: "Password & Confirm Password length at least 8 characters"
        });
        if (password.value !== confirm_password.value) return swal2_mixin.fire({
            icon: "error",
            title: "Confirm password must match the new password"
        });
    }

    if (!/^[a-z0-9_]+$/.test(username.value)) {
        return swal2_mixin.fire({
            icon: "error",
            title: "Invalid username! Use lowercase letters, numbers, or underscore"
        })
    }

    let res = await fetch("/admin/user", {
        method: "PATCH",
        headers: {
            "token": localStorage.getItem("token")
        },
        body: new URLSearchParams({
            id,
            "full_name": full_name.value,
            "username": username.value,
            "email": email.value,
            "role_id": role.val(),
            ...(password.value ? {"password": password.value} : {})
        })
    })

    if (res.status === 200) {
        const res_json = await res.json();

        swal2_mixin.fire({
            icon: "success",
            title: "User account has been edited!"
        });

        users_table.row("#" + res_json.data.id).data([
            res_json.data.username,
            res_json.data.full_name,
            new Date(res_json.data.created_at).toLocaleString('en-GB', {day: '2-digit',month: 'short',year: 'numeric',hour: '2-digit',minute: '2-digit',second: '2-digit',hour12: false}),
            new Date(res_json.data.updated_at).toLocaleString('en-GB', {day: '2-digit',month: 'short',year: 'numeric',hour: '2-digit',minute: '2-digit',second: '2-digit',hour12: false}),
            `<center>
              <button type="button" class="text-right btn btn-primary action_edit" value="${res_json.data.id}"><i class="fa fa-eye"></i> View/Edit</button>
              <button type="button" class="text-right btn btn-danger action_delete" value="${res_json.data.id}"><i class="fa fa-trash"></i> Delete</button>
            </center>`,
            res_json.data.id
        ]).draw();
        
        modal_user.modal("hide");
    } else {
        const res_json = await res.json();

        swal2_mixin.fire({
            icon: "error",
            title: res_json.errors
        })
    }
}