@extends('layouts.admin')

@section('page_title', 'Projects')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 fw-semibold mb-1">Portfolio Projects</h2>
        <p class="text-muted mb-0">Celebrate product victories with compelling case studies and galleries.</p>
    </div>
    <button class="btn btn-primary rounded-3" data-bs-toggle="modal" data-bs-target="#projectModal" data-mode="create">New project</button>
</div>
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
        <table class="table table-hover align-middle" id="projects-table">
            <thead>
                <tr>
                    <th width="40">#</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Featured</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@include('admin.projects.partials.modal')
@include('admin.projects.partials.gallery')
@endsection

@push('scripts')
<script>
    window.AdminProjects = {
        categories: @json($categories),
        table: '#projects-table',
        endpoints: {
            list: '{{ url('/admin/projects/data') }}',
            store: '{{ url('/admin/projects') }}',
            update: id => `/admin/projects/${id}`,
            show: id => `/admin/projects/${id}`,
            delete: id => `/admin/projects/${id}`,
            toggleFeatured: id => `/admin/projects/${id}/toggle-featured`,
            publish: id => `/admin/projects/${id}/publish`,
            unpublish: id => `/admin/projects/${id}/unpublish`,
            uploadImage: id => `/admin/projects/${id}/images`,
            deleteImage: (projectId, imageId) => `/admin/projects/${projectId}/images/${imageId}`,
            reorderImages: id => `/admin/projects/${id}/images/reorder`
        }
    };
</script>
@endpush
