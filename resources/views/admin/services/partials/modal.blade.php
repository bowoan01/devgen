<div class="modal fade" id="service-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="service-form">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Slug</label>
                            <input type="text" class="form-control" name="slug">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Icon class</label>
                            <input type="text" class="form-control" name="icon_class" placeholder="bi bi-stars">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Display order</label>
                            <input type="number" class="form-control" name="display_order" min="0" value="0">
                        </div>
                        <div class="col-md-3 d-flex align-items-center">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="service-featured">
                                <label class="form-check-label" for="service-featured">Featured</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Excerpt</label>
                            <textarea class="form-control" name="excerpt" rows="2"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Body</label>
                            <textarea class="form-control" name="body" rows="5"></textarea>
                        </div>
                        <div class="col-12">
                            <div class="alert alert-danger d-none" id="service-errors"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
