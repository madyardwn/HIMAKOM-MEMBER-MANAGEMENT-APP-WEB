<div class="modal fade" id="modal-edit-notifications" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit {{ ucwords($activeSubMenu) }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="form-edit-notifications">
                    <div class="row">
                        <div class="col-md-5">
                            <label class="form-label" for="edit-poster">Poster</label>
                            <div class="mb-3">
                                <img src="{{ asset(config('tablar.default.preview.path')) }}" id="preview-edit-poster" class="img-thumbnail" width="265" height="300" alt="{{ config('tablar.default.preview.name') }}">
                            </div>
                            <input type="file" name="poster" id="edit-poster" class="form-control" placeholder="Enter logo" autocomplete="off" required>
                        </div>
                        <div class="col-md-7">
                            <div class="mb-3">
                                <label class="form-label" for="edit-title">Title</label>
                                <input type="text" name="title" id="edit-title" class="form-control" placeholder="Enter title" autocomplete="off" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="edit-body">Body</label>
                                <textarea name="body" id="edit-body" class="form-control" placeholder="Enter body" autocomplete="off" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="edit-link">Link</label>
                                <input type="text" name="link" id="edit-link" class="form-control" placeholder="Enter link" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary ms-auto" id="submit-edit-notifications">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Edit {{ ucwords($activeSubMenu) }}
                </button>
            </div>
        </div>
    </div>
</div>
