
<link rel="stylesheet" href="{{asset('css/select2.min.css')}}"/>
<link rel="stylesheet" href="{{asset('css/select2-bootstrap4.min.css')}}"/>
<script src="{{asset('js/select2.full.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2()
        $('.select2survey').select2({
            placeholder: $(this).data('placeholder'),
        })
    });
</script>