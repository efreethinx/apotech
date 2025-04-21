$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

$(".custom-file-input").on("change", function () {
    let filename = $(this).val().split("\\").pop();
    $(this).next(".custom-file-label").addClass("selected").html(filename);
});

$('[data-toggle="tooltip"]').tooltip();

function preview(target, image) {
    $(target).attr("src", window.URL.createObjectURL(image)).show();
}

function resetForm(selector) {
    $(selector)[0].reset();
    $(`.summernote, .summernote-simple`).summernote("code", "");

    $(`.select2:not(.filter)`).trigger("change");
    $(
        ".form-control, .custom-select, [type=radio], [type=checkbox], [type=file], .select2, .note-editor"
    ).removeClass("is-invalid");
    $(".invalid-feedback").remove();
}

function clearSelectedInputFile(selector) {
    Array.from($(selector)[0].elements).forEach((input) => {
        if ($(input).attr("type") == "file") {
            $(`.preview-${$(input).attr("name")}`).hide();
            let selectedOldFile = $($(input).next());
            if (selectedOldFile.has("selected")) {
                selectedOldFile.html("Choose file");
            }
        }
    });
}

function clearErros() {
    $(`.select2:not(.filter)`).trigger("change");
    $(
        ".form-control, .custom-select, [type=radio], [type=checkbox], [type=file], .select2, .note-editor"
    ).removeClass("is-invalid");
    $(".invalid-feedback").remove();
}

function loopForm(originalForm) {
    for (field in originalForm) {
        if ($(`[name=${field}]`).attr("type") != "file") {
            if ($(`[name=${field}]`).hasClass("summernote")) {
                $(`[name=${field}]`).summernote("code", originalForm[field]);
            } else if ($(`[name=${field}]`).attr("type") == "radio") {
                $(`[name=${field}]`)
                    .filter(`[value="${originalForm[field]}"]`)
                    .prop("checked", true);
            } else {
                $(`[name=${field}]`).val(originalForm[field]);
            }

            $("select").trigger("change");
        } else {
            $(`.preview-${field}`).attr("src", originalForm[field]).show();
        }
    }
}

function loopErrors(errors) {
    $(
        ".form-control, .custom-select, [type=radio], [type=checkbox], [type=file], .select2, .note-editor"
    ).removeClass("is-invalid");
    $(".invalid-feedback").remove();

    if (errors == undefined) {
        return;
    }

    for (error in errors) {
        if (error.includes(".")) {
            continue;
        }

        $(`[name=${error}]`).addClass("is-invalid");

        if ($(`[name=${error}]`).hasClass("select2")) {
            $(
                `<span class="error invalid-feedback">${errors[error][0]}</span>`
            ).insertAfter($(`[name=${error}]`).next());
        } else if (
            $(`[name=${error}]`).hasClass("summernote") ||
            $(`[name=${error}]`).hasClass("summernote-simple")
        ) {
            $(".note-editor").addClass("is-invalid");
            $(
                `<span class="error invalid-feedback">${errors[error][0]}</span>`
            ).insertAfter($(`[name=${error}]`).next());
        } else if ($(`[name=${error}]`).hasClass("custom-control-input")) {
            $(
                `<span class="error invalid-feedback">${errors[error][0]}</span>`
            ).insertAfter($(`[name=${error}]`).next());
        } else {
            if ($(`[name=${error}]`).length == 0) {
                // array | multiple
                $(`[name="${error}[]"]`).addClass("is-invalid");
                $(
                    `<span class="error invalid-feedback">${errors[error][0]}</span>`
                ).insertAfter($(`[name="${error}[]"]`).next());
            } else if (
                $(`[name=${error}]`).parent(".input-group").length == 1
            ) {
                // input group
                $(`[name=${error}]`)
                    .parent(".input-group")
                    .addClass("is-invalid");
                $(
                    `<span class="error invalid-feedback">${errors[error][0]}</span>`
                ).insertAfter($(`[name=${error}]`).parent(".input-group"));
            } else {
                $(
                    `<span class="error invalid-feedback">${errors[error][0]}</span>`
                ).insertAfter($(`[name=${error}]`));
            }
        }
    }
}

function showAlert(message, type) {
    let title = "";
    switch (type) {
        case "success":
            title = "Success";
            break;
        case "danger":
            title = "Failed";
            break;
        default:
            break;
    }

    const toastId = `toast-${Date.now()}`;

    $(document).Toasts("create", {
        class: `bg-${type} ${toastId}`,
        title: title,
        body: message,
    });

    setTimeout(() => {
        $(`.${toastId}`).remove();
    }, 3000);
}

$.fn.digits = function () {
    return this.each(function () {
        $(this).text(
            $(this)
                .text()
                .replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.")
        );
    });
};
$(".format").digits();

/**
 * Format number
 */
function digits(number) {
    if (number == null || number == undefined) {
        return null;
    }

    return `${number}`.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
}

/**
 * Auto format currency on keyup
 */
function currency(input) {
    a = input.value;
    if (a == undefined) {
        a = input.toString();
    }
    b = a.replace(/[^\d]/g, "");
    c = "";
    length = b.length;

    j = 0;
    for (i = length; i > 0; i--) {
        j = j + 1;
        if (j % 3 == 1 && j != 1) {
            c = b.substr(i - 1, 1) + "." + c;
        } else {
            c = b.substr(i - 1, 1) + c;
        }
    }
    if (input.value == undefined) {
        return c;
    }

    input.value = c;
}
