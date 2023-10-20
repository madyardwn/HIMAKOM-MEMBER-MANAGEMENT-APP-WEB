<div class="modal fade" id="modal-add-cabinets" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add {{ ucwords($activeSubMenu) }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="form-add-cabinets">
                    <div class="mb-3">
                        <label class="form-label" for="add-name">Name</label>
                        <input type="text" name="name" id="add-name" class="form-control" placeholder="Enter name" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-description">Description</label>
                        <textarea name="description" id="add-description" class="form-control" placeholder="Enter description" autocomplete="off" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-visi">Visi</label>
                        <textarea name="visi" id="add-visi" class="form-control" placeholder="Enter visi" autocomplete="off" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-misi">Misi</label>
                        <textarea name="misi" id="add-misi" class="form-control" placeholder="Enter misi" autocomplete="off" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-year">Year</label>
                        <input type="text" name="year" id="add-year" class="form-control" placeholder="Enter year" autocomplete="off" required>
                    </div>                    
                    <div class="mb-3">
                        <label class="form-label" for="add-logo">Logo</label>
                        {{-- Preview : Image, Input have same category (logo) --}}
                        <img src="{{ asset(config('tablar.custom.preview.path')) }}" id="preview-add-logo" class="img-thumbnail" width="265" height="300" alt="{{ config('tablar.custom.preview.name') }}">
                        <input type="file" name="logo" id="add-logo" class="form-control" placeholder="Enter logo" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <div class="divide-y">
                            <div>
                                <label class="row">
                                    <span class="col">Active</span>
                                    <span class="col-auto">
                                        <label class="form-check form-check-single form-switch">
                                            <input type="checkbox" name="is_active" class="form-check-input" checked="" id="add-is_active">
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
                <button type="button" class="btn btn-primary ms-auto" id="submit-add-cabinets">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Add {{ ucwords($activeSubMenu) }}
                </button>
            </div>
        </div>
    </div>
</div>
