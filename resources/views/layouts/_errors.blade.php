@if(session()->has('sweet_alert.alert'))
<script>
    if (typeof swal === "function") {
        swal({!! session()->pull('sweet_alert.alert') !!});
    }
</script>
@endif