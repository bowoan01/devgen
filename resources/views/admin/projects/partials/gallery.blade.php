<div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-light">
                <h5 class="modal-title">Project Gallery</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="gallery-upload" class="border border-dashed rounded-4 p-4 text-center mb-4">
                    @csrf
                    <input type="hidden" name="project_id" id="gallery-project-id">
                    <p class="mb-3">Upload high-resolution visuals to elevate the case study.</p>
                    <input type="file" name="image" class="form-control" accept="image/*" required>
                    <input type="text" name="caption" class="form-control mt-3" placeholder="Caption (optional)">
                    <button class="btn btn-primary mt-3" type="submit">Upload</button>
                </form>
                <p class="text-muted small mb-3">Drag &amp; drop images to reorder the gallery. Changes are saved automatically.</p>
                <div id="gallery-grid" class="row g-3"></div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Done</button>
            </div>
        </div>
    </div>
</div>
