<div
    class="modal fade"
    id="staffModal"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">


            {{-- Header --}}
            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="staffModalLabel">

                    Add Admin

                </h5>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">

                </button>

            </div>


            {{-- Form --}}
            <form
                id="staffForm"
                enctype="multipart/form-data">

                @csrf


                <input
                    type="hidden"
                    name="staff_id"
                    id="staff_id">


                <div class="modal-body">

                    <div class="row g-3">


                        {{-- Name --}}
                        <div class="col-md-6">

                            <x-ui.form-input

                                label="Name"

                                name="name"

                                id="name"

                                placeholder="Enter admin name"

                                required />

                        </div>


                        {{-- Email --}}
                        <div class="col-md-6">

                            <x-ui.form-input

                                type="email"

                                label="Email"

                                name="email"

                                id="email"

                                placeholder="Enter email address"

                                required />

                        </div>


                        {{-- Mobile --}}
                        <div class="col-md-6">

                            <x-ui.form-input

                                label="Mobile"

                                name="mobile"

                                id="mobile"

                                placeholder="Enter mobile number" />

                        </div>


                        {{-- Employee ID --}}
                        <div class="col-md-6">

                            <x-ui.form-input

                                label="Employee ID"

                                name="employee_id"

                                id="employee_id"

                                placeholder="Enter employee ID" />

                        </div>


                        {{-- Designation --}}
                        <div class="col-md-6">

                            <x-ui.form-input

                                label="Designation"

                                name="designation"

                                id="designation"

                                placeholder="Enter designation" />

                        </div>


                        {{-- Department --}}
                        <div class="col-md-6">

                            <x-ui.form-input

                                label="Department"

                                name="department"

                                id="department"

                                placeholder="Enter department" />

                        </div>


                        {{-- Joining Date --}}
                        <div class="col-md-6">

                            <x-ui.form-input

                                type="date"

                                label="Joining Date"

                                name="joining_date"

                                id="joining_date" />

                        </div>


                        {{-- Status --}}
                        <div class="col-md-6">

                            <x-ui.select

                                label="Status"

                                name="status"

                                id="status"

                                value="1"

                                :options="[

                                    1 => 'Active',

                                    0 => 'Inactive'

                                ]"

                                required />

                        </div>


                        {{-- Profile Image --}}
                        <div class="col-md-4">

                            <x-ui.form-file
                                label="Profile Image"
                                name="profile_image"
                                id="profile_image"
                                accept="image/*"
                                help="Maximum file size: 2 MB"
                            />

                        </div>

                        <div class="col-md-4">
                            <div class="text-center">
                                <img
                                    id="profilePreview"
                                    src="{{ asset('assets/uploads/profile/default-avatar.jpg') }}"
                                    alt="Profile Preview"
                                    class="rounded-circle img-thumbnail"
                                    width="120"
                                    height="120"
                                    style="object-fit: cover;">
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

                        Cancel

                    </button>


                    <x-ui.button

                        type="submit"

                        id="btnSaveStaff">

                        Save Admin

                    </x-ui.button>


                </div>

            </form>

        </div>

    </div>

</div>