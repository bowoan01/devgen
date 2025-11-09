<div class="d-flex justify-content-end gap-2">
    <button class="btn btn-sm btn-outline-secondary" data-action="edit" data-id="{{ $project->id }}">Edit</button>
    <button class="btn btn-sm btn-outline-info" data-action="gallery" data-id="{{ $project->id }}">Gallery</button>
    <button class="btn btn-sm btn-outline-primary" data-action="feature" data-id="{{ $project->id }}">{{ $project->is_featured ? 'Unfeature' : 'Feature' }}</button>
    @if($project->published_at)
        <button class="btn btn-sm btn-outline-warning" data-action="unpublish" data-id="{{ $project->id }}">Unpublish</button>
    @else
        <button class="btn btn-sm btn-outline-success" data-action="publish" data-id="{{ $project->id }}">Publish</button>
    @endif
    <button class="btn btn-sm btn-outline-danger" data-action="delete" data-id="{{ $project->id }}">Delete</button>
</div>
