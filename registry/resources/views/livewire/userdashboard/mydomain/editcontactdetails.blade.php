@extends('layout.user-dashboard.app')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Update Contact</h1>
        </div>

        @livewire('contactupdate-form',['id' => request('id'),'domain'=>request('domain'),'ctype'=>request('ctype')])
    @endsection
