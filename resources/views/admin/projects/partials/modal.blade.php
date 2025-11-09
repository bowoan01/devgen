<div class="modal fade" id="project-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="project-form" enctype="multipart/form-data">
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
                        <div class="col-md-4">
                            <label class="form-label">Category</label>
                            <select class="form-select" name="category" required>
                                <option value="web">Web</option>
                                <option value="mobile">Mobile</option>
                                <option value="design">Design</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Published at</label>
                            <input type="date" class="form-control" name="published_at">
                        </div>
                        <div class="col-md-4 d-flex align-items-center">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="project-featured">
                                <label class="form-check-label" for="project-featured">Featured</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Summary</label>
                            <textarea class="form-control" name="summary" rows="2"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Problem</label>
                            <textarea class="form-control" name="problem_text" rows="3"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Solution</label>
                            <textarea class="form-control" name="solution_text" rows="3"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Tech stack (comma separated)</label>
                            <input type="text" class="form-control" name="tech_stack[]" placeholder="Laravel, React, AWS">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Testimonial author</label>
                            <input type="text" class="form-control" name="testimonial_author">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Testimonial</label>
                            <textarea class="form-control" name="testimonial_text" rows="2"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Cover image</label>
                            <input type="file" class="form-control" name="cover_image" accept="image/*">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gallery images</label>
                            <input type="file" class="form-control" name="gallery[]" accept="image/*" multiple>
                        </div>
                        <div class="col-12">
                            <div class="alert alert-danger d-none" id="project-errors"></div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="fw-semibold mb-0">Existing gallery</h6>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="project-reorder">Save order</button>
                            </div>
                            <div id="project-gallery-preview" class="row g-2"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save project</button>
                </div>
            </form>
        </div>
    </div>
</div>
