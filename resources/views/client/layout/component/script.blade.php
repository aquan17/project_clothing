<script type="text/javascript" src="{{ asset('client/js/jquery.js') }}"></script>
<script type="text/javascript" src="{{ asset('client/js/vendors.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('client/js/main.js') }}"></script>
<script>
    var isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
</script>
