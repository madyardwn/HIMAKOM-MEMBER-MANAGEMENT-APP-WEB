<div class="modal fade" id="modal-edit-roles" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit {{ ucwords($activeSubMenu) }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="form-edit-roles">
                    <input type="hidden" name="edit_id" id="edit-id">
                    <div class="mb-3">
                        <label class="form-label" for="edit-name">Name</label>
                        <input type="text" name="edit_name" id="edit-name" class="form-control" placeholder="Enter name" autocomplete="off" required>                        
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label" for="edit-permissions">Permissions</label>
                                <select name="edit_permissions" id="edit-permissions" multiple>                                    
                                </select>
                            </div>
                        </div>
                    </div>   
                </form>
            </div>
            <div class="modal-footer">
                <Button type="button" class="btn" data-bs-dismiss="modal">Cancel</Button>
                <button type="button" class="btn btn-primary ms-auto" id="submit-edit-role">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4"></path>
                        <path d="M13.5 6.5l4 4"></path>
                    </svg>
                    Edit {{ ucwords($activeSubMenu) }}
                </button>
            </div>
        </div>
    </div>
</div>
