<!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <input type="hidden" name="todaydate" value="<?php echo date('Y-m-d') ?>" />
    <script>var baseurl = "<?php echo $_SESSION['baseurl'] ? $_SESSION['baseurl'] : ""?>"; </script>
    
    <script src="<?php echo $baseurl?>assets/vendor/libs/jquery/jquery.js"></script>
    <script src="<?php echo $baseurl?>assets/vendor/libs/popper/popper.js"></script>
    <script src="<?php echo $baseurl?>assets/vendor/js/bootstrap.js"></script>
    <script src="<?php echo $baseurl?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="<?php echo $baseurl?>assets/vendor/js/jquery.validate.min.js"></script>
    <script src="<?php echo $baseurl?>assets/vendor/libs/hammer/hammer.js"></script>
    <script src="<?php echo $baseurl?>assets/vendor/libs/i18n/i18n.js"></script>
    <script src="<?php echo $baseurl?>assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="<?php echo $baseurl?>assets/vendor/js/menu.js"></script>
    <script src="<?php echo $baseurl?>assets/js/moment.min.js"></script>
    <script src="<?php echo $baseurl?>assets/js/daterangepicker.js"></script>
    <script src="<?php echo $baseurl?>assets/vendor/libs/select2/select2.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src= "<?php echo $baseurl ?>assets/js/bind/modal/model.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="<?php echo $baseurl?>assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="<?php echo $baseurl?>assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="<?php echo $baseurl?>assets/js/dashboards-analytics.js"></script>
    <script src="<?php echo $baseurl?>assets/js/ui-popover.js"></script>
    <script src="<?php echo $baseurl?>assets/js/common.js?v=<?php echo $ver ?>"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <noscript>
    <style>html{display:none;}</style>
    <meta http-equiv="refresh" content="0.0;url=nojavascript.html">
    </noscript>