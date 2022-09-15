<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="{{asset('css/_bootstrap-switch.scss')}}" />
<script src="{{asset('js/bootstrap-switch.min.js')}}"></script>
<script>
  // $(document).ready(function() {
  //   $("input[data-bootstrap-switch]").each(function() {
  //     $(this).bootstrapSwitch('state', $(this).prop('unchecked'));
  //   });
  // });
  $("input[data-bootstrap-switch]").each(function() {
    $(this).bootstrapSwitch('state', $(this).prop('checked'));
  });

  function switchmethod() {
    $("input[data-bootstrap-switch]").each(function() {
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });
  }
</script>