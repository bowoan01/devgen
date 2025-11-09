<div class="d-flex justify-content-end gap-2">
    <button class="btn btn-sm btn-outline-secondary" data-action="view" data-id="{{ $message->id }}">View</button>
    <button class="btn btn-sm btn-outline-success" data-action="status" data-status="read" data-id="{{ $message->id }}">Mark read</button>
    <button class="btn btn-sm btn-outline-warning" data-action="status" data-status="archived" data-id="{{ $message->id }}">Archive</button>
    <button class="btn btn-sm btn-outline-danger" data-action="delete" data-id="{{ $message->id }}">Delete</button>
</div>
