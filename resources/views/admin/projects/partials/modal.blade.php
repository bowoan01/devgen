<div class="modal fade" id="projectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-light">
                <h5 class="modal-title">Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="project-form">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Slug</label>
                            <input type="text" name="slug" class="form-control" placeholder="leave blank to auto-generate">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}">{{ ucfirst($category) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Published at</label>
                            <input type="date" name="published_at" class="form-control">
                        </div>
                        <div class="col-md-4 d-flex align-items-center pt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_featured" id="project-featured">
                                <label class="form-check-label" for="project-featured">Featured</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Summary</label>
                            <textarea name="summary" class="form-control" rows="2" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Problem</label>
                            <textarea name="problem_text" class="form-control" rows="4"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Solution</label>
                            <textarea name="solution_text" class="form-control" rows="4"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tech stack (comma separated)</label>
                            <input type="text" name="tech_stack" class="form-control" placeholder="Laravel, Flutter, Figma">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Testimonial author</label>
                            <input type="text" name="testimonial_author" class="form-control">
                        </div>
                        <div class="col-md-9">
                            <label class="form-label">Testimonial</label>
                            <textarea name="testimonial_text" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save project</button>
                </div>
            </form>
        </div>
    </div>
</div>
