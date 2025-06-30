<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Page Title' }}</title>
        @livewireStyles
        @include('components.layouts.user-dashboard.header')
        
    </head>

    <body class="g-sidenav-show  bg-gray-100">
      
        @include('components.layouts.user-dashboard.sidebar')
        
        <!-- Content Wrapper -->
        
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
            <!-- Main Content -->
            @include('components.layouts.user-dashboard.navbar')
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
                    @include('components.layouts.user-dashboard.footer-top')
                    @include('components.layouts.user-dashboard.footer')
                </div>
        </main>
       @livewireScripts
    </body>
</html>
