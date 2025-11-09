<div class="modal fade" id="projectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-light border-0 pb-0">
                <div>
                    <p class="text-uppercase text-muted fw-semibold small mb-1">Projects</p>
                    <h5 class="modal-title fw-semibold" data-modal-title>New project</h5>
                    <p class="text-muted mb-0 small">Complete the details below to keep the portfolio fresh and on-brand.
                    </p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="project-form" class="needs-validation d-flex flex-column h-100" novalidate>
                @csrf
                <div class="modal-body pt-4 pb-5 flex-grow-1 overflow-auto">
                    <div class="mb-4">
                        <h6 class="text-uppercase text-muted fs-6 mb-3">Overview</h6>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Title<span
                                        class="text-danger ms-1">*</span></label>
                                <input type="text" name="title" class="form-control form-control-lg rounded-3"
                                    required placeholder="e.g. Healthcare Analytics Platform">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Slug</label>
                                <input type="text" name="slug" class="form-control form-control-lg rounded-3"
                                    placeholder="Leave blank to auto-generate">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Category<span
                                        class="text-danger ms-1">*</span></label>
                                <select name="category" class="form-select form-select-lg rounded-3" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category }}">{{ ucfirst($category) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Published at</label>
                                <input type="date" name="published_at"
                                    class="form-control form-control-lg rounded-3">
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_featured" value="0">
                                    <input class="form-check-input" type="checkbox" name="is_featured"
                                        id="project-featured" value="1">
                                    <label class="form-check-label" for="project-featured">Mark as featured</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h6 class="text-uppercase text-muted fs-6 mb-3">Narrative</h6>
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Summary<span
                                        class="text-danger ms-1">*</span></label>
                                <textarea name="summary" class="form-control rounded-3" rows="3" required
                                    placeholder="Short description that sells the win."></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Problem</label>
                                <textarea name="problem_text" class="form-control rounded-3" rows="4"
                                    placeholder="What challenge were we solving?"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Solution</label>
                                <textarea name="solution_text" class="form-control rounded-3" rows="4"
                                    placeholder="Summarize the solution approach."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <h6 class="text-uppercase text-muted fs-6 mb-3">Proof points</h6>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tech stack</label>
                                <input type="text" name="tech_stack" class="form-control rounded-3"
                                    placeholder="Laravel, Flutter, Figma">
                                <div class="form-text">Use commas to separate technologies.</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Testimonial author</label>
                                <input type="text" name="testimonial_author" class="form-control rounded-3"
                                    placeholder="Jane Doe, VP Product">
                            </div>
                            <div class="col-md-9">
                                <label class="form-label fw-semibold">Testimonial</label>
                                <textarea name="testimonial_text" class="form-control rounded-3" rows="3"
                                    placeholder="Quote that captures the impact."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 justify-content-between mt-auto">
                    <button type="button" class="btn btn-outline-secondary px-4"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4" data-action="submit-project-form">
                        <span data-submit-label>Save project</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
