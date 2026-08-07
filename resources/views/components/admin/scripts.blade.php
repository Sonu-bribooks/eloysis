
{{-- JQuery --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Bootstrap --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

{{-- Common JS --}}
<script src="{{ asset('assets/common/js/helper.js') }}"></script>
<script src="{{ asset('assets/common/js/ajax.js') }}"></script>
<script src="{{ asset('assets/common/js/toast.js') }}"></script>

{{-- Admin JS --}}
<script src="{{ asset('assets/admin/js/sidebar.js') }}"></script>
<script src="{{ asset('assets/admin/js/app.js') }}"></script>
<script src="{{ asset('assets/admin/js/auth.js') }}"></script>

<script> 

    const BASE_URL = document
        .querySelector('meta[name="base-url"]')
        .getAttribute('content');

    console.log(BASE_URL);
</script>