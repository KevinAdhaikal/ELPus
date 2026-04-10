const profile_img3 = document.getElementById("profile_img3")
const change_profile_button = document.getElementById("change_profile_button")
const delete_photo_button = document.getElementById("delete_photo_button")
const current_password = document.getElementById("current_password")
const new_password = document.getElementById("new_password")
const confirm_new_password = document.getElementById("confirm_new_password")
const profile_img_input = document.getElementById("profile_img_input");
const delete_photo_input = document.getElementById("delete_photo_input");


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

function preview_image(event) {
    const file = event.target.files[0];

    if (file) {
        profile_img3.src = URL.createObjectURL(file);
        check_change();
        delete_photo_button.disabled = false;
        delete_photo_input.value = "0";
    }
}

function delete_photo_function() {
    profile_img3.src = "/profile_img/default.svg";
    delete_photo_button.disabled = true;
    
    delete_photo_input.value = "1";
    profile_img_input.value = "";
    check_change();
}

function check_change() {
    change_profile_button.disabled = false;
}

async function change_password() {
    if (new_password.value.length < 8 ||  confirm_new_password.value.length < 8) return swal2_mixin.fire({
        icon: "error",
        title: "New Password & Confirm New Password length at least 8 characters"
    });
    if (new_password.value !== confirm_new_password.value) return swal2_mixin.fire({
        icon: "error",
        title: "Confirm password must match the new password."
    })

    try {
        let res = await fetch("/change_password", {
            method: "PATCH",
            headers: {
                "token": localStorage.getItem("token")
            },
            body: new URLSearchParams({
                "old_pass": current_password.value,
                "new_pass": new_password.value
            })
        })

        if (res.status === 200) {
            const res_body = await res.text();
            global.change_password = true;
            
            swal2_mixin.fire({
                icon: "success",
                title: "Password has been changed!"
            })

            if (res_body) {
                localStorage.setItem("token", res_body);
                localStorage.setItem("password", new_password.value);
            }

            new_password.value = "";
            confirm_new_password.value = "";

            $("#modal_change_password").modal("hide");
        } else {
            swal2_mixin.fire({
                icon: "error",
                title: "Incorrect current passowrd! Please enter the correct current password."
            })
        }
    } finally {
    }
}