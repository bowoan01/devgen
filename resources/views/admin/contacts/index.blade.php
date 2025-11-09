@extends('layouts.admin')

@section('title', 'Contact Messages — Devengour Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-semibold mb-0">Contact messages</h1>
        <p class="text-muted mb-0">Review new leads and conversations.</p>
    </div>
    <a href="{{ route('admin.contacts.export') }}" class="btn btn-outline-primary rounded-pill">Export CSV</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-striped" id="contacts-table" style="width:100%">
            <thead>
                <tr>
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
    window.Devengour = window.Devengour || {};
    window.Devengour.contactsConfig = {
        tableUrl: '{{ route('admin.contacts.index') }}',
        showUrl: function(id){ return '{{ url('admin/contacts') }}/' + id; },
        statusUrl: function(id){ return '{{ url('admin/contacts') }}/' + id + '/status'; },
        deleteUrl: function(id){ return '{{ url('admin/contacts') }}/' + id; }
    };
</script>
@endpush
