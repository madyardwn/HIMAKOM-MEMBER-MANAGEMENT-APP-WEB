<div class="modal fade" id="modal-import-users" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import {{ ucwords($activeSubMenu) }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-import-users">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-label" for="import-users">Users</label>
                            <input type="file" name="users" id="import-users" class="form-control" placeholder="Import User File" autocomplete="off" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal" data-bs-target="#modal-import-users">Close</button>
                <button type="button" class="btn btn-primary ms-auto" id="submit-import-users">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Import {{ ucwords($activeSubMenu) }}
                </button>
            </div>
        </div>
    </div>
</div>
