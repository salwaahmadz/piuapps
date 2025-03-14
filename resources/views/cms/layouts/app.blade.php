<!DOCTYPE html>
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ secure_asset('assets') }}"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title')PIU Apps</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ secure_asset('assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    @stack('css')

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ secure_asset('assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ secure_asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ secure_asset('assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ secure_asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ secure_asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <link rel="stylesheet" href="{{ secure_asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ secure_asset('assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ secure_asset('assets/js/config.js') }}"></script>

  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">

        @include('cms.layouts.sidebar')

        <!-- Layout container -->
        <div class="layout-page">
         @include('cms.layouts.navbar')
         
          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              @yield('content')
            </div>
            <!-- / Content -->

            @include('cms.layouts.footer')

          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ secure_asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ secure_asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ secure_asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ secure_asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ secure_asset('assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ secure_asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ secure_asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ secure_asset('assets/js/dashboards-analytics.js') }}"></script>

    <script src="{{ secure_asset('assets/js/sweetalert2.bundle.js') }}" type="text/javascript"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>

  <script>
      const formatRp = (amount) => new Intl.NumberFormat("id-ID", {
          style: "currency",
          currency: "IDR"
      }).format(amount)
  </script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

@if (session('error'))
<script>
    $(document).ready(function() {
        Swal.fire({
            title: 'Gagal',
            icon: 'error',
            text: 'Data tidak ditemukan!',
            showConfirmButton: false,
            timer: 1500
        });
    });
</script>
@endif

@stack('js')
</html>
