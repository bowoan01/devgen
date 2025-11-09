@extends('layouts.admin')

@section('title', 'Projects — Devengour Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-semibold mb-0">Projects</h1>
        <p class="text-muted mb-0">Curate the portfolio showcased on the public site.</p>
    </div>
    <button class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#project-modal" data-action="create">Add project</button>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-striped" id="projects-table" style="width:100%">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Featured</th>
                    <th>Published</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@include('admin.projects.partials.modal')
@endsection

@push('scripts')
<script>
    window.Devengour = window.Devengour || {};
    window.Devengour.projectsConfig = {
        tableUrl: '{{ route('admin.projects.index') }}',
        storeUrl: '{{ route('admin.projects.store') }}',
        showUrl: function(id){ return '{{ url('admin/projects') }}/' + id; },
        updateUrl: function(id){ return '{{ url('admin/projects') }}/' + id; },
        deleteUrl: function(id){ return '{{ url('admin/projects') }}/' + id; },
        reorderUrl: function(id){ return '{{ url('admin/projects') }}/' + id + '/images/reorder'; },
        deleteImageUrl: function(imageId){ return '{{ url('admin/project-images') }}/' + imageId; }
    };
</script>
@endpush
