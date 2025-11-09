(function ($) {
    "use strict";

    // ----- CSRF + AJAX defaults -----
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

    // ----- LightGallery plugin guard (optional modules) -----
    if (
        typeof window.lgModules === "undefined" &&
        typeof lgZoom !== "undefined" &&
        typeof lgThumbnail !== "undefined"
    ) {
        window.lgModules = [lgZoom, lgThumbnail];
    }

    // ---------- Helpers ----------
    const handleAjaxError = (xhr, $feedback) => {
        const res = xhr.responseJSON || {};
        const message =
            res.message || "Something went wrong. Please try again.";
        const errors = res.errors
            ? Object.values(res.errors).flat().join("<br>")
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
        if (typeof window === "undefined" || typeof window.Swal === "undefined")
            return null;
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
            .map((m) => `<li>${m}</li>`)
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

    const presentAjaxError = (
        xhr,
        fallbackMessage = "Unable to process the request."
    ) => {
        const res = xhr?.responseJSON || {};
        const message = res.message || fallbackMessage;
        const errorsHtml = formatValidationErrors(res.errors);
        const htmlParts = [];
        if (message) htmlParts.push(`<p class="mb-2">${message}</p>`);
        if (errorsHtml) htmlParts.push(errorsHtml);
        return showSwalError(
            "Action needed",
            htmlParts.join("") || fallbackMessage
        );
    };

    const populateForm = ($form, data) => {
        Object.entries(data).forEach(([key, value]) => {
            const $input = $form.find(`[name="${key}"]`);
            if (!$input.length) return;

            if ($input.is(':checkbox')) {
                // anggap true kalau true / 1 / "1"
                const truthy = value === true || value === 1 || value === '1';
                $input.prop('checked', truthy).val('1'); // nilai checkbox tetap 1 saat checked

                // sinkronkan hidden field yang bernama sama (jika ada)
                const $hidden = $form.find(`input[type="hidden"][name="${key}"]`);
                if ($hidden.length) $hidden.val(truthy ? 1 : 0);
                return;
            }

            if ($input.attr('type') === 'file') return;

            if ($input.attr('type') === 'date' && value) {
                $input.val(String(value).substring(0, 10));
                return;
            }

            $input.val(value);
        });
    };


    // ---------- Public forms ----------
    const initContactForm = () => {
        const $form = $("#contact-form");
        if (!$form.length) return;
        const $feedback = $("#contact-feedback");
        $form.on("submit", function (e) {
            e.preventDefault();
            $.post($form.attr("action"), $form.serialize())
                .done((res) => {
                    handleAjaxSuccess(
                        res,
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
            $.post($form.attr("action"), $form.serialize())
                .done((res) => {
                    handleAjaxSuccess(
                        res,
                        $feedback,
                        "Login successful. Redirecting..."
                    );
                    setTimeout(
                        () => (window.location.href = res.redirect || "/admin"),
                        800
                    );
                })
                .fail((xhr) => handleAjaxError(xhr, $feedback));
        });
    };

    // ---------- LightGallery on frontend ----------
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

    // ---------- Admin: Services ----------
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
            $.ajax({ url, method, data: $form.serialize() })
                .done((res) => {
                    dataTable.ajax.reload(null, false);
                    $modal.modal("hide");
                    showSwalSuccess("Saved", res.message || "Service saved.");
                })
                .fail((xhr) =>
                    presentAjaxError(xhr, "Unable to save service.")
                );
        });

        $(table).on("click", '[data-action="edit"]', function () {
            const id = $(this).data("id");
            resetForm();
            $.get(endpoints.show(id)).done(({ data }) => {
                populateForm($form, data);
                $form.data("id", id);
                $submit.text("Update service");
                $modal.modal("show");
            });
        });

        $(table).on("click", '[data-action="delete"]', async function () {
            const id = $(this).data("id");
            const ask = await confirmSwal(
                "Delete this service?",
                "This action cannot be undone."
            );
            if (!ask.isConfirmed) return;
            $.ajax({ url: endpoints.delete(id), method: "DELETE" })
                .done((res) => {
                    dataTable.ajax.reload(null, false);
                    showSwalSuccess(
                        "Deleted",
                        res.message || "Service deleted."
                    );
                })
                .fail((xhr) =>
                    presentAjaxError(xhr, "Failed to delete service.")
                );
        });

        loadTable();
    };

    // ---------- Admin: Projects (fixed) ----------
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
            if ($form[0]) $form[0].reset();
            $form.removeData("id").removeClass("was-validated");
        };

        const setSubmitting = (isLoading) => {
            const mode = $modal.data("mode") || "create";
            const copy = modalCopy[mode] || modalCopy.create;
            $submitButton.prop("disabled", isLoading);
            $submitLabel.text(
                isLoading
                    ? mode === "edit"
                        ? "Updating..."
                        : "Saving..."
                    : copy.submit
            );
        };

        const refreshTable = () => {
            if (dataTable) dataTable.ajax.reload(null, false);
        };

        // DataTable load
        if (table) {
            dataTable = $(table).DataTable({
                processing: true,
                serverSide: true,
                ajax: endpoints.list,
                order: [[0, "desc"]],
                columns: [
                    { data: "id" },
                    { data: "title" },
                    { data: "slug" },
                    { data: "published_at" },
                    { data: "is_featured" },
                    { data: "actions", orderable: false, searchable: false },
                ],
            });
        }

        // Gallery render/order
        const renderGallery = (images, projectId) => {
            $galleryGrid.empty();
            (images || []).forEach((image) => {
                const caption = image.caption || "";
                const card = $(`
                    <div class="col-md-6 gallery-card" data-id="${
                        image.id
                    }" draggable="true">
                        <div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow-sm position-relative">
                            <img class="w-100 h-100 object-fit-cover" src="/storage/${
                                image.file_path
                            }" alt="${caption || "Project image"}">
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2 gap-2">
                            <p class="mb-0 small text-muted flex-fill text-truncate" title="${caption}">${caption}</p>
                            <button class="btn btn-sm btn-outline-danger" data-action="remove-image" data-id="${
                                image.id
                            }" data-project="${projectId}" title="Remove image">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                `);
                $galleryGrid.append(card);
            });
            $galleryGrid.data("items", images || []);
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

        // Drag & drop events
        $galleryGrid.on("dragstart", ".gallery-card", function (e) {
            dragCard = this;
            $(this).addClass("dragging");
            if (e.originalEvent?.dataTransfer) {
                e.originalEvent.dataTransfer.effectAllowed = "move";
                e.originalEvent.dataTransfer.setData(
                    "text/plain",
                    $(this).data("id")
                );
            }
        });
        $galleryGrid.on("dragover", ".gallery-card", function (e) {
            e.preventDefault();
            if (!dragCard || this === dragCard) return;
            const bounding = this.getBoundingClientRect();
            const offset = (e.originalEvent?.clientY || 0) - bounding.top;
            const $dragCard = $(dragCard);
            offset > bounding.height / 2
                ? $(this).after($dragCard)
                : $(this).before($dragCard);
        });
        $galleryGrid.on("dragover", function (e) {
            if (!dragCard) return;
            const $target = $(e.target).closest(".gallery-card");
            if ($target.length) return;
            e.preventDefault();
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
            persistGalleryOrder($galleryModal.data("project-id"));
            dragCard = null;
        });
        $galleryGrid.on("drop", ".gallery-card", function (e) {
            e.preventDefault();
            $(this).removeClass("drag-over");
        });

        // Modal open (create/edit)
        const openModal = (projectId = null) => {
            resetForm();
            setModalMode(projectId ? "edit" : "create");
            setSubmitting(false);

            if (!projectId) {
                $modal.modal("show");
                return;
            }

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
        };

        // Gallery open
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

        // Modal events
        $modal.on("shown.bs.modal", () => {
            $form.find('[name="title"]').trigger("focus");
        });
        $modal.on("hidden.bs.modal", () => {
            resetForm();
            setModalMode("create");
            setSubmitting(false);
        });

        // Create button
        $('[data-action="create-project"]').on("click", () => openModal());

        // // Submit form (create/update) — FIXED BLOCK
        // $form.on("submit", function (e) {
        //     e.preventDefault();
        //     const id = $form.data("id");
        //     const method = id ? "PUT" : "POST";
        //     const url = id ? endpoints.update(id) : endpoints.store;

        //     setSubmitting(true);
        //     $.ajax({ url, method, data: $form.serialize() })
        //         .done((response) => {
        //             $modal.modal("hide");
        //             refreshTable();
        //             showSwalSuccess(
        //                 id ? "Project updated" : "Project created",
        //                 response.message ||
        //                     (id ? "The project was updated successfully." : "The project was created successfully.")
        //             );
        //         })
        //         .fail((xhr) => presentAjaxError(xhr, id ? "Unable to update the project." : "Unable to create the project."))
        //         .always(() => setSubmitting(false));
        // });
        // Submit form (create/update) — FIXED BLOCK
        $form.on("submit", function (e) {
            e.preventDefault();

            // ⬇️ Tambahkan blok normalisasi ini
            const $cb = $form.find(
                'input[type="checkbox"][name="is_featured"]'
            );
            if ($cb.length) {
                const checked = $cb.is(":checked") ? 1 : 0;
                // pastikan ada hidden input 'is_featured' agar serialize() kirim 0 saat unchecked
                let $hidden = $form.find(
                    'input[type="hidden"][name="is_featured"]'
                );
                if (!$hidden.length) {
                    $hidden = $(
                        '<input type="hidden" name="is_featured">'
                    ).appendTo($form);
                }
                $hidden.val(checked);
            }
            // ⬆️ Sampai sini

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
                                : "The project was created successfully.")
                    );
                })
                .fail((xhr) =>
                    presentAjaxError(
                        xhr,
                        id
                            ? "Unable to update the project."
                            : "Unable to create the project."
                    )
                )
                .always(() => setSubmitting(false));
        });

        // Table: Edit / Delete / Gallery
        if (table) {
            $(table).on("click", '[data-action="edit"]', function () {
                const id = $(this).data("id");
                openModal(id);
            });

            $(table).on("click", '[data-action="delete"]', async function () {
                const id = $(this).data("id");
                const ask = await confirmSwal(
                    "Delete this project?",
                    "This action cannot be undone."
                );
                if (!ask.isConfirmed) return;
                $.ajax({ url: endpoints.delete(id), method: "DELETE" })
                    .done((res) => {
                        refreshTable();
                        showSwalSuccess(
                            "Deleted",
                            res.message || "Project deleted."
                        );
                    })
                    .fail((xhr) =>
                        presentAjaxError(xhr, "Failed to delete the project.")
                    );
            });

            $(table).on("click", '[data-action="gallery"]', function () {
                const id = $(this).data("id");
                loadGallery(id);
            });
        }

        // Gallery: upload & remove
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
                .done(() => loadGallery(projectId))
                .fail((xhr) =>
                    presentAjaxError(xhr, "Failed to upload image.")
                );
        });

        $galleryGrid.on(
            "click",
            '[data-action="remove-image"]',
            async function () {
                const id = $(this).data("id");
                const projectId = $(this).data("project");
                const ask = await confirmSwal(
                    "Remove this image?",
                    "This cannot be undone."
                );
                if (!ask.isConfirmed) return;

                $.ajax({
                    url: endpoints.removeImage(projectId, id),
                    method: "DELETE",
                })
                    .done(() => loadGallery(projectId))
                    .fail((xhr) =>
                        presentAjaxError(xhr, "Failed to remove image.")
                    );
            }
        );
    }; // <--- END initProjectsAdmin (pastikan fungsi berakhir di sini)

    // ---------- Admin: Team ----------
    const initTeamAdmin = () => {
        if (!window.AdminTeam) return;
        const { endpoints, table } = window.AdminTeam;
        const $modal = $("#teamModal");
        const $form = $("#team-form");
        const $photoInput = $form.find('[name="photo"]');
        const $previewLink = $modal.find("[data-preview-link]");
        const $previewImage = $modal.find("[data-preview-image]");
        const $previewEmpty = $modal.find("[data-preview-empty]");
        const previewPlaceholder = $previewLink.data("placeholder");
        let previewGalleryInstance = null;
        let existingPhotoPath = null;
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

        const destroyPreviewGallery = () => {
            if (previewGalleryInstance) {
                previewGalleryInstance.destroy(true);
                previewGalleryInstance = null;
            }
        };

        const initPreviewGallery = () => {
            if (typeof window.lightGallery === "undefined") return;
            const wrapper = document.getElementById("team-photo-preview-wrapper");
            if (!wrapper) return;
            destroyPreviewGallery();
            previewGalleryInstance = window.lightGallery(wrapper, {
                selector: "[data-preview-link]:not(.disabled)",
                plugins: window.lgModules || [],
                download: false,
                speed: 300,
            });
        };

        const resolvePhotoSource = (value) => {
            if (!value) return null;
            if (/^(https?:|data:|blob:)/i.test(value)) {
                return value;
            }
            const sanitized = String(value).replace(/^\/+/, "");
            return `/storage/${sanitized}`;
        };

        const setPhotoPreview = (value) => {
            const imageUrl = resolvePhotoSource(value);
            const hasPhoto = Boolean(imageUrl);
            $previewImage.attr("src", hasPhoto ? imageUrl : previewPlaceholder);
            $previewImage.toggleClass("d-none", !hasPhoto);
            $previewEmpty.toggleClass("d-none", hasPhoto);
            $previewLink
                .attr("href", hasPhoto ? imageUrl : previewPlaceholder)
                .toggleClass("disabled pe-none", !hasPhoto)
                .attr("tabindex", hasPhoto ? "0" : "-1");
            if (hasPhoto) {
                initPreviewGallery();
            } else {
                destroyPreviewGallery();
            }
        };

        const rememberExistingPhoto = (value) => {
            existingPhotoPath = value || null;
            setPhotoPreview(existingPhotoPath);
        };

        const resetForm = () => {
            $form[0].reset();
            $form.removeData("id");
            rememberExistingPhoto(null);
        };

        $modal.on("show.bs.modal", function (event) {
            const $trigger = $(event.relatedTarget);
            if (!$trigger.length) {
                // Programmatic show (edit via JS) already handles state.
                return;
            }
            const mode = $trigger.data("mode") || "create";
            resetForm();
            if (mode === "edit") {
                const id = $trigger.data("id");
                if (!id) return;
                $.get(endpoints.show(id)).done(({ data }) => {
                    populateForm($form, data);
                    $form.data("id", id);
                    rememberExistingPhoto(data.photo_path);
                });
            } else {
                $form.removeData("id");
                rememberExistingPhoto(null);
            }
        });

        $form.on("submit", function (e) {
            e.preventDefault();
            const id = $form.data("id");
            const formData = new FormData($form[0]);
            const url = id ? endpoints.update(id) : endpoints.store;
            if (id) formData.append("_method", "PUT");

            $.ajax({
                url,
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
            })
                .done((res) => {
                    dataTable.ajax.reload(null, false);
                    $modal.modal("hide");
                    showSwalSuccess(
                        "Saved",
                        res.message || "Team member saved."
                    );
                })
                .fail((xhr) =>
                    presentAjaxError(xhr, "Unable to save team member.")
                );
        });

        $(table).on("click", '[data-action="edit"]', function () {
            const id = $(this).data("id");
            resetForm();
            $.get(endpoints.show(id)).done(({ data }) => {
                populateForm($form, data);
                $form.data("id", id);
                rememberExistingPhoto(data.photo_path);
                $modal.modal("show");
            });
        });

        $photoInput.on("change", function () {
            const file = this.files?.[0];
            if (!file) {
                setPhotoPreview(existingPhotoPath);
                return;
            }
            const reader = new FileReader();
            reader.onload = (event) => setPhotoPreview(event.target?.result);
            reader.readAsDataURL(file);
        });

        $(table).on("click", '[data-action="delete"]', async function () {
            const id = $(this).data("id");
            const ask = await confirmSwal(
                "Delete this team member?",
                "This action cannot be undone."
            );
            if (!ask.isConfirmed) return;

            $.ajax({ url: endpoints.delete(id), method: "DELETE" })
                .done((res) => {
                    dataTable.ajax.reload(null, false);
                    showSwalSuccess(
                        "Deleted",
                        res.message || "Team member deleted."
                    );
                })
                .fail((xhr) =>
                    presentAjaxError(xhr, "Failed to delete member.")
                );
        });
    };

    // ---------- Admin: Contacts ----------
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
                .done((res) => {
                    dataTable.ajax.reload(null, false);
                    showSwalSuccess(
                        "Updated",
                        res.message || "Status updated."
                    );
                })
                .fail((xhr) =>
                    presentAjaxError(xhr, "Unable to update status.")
                );
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

        $(table).on("click", '[data-action="delete"]', async function () {
            const id = $(this).data("id");
            const ask = await confirmSwal(
                "Delete this message?",
                "This action cannot be undone."
            );
            if (!ask.isConfirmed) return;

            $.ajax({ url: endpoints.delete(id), method: "DELETE" })
                .done((res) => {
                    dataTable.ajax.reload(null, false);
                    showSwalSuccess(
                        "Deleted",
                        res.message || "Message deleted."
                    );
                })
                .fail((xhr) =>
                    presentAjaxError(xhr, "Failed to delete message.")
                );
        });

        $modal.on("click", '[data-action="status"]', function () {
            const status = $(this).data("status");
            updateStatus($modal.data("id"), status);
        });

        $modal.on("click", '[data-action="delete"]', async function () {
            const id = $modal.data("id");
            const ask = await confirmSwal(
                "Delete this message?",
                "This action cannot be undone."
            );
            if (!ask.isConfirmed) return;

            $.ajax({ url: endpoints.delete(id), method: "DELETE" })
                .done((res) => {
                    dataTable.ajax.reload(null, false);
                    $modal.modal("hide");
                    showSwalSuccess(
                        "Deleted",
                        res.message || "Message deleted."
                    );
                })
                .fail((xhr) =>
                    presentAjaxError(xhr, "Failed to delete message.")
                );
        });
    };

    // ---------- Boot ----------
    $(document).ready(function () {
        initContactForm();
        initLoginForm();
        initLightGallery();
        initServicesAdmin();
        initProjectsAdmin(); // <- area yang rusak sebelumnya, sekarang sudah tertutup rapi
        initTeamAdmin();
        initContactAdmin();
    });
})(jQuery);
