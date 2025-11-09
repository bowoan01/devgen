(function () {
    const tokenMeta = document.querySelector('meta[name="csrf-token"]');
    if (tokenMeta && window.jQuery) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': tokenMeta.getAttribute('content')
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initLightGallery();
        initContactForm();
        initAdminLogin();
        initServiceAdmin();
        initProjectAdmin();
        initTeamAdmin();
        initContactAdmin();
    });

    function initLightGallery() {
        const gallery = document.getElementById('project-gallery');
        if (gallery && window.lightGallery) {
            const plugins = [];
            if (typeof window.lgThumbnail !== 'undefined') { plugins.push(lgThumbnail); }
            if (typeof window.lgZoom !== 'undefined') { plugins.push(lgZoom); }
            lightGallery(gallery, {
                selector: '.gallery-item',
                plugins: plugins,
                licenseKey: '0000-0000-000-0000',
            });
        }
    }

    function initContactForm() {
        const form = document.getElementById('contact-form');
        if (!form || !window.jQuery) {
            return;
        }

        const alertBox = document.getElementById('contact-alert');
        const spinner = document.getElementById('contact-spinner');

        $(form).on('submit', function (event) {
            event.preventDefault();
            const $form = $(this);
            const submitButton = $form.find('button[type="submit"]');

            spinner?.classList.remove('d-none');
            submitButton.prop('disabled', true);
            alertBox?.classList.add('d-none');

            $.ajax({
                url: $form.attr('action'),
                method: 'POST',
                data: $form.serialize(),
                success: function (response) {
                    if (alertBox) {
                        alertBox.classList.remove('d-none', 'alert-danger');
                        alertBox.classList.add('alert-success');
                        alertBox.textContent = response.message || 'Thank you for reaching out.';
                    }
                    $form.trigger('reset');
                },
                error: function (xhr) {
                    if (alertBox) {
                        alertBox.classList.remove('d-none', 'alert-success');
                        alertBox.classList.add('alert-danger');
                        alertBox.textContent = formatErrors(xhr);
                    }
                },
                complete: function () {
                    spinner?.classList.add('d-none');
                    submitButton.prop('disabled', false);
                }
            });
        });
    }

    function initAdminLogin() {
        if (!window.jQuery) {
            return;
        }
        const form = document.getElementById('admin-login-form');
        if (!form) {
            return;
        }

        $(form).on('submit', function (event) {
            event.preventDefault();
            const $form = $(this);
            const submitButton = $form.find('button[type="submit"]');
            submitButton.prop('disabled', true).text('Signing in…');

            $.ajax({
                url: $form.attr('action'),
                method: 'POST',
                data: $form.serialize(),
                success: function (response) {
                    window.location.href = response.redirect || '/admin';
                },
                error: function (xhr) {
                    const errors = formatErrors(xhr);
                    let alert = document.getElementById('login-error');
                    if (!alert) {
                        alert = document.createElement('div');
                        alert.id = 'login-error';
                        alert.className = 'alert alert-danger mt-3';
                        form.prepend(alert);
                    }
                    alert.textContent = errors;
                },
                complete: function () {
                    submitButton.prop('disabled', false).text('Sign in');
                }
            });
        });
    }

    function initServiceAdmin() {
        if (!window.jQuery) {
            return;
        }
        const tableElement = $('#services-table');
        if (!tableElement.length) {
            return;
        }
        const config = window.Devengour?.servicesConfig;
        const modal = document.getElementById('service-modal');
        const errorBox = document.getElementById('service-errors');
        const form = document.getElementById('service-form');
        let currentId = null;

        const table = tableElement.DataTable({
            processing: true,
            serverSide: true,
            ajax: config.tableUrl,
            columns: [
                { data: 'title', name: 'title' },
                { data: 'slug', name: 'slug' },
                { data: 'featured_label', orderable: false, searchable: false },
                { data: 'updated_at', name: 'updated_at' },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: function (data) {
                        return `<div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-primary" data-action="edit" data-id="${data}">Edit</button>
                                    <button type="button" class="btn btn-outline-danger" data-action="delete" data-id="${data}">Delete</button>
                                </div>`;
                    }
                }
            ],
            order: [[3, 'desc']]
        });

        modal?.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            errorBox?.classList.add('d-none');
            form.reset();
            if (button?.getAttribute('data-action') === 'edit') {
                currentId = button.getAttribute('data-id');
                fetchService(currentId);
            } else {
                currentId = null;
                form.querySelector('[name="display_order"]').value = '0';
            }
        });

        modal?.addEventListener('hidden.bs.modal', function () {
            currentId = null;
            errorBox?.classList.add('d-none');
        });

        tableElement.on('click', 'button[data-action="edit"]', function () {
            const id = this.getAttribute('data-id');
            const modalInstance = bootstrap.Modal.getOrCreateInstance(modal);
            currentId = id;
            modalInstance.show(this);
        });

        tableElement.on('click', 'button[data-action="delete"]', function () {
            const id = this.getAttribute('data-id');
            if (!confirm('Delete this service?')) {
                return;
            }
            $.ajax({
                url: config.deleteUrl(id),
                method: 'DELETE',
                success: function () {
                    table.ajax.reload(null, false);
                }
            });
        });

        $(form).on('submit', function (event) {
            event.preventDefault();
            const formData = new FormData(form);
            if (!formData.has('is_featured')) {
                formData.append('is_featured', '0');
            }
            const url = currentId ? config.updateUrl(currentId) : config.storeUrl;
            if (currentId) {
                formData.append('_method', 'PUT');
            }
            $.ajax({
                url,
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function () {
                    bootstrap.Modal.getInstance(modal)?.hide();
                    table.ajax.reload(null, false);
                },
                error: function (xhr) {
                    if (errorBox) {
                        errorBox.classList.remove('d-none');
                        errorBox.innerHTML = formatErrors(xhr);
                    }
                }
            });
        });

        function fetchService(id) {
            $.getJSON(config.showUrl(id), function (response) {
                const data = response.data;
                form.querySelector('[name="title"]').value = data.title || '';
                form.querySelector('[name="slug"]').value = data.slug || '';
                form.querySelector('[name="icon_class"]').value = data.icon_class || '';
                form.querySelector('[name="display_order"]').value = data.display_order || 0;
                form.querySelector('[name="excerpt"]').value = data.excerpt || '';
                form.querySelector('[name="body"]').value = data.body || '';
                form.querySelector('[name="is_featured"]').checked = !!data.is_featured;
            });
        }
    }

    function initProjectAdmin() {
        if (!window.jQuery) {
            return;
        }
        const tableElement = $('#projects-table');
        if (!tableElement.length) {
            return;
        }
        const config = window.Devengour?.projectsConfig;
        const modal = document.getElementById('project-modal');
        const form = document.getElementById('project-form');
        const errorBox = document.getElementById('project-errors');
        const preview = document.getElementById('project-gallery-preview');
        const reorderButton = document.getElementById('project-reorder');
        let currentId = null;
        let galleryOrder = [];

        const table = tableElement.DataTable({
            processing: true,
            serverSide: true,
            ajax: config.tableUrl,
            columns: [
                { data: 'title', name: 'title' },
                { data: 'category', name: 'category' },
                { data: 'featured_label', orderable: false, searchable: false },
                { data: 'published_at', name: 'published_at' },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: function (data) {
                        return `<div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-primary" data-action="edit" data-id="${data}">Edit</button>
                                    <button type="button" class="btn btn-outline-danger" data-action="delete" data-id="${data}">Delete</button>
                                </div>`;
                    }
                }
            ],
            order: [[3, 'desc']]
        });

        tableElement.on('click', 'button[data-action="edit"]', function () {
            const id = this.getAttribute('data-id');
            currentId = id;
            const modalInstance = bootstrap.Modal.getOrCreateInstance(modal);
            modalInstance.show(this);
        });

        tableElement.on('click', 'button[data-action="delete"]', function () {
            const id = this.getAttribute('data-id');
            if (!confirm('Delete this project?')) {
                return;
            }
            $.ajax({
                url: config.deleteUrl(id),
                method: 'DELETE',
                success: function () {
                    table.ajax.reload(null, false);
                }
            });
        });

        modal?.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            form.reset();
            errorBox?.classList.add('d-none');
            preview.innerHTML = '';
            galleryOrder = [];
            if (button?.getAttribute('data-action') === 'edit' && currentId) {
                fetchProject(currentId);
            } else {
                currentId = null;
            }
        });

        $(form).on('submit', function (event) {
            event.preventDefault();
            const formData = new FormData(form);
            const techField = form.querySelector('[name="tech_stack[]"]');
            if (techField && techField.value) {
                const parts = techField.value.split(',').map(function (item) {
                    return item.trim();
                }).filter(Boolean);
                formData.delete('tech_stack[]');
                parts.forEach(function (item) {
                    formData.append('tech_stack[]', item);
                });
            }
            if (!formData.has('is_featured')) {
                formData.append('is_featured', '0');
            }
            const url = currentId ? config.updateUrl(currentId) : config.storeUrl;
            if (currentId) {
                formData.append('_method', 'PUT');
            }
            $.ajax({
                url,
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function () {
                    bootstrap.Modal.getInstance(modal)?.hide();
                    table.ajax.reload(null, false);
                },
                error: function (xhr) {
                    if (errorBox) {
                        errorBox.classList.remove('d-none');
                        errorBox.innerHTML = formatErrors(xhr);
                    }
                }
            });
        });

        reorderButton?.addEventListener('click', function () {
            if (!currentId || !galleryOrder.length) {
                return;
            }
            $.ajax({
                url: config.reorderUrl(currentId),
                method: 'POST',
                data: { order: galleryOrder },
                success: function () {
                    bootstrap.Toast?.getOrCreateInstance(createToast('Gallery order saved.'))?.show();
                }
            });
        });

        preview?.addEventListener('dragstart', function (event) {
            const target = event.target.closest('.gallery-item');
            if (!target) return;
            event.dataTransfer.setData('text/plain', target.dataset.id);
            event.dataTransfer.effectAllowed = 'move';
        });

        preview?.addEventListener('dragover', function (event) {
            event.preventDefault();
            event.dataTransfer.dropEffect = 'move';
        });

        preview?.addEventListener('drop', function (event) {
            event.preventDefault();
            const sourceId = event.dataTransfer.getData('text/plain');
            const dragged = preview.querySelector(`[data-id="${sourceId}"]`);
            const target = event.target.closest('.gallery-item');
            if (dragged && target && dragged !== target) {
                const nodes = Array.from(preview.children);
                const dragIndex = nodes.indexOf(dragged.parentElement);
                const dropIndex = nodes.indexOf(target.parentElement);
                if (dragIndex > dropIndex) {
                    preview.insertBefore(dragged.parentElement, target.parentElement);
                } else {
                    preview.insertBefore(dragged.parentElement, target.parentElement.nextSibling);
                }
                updateGalleryOrder();
            }
        });

        preview?.addEventListener('click', function (event) {
            const button = event.target.closest('.remove-image');
            if (!button) return;
            const imageId = button.dataset.id;
            if (!confirm('Remove this image?')) {
                return;
            }
            $.ajax({
                url: config.deleteImageUrl(imageId),
                method: 'DELETE',
                success: function () {
                    preview.querySelector(`[data-wrapper-id="${imageId}"]`)?.remove();
                    updateGalleryOrder();
                }
            });
        });

        function fetchProject(id) {
            $.getJSON(config.showUrl(id), function (response) {
                const data = response.data;
                form.querySelector('[name="title"]').value = data.title || '';
                form.querySelector('[name="slug"]').value = data.slug || '';
                form.querySelector('[name="category"]').value = data.category || 'web';
                form.querySelector('[name="summary"]').value = data.summary || '';
                form.querySelector('[name="problem_text"]').value = data.problem_text || '';
                form.querySelector('[name="solution_text"]').value = data.solution_text || '';
                form.querySelector('[name="published_at"]').value = data.published_at ? data.published_at.substring(0, 10) : '';
                form.querySelector('[name="testimonial_author"]').value = data.testimonial_author || '';
                form.querySelector('[name="testimonial_text"]').value = data.testimonial_text || '';
                form.querySelector('[name="is_featured"]').checked = !!data.is_featured;
                const techField = form.querySelector('[name="tech_stack[]"]');
                if (techField) {
                    techField.value = Array.isArray(data.tech_stack) ? data.tech_stack.join(', ') : '';
                }
                renderGallery(data.images || []);
            });
        }

        function renderGallery(images) {
            preview.innerHTML = '';
            images.forEach(function (image) {
                const column = document.createElement('div');
                column.className = 'col-4';
                column.dataset.wrapperId = image.id;
                column.innerHTML = `<div class="gallery-item border" data-id="${image.id}" draggable="true">
                        <img src="/storage/${image.file_path}" class="img-fluid" alt="Project image">
                        <button type="button" class="remove-image" data-id="${image.id}">×</button>
                    </div>`;
                preview.appendChild(column);
            });
            updateGalleryOrder();
        }

        function updateGalleryOrder() {
            galleryOrder = Array.from(preview.querySelectorAll('.gallery-item')).map(function (item) {
                return item.dataset.id;
            });
        }
    }

    function initTeamAdmin() {
        if (!window.jQuery) {
            return;
        }
        const tableElement = $('#team-table');
        if (!tableElement.length) {
            return;
        }
        const config = window.Devengour?.teamConfig;
        const modal = document.getElementById('team-modal');
        const form = document.getElementById('team-form');
        const errorBox = document.getElementById('team-errors');
        let currentId = null;

        const table = tableElement.DataTable({
            processing: true,
            serverSide: true,
            ajax: config.tableUrl,
            columns: [
                { data: 'name', name: 'name' },
                { data: 'role_title', name: 'role_title' },
                { data: 'linkedin_url', name: 'linkedin_url', render: function (data) {
                    if (!data) return '<span class="text-muted">—</span>';
                    return `<a href="${data}" target="_blank" rel="noopener">LinkedIn</a>`;
                } },
                { data: 'updated_at', name: 'updated_at' },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: function (data) {
                        return `<div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-primary" data-action="edit" data-id="${data}">Edit</button>
                                    <button type="button" class="btn btn-outline-danger" data-action="delete" data-id="${data}">Delete</button>
                                </div>`;
                    }
                }
            ],
            order: [[3, 'desc']]
        });

        tableElement.on('click', 'button[data-action="edit"]', function () {
            currentId = this.getAttribute('data-id');
            const modalInstance = bootstrap.Modal.getOrCreateInstance(modal);
            modalInstance.show(this);
        });

        tableElement.on('click', 'button[data-action="delete"]', function () {
            const id = this.getAttribute('data-id');
            if (!confirm('Delete this team member?')) {
                return;
            }
            $.ajax({
                url: config.deleteUrl(id),
                method: 'DELETE',
                success: function () {
                    table.ajax.reload(null, false);
                }
            });
        });

        modal?.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            form.reset();
            errorBox?.classList.add('d-none');
            form.querySelector('[name="sort_order"]').value = '0';
            form.querySelector('[name="remove_photo"]').checked = false;
            if (button?.getAttribute('data-action') === 'edit' && currentId) {
                fetchTeamMember(currentId);
            } else {
                currentId = null;
            }
        });

        $(form).on('submit', function (event) {
            event.preventDefault();
            const formData = new FormData(form);
            const url = currentId ? config.updateUrl(currentId) : config.storeUrl;
            if (currentId) {
                formData.append('_method', 'PUT');
            }
            $.ajax({
                url,
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function () {
                    bootstrap.Modal.getInstance(modal)?.hide();
                    table.ajax.reload(null, false);
                },
                error: function (xhr) {
                    if (errorBox) {
                        errorBox.classList.remove('d-none');
                        errorBox.innerHTML = formatErrors(xhr);
                    }
                }
            });
        });

        function fetchTeamMember(id) {
            $.getJSON(config.showUrl(id), function (response) {
                const data = response.data;
                form.querySelector('[name="name"]').value = data.name || '';
                form.querySelector('[name="role_title"]').value = data.role_title || '';
                form.querySelector('[name="bio"]').value = data.bio || '';
                form.querySelector('[name="linkedin_url"]').value = data.linkedin_url || '';
                form.querySelector('[name="sort_order"]').value = data.sort_order || 0;
                form.querySelector('[name="remove_photo"]').checked = false;
            });
        }
    }

    function initContactAdmin() {
        if (!window.jQuery) {
            return;
        }
        const tableElement = $('#contacts-table');
        if (!tableElement.length) {
            return;
        }
        const config = window.Devengour?.contactsConfig;
        const modal = document.getElementById('contact-modal');
        const details = document.getElementById('contact-details');
        const deleteButton = document.getElementById('delete-contact');
        let currentId = null;

        const table = tableElement.DataTable({
            processing: true,
            serverSide: true,
            ajax: config.tableUrl,
            columns: [
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'company', name: 'company' },
                { data: 'status', name: 'status' },
                { data: 'created_at', name: 'created_at' },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: function (data) {
                        return `<div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-primary" data-action="view" data-id="${data}">View</button>
                                    <button type="button" class="btn btn-outline-danger" data-action="delete" data-id="${data}">Delete</button>
                                </div>`;
                    }
                }
            ],
            order: [[4, 'desc']]
        });

        tableElement.on('click', 'button[data-action="view"]', function () {
            currentId = this.getAttribute('data-id');
            fetchContact(currentId);
            bootstrap.Modal.getOrCreateInstance(modal).show();
        });

        tableElement.on('click', 'button[data-action="delete"]', function () {
            const id = this.getAttribute('data-id');
            if (!confirm('Delete this message?')) {
                return;
            }
            $.ajax({
                url: config.deleteUrl(id),
                method: 'DELETE',
                success: function () {
                    table.ajax.reload(null, false);
                }
            });
        });

        modal?.addEventListener('click', function (event) {
            const button = event.target.closest('button[data-status]');
            if (!button || !currentId) {
                return;
            }
            const status = button.getAttribute('data-status');
            $.ajax({
                url: config.statusUrl(currentId),
                method: 'PATCH',
                data: { status },
                success: function () {
                    table.ajax.reload(null, false);
                }
            });
        });

        deleteButton?.addEventListener('click', function () {
            if (!currentId || !confirm('Delete this message?')) {
                return;
            }
            $.ajax({
                url: config.deleteUrl(currentId),
                method: 'DELETE',
                success: function () {
                    bootstrap.Modal.getInstance(modal)?.hide();
                    table.ajax.reload(null, false);
                }
            });
        });

        function fetchContact(id) {
            $.getJSON(config.showUrl(id), function (response) {
                const data = response.data;
                if (details) {
                    details.innerHTML = '';
                    appendDetail('Name', data.name);
                    appendDetail('Email', `<a href="mailto:${data.email}">${data.email}</a>`);
                    appendDetail('Company', data.company || '—');
                    appendDetail('Phone', data.phone || '—');
                    appendDetail('Status', data.status);
                    appendDetail('Message', `<p class="mb-0">${(data.message || '').replace(/\n/g, '<br>')}</p>`);
                    appendDetail('Received', data.created_at);
                }
            });
        }

        function appendDetail(label, value) {
            const dt = document.createElement('dt');
            dt.className = 'col-sm-3 text-muted';
            dt.innerHTML = label;
            const dd = document.createElement('dd');
            dd.className = 'col-sm-9';
            dd.innerHTML = value;
            details.appendChild(dt);
            details.appendChild(dd);
        }
    }

    function formatErrors(xhr) {
        if (xhr?.responseJSON?.errors) {
            return Object.values(xhr.responseJSON.errors).flat().join(' ');
        }
        if (xhr?.responseJSON?.message) {
            return xhr.responseJSON.message;
        }
        return 'An unexpected error occurred.';
    }

    function createToast(message) {
        const container = document.getElementById('toast-container') || createToastContainer();
        const toast = document.createElement('div');
        toast.className = 'toast align-items-center text-bg-primary border-0';
        toast.setAttribute('role', 'status');
        toast.setAttribute('aria-live', 'polite');
        toast.setAttribute('aria-atomic', 'true');
        toast.innerHTML = `<div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>`;
        container.appendChild(toast);
        return toast;
    }

    function createToastContainer() {
        const container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'toast-container position-fixed top-0 end-0 p-3';
        document.body.appendChild(container);
        return container;
    }
})();
