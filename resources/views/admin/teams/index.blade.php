@extends('layouts.admin')

@section('page_title', 'Team')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 fw-semibold mb-1">Core Team</h2>
        <p class="text-muted mb-0">Tell the story of the experts behind Devengour.</p>
    </div>
    <button class="btn btn-primary rounded-3" data-bs-toggle="modal" data-bs-target="#teamModal" data-mode="create">Add member</button>
</div>
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
        <table class="table table-hover align-middle" id="team-table">
            <thead>
                <tr>
                    <th width="40">#</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>LinkedIn</th>
                    <th>Order</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@include('admin.teams.partials.modal')
@endsection

@push('scripts')
<script>
    window.AdminTeam = {
        table: '#team-table',
        endpoints: {
            list: '{{ url('/admin/teams/data') }}',
            store: '{{ url('/admin/teams') }}',
            update: id => `/admin/teams/${id}`,
            show: id => `/admin/teams/${id}`,
            delete: id => `/admin/teams/${id}`,
            reorder: '{{ url('/admin/teams/reorder') }}'
        }
    };
</script>
@endpush
