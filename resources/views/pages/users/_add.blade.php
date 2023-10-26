<div class="modal fade" id="modal-add-users" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add {{ ucwords($activeSubMenu) }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="form-add-users">
                    <div class="row">
                        <div class="col-md-5">
                            <label class="form-label" for="add-picture">Picture</label>
                            <div class="mb-3">
                                <img src="{{ asset(config('tablar.default.preview.path')) }}" id="preview-add-picture" class="img-thumbnail" width="265" height="300" alt="{{ config('tablar.default.preview.name') }}">
                            </div>
                            <input type="file" name="picture" id="add-picture" class="form-control" placeholder="Enter picture" autocomplete="off" required>
                        </div>
                        <div class="col-md-7">
                            <div class="mb-3">
                                <label class="form-label" for="add-name">Name</label>
                                <input type="text" name="name" id="add-name" class="form-control" placeholder="Enter name" autocomplete="off" required>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label" for="add-gender">Gender</label>
                                    <select name="gender" id="add-gender">
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-email">Email</label>
                                <input type="email" name="email" id="add-email" class="form-control" placeholder="Enter email" autocomplete="off" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-nim">NIM</label>
                                <input type="text" name="nim" id="add-nim" class="form-control" placeholder="Enter NIM" autocomplete="off" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-npa">NPA</label>
                                <input type="text" name="npa" id="add-npa" class="form-control" placeholder="Enter NPA" autocomplete="off" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-name_bagus">Name Bagus</label>
                                <input type="text" name="name_bagus" id="add-name_bagus" class="form-control" placeholder="Enter Nama Bagus" autocomplete="off" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-year">Year</label>
                                <input type="text" name="year" id="add-year" class="form-control" placeholder="Enter year" autocomplete="off" required>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="input-group input-group-flat">
                                            <input type="password" name="password" id="add-password" class="type-password form-control" placeholder="Password" autocomplete="off">
                                            <span class="input-group-text">
                                                <a href="#" class="link-secondary" data-bs-toggle="tooltip"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <circle cx="12" cy="12" r="2" />
                                                        <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" />
                                                    </svg>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Confirm Password</label>
                                        <div class="input-group input-group-flat">
                                            <input type="password" name="password_confirmation" id="add-password_confirmation" class="type-password form-control" placeholder="Password" autocomplete="off">
                                            <span class="input-group-text">
                                                <a href="#" class="link-secondary" data-bs-toggle="tooltip"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <circle cx="12" cy="12" r="2" />
                                                        <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" />
                                                    </svg>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label" for="add-cabinets">Cabinet</label>
                                    <select name="cabinets" id="add-cabinets" multiple>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label" for="add-departments">Department</label>
                                    <select name="departments" id="add-departments" multiple>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label" for="add-roles">Role</label>
                                    <select name="roles" id="add-roles" multiple>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary ms-auto" id="submit-add-users">
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
