@extends('layouts.admin.master')

@section('title', 'Add Student')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <x-ui.page-header
        title="Add Student"
        subtitle="Create a new student profile">

        <x-slot:actions>

            <a
                href="{{ route('admin.students.index') }}"
                class="btn btn-secondary">

                <i class="bi bi-arrow-left"></i>

                Back

            </a>

        </x-slot:actions>

    </x-ui.page-header>


    <form
        id="studentForm"
        method="POST"
        action="{{ route('admin.students.store') }}"
        enctype="multipart/form-data">

        @csrf


        @include('admin.students.partials.form')


        <div class="d-flex justify-content-end gap-2 mt-4">

            <a
                href="{{ route('admin.students.index') }}"
                class="btn btn-secondary">

                Cancel

            </a>


            <x-ui.button
                type="submit"
                id="btnSaveStudent">

                <i class="bi bi-check-lg"></i>

                Save Student

            </x-ui.button>

        </div>

    </form>

</div>

@endsection


@push('scripts')


<script src="{{ asset('assets/admin/js/students.js') }}"></script>

@endpush