@extends('layouts.admin.master')

@section('title', 'Log')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="card border-0 mb-4">
        <div class="card-body">

            <div class="d-flex align-items-center gap-3 mb-4">

                <i class="bi bi-command fs-3 text-secondary"></i>

                <h4 class="mb-0">
                    Log
                </h4>

            </div>

            <div class="row g-3 align-items-end">

                {{-- File --}}
                <div class="col-md-4">

                    <label class="form-label">
                        Log File
                    </label>

                    <select
                        id="logFile"
                        class="form-select">
                    </select>

                </div>

                {{-- Lines --}}
                <div class="col-md-2">

                    <label class="form-label">
                        Lines
                    </label>

                    <select
                        id="logLines"
                        class="form-select">

                        <option value="100">
                            100
                        </option>

                        <option value="500">
                            500
                        </option>

                        <option value="1000" selected>
                            1000
                        </option>

                        <option value="2000">
                            2000
                        </option>

                        <option value="5000">
                            5000
                        </option>

                    </select>

                </div>

                {{-- Search --}}
                <div class="col-md-4">

                    <label class="form-label">
                        Search
                    </label>

                    <input
                        type="text"
                        id="logSearch"
                        class="form-control"
                        placeholder="Search">

                </div>

                <div class="col-md-2">

                    <button
                        type="button"
                        id="btnSearch"
                        class="btn btn-primary w-100">

                        <i class="bi bi-search"></i>

                        Search

                    </button>

                </div>

            </div>

        </div>
    </div>


    {{-- Log --}}
    <div class="card border-0">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0">

                <i class="bi bi-list-ul me-2"></i>

                Log

            </h5>

            <div class="d-flex gap-2">

                <button
                    type="button"
                    id="btnRefresh"
                    class="btn btn-sm btn-primary">

                    <i class="bi bi-arrow-clockwise"></i>

                </button>

                <button
                    type="button"
                    id="btnDownload"
                    class="btn btn-sm btn-danger">

                    <i class="bi bi-download"></i>

                </button>

            </div>

        </div>

        <div class="card-body p-2">

            <pre
                id="logViewer"
                class="log-viewer">Loading...</pre>

        </div>

    </div>

</div>

@endsection


@push('styles')

<style>

.log-viewer {
    height: 650px;

    margin: 0;

    padding: 20px;

    overflow: auto;

    background: #fff;

    border: 1px solid #dee2e6;

    border-radius: 6px;

    color: #334155;

    font-family:
        "SFMono-Regular",
        Consolas,
        "Liberation Mono",
        monospace;

    font-size: 13px;

    line-height: 1.6;

    white-space: pre;

    tab-size: 4;
}

</style>

@endpush


@push('scripts')

<script>

const LOG_FILES_URL =
    "{{ route('admin.logs.files') }}";

const LOG_READ_URL =
    "{{ route('admin.logs.read') }}";

const LOG_DOWNLOAD_URL =
    "{{ route('admin.logs.download') }}";


let selectedLogFile = null;


/**
 * Load files
 */
function loadLogFiles()
{
    $.get(LOG_FILES_URL)

        .done(function(response) {

            const select =
                $('#logFile');

            select.empty();

            if (!response.files.length) {

                select.append(
                    '<option value="">No log files found</option>'
                );

                return;
            }

            response.files.forEach(function(file) {

                select.append(`
                    <option value="${file.name}">
                        ${file.name.replace('.log', '')}
                    </option>
                `);

            });

            selectedLogFile =
                response.files[0].name;

            select.val(
                selectedLogFile
            );

            loadLog();

        })

        .fail(function(xhr) {

            Toast.error(
                xhr.responseJSON?.message ??
                'Unable to load log files.'
            );

        });
}


/**
 * Load selected log
 */
function loadLog()
{
    const file =
        $('#logFile').val();

    if (!file) {
        return;
    }

    selectedLogFile = file;

    $('#logViewer').text(
        'Loading...'
    );

    $.get(
        LOG_READ_URL,
        {
            file: file,

            lines:
                $('#logLines').val(),

            search:
                $('#logSearch').val()
        }
    )

    .done(function(response) {

        $('#logViewer').html(
            response.logs.join('\n\n') ||
            'No log entries found.'
        );

    })

    .fail(function(xhr) {

        $('#logViewer').text(
            xhr.responseJSON?.message ??
            'Unable to read log file.'
        );

    });
}


/**
 * File changed
 */
$(document).on(
    'change',
    '#logFile',
    function() {

        loadLog();

    }
);


/**
 * Lines changed
 */
$(document).on(
    'change',
    '#logLines',
    function() {

        loadLog();

    }
);


/**
 * Search
 */
$('#btnSearch').on(
    'click',
    function() {

        loadLog();

    }
);


/**
 * Enter search
 */
$('#logSearch').on(
    'keypress',
    function(e) {

        if (e.which === 13) {

            loadLog();

        }

    }
);


/**
 * Refresh
 */
$('#btnRefresh').on(
    'click',
    function() {

        loadLog();

    }
);


/**
 * Download
 */
$('#btnDownload').on(
    'click',
    function() {

        const file =
            $('#logFile').val();

        if (!file) {
            return;
        }

        window.location.href =
            LOG_DOWNLOAD_URL +
            '?file=' +
            encodeURIComponent(file);

    }
);


/**
 * Initial load
 */
$(document).ready(function() {

    loadLogFiles();

});

</script>

@endpush