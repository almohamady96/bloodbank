
<!-- jQuery 3 -->
<script src="{{asset('adminlte/plugins/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('adminlte/plugins/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- SlimScroll -->
<script src="{{asset('adminlte/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('adminlte/plugins/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('adminlte/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('adminlte/js/demo.js')}}"></script>
<script src="{{asset('adminlte/plugins/jquery-confirm/jquery.confirm.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js  "></script>

<script>
    $(document).ready(function () {
        $('.sidebar-menu').tree()
    })
</script>
<script src="{{asset('js/ayman.js')}}"></script>


@stack('scripts')
@stack('print')
@stack('showpassword')
</body>
</html>
