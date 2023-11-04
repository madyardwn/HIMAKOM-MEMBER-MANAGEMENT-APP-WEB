<div class="modal fade" id="modal-add-filosofies" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add {{ ucwords($activeSubMenu) }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-add-filosofies">
                    <div class="row">
                        <div class="col-md-5">
                            <label class="form-label" for="add-logo">Logo</label>
                            <div class="mb-3">
                                <img src="{{ asset(config('tablar.default.preview.path')) }}" id="preview-add-logo" class="img-thumbnail" width="265" height="300" alt="{{ config('tablar.default.preview.name') }}">
                            </div>
                            <input type="file" name="logo" id="add-logo" class="form-control" placeholder="Enter logo" autocomplete="off" required>
                        </div>
                        <div class="col-md-7">
                            <div class="mb-3">
                                <label class="form-label" for="add-label">Label</label>
                                <textarea name="label" id="add-label" class="form-control" placeholder="Enter label" autocomplete="off" required></textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="add-cabinet">Cabinet</label>
                                        <select name="cabinet" id="add-cabinet">
                                            <option value="" selected disabled>Select cabinet</option>
                                            @foreach ($cabinets as $cabinet)
                                                <option value="{{ $cabinet->id }}">{{ $cabinet->name }}</option>
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
                <button type="button" class="btn btn-primary ms-auto" id="submit-add-filosofies">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
