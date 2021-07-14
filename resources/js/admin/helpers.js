import router from "./router";

export const redirectToErrorPageIfNeeded = status => {
    if (status === 404) {
        router.push("/admin/404");
    } else if (status === 403) {
        router.push("/admin/403");
    } else if (status === 401) {
        window.location = "/";
    }
};

export const fireConfirm = callbackfn => {
    swal.fire({
        title: translate("admin.confirmationTitle"),
        text: translate("admin.confirmationText"),
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#F13527",
        cancelButtonColor: "#55AE59",
        confirmButtonText: translate("admin.confirmationConfirm"),
        cancelButtonText: translate("admin.discard")
    }).then(result => {
        if (result.isConfirmed) {
            callbackfn();
        }
    });
};
export const fireAlert = (icon, title, text) => {
    swal.fire({
        icon,
        title,
        text,
        confirmButtonColor: "#55AE59"
    });
};
export const fireToast = (type, message) => {
    const inAdminPanel = window.location.href.indexOf("/admin") != -1;
    let icon;
    let delay = inAdminPanel ?  2000 : 4000;
    if (type == "success") {
        icon = "check";
    }
    if (type == "danger") {
        icon = "error";
    }
    if (type == "info") {
        icon = "notification_add";
        delay = 5000;
    }
    $.notify(
        {
            icon: icon,
            message
        },
        {
            type,
            delay,
            newest_on_top: true,
            placement: {
                from: "bottom",
                align: inAdminPanel ? "right" : "left"
            }
        }
    );
};

export const imageIsValid = file => {
    return (
        file &&
        (file.type == "image/png" ||
            file.type == "image/gif" ||
            file.type == "image/jpeg" ||
            file.type == "image/gif" ||
            file.type == "image/svg+xml")
    );
};
