<div class="modal fade" id="serviceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-light">
                <h5 class="modal-title">Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="service-form">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Slug</label>
                            <input type="text" name="slug" class="form-control" placeholder="auto-generated if blank">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Icon class</label>
                            <input type="text" name="icon_class" class="form-control" placeholder="e.g. ph-duotone ph-globe">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Display order</label>
                            <input type="number" name="display_order" class="form-control" min="0" value="0">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Excerpt</label>
                            <input type="text" name="excerpt" class="form-control" maxlength="255" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Detailed description</label>
                            <textarea name="body" class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="col-12 form-check">
                            <input class="form-check-input" type="checkbox" name="is_featured" id="service-featured">
                            <label class="form-check-label" for="service-featured">Highlight on homepage</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save service</button>
                </div>
            </form>
        </div>
    </div>
</div>
