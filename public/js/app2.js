(function ($) {
    "use strict";

    const token =
        document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute("content") ||
        document.querySelector('input[name="_token"]')?.value;
    if (token) {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": token,
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
            },
        });
    }

    if (
        typeof window.lgModules === "undefined" &&
        typeof lgZoom !== "undefined" &&
        typeof lgThumbnail !== "undefined"
    ) {
        window.lgModules = [lgZoom, lgThumbnail];
    }

    const handleAjaxError = (xhr, $feedback) => {
        const response = xhr.responseJSON || {};
        const message =
            response.message || "Something went wrong. Please try again.";
        const errors = response.errors
            ? Object.values(response.errors).flat().join("<br>")
            : "";
        $feedback
            .removeClass("d-none alert-success")
            .addClass("alert alert-danger")
            .html(`${message}${errors ? "<br>" + errors : ""}`);
    };

    const handleAjaxSuccess = (response, $feedback, successMessage) => {
        $feedback
            .removeClass("d-none alert-danger")
            .addClass("alert alert-success")
            .text(response.message || successMessage);
    };

    const getSwalInstance = () => {
        if (typeof window === "undefined" || typeof window.Swal === "undefined") {
            return null;
        }
        if (!window.__appSwal) {
            window.__appSwal = window.Swal.mixin({
                buttonsStyling: false,
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-outline-secondary ms-2",
                    denyButton: "btn btn-outline-danger ms-2",
                },
            });
        }
        return window.__appSwal;
    };

    const formatValidationErrors = (errors) => {
        if (!errors) return "";
        const items = Object.values(errors)
            .flat()
            .map((message) => `<li>${message}</li>`)
            .join("");
        return items
            ? `<div class="text-start"><ul class="mb-0 ps-3">${items}</ul></div>`
            : "";
    };

    const showSwalSuccess = (title, text) => {
        const swal = getSwalInstance();
        if (swal) {
            return swal.fire({
                icon: "success",
                title: title || "Success",
                text: text || "",
                showConfirmButton: false,
                timer: 2200,
            });
        }
        alert(`${title || "Success"}${text ? `: ${text}` : ""}`);
        return Promise.resolve();
    };

    const showSwalError = (title, html) => {
        const swal = getSwalInstance();
        if (swal) {
            return swal.fire({
                icon: "error",
                title: title || "Action failed",
                html: html || "",
                confirmButtonText: "Got it",
            });
        }
        const fallback = `${title || "Action failed"}${
            html ? `: ${html.replace(/<[^>]*>/g, " ")}` : ""
        }`;
        alert(fallback);
        return Promise.resolve();
    };

    const confirmSwal = (title, text, confirmButtonText = "Yes, proceed") => {
        const swal = getSwalInstance();
        if (swal) {
            return swal.fire({
                icon: "warning",
                title: title || "Are you sure?",
                html: text || "",
                showCancelButton: true,
                confirmButtonText,
                cancelButtonText: "Cancel",
            });
        }
        const confirmed = window.confirm(
            `${title || "Are you sure?"}${text ? `\n${text}` : ""}`
        );
        return Promise.resolve({ isConfirmed: confirmed });
    };

    const presentAjaxError = (xhr, fallbackMessage = "Unable to process the request.") => {
        const response = xhr?.responseJSON || {};
        const message = response.message || fallbackMessage;
        const errorsHtml = formatValidationErrors(response.errors);
        const htmlParts = [];
        if (message) {
            htmlParts.push(`<p class="mb-2">${message}</p>`);
        }
        if (errorsHtml) {
            htmlParts.push(errorsHtml);
        }
        return showSwalError("Action needed", htmlParts.join("") || fallbackMessage);
    };

    const initContactForm = () => {
        const $form = $("#contact-form");
        if (!$form.length) return;
        const $feedback = $("#contact-feedback");
        $form.on("submit", function (e) {
            e.preventDefault();
            const formData = $form.serialize();
            $.post($form.attr("action"), formData)
                .done((response) => {
                    handleAjaxSuccess(
                        response,
                        $feedback,
                        "Message sent. We will respond shortly."
                    );
                    $form.trigger("reset");
                })
                .fail((xhr) => handleAjaxError(xhr, $feedback));
        });
    };

    const initLoginForm = () => {
        const $form = $("#login-form");
        if (!$form.length) return;
        const $feedback = $("#login-feedback");
        $form.on("submit", function (e) {
            e.preventDefault();
            const formData = $form.serialize();
            $.post($form.attr("action"), formData)
                .done((response) => {
                    handleAjaxSuccess(
                        response,
                        $feedback,
                        "Login successful. Redirecting..."
                    );
                    setTimeout(
                        () =>
                            (window.location.href =
                                response.redirect || "/admin"),
                        800
                    );
                })
                .fail((xhr) => handleAjaxError(xhr, $feedback));
        });
    };

    const initLightGallery = () => {
        const galleries = [
            document.getElementById("project-gallery"),
            document.getElementById("home-portfolio"),
        ];
        galleries.forEach((el) => {
            if (el && window.lightGallery) {
                lightGallery(el, {
                    selector: ".gallery-item",
                    plugins: window.lgModules || [lgZoom, lgThumbnail],
                    speed: 400,
                });
            }
        });
    };

    const initServicesAdmin = () => {
        if (!window.AdminServices) return;
        const { endpoints, table } = window.AdminServices;
        const $modal = $("#serviceModal");
        const $form = $("#service-form");
        const $submit = $form.find('button[type="submit"]');
        let dataTable;

        const loadTable = () => {
            dataTable = $(table).DataTable({
                processing: true,
                serverSide: true,
                ajax: endpoints.list,
                order: [[4, "asc"]],
                columns: [
                    { data: "id" },
                    { data: "title" },
                    { data: "slug" },
                    { data: "is_featured" },
                    { data: "display_order" },
                    { data: "actions", orderable: false, searchable: false },
                ],
            });
        };

        const resetForm = () => {
            $form[0].reset();
            $form.removeData("id");
        };

        $('[data-bs-target="#serviceModal"]').on("click", function () {
            resetForm();
            $submit.text("Save service");
        });

        $form.on("submit", function (e) {
            e.preventDefault();
            const id = $form.data("id");
            const method = id ? "PUT" : "POST";
            const url = id ? endpoints.update(id) : endpoints.store;
            $.ajax({
                url,
                method,
                data: $form.serialize(),
            })
                .done((response) => {
                    dataTable.ajax.reload(null, false);
                    $modal.modal("hide");
                })
                .fail((xhr) => {
                    alert(
                        xhr.responseJSON?.message || "Unable to save service."
                    );
                });
        });

        $(table).on("click", '[data-action="edit"]', function () {
            const id = $(this).data("id");
            resetForm();
            $.get(endpoints.show(id)).done(({ data }) => {
                Object.entries(data).forEach(([key, value]) => {
                    const $input = $form.find(`[name="${key}"]`);
                    if ($input.attr("type") === "checkbox") {
                        $input.prop("checked", Boolean(value));
                    } else if ($input.length) {
                        $input.val(value);
                    }
                });
                $form.data("id", id);
                $submit.text("Update service");
                $modal.modal("show");
            });
        });

        $(table).on("click", '[data-action="delete"]', function () {
            const id = $(this).data("id");
            if (!confirm("Delete this service?")) return;
            $.ajax({ url: endpoints.delete(id), method: "DELETE" })
                .done(() => dataTable.ajax.reload(null, false))
                .fail(() => alert("Failed to delete."));
        });

        loadTable();
    };

    const populateForm = ($form, data) => {
        Object.entries(data).forEach(([key, value]) => {
            const $input = $form.find(`[name="${key}"]`);
            if (!$input.length) return;
            if ($input.attr("type") === "checkbox") {
                $input.prop("checked", Boolean(value));
            } else if ($input.attr("type") === "file") {
                return;
            } else if ($input.attr("type") === "date" && value) {
                $input.val(value.substring(0, 10));
            } else {
                $input.val(value);
            }
        });
    };

    const initProjectsAdmin = () => {
        if (!window.AdminProjects) return;
        const { endpoints, table } = window.AdminProjects;
        const $modal = $("#projectModal");
        const $form = $("#project-form");
        const $modalTitle = $modal.find("[data-modal-title]");
        const $submitButton = $form.find('[data-action="submit-project-form"]');
        const $submitLabel = $submitButton.find("[data-submit-label]");
        const $galleryModal = $("#galleryModal");
        const $galleryGrid = $("#gallery-grid");
        const $uploadForm = $("#gallery-upload");
        const modalCopy = {
            create: { title: "New project", submit: "Save project" },
            edit: { title: "Edit project", submit: "Update project" },
        };
        let dataTable;
        let dragCard = null;

        const setModalMode = (mode) => {
            const copy = modalCopy[mode] || modalCopy.create;
            $modal.data("mode", mode);
            $modalTitle.text(copy.title);
            $submitLabel.text(copy.submit);
        };

        const resetForm = () => {
            if ($form[0]) {
                $form[0].reset();
            }
            $form.removeData("id");
            $form.removeClass("was-validated");
        };

        const setSubmitting = (isLoading) => {
            const mode = $modal.data("mode") || "create";
            const copy = modalCopy[mode] || modalCopy.create;
            $submitButton.prop("disabled", isLoading);
            if (isLoading) {
                $submitLabel.text(mode === "edit" ? "Updating..." : "Saving...");
            } else {
                $submitLabel.text(copy.submit);
            }
        };

        const refreshTable = () => {
            if (dataTable) {
                dataTable.ajax.reload(null, false);
            }
        };

        const renderGallery = (images, projectId) => {
            $galleryGrid.empty();
            images.forEach((image) => {
                const card = $(
                    `
                    <div class="col-md-6 gallery-card" data-id="${image.id}" draggable="true">
                        <div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow-sm position-relative">
                            <img class="w-100 h-100 object-fit-cover" alt="">
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2 gap-2">
                            <p class="mb-0 small text-muted flex-fill text-truncate" data-caption></p>
                            <button class="btn btn-sm btn-outline-danger" data-action="remove-image" data-id="${image.id}" data-project="${projectId}" title="Remove image">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                `
                );
                const caption = image.caption || "";
                card
                    .find("img")
                    .attr("src", `/storage/${image.file_path}`)
                    .attr("alt", caption || "Project image");
                card.find("[data-caption]").text(caption);
                $galleryGrid.append(card);
            });
            $galleryGrid.data("items", images);
        };

        const persistGalleryOrder = (projectId) => {
            if (!projectId) return;
            const order = $galleryGrid
                .find(".gallery-card")
                .map((_, el) => $(el).data("id"))
                .get();
            $.post(endpoints.reorderImages(projectId), { order }).fail(() =>
                showSwalError("Gallery error", "Unable to save gallery order.")
            );
        };

        $galleryGrid.on("dragstart", ".gallery-card", function (event) {
            dragCard = this;
            $(this).addClass("dragging");
            if (event.originalEvent?.dataTransfer) {
                event.originalEvent.dataTransfer.effectAllowed = "move";
                event.originalEvent.dataTransfer.setData(
                    "text/plain",
                    $(this).data("id")
                );
            }
        });

        $galleryGrid.on("dragover", ".gallery-card", function (event) {
            event.preventDefault();
            if (!dragCard || this === dragCard) return;
            const bounding = this.getBoundingClientRect();
            const offset = (event.originalEvent?.clientY || 0) - bounding.top;
            const shouldPlaceAfter = offset > bounding.height / 2;
            const $dragCard = $(dragCard);
            if (shouldPlaceAfter) {
                $(this).after($dragCard);
            } else {
                $(this).before($dragCard);
            }
        });

        $galleryGrid.on("dragover", function (event) {
            if (!dragCard) return;
            const $target = $(event.target).closest(".gallery-card");
            if ($target.length) return;
            event.preventDefault();
            $galleryGrid.append($(dragCard));
        });

        $galleryGrid.on("dragenter", ".gallery-card", function () {
            if (this === dragCard) return;
            $(this).addClass("drag-over");
        });

        $galleryGrid.on("dragleave", ".gallery-card", function () {
            $(this).removeClass("drag-over");
        });

        $galleryGrid.on("dragend", ".gallery-card", function () {
            $(this).removeClass("dragging drag-over");
            const projectId = $galleryModal.data("project-id");
            persistGalleryOrder(projectId);
            dragCard = null;
        });

        $galleryGrid.on("drop", ".gallery-card", function (event) {
            event.preventDefault();
            $(this).removeClass("drag-over");
        });

        const openModal = (projectId = null) => {
            resetForm();
            setModalMode(projectId ? "edit" : "create");
            setSubmitting(false);
            if (projectId) {
                setSubmitting(true);
                $.get(endpoints.show(projectId))
                    .done(({ data }) => {
                        populateForm($form, data);
                        $form.data("id", projectId);
                        $modal.modal("show");
                    })
                    .fail((xhr) =>
                        presentAjaxError(xhr, "Unable to load the project.")
                    )
                    .always(() => setSubmitting(false));
            } else {
                $modal.modal("show");
            }
        };

        const loadGallery = (projectId) => {
            $.get(endpoints.show(projectId))
                .done(({ data }) => {
                    renderGallery(data.images || [], projectId);
                    $uploadForm.find("#gallery-project-id").val(projectId);
                    $galleryModal.data("project-id", projectId).modal("show");
                })
                .fail((xhr) =>
                    presentAjaxError(xhr, "Unable to load the gallery.")
                );
        };

        $modal.on("shown.bs.modal", () => {
            $form.find('[name="title"]').trigger("focus");
        });

        $modal.on("hidden.bs.modal", () => {
            resetForm();
            setModalMode("create");
            setSubmitting(false);
        });

        $('[data-action="create-project"]').on("click", () => openModal());

        $form.on("submit", function (e) {
            e.preventDefault();
            const id = $form.data("id");
            const method = id ? "PUT" : "POST";
            const url = id ? endpoints.update(id) : endpoints.store;
            setSubmitting(true);
            $.ajax({ url, method, data: $form.serialize() })
                .done((response) => {
                    $modal.modal("hide");
                    refreshTable();
                    showSwalSuccess(
                        id ? "Project updated" : "Project created",
                        response.message ||
                            (id
                                ? "The project was updated successfully."
            
    const initTeamAdmin = () => {
        if (!window.AdminTeam) return;
        const { endpoints, table } = window.AdminTeam;
        const $modal = $("#teamModal");
        const $form = $("#team-form");
        let dataTable;

        dataTable = $(table).DataTable({
            processing: true,
            serverSide: true,
            ajax: endpoints.list,
            order: [[4, "asc"]],
            columns: [
                { data: "id" },
                { data: "name" },
                { data: "role_title" },
                { data: "linkedin_url", orderable: false },
                { data: "sort_order" },
                { data: "actions", orderable: false, searchable: false },
            ],
        });

        const resetForm = () => {
            $form[0].reset();
            $form.removeData("id");
        };

        $modal.on("show.bs.modal", function (event) {
            const mode = $(event.relatedTarget).data("mode") || "create";
            resetForm();
            if (mode === "edit") {
                const id = $(event.relatedTarget).data("id");
                $.get(endpoints.show(id)).done(({ data }) => {
                    populateForm($form, data);
                    $form.data("id", id);
                });
            }
        });

        $form.on("submit", function (e) {
            e.preventDefault();
            const id = $form.data("id");
            const formData = new FormData($form[0]);
            const method = id ? "POST" : "POST";
            const url = id ? endpoints.update(id) : endpoints.store;
            if (id) formData.append("_method", "PUT");
            $.ajax({
                url,
                method,
                data: formData,
                processData: false,
                contentType: false,
            })
                .done(() => {
                    dataTable.ajax.reload(null, false);
                    $modal.modal("hide");
                })
                .fail((xhr) =>
                    alert(
                        xhr.responseJSON?.message ||
                            "Unable to save team member."
                    )
                );
        });

        $(table).on("click", '[data-action="edit"]', function () {
            const id = $(this).data("id");
            $.get(endpoints.show(id)).done(({ data }) => {
                populateForm($form, data);
                $form.data("id", id);
                $modal.modal("show");
            });
        });

        $(table).on("click", '[data-action="delete"]', function () {
            const id = $(this).data("id");
            if (!confirm("Delete this team member?")) return;
            $.ajax({ url: endpoints.delete(id), method: "DELETE" })
                .done(() => dataTable.ajax.reload(null, false))
                .fail(() => alert("Failed to delete member."));
        });
    };

    const initContactAdmin = () => {
        if (!window.AdminContacts) return;
        const { endpoints, table } = window.AdminContacts;
        const $modal = $("#contactModal");
        const $fields = $modal.find("[data-field]");
        let dataTable;

        dataTable = $(table).DataTable({
            processing: true,
            serverSide: true,
            ajax: endpoints.list,
            order: [[5, "desc"]],
            columns: [
                { data: "id" },
                { data: "name" },
                { data: "email" },
                { data: "company" },
                { data: "status" },
                { data: "created_at" },
                { data: "actions", orderable: false, searchable: false },
            ],
        });

        const updateStatus = (id, status) => {
            $.post(endpoints.updateStatus(id), { status })
                .done(() => dataTable.ajax.reload(null, false))
                .fail(() => alert("Unable to update status."));
        };

        $(table).on("click", '[data-action="view"]', function () {
            const id = $(this).data("id");
            $.get(endpoints.show(id)).done(({ data }) => {
                $fields.each(function () {
                    const field = $(this).data("field");
                    $(this).text(data[field] || "—");
                });
                $modal.data("id", id).modal("show");
            });
        });

        $(table).on("click", '[data-action="status"]', function () {
            const id = $(this).data("id");
            const status = $(this).data("status");
            updateStatus(id, status);
        });

        $(table).on("click", '[data-action="delete"]', function () {
            const id = $(this).data("id");
            if (!confirm("Delete this message?")) return;
            $.ajax({ url: endpoints.delete(id), method: "DELETE" })
                .done(() => dataTable.ajax.reload(null, false))
                .fail(() => alert("Failed to delete message."));
        });

        $modal.on("click", '[data-action="status"]', function () {
            const status = $(this).data("status");
            const id = $modal.data("id");
            updateStatus(id, status);
        });

        $modal.on("click", '[data-action="delete"]', function () {
            const id = $modal.data("id");
            if (!confirm("Delete this message?")) return;
            $.ajax({ url: endpoints.delete(id), method: "DELETE" })
                .done(() => {
                    dataTable.ajax.reload(null, false);
                    $modal.modal("hide");
                })
                .fail(() => alert("Failed to delete message."));
        });
    };

    $(document).ready(function () {
        initContactForm();
        initLoginForm();
        initLightGallery();
        initServicesAdmin();
        initProjectsAdmin();
        initTeamAdmin();
        initContactAdmin();
    });
})(jQuery);
