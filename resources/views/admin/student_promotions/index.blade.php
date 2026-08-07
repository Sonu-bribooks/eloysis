@extends('layouts.admin.master')

@section('title', 'Student Promotion')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <x-ui.page-header
        title="Student Promotion"
        subtitle="Promote students to next academic session">
    </x-ui.page-header>


    {{-- Current Session Filters --}}
    <x-ui.table.filters id="filterForm">

        <div class="col-md-3">

            <x-ui.select
                label="Current Session"
                name="academic_session_id"
                id="academic_session_id"
                :options="$academicSessions"
                required />

        </div>

        <div class="col-md-3">

            <x-ui.select
                label="Current Class"
                name="class_id"
                id="class_id"
                :options="$classes"
                data-section-target="#section_id"
                required />

        </div>

        <div class="col-md-3">

            <x-ui.select
                label="Current Section"
                name="section_id"
                id="section_id"
                :options="$sections" />

        </div>

        <div class="col-md-3 d-flex align-items-end">

            <x-ui.button
                id="btnLoadStudents"
                type="submit"
                block>

                Load Students

            </x-ui.button>

        </div>

    </x-ui.table.filters>


    <div class="row mt-4">

        {{-- Student List --}}
        <div class="col-lg-8">

            <x-ui.card>

                <x-slot:header>

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <strong>

                                Students

                            </strong>

                        </div>

                        <div>

                            <div class="form-check">

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="selectAll">

                                <label
                                    class="form-check-label">

                                    Select All

                                </label>

                            </div>

                        </div>

                    </div>

                </x-slot:header>

                <x-ui.datatable id="promotionTable">

                    <x-ui.table.thead>

                        <x-ui.table.col width="50">

                        </x-ui.table.col>

                        <x-ui.table.col width="70">

                            Photo

                        </x-ui.table.col>

                        <x-ui.table.col>

                            Student

                        </x-ui.table.col>

                        <x-ui.table.col>

                            Current Session

                        </x-ui.table.col>

                        <x-ui.table.col>

                            Admission No

                        </x-ui.table.col>

                        <x-ui.table.col>

                            Roll No

                        </x-ui.table.col>

                        <x-ui.table.col>

                            Class

                        </x-ui.table.col>

                        <x-ui.table.col>

                            Section

                        </x-ui.table.col>

                    </x-ui.table.thead>

                    <x-ui.table.tbody
                        id="studentTableBody">

                    </x-ui.table.tbody>

                </x-ui.datatable>

            </x-ui.card>

        </div>


        {{-- Promotion Panel --}}
        <div class="col-lg-4">

            <x-ui.card>

                <x-slot:header>

                    <strong>

                        Promotion Details

                    </strong>

                </x-slot:header>

                <form id="promotionForm">

                    @csrf

                    <div class="row g-3">

                        <div class="col-md-12">

                            <x-ui.select
                                label="Target Session"
                                name="target_academic_session_id"
                                id="target_academic_session_id"
                                :options="$academicSessions"
                                required />

                        </div>


                        <div class="col-md-12">

                            <x-ui.select
                                label="Target Class"
                                name="target_class_id"
                                id="target_class_id"
                                :options="$classes"
                                data-section-target="#target_section_id"
                                required />

                        </div>


                        <div class="col-md-12">

                            <x-ui.select
                                label="Target Section"
                                name="target_section_id"
                                id="target_section_id"
                                :options="$sections" />

                        </div>


                        <div class="col-md-12">

                            <x-ui.button
                                id="btnPromote"
                                type="submit"
                                block>

                                Promote Selected Students

                            </x-ui.button>

                        </div>

                    </div>

                </form>

            </x-ui.card>

        </div>

    </div>

</div>

@include('admin.student_promotions.partials.summary-modal')

@endsection


@push('scripts')

<script>

const STUDENT_LOAD_URL = "{{ route('admin.student-promotions.students') }}";

const STUDENT_PROMOTE_URL = "{{ route('admin.student-promotions.promote') }}";

</script>

<script src="{{ asset('assets/admin/js/studentPromotions.js') }}"></script>

@endpush