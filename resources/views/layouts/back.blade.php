<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>@yield('title')</title>
   <!-- CSRF Token -->
   <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('backend/assets/modules/bootstrap/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{ asset('backend/assets/modules/fontawesome/css/all.min.css')}}">

   <!-- CSS Libraries -->
   <link rel="stylesheet" href="{{ asset('assets/modules/jqvmap/dist/jqvmap.min.css')}}">
   <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.cs')}}s">
   <link rel="stylesheet" href="{{ asset('assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css')}}">
   <link rel="stylesheet" href="{{ asset('assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/izitoast/css/iziToast.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css')}}">
  <link rel="stylesheet" href="{{ asset('backend/assets/css/components.css')}}">

  <style>
    body.sidebar-mini .main-sidebar:after {
      background-color: #1a2035;
    }
    .btn-gradient {
    background: linear-gradient(45deg, #662D8C, #ED1E79);
    border: none;
    color: white;
  }



    .btn-primary, .btn-primary.disabled {
      background: linear-gradient(45deg, #662D8C, #ED1E79);
      border: none;
      color: white;
    }

    .btn-danger, .btn-danger.disabled {
      background: linear-gradient(45deg, #FF512F , #DD2476);
      border: none;
      color: white;
    }

    .btn-warning, .btn-warning.disabled {
      background: linear-gradient(45deg, #D8B5FF  , #1EAE98);
      border: none;
      color: white;
    }

    .bg-primary {
      background: linear-gradient(45deg, #11998E  , #38EF7D);
      color: white;
    }

    .btn-success, .btn-success.disabled {
      background: linear-gradient(45deg, #C33764  , #1D2671);
      border: none;
      color: white;
    }

    .section .section-title:before {
    content: ' ';
    border-radius: 5px;
    height: 8px;
    width: 30px;
    background: linear-gradient(45deg, #FF512F , #DD2476);
    display: inline-block;
    float: left;
    margin-top: 6px;
    margin-right: 15px;
}

.section .section-header h1 {
    margin-bottom: 0;
    font-weight: 700;
    display: inline-block;
    font-size: 24px;
    margin-top: 3px;
    background: linear-gradient(45deg, rgb(188, 12, 241), rgb(212, 4, 4));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.page-item.active .page-link {
    background: linear-gradient(45deg, #09203F  , #537895);
    border-color: #6777ef;
}

.main-sidebar .sidebar-brand a {
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    font-weight: 700;
    background: linear-gradient(45deg, rgb(188, 12, 241), rgb(212, 4, 4));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;


}


.btn-secondary, .btn-secondary.disabled {
    background: linear-gradient(45deg, #FF512F , #DD2476);
    border: none;
    color: white;
}

.btn-active {
    background: linear-gradient(45deg, #09203F  , #537895);
    border: none;
    color: white;
  }


.bg-danger {
    background: linear-gradient(45deg, #FF512F , #DD2476);
    color: white;

}
.bg-warning {
    background: linear-gradient(45deg, #D8B5FF , #1EAE98);
    color: white;

}

.bg-success {
    background: linear-gradient(45deg, #C33764 , #1D2671);
    color: white;

}




/* From Uiverse.io by boryanakrasteva */
.input-container {
  width: 220px;
  position: relative;
}

.icon {
  position: absolute;
  right: 10px;
  top: calc(50% + 5px);
  transform: translateY(calc(-50% - 5px));
}

.input {
  width: 100%;
  height: 40px;
  padding: 10px;
  transition: .2s linear;
  border: 2.5px solid #DD2476;
  font-size: 14px;
  text-transform: uppercase;
  letter-spacing: 2px;
}

.input:focus {
  outline: none;
  border: 0.5px solid rgb(25, 168, 211);
  box-shadow: -5px -5px 0px rgb(36, 139, 145);
}

.input-container:hover > .icon {
  animation: anim 1s linear infinite;
}

@keyframes anim {
  0%,
  100% {
    transform: translateY(calc(-50% - 5px)) scale(1);
  }

  50% {
    transform: translateY(calc(-50% - 5px)) scale(1.1);
  }
}








  </style>

    @stack('styles')
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        @include('inc.topbar')
        @include('inc.sidebar')
        <!-- Main Content -->
        <div class="main-content">
          <section class="section">
            @yield('content')

          </section>
        </div>
      </div>

  </div>
  @stack('modals')
  <!-- General JS Scripts -->
  <script src="{{ asset('backend/assets/modules/jquery.min.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/popper.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/tooltip.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/moment.min.js')}}"></script>
  <script src="{{ asset('backend/assets/js/stisla.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/sweetalert/sweetalert.min.js')}}"></script>

  <!-- JS Libraies -->
  <script src="{{ asset('backend/assets/modules/jquery.sparkline.min.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/chart.min.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/owlcarousel2/dist/owl.carousel.min.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/summernote/summernote-bs4.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/chocolat/dist/js/jquery.chocolat.min.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/izitoast/js/iziToast.min.js') }}"></script>

  <script src="{{ asset('backend/assets/modules/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset('backend/assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('backend/assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
  <script src="{{ asset('backend/assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>
  <!-- Page Specific JS File -->

  <!-- Template JS File -->
  <script src="{{ asset('backend/assets/js/scripts.js')}}"></script>
  <script src="{{ asset('backend/assets/js/custom.js')}}"></script>


  @include('notification.toast')
   <script src="{{ asset('backend/assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
   <script>
       $(document).ready(function() {
           const addSelectAll = matches => {
               if (matches.length > 0) {
               // Insert a special "Select all matches" item at the start of the
               // list of matched items.
               return [
                   {id: 'selectAll', text: 'Select all matches', matchIds: matches.map(match => match.id)},
                   ...matches
               ];
               }
           };
           const handleSelection = event => {
               if (event.params.data.id === 'selectAll') {
               $('.select2').val(event.params.data.matchIds);
               $('.select2').trigger('change');
               };
           };
           $('.select2').select2({
               multiple: true,
               sorter: addSelectAll,
           });
           $('.select2').on('select2:select', handleSelection);
       });
   </script>
  {{-- <!--Start of Tawk.to Script-->
  <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/67b61c7b7d251a1909996f27/1ikfluhhs';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script--> --}}
  @stack('scripts')
</body>
</html>
