@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Toast.success(@json(session('success')));
});
</script>
@endif

@if(session('error'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Toast.error(@json(session('error')));
});
</script>
@endif

@if(session('warning'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Toast.warning(@json(session('warning')));
});
</script>
@endif

@if(session('info'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Toast.info(@json(session('info')));
});
</script>
@endif