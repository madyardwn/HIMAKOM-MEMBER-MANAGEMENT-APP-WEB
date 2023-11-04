<div class="modal fade" id="modal-edit-events" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit {{ ucwords($activeSubMenu) }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-edit-events">
                    <input type="hidden" name="id" id="edit-id-events">
                    <div class="row">
                        <div class="col-md-5">
                            <label class="form-label" for="edit-poster">Poster</label>
                            <div class="mb-3">
                                <img src="{{ asset(config('tablar.default.preview.path')) }}" id="preview-edit-poster" class="img-thumbnail" width="265" height="300" alt="{{ config('tablar.default.preview.name') }}">
                            </div>
                            <input name="poster" type="file" id="edit-poster" class="form-control" placeholder="Enter poster" autocomplete="off" required>
                        </div>
                        <div class="col-md-7">
                            <div class="mb-3">
                                <label class="form-label" for="edit-name">Name</label>
                                <input type="text" name="name" id="edit-name" class="form-control" placeholder="Enter name" autocomplete="off" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="edit-description">Description</label>
                                <textarea name="description" id="edit-description" class="form-control" placeholder="Enter description" autocomplete="off" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="edit-location">Location</label>
                                <input type="text" name="location" id="edit-location" class="form-control" placeholder="Enter location" autocomplete="off" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="edit-date">Date</label>
                                <input type="datetime-local" name="date" id="edit-date" class="form-control" placeholder="Enter date" autocomplete="off" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="edit-link">Link</label>
                                <input type="url" name="link" id="edit-link" class="form-control" placeholder="Enter link" autocomplete="off" required>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="edit-type">type</label>
                                        <select name="type" id="edit-type" required>
                                            <option value="" selected disabled></option>
                                            @foreach ($types as $key => $type)
                                                <option value="{{ $key }}">{{ ucwords($type) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary ms-auto" id="submit-edit-events">
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
