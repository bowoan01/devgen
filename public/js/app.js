(function ($) {
    "use strict";

    const token =
        document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute("content") ||
        document.querySelector('input[name="_token"]')?.value;
    if (token) {
        $.ajaxSetup({
            // headers: { 'X-CSRF-TOKEN': token }
            // headers: {
            //     "X-CSRF-TOKEN": document
            //         .querySelector('meta[name="csrf-token"]')
            //         .getAttribute("content"),
            // },
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                "X-Requested-With": "XMLHttpRequest",
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
        const $galleryModal = $("#galleryModal");
        const $galleryGrid = $("#gallery-grid");
        const $uploadForm = $("#gallery-upload");
        let dataTable;

        const renderGallery = (images, projectId) => {
            $galleryGrid.empty();
            images.forEach((image) => {
                const card = $(`
                    <div class="col-md-6 gallery-card" data-id="${
                        image.id
                    }" draggable="true">
                        <div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow-sm">
                            <img src="/storage/${
                                image.file_path
                            }" class="w-100 h-100 object-fit-cover" alt="${
                    image.caption || ""
                }">
                        </div>
                        <button class="btn btn-sm btn-outline-danger mt-2" data-action="remove-image" data-id="${
                            image.id
                        }" data-project="${projectId}">Remove</button>
                    </div>
                `);
                $galleryGrid.append(card);
            });
            $galleryGrid.data("items", images);
        };

        const persistGalleryOrder = (projectId) => {
            if (!projectId) return;
            const order = $galleryGrid
                .find(".gallery-card")
                .map((index, el) => $(el).data("id"))
                .get();
            $.post(endpoints.reorderImages(projectId), { order }).fail(() =>
                alert("Unable to save gallery order.")
            );
        };

        let dragCard = null;

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

        const refreshTable = () => dataTable.ajax.reload(null, false);

        const openModal = (id = null) => {
            $form[0].reset();
            $form.removeData("id");
            if (id) {
                $.get(endpoints.show(id)).done(({ data }) => {
                    populateForm($form, data);
                    $form.data("id", id);
                    $modal.modal("show");
                });
            } else {
                $modal.modal("show");
            }
        };

        $modal.on("shown.bs.modal", () => {
            $form.find('[name="title"]').trigger("focus");
        });

        $form.on("submit", function (e) {
            e.preventDefault();
            const id = $form.data("id");
            const method = id ? "PUT" : "POST";
            const url = id ? endpoints.update(id) : endpoints.store;
            $.ajax({ url, method, data: $form.serialize() })
                .done(() => {
                    $modal.modal("hide");
                    refreshTable();
                })
                .fail((xhr) =>
                    alert(
                        xhr.responseJSON?.message || "Unable to save project."
                    )
                );
        });

        $(table).on("click", '[data-action="edit"]', function () {
            openModal($(this).data("id"));
        });

        $(table).on("click", '[data-action="delete"]', function () {
            const id = $(this).data("id");
            if (!confirm("Delete this project?")) return;
            $.ajax({ url: endpoints.delete(id), method: "DELETE" })
                .done(() => refreshTable())
                .fail(() => alert("Failed to delete project."));
        });

        $(table).on("click", '[data-action="feature"]', function () {
            const id = $(this).data("id");
            $.post(endpoints.toggleFeatured(id)).done(() => refreshTable());
        });

        $(table).on("click", '[data-action="publish"]', function () {
            const id = $(this).data("id");
            $.post(endpoints.publish(id)).done(() => refreshTable());
        });

        $(table).on("click", '[data-action="unpublish"]', function () {
            const id = $(this).data("id");
            $.post(endpoints.unpublish(id)).done(() => refreshTable());
        });

        $(table).on("click", '[data-action="gallery"]', function () {
            const id = $(this).data("id");
            $.get(endpoints.show(id)).done(({ data }) => {
                renderGallery(data.images || [], id);
                $uploadForm.find("#gallery-project-id").val(id);
                $galleryModal.data("project-id", id).modal("show");
            });
        });

        $uploadForm.on("submit", function (e) {
            e.preventDefault();
            const projectId = $galleryModal.data("project-id");
            const formData = new FormData(this);
            $.ajax({
                url: endpoints.uploadImage(projectId),
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
            })
                .done(() => {
                    $.get(endpoints.show(projectId)).done(({ data }) =>
                        renderGallery(data.images || [], projectId)
                    );
                    $uploadForm.trigger("reset");
                    refreshTable();
                })
                .fail(() =>
                    alert("Upload failed. Please check the image size.")
                );
        });

        $galleryGrid.on("click", '[data-action="remove-image"]', function () {
            const imageId = $(this).data("id");
            const projectId = $(this).data("project");
            if (!confirm("Remove this image?")) return;
            $.ajax({
                url: endpoints.deleteImage(projectId, imageId),
                method: "DELETE",
            })
                .done(() => {
                    $.get(endpoints.show(projectId)).done(({ data }) =>
                        renderGallery(data.images || [], projectId)
                    );
                    refreshTable();
                })
                .fail(() => alert("Unable to delete image."));
        });

        dataTable = $(table).DataTable({
            processing: true,
            serverSide: true,
            ajax: endpoints.list,
            order: [[0, "desc"]],
            columns: [
                { data: "id" },
                { data: "title" },
                { data: "category" },
                { data: "is_featured" },
                { data: "published_at" },
                { data: "actions", orderable: false, searchable: false },
            ],
        });
    };

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
