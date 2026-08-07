<div
    class="modal fade"
    id="staffViewModal"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">


            {{-- Header --}}
            <div class="modal-header">

                <h5 class="modal-title">

                    Admin Details

                </h5>


                <button

                    type="button"

                    class="btn-close"

                    data-bs-dismiss="modal">

                </button>

            </div>


            {{-- Body --}}
            <div class="modal-body p-0">


                {{-- Profile Header --}}
                

                <div class="teacher-profile-header text-center py-4">

                    <img
                        id="viewProfileImage"
                        src="{{ asset('assets/uploads/profile/default-avatar.jpg') }}"
                        alt="Profile Image"
                        class="rounded-circle border border-3 border-white shadow-sm"
                        width="100"
                        height="100"
                        style="object-fit: cover;">

                    <h4
                        id="viewStaffName"
                        class="mt-3 mb-1 fw-semibold">

                        -

                    </h4>

                    <div
                        id="viewEmployeeId"
                        class="text-muted">

                        Employee ID: -

                    </div>

                    <div
                        id="viewStaffStatus"
                        class="mt-2">

                        -

                    </div>

                </div>

                <div class="p-4">

                    {{-- User Information --}}
                    <div class="card border-0 bg-light mb-3">

                        <div class="card-body">

                            <h6 class="mb-3">

                                <i
                                    class="bi bi-person me-2">

                                </i>

                                Personal Information

                            </h6>


                            <div class="row g-3">


                                <div class="col-md-6">

                                    <small
                                        class="text-muted">

                                        Email

                                    </small>


                                    <div
                                        id="viewStaffEmail"
                                        class="fw-semibold">

                                        -

                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <small
                                        class="text-muted">

                                        Mobile

                                    </small>


                                    <div
                                        id="viewStaffMobile"
                                        class="fw-semibold">

                                        -

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- Employment Information --}}
                    <div class="card border-0 bg-light">

                        <div class="card-body">

                            <h6 class="mb-3">

                                <i
                                    class="bi bi-briefcase me-2">

                                </i>

                                Employment Information

                            </h6>


                            <div class="row g-3">


                                <div class="col-md-6">

                                    <small
                                        class="text-muted">

                                        Employee ID

                                    </small>


                                    <div
                                        id="viewStaffEmployeeId"
                                        class="fw-semibold">

                                        -

                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <small
                                        class="text-muted">

                                        Designation

                                    </small>


                                    <div
                                        id="viewStaffDesignation"
                                        class="fw-semibold">

                                        -

                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <small
                                        class="text-muted">

                                        Department

                                    </small>


                                    <div
                                        id="viewStaffDepartment"
                                        class="fw-semibold">

                                        -

                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <small
                                        class="text-muted">

                                        Joining Date

                                    </small>


                                    <div
                                        id="viewStaffJoiningDate"
                                        class="fw-semibold">

                                        -

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>


            {{-- Footer --}}
            <div class="modal-footer">

                <button

                    type="button"

                    class="btn btn-secondary"

                    data-bs-dismiss="modal">

                    Close

                </button>

            </div>

        </div>

    </div>

</div>