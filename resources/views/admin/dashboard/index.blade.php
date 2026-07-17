@extends('layouts.admin.master')

@section('title','Dashboard')

@section('content')

<div class="row g-4">

    {{-- Welcome Card --}}
    <div class="col-12">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <h3>

                    Welcome Back,

                    {{ auth('admin')->user()->name }} 👋

                </h3>

                <p class="text-muted mb-0">

                    {{ now()->format('l, d F Y') }}

                </p>

            </div>

        </div>

    </div>

</div>

<div class="row mt-4 g-4">

    @include('admin.dashboard.partials.statistics')

</div>

<div class="row mt-4 g-4">

    <div class="col-lg-6">

        @include('admin.dashboard.partials.latest-admissions')

    </div>

    <div class="col-lg-6">

        @include('admin.dashboard.partials.upcoming-exams')

    </div>

</div>

<div class="row mt-4 g-4">

    <div class="col-lg-6">

        @include('admin.dashboard.partials.activities')

    </div>

    <div class="col-lg-6">

        @include('admin.dashboard.partials.quick-actions')

    </div>

</div>

@endsection