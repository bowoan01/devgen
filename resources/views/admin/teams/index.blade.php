@extends('layouts.admin')

@section('title', 'Team — Devengour Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-semibold mb-0">Team</h1>
        <p class="text-muted mb-0">Keep the About page team section fresh.</p>
    </div>
    <button class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#team-modal" data-action="create">Add member</button>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-striped" id="team-table" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Role</th>
                    <th>LinkedIn</th>
                    <th>Updated</th>
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
    window.Devengour = window.Devengour || {};
    window.Devengour.teamConfig = {
        tableUrl: '{{ route('admin.teams.index') }}',
        storeUrl: '{{ route('admin.teams.store') }}',
        showUrl: function(id){ return '{{ url('admin/team') }}/' + id; },
        updateUrl: function(id){ return '{{ url('admin/team') }}/' + id; },
        deleteUrl: function(id){ return '{{ url('admin/team') }}/' + id; }
    };
</script>
@endpush
