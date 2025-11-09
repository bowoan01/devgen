@extends('layouts.admin')

@section('page_title', 'Services')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 fw-semibold mb-1">Services Catalogue</h2>
        <p class="text-muted mb-0">Craft clear offerings that headline the Devengour experience.</p>
    </div>
    <button class="btn btn-primary rounded-3" data-bs-toggle="modal" data-bs-target="#serviceModal" data-mode="create">Add service</button>
</div>
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
        <table class="table table-hover align-middle" id="services-table">
            <thead>
                <tr>
                    <th width="40">#</th>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Featured</th>
                    <th>Order</th>
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
    window.AdminServices = {
        table: '#services-table',
        endpoints: {
            list: '{{ url('/admin/services/data') }}',
            store: '{{ url('/admin/services') }}',
            update: id => `/admin/services/${id}`,
            show: id => `/admin/services/${id}`,
            delete: id => `/admin/services/${id}`,
            reorder: '{{ url('/admin/services/reorder') }}'
        }
    };
</script>
@endpush
