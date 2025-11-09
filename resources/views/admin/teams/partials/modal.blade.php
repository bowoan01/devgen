@php
    $teamPhotoPlaceholder = 'data:image/svg+xml;charset=UTF-8,' . rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" width="400" height="400"><rect width="400" height="400" fill="#f8f9fa"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#adb5bd" font-size="24" font-family="Inter, Arial, sans-serif">No Photo</text></svg>');
@endphp
<div class="modal fade" id="teamModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-light">
                <h5 class="modal-title">Team Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="team-form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Role</label>
                            <input type="text" name="role_title" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">LinkedIn URL</label>
                            <input type="url" name="linkedin_url" class="form-control" placeholder="https://linkedin.com/in/...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Display order</label>
                            <input type="number" name="sort_order" class="form-control" min="0" value="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Portrait</label>
                            <input type="file" name="photo" class="form-control" accept="image/*">
                            <div class="mt-3">
                                <p class="text-muted small mb-2">Current photo</p>
                                <div class="ratio ratio-1x1 border rounded-3 overflow-hidden bg-light" id="team-photo-preview-wrapper">
                                    <a href="{{ $teamPhotoPlaceholder }}" data-preview-link data-placeholder="{{ $teamPhotoPlaceholder }}"
                                        class="d-flex w-100 h-100 align-items-center justify-content-center text-decoration-none disabled">
                                        <img data-preview-image src="{{ $teamPhotoPlaceholder }}" alt="Team photo preview"
                                            class="w-100 h-100 object-fit-cover d-none">
                                        <span data-preview-empty class="text-muted small text-center px-3">No photo uploaded yet.</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Bio</label>
                            <textarea name="bio" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save member</button>
                </div>
            </form>
        </div>
    </div>
</div>
