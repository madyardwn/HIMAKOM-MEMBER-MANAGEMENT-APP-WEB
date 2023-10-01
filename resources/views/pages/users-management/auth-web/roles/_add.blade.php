<div class="modal modal-blur fade" id="modal-add-roles" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add {{ ucwords($activeSubMenu) }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="form-add-roles">
                    <div class="mb-3">
                        <label class="form-label" for="add-name">Name</label>
                        <input type="text" name="add_name" id="add-name" class="form-control @error('add_name') is-invalid @enderror" placeholder="Enter name" autocomplete="off" required>
                        @error('add_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label" for="add-permissions">Permissions</label>
                                <select name="add_permissions" id="add-permissions" @error('add_permissions') is-invalid @enderror multiple>                                    
                                </select>
                                @error('add_permissions')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>   
                </form>
            </div>
            <div class="modal-footer">
                <Button type="button" class="btn" data-bs-dismiss="modal">Cancel</Button>
                <button type="button" class="btn btn-primary ms-auto" id="submit-add-role" data-bs-dismiss="modal">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                         stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Create {{ ucwords($activeSubSubMenu) ?? ucwords($activeSubMenu) }}
                </button>
            </div>
        </div>
    </div>
</div>
