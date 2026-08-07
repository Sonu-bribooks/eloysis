@extends('layouts.admin.master')

@section('title', 'Student Profile')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <x-ui.page-header
        title="Student Profile"
        subtitle="View student details">

        <x-slot:actions>

            <a
                href="{{ route('admin.students.edit', $enrollment->id) }}"
                class="btn btn-warning">

                <i class="bi bi-pencil"></i>

                Edit Student

            </a>


            <a
                href="{{ route('admin.students.index') }}"
                class="btn btn-secondary">

                <i class="bi bi-arrow-left"></i>

                Back

            </a>

        </x-slot:actions>

    </x-ui.page-header>


    <div class="row g-4">

        {{-- LEFT PROFILE CARD --}}
        <div class="col-lg-4">

            <div class="card shadow-sm border-0">

                <div class="card-body text-center">

                    @if($enrollment->student->user->profile_image)

                        <img
                            src="{{ \App\Helpers\UploadHelper::url(
                                $enrollment->student->user->profile_image
                            ) }}"
                            width="120"
                            height="120"
                            class="rounded-circle mb-3"
                            style="object-fit: cover;">

                    @else

                        <div
                            class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3"
                            style="width:120px;height:120px;">

                            <i
                                class="bi bi-person text-secondary"
                                style="font-size:60px;">

                            </i>

                        </div>

                    @endif


                    <h4 class="mb-1">

                        {{ $enrollment->student->user->name }}

                    </h4>


                    <p class="text-muted mb-3">

                        {{ $enrollment->student->admission_no }}

                    </p>


                    @if($enrollment->student->user->status)

                        <span class="badge bg-success">

                            Active

                        </span>

                    @else

                        <span class="badge bg-danger">

                            Inactive

                        </span>

                    @endif

                </div>

            </div>


            {{-- CONTACT --}}
            <div class="card shadow-sm border-0 mt-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0 header-title">

                        <i class="bi bi-person-lines-fill me-2"></i>

                        Contact Information

                    </h5>

                </div>


                <div class="card-body">

                    <div class="mb-3">

                        <small class="text-muted">

                            Email

                        </small>

                        <div>

                            {{ $enrollment->student->user->email ?? '-' }}

                        </div>

                    </div>


                    <div class="mb-3">

                        <small class="text-muted">

                            Mobile

                        </small>

                        <div>

                            {{ $enrollment->student->user->mobile ?? '-' }}

                        </div>

                    </div>


                    <div>

                        <small class="text-muted">

                            Address

                        </small>

                        <div>

                            {{ $enrollment->student->address ?? '-' }}

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- RIGHT CONTENT --}}
        <div class="col-lg-8">


            {{-- ACADEMIC INFORMATION --}}
            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0 header-title">

                        <i class="bi bi-mortarboard me-2"></i>

                        Academic Information

                    </h5>

                </div>


                <div class="card-body">

                    <div class="row g-4">

                        <div class="col-md-4">

                            <small class="text-muted">

                                Admission Number

                            </small>

                            <div class="fw-semibold">

                                {{ $enrollment->student->admission_no }}

                            </div>

                        </div>


                        <div class="col-md-4">

                            <small class="text-muted">

                                Roll Number

                            </small>

                            <div class="fw-semibold">

                                {{ $enrollment->roll_number ?? '-' }}

                            </div>

                        </div>


                        <div class="col-md-4">

                            <small class="text-muted">

                                Admission Date

                            </small>

                            <div class="fw-semibold">

                                {{ $enrollment->student->admission_date
                                    ? $enrollment->student->admission_date
                                    : '-'
                                }}

                            </div>

                        </div>


                        <div class="col-md-4">

                            <small class="text-muted">

                                Academic Session

                            </small>

                            <div class="fw-semibold">

                                {{ $enrollment->academicSession->name ?? '-' }}

                            </div>

                        </div>


                        <div class="col-md-4">

                            <small class="text-muted">

                                Class

                            </small>

                            <div class="fw-semibold">

                                {{ $enrollment->studentClass->class_name ?? '-' }}

                            </div>

                        </div>


                        <div class="col-md-4">

                            <small class="text-muted">

                                Section

                            </small>

                            <div class="fw-semibold">

                                {{ $enrollment->section->name ?? '-' }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- PERSONAL INFORMATION --}}
            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0 header-title">

                        <i class="bi bi-person-vcard me-2"></i>

                        Personal Information

                    </h5>

                </div>


                <div class="card-body">

                    <div class="row g-4">

                        <div class="col-md-4">

                            <small class="text-muted">

                                Date of Birth

                            </small>

                            <div>

                                {{ $enrollment->student->dob
                                    ? $enrollment->student->dob->format('d M Y')
                                    : '-'
                                }}

                            </div>

                        </div>


                        <div class="col-md-4">

                            <small class="text-muted">

                                Gender

                            </small>

                            <div>

                                {{ ucfirst($enrollment->student->gender ?? '-') }}

                            </div>

                        </div>


                        <div class="col-md-4">

                            <small class="text-muted">

                                Blood Group

                            </small>

                            <div>

                                {{ $enrollment->student->blood_group ?? '-' }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- FAMILY INFORMATION --}}
            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0 header-title">

                        <i class="bi bi-people me-2"></i>

                        Family / Guardian Information

                    </h5>

                </div>


                <div class="card-body">

                    <div class="row g-4">

                        <div class="col-md-6">

                            <small class="text-muted">

                                Father Name

                            </small>

                            <div>

                                {{ $enrollment->student->father_name ?? '-' }}

                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">

                                Mother Name

                            </small>

                            <div>

                                {{ $enrollment->student->mother_name ?? '-' }}

                            </div>

                        </div>


                        <div class="col-md-4">

                            <small class="text-muted">

                                Guardian Name

                            </small>

                            <div>

                                {{ $enrollment->student->guardian_name ?? '-' }}

                            </div>

                        </div>


                        <div class="col-md-4">

                            <small class="text-muted">

                                Guardian Mobile

                            </small>

                            <div>

                                {{ $enrollment->student->guardian_mobile ?? '-' }}

                            </div>

                        </div>


                        <div class="col-md-4">

                            <small class="text-muted">

                                Guardian Email

                            </small>

                            <div>

                                {{ $enrollment->student->guardian_email ?? '-' }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ADDRESS --}}
            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">

                    <h5 class="mb-0 header-title">

                        <i class="bi bi-geo-alt me-2"></i>

                        Address Information

                    </h5>

                </div>


                <div class="card-body">

                    <div class="row g-4">

                        <div class="col-md-4">

                            <small class="text-muted">

                                City

                            </small>

                            <div>

                                {{ $enrollment->student->city ?? '-' }}

                            </div>

                        </div>


                        <div class="col-md-4">

                            <small class="text-muted">

                                State

                            </small>

                            <div>

                                {{ $enrollment->student->state ?? '-' }}

                            </div>

                        </div>


                        <div class="col-md-4">

                            <small class="text-muted">

                                Pincode

                            </small>

                            <div>

                                {{ $enrollment->student->pincode ?? '-' }}

                            </div>

                        </div>


                        <div class="col-md-12">

                            <small class="text-muted">

                                Full Address

                            </small>

                            <div>

                                {{ $enrollment->student->address ?? '-' }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection