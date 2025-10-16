<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <title>{{ $title ?? 'Page Title' }}</title>
        @livewireStyles
        @include('layouts.backend.header')
        
    </head>

    <body class="g-sidenav-show  bg-gray-100">
      
        @include('layouts.backend.sidebar')
        
        <!-- Content Wrapper -->
        
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
            <!-- Main Content -->
            @include('layouts.backend.navbar')
                <div class="container-fluid">
           
                    <!-- Content Column -->
                    <div class="col-lg-12 mb-4">
                        <!-- Project Card Example -->
                        <div class="card shadow mb-4">
                            <div class="card-body mx-5">
                                {{ $slot }}
        
        
                            </div>
                        </div>
                    </div>
                    @include('layouts.backend.footer-top')
                    @include('layouts.backend.footer')
                </div>
        </main>
       @livewireScripts
     
       @stack('scripts')
    </body>
</html>
