<!DOCTYPE html>
<html lang="en">
<head>
  <base href="<?php echo base_url();?>">
  <script>
    let base_url = '<?php echo base_url(); ?>';
  </script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{title} </title>
  {metas}
  
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <link href="assets/css/style.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="assets/components/toastr/toastr.css">
  <link rel="stylesheet" type="text/css" href="assets/components/jquery-confirm/jquery-confirm.min.css">
  {styles}

  <script type="text/javascript" src="assets/js/jquery.js"></script>
  <script type="text/javascript" src="assets/components/toastr/toastr.min.js"></script>
  <script type="text/javascript" src="assets/components/jquery-confirm/jquery-confirm.min.js"></script>
  <script type="text/javascript">
        
        function toasterOptions() {
          toastr.options = {
              "closeButton": true,
              "debug": false,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-bottom-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "3000",
              "hideDuration": "2000",
              "timeOut": "3000",
              "extendedTimeOut": "2000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
          }
        };
        
        toasterOptions();

      </script>
  

</head>
  {content}
</body>
  {scripts}
   <?php if($this->session->flashdata('success')) { ?>
      <script type="text/javascript">
        toastr.success("<?php echo $this->session->userdata("success"); ?>");
    </script>
    <?php } ?>

    <?php if($this->session->flashdata('error')) { ?>
      <script type="text/javascript">
        toastr.error("<?php echo $this->session->userdata("error"); ?>");
    </script>
    <?php } ?>
</html>