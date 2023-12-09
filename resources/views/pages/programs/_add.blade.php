<div class="modal fade" id="modal-add-programs" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add {{ ucwords($activeSubMenu) }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-add-programs">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label" for="add-name">Name</label>
                                <input type="text" name="name" id="add-name" class="form-control" placeholder="Enter name" autocomplete="off" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-description">Description</label>
                                <textarea name="description" id="add-description" class="form-control" placeholder="Enter description" autocomplete="off" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-end_at">End At</label>
                                <input type="datetime-local" name="end_at" id="add-end_at" class="form-control" placeholder="Enter End At" autocomplete="off" required>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="add-department">Department</label>
                                        <select name="department" id="add-department">
                                            <option value="" selected disabled></option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="add-cabinet">Cabinet</label>
                                        <select name="cabinet" id="add-cabinet">
                                            <option value="" selected disabled></option>
                                            @foreach ($cabinets as $cabinet)
                                                <option value="{{ $cabinet->id }}">{{ $cabinet->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="add-lead">Lead</label>
                                        <select name="lead" id="add-lead">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="add-participants">Participants</label>
                                        <select name="participants[]" id="add-participants" multiple>
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
                <button type="button" class="btn btn-primary ms-auto" id="submit-add-programs">
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
