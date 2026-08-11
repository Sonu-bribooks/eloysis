<div
    class="modal fade"
    id="teacherViewModal"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content">

            {{-- Modal Header --}}

            <div class="modal-header">

                <h5 class="modal-title">

                    Teacher Details

                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">

                </button>

            </div>


            {{-- Modal Body --}}

            <div class="modal-body p-0">

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
                        id="viewName"
                        class="mt-3 mb-1 fw-semibold">

                        -

                    </h4>

                    <div
                        id="viewEmployeeId"
                        class="text-muted">

                        Employee ID: -

                    </div>

                    <div
                        id="viewStatus"
                        class="mt-2">

                        -

                    </div>

                </div>


                <div class="p-4">

                    {{-- Contact Information --}}

                    <div class="detail-section">

                        <h6 class="detail-section-title">

                            <i class="bi bi-person-lines-fill me-2"></i>

                            Contact Information

                        </h6>

                        <div class="row g-4">

                            <div class="col-md-6">

                                <x-ui.detail-item
                                    label="Email"
                                    id="viewEmail"
                                    icon="bi-envelope"/>

                            </div>

                            <div class="col-md-6">

                                <x-ui.detail-item
                                    label="Mobile"
                                    id="viewMobile"
                                    icon="bi-phone"/>

                            </div>

                        </div>

                    </div>


                    {{-- Professional Information --}}

                    <div class="detail-section mt-4">

                        <h6 class="detail-section-title">

                            <i class="bi bi-briefcase-fill me-2"></i>

                            Professional Information

                        </h6>

                        <div class="row g-4">

                            <div class="col-md-6">

                                <x-ui.detail-item
                                    label="Qualification"
                                    id="viewQualification"/>

                            </div>

                            <div class="col-md-6">

                                <x-ui.detail-item
                                    label="Specialization"
                                    id="viewSpecialization"/>

                            </div>

                            <div class="col-md-4">

                                <x-ui.detail-item
                                    label="Experience"
                                    id="viewExperience"/>

                            </div>

                        </div>

                    </div>


                    {{-- Personal Information --}}

                    <div class="detail-section mt-4">

                        <h6 class="detail-section-title">

                            <i class="bi bi-person-fill me-2"></i>

                            Personal Information

                        </h6>

                        <div class="row g-4">

                            <div class="col-md-4">

                                <x-ui.detail-item
                                    label="Gender"
                                    id="viewGender"/>

                            </div>

                            <div class="col-md-4">

                                <x-ui.detail-item
                                    label="Date of Birth"
                                    id="viewDob"/>

                            </div>

                            <div class="col-md-4">

                                <x-ui.detail-item
                                    label="Joining Date"
                                    id="viewJoiningDate"/>

                            </div>

                        </div>

                    </div>


                    {{-- Address --}}

                    <div class="detail-section mt-4">

                        <h6 class="detail-section-title">

                            <i class="bi bi-geo-alt-fill me-2"></i>

                            Address Information

                        </h6>

                        <div class="row g-4">

                            <div class="col-md-4">

                                <x-ui.detail-item
                                    label="City"
                                    id="viewCity"/>

                            </div>

                            <div class="col-md-4">

                                <x-ui.detail-item
                                    label="State"
                                    id="viewState"/>

                            </div>

                            <div class="col-md-4">

                                <x-ui.detail-item
                                    label="Pincode"
                                    id="viewPincode"/>

                            </div>

                            <div class="col-md-12">

                                <x-ui.detail-item
                                    label="Address"
                                    id="viewAddress"/>

                            </div>

                        </div>

                    </div>


                    {{-- Emergency Contact --}}

                    <div class="detail-section mt-4">

                        <h6 class="detail-section-title">

                            <i class="bi bi-telephone-forward-fill me-2"></i>

                            Emergency Contact

                        </h6>

                        <div class="row g-4">

                            <div class="col-md-6">

                                <x-ui.detail-item
                                    label="Contact Name"
                                    id="viewEmergencyContactName"/>

                            </div>

                            <div class="col-md-6">

                                <x-ui.detail-item
                                    label="Contact Mobile"
                                    id="viewEmergencyContactMobile"/>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Modal Footer --}}

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