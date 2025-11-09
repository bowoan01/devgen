<div class="modal fade" id="contactModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-light">
                <h5 class="modal-title">Message detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3">Name</dt>
                    <dd class="col-sm-9" data-field="name"></dd>
                    <dt class="col-sm-3">Email</dt>
                    <dd class="col-sm-9" data-field="email"></dd>
                    <dt class="col-sm-3">Company</dt>
                    <dd class="col-sm-9" data-field="company"></dd>
                    <dt class="col-sm-3">Phone</dt>
                    <dd class="col-sm-9" data-field="phone"></dd>
                    <dt class="col-sm-3">Message</dt>
                    <dd class="col-sm-9" data-field="message" class="whitespace-pre-wrap"></dd>
                </dl>
            </div>
            <div class="modal-footer bg-light">
                <div class="me-auto">
                    <div class="btn-group" role="group">
                        <button class="btn btn-outline-secondary" data-action="status" data-status="new">Mark new</button>
                        <button class="btn btn-outline-success" data-action="status" data-status="read">Mark read</button>
                        <button class="btn btn-outline-warning" data-action="status" data-status="archived">Archive</button>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-danger" data-action="delete">Delete</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
