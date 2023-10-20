<div class="modal fade" id="modal-edit-cabinets" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit {{ ucwords($activeSubMenu) }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="form-edit-cabinets">
                    <input type="hidden" name="id" id="edit-id-cabinets">
                    <div class="mb-3">
                        <label class="form-label" for="edit-name">Name</label>
                        <input type="text" name="name" id="edit-name" class="form-control" placeholder="Enter name"
                            autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="edit-description">Description</label>
                        <textarea name="description" id="edit-description" class="form-control" placeholder="Enter description" autocomplete="off" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="edit-visi">Visi</label>
                        <textarea name="visi" id="edit-visi" class="form-control" placeholder="Enter visi" autocomplete="off" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="edit-misi">Misi</label>
                        <textarea name="misi" id="edit-misi" class="form-control" placeholder="Enter misi" autocomplete="off" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="edit-year">Year</label>
                        <input type="text" name="year" id="edit-year" class="form-control" placeholder="Enter year"
                            autocomplete="off" required>
                    </div>                    
                    <div class="mb-3">
                        <label class="form-label" for="edit-logo">Logo</label>
                        <input name="logo" type="file" id="edit-logo" class="form-control" placeholder="Enter logo"
                            autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <div class="divide-y">
                            <div>
                                <label class="row">
                                    <span class="col">Active</span>
                                    <span class="col-auto">
                                        <label class="form-check form-check-single form-switch">
                                            <input name="is_active" class="form-check-input" type="checkbox" checked="" id="edit-is_active">
                                        </label>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary ms-auto" id="submit-edit-cabinets">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
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
