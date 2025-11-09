@extends('layouts.admin')

@section('title', 'Services — Devengour Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-semibold mb-0">Services</h1>
        <p class="text-muted mb-0">Manage the offerings displayed on the public site.</p>
    </div>
    <button class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#service-modal" data-action="create">Add service</button>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-striped" id="services-table" style="width:100%">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Featured</th>
                    <th>Updated</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@include('admin.services.partials.modal')
@endsection

@push('scripts')
<script>
    window.Devengour = window.Devengour || {};
    window.Devengour.servicesConfig = {
        tableUrl: '{{ route('admin.services.index') }}',
        storeUrl: '{{ route('admin.services.store') }}',
        updateUrl: function(id){ return '{{ url('admin/services') }}/' + id; },
        showUrl: function(id){ return '{{ url('admin/services') }}/' + id; },
        deleteUrl: function(id){ return '{{ url('admin/services') }}/' + id; },
    };
</script>
@endpush
