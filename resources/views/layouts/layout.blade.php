<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Bank Bima Arthonity</title>
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        <!-- Google Font: Roboto -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
        
        <!-- Bootstrap cdn -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        
        <!-- Font Awesome cdn -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        
        <!-- jquery link -->
        <script src="{{ asset('js/jQuery-3.7.1.js') }}"></script>
        <script>
            let apiUrl = "{{ config('app.api_url') }}";
            // console.log(apiUrl);
            
        </script>
        <script src="{{ asset('js/ajax/common_ajax_requests.js') }}"></script>
        
        <!-- including custom style sheet -->
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        {{-- brian2694/laravel-toastr css  --}}
        <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">

        <!-- add extra styles if needed -->
        @yield('style')
    </head>
    <body>
        <div class="main-container">
            {{-- {{dd(session()->all())}} --}}
            {{-- @include('layouts.main_data') --}}
            <!-- Sidebar Container -->
            @include('layouts.sidebar')

            <!-- Body Wrapper. Contains main content -->
            <div class="body-wrapper">
                <!-- include header file --> 
                @include('layouts.header')
                

                <!-- Dynamic Content will be added here -->
                <div class="main-content">
                    @yield('admin')
                    @yield('main-content')
                </div>


                <!-- Include Footer file --> 
                @include('layouts.footer')

            </div>
        </div>

        <!-- ////////////////////////////////////////  Script file add start from here /////////////////////////// -->

        <!-- Bootstrap cdn link -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        {{-- laravel csrf token ajax --}}
        {{-- <script>
            var token = localStorage.getItem('token');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json',
                }
            });
        </script> --}}
        {{-- <script>
            let apiUrl = "{{ env('API_URL') }}";
        </script> --}}
        {{-- common ajax Request file --}}
        {{-- <script src="{{ asset('js/ajax/common_ajax_requests.js') }}"></script> --}}
        <script src="{{ asset('js/ajax/common_ajax/common_events.js') }}"></script>
        <script src="{{ asset('js/ajax/common_ajax/custom_helper_function.js') }}"></script>
        <script src="{{ asset('js/ajax/common_ajax/get_data.js') }}"></script>
        <script src="{{ asset('js/ajax/common_ajax/crude_ajax.js') }}"></script>
        <script src="{{ asset('js/ajax/common_ajax/search_pagination.js') }}"></script>
        <script src="{{ asset('js/ajax/common_ajax/render_pagination.js') }}"></script>
        {{-- add extra ajax file if needed --}}
        @yield('ajax')
        {{-- custom sidebar ajax --}}
        <script src="{{ asset('js/sidebar.js') }}"></script>
        {{-- custom modal ajax --}}
        <script src="{{ asset('js/modal.js') }}"></script> 
        {{-- brian2694/laravel-toastr js  --}}
        <script src="{{ asset('js/toastr.min.js') }}"></script> 
        {!! Toastr::message() !!}
        <script>
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "3000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
        </script>
        {{-- add extra script file if needed --}}
        @if (session('message'))
            <script>
                toastr.error('{{ session('message') }}', 'Permission Denied!');
            </script>
        @endif
        {{-- <script>
            $(document).ready(function() {
                SidebarListClick('#bank-details', '{{ route('show.banks') }}');
                SidebarListClick('#location-details', '{{ route('show.locations') }}');
            });
        </script> --}}
        @yield('script')
    </body>
</html>