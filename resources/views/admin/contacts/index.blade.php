@extends('layouts.admin')

@section('page_title', 'Contact Messages')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 fw-semibold mb-1">Inbox</h2>
        <p class="text-muted mb-0">Stay close to every conversation from clients and partners.</p>
    </div>
    <a href="{{ url('/admin/contacts/export') }}" class="btn btn-outline-primary rounded-3">Export CSV</a>
</div>
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
        <table class="table table-hover align-middle" id="contacts-table">
            <thead>
                <tr>
                    <th width="40">#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Company</th>
                    <th>Status</th>
                    <th>Received</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@include('admin.contacts.partials.modal')
@endsection

@push('scripts')
<script>
    window.AdminContacts = {
        table: '#contacts-table',
        endpoints: {
            list: '{{ url('/admin/contacts/data') }}',
            show: id => `/admin/contacts/${id}`,
            updateStatus: id => `/admin/contacts/${id}/status`,
            delete: id => `/admin/contacts/${id}`
        }
    };
</script>
@endpush
