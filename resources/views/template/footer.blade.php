
@php
$basepublic = 'https://route.plustrap.com/public/sneat/'
@endphp

</div>
<!-- / Content -->

<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
  <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
    <div class="mb-2 mb-md-0">
      ©
      <script>
        document.write(new Date().getFullYear());
      </script>
      , made with ❤️ by Plustrap
    </div>
  </div>
</footer>
<!-- / Footer -->

<div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
</div>
<!-- / Layout page -->
</div>

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->

<!-- Helpers -->
<script src="{{ $basepublic }}vendor/js/helpers.js"></script>

<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="{{ $basepublic }}js/config.js"></script>
    
<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{$basepublic}}vendor/libs/jquery/jquery.js"></script>
<script src="{{$basepublic}}vendor/libs/popper/popper.js"></script>
<script src="{{$basepublic}}vendor/js/bootstrap.js"></script>
<script src="{{$basepublic}}vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

<script src="{{$basepublic}}vendor/js/menu.js"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{$basepublic}}vendor/libs/apex-charts/apexcharts.js"></script>

<!-- Main JS -->
<script src="{{$basepublic}}js/main.js"></script>

<!-- Page JS -->
<script src="{{$basepublic}}js/dashboards-analytics.js"></script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

</body>
</html>
