<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>{{ config('app.name', 'CRM') }} - @yield('title','CMS')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="YM Service App." name="description" />
        <meta content="Techzaa" name="author" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('cms/favicon.ico') }}">
        <!-- Theme Config Js -->
        <script src="{{ asset('cms/assets/js/config.js') }}"></script>
        @yield('pre-css')
        <!-- App css -->
        <link href="{{ asset('cms/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
        <!-- Icons css -->
        <link href="{{ asset('cms/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{asset('cms/assets/vendor/pace-progress/themes/blue/pace-theme-flash.css')}}">
        @yield('css')
    </head>

    <body>
        <div class="wrapper">

            <!-- ========== Topbar Start ========== -->
            <div class="navbar-custom">
                <div class="topbar container-fluid">
                    <div class="d-flex align-items-center gap-1">

                        <!-- Topbar Brand Logo -->
                        <div class="logo-topbar">
                            <!-- Logo Dark -->
                            <a href="{{route('dashboard')}}" class="logo-dark">
                                <span class="logo-lg">
                                    <img src="{{ asset('cms/assets/images/logo-dark.png') }}" alt="dark logo">
                                </span>
                                <span class="logo-sm">
                                    <img src="{{ asset('cms/assets/images/logo-sm.png') }}" alt="small logo">
                                </span>
                            </a>
                        </div>

                        <!-- Sidebar Menu Toggle Button -->
                        <button class="button-toggle-menu">
                            <i class="ri-menu-line"></i>
                        </button>

                        <!-- Horizontal Menu Toggle Button -->
                        <button class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </button>
                    </div>

                    <ul class="topbar-menu d-flex align-items-center gap-3">
                        <li class="dropdown">
                            <a class="nav-link dropdown-toggle arrow-none nav-user" data-bs-toggle="dropdown" href="#" role="button"
                               aria-haspopup="false" aria-expanded="false">
                                <span class="account-user-avatar">
                                    <img src="{{ asset('cms/assets/images/avatar-1.jpg')}}" alt="user-image" width="32" class="rounded-circle">
                                </span>
                                <span class="d-lg-block d-none">
                                    <h5 class="my-0 fw-normal">{{auth()->user()->name}} <i  class="ri-arrow-down-s-line d-none d-sm-inline-block align-middle"></i></h5>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
                                <!-- item-->
                                <div class=" dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">{{auth()->user()->email}}</h6>
                                </div>
                                <!-- item-->
                                <a href="#" class="dropdown-item">
                                    <i class="ri-account-circle-line fs-18 align-middle me-1"></i>
                                    <span>My Account</span>
                                </a>
                                <!-- item-->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                                        <i class="ri-logout-box-line fs-18 align-middle me-1"></i>
                                        <span>Logout</span>
                                    </a>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- ========== Topbar End ========== -->

            <!-- ========== Left Sidebar Start ========== -->
            <div class="leftside-menu">
                <!-- Brand Logo Dark -->
                <a href="index.html" class="logo logo-light">
                    <span class="logo-lg">
                        <img src="{{ asset('cms/assets/images/logo.png')}}" alt="dark logo">
                    </span>
                    <span class="logo-sm">
                        <img src="{{ asset('cms/assets/images/logo-sm.png')}}" alt="small logo">
                    </span>
                </a>
                <!-- Sidebar -left -->
                <div class="h-100" id="leftside-menu-container" data-simplebar>
                    <!--- Sidemenu -->
                    <ul class="side-nav">
                        <li class="side-nav-item {{request()->is('dashboard')?'menuitem-active':''}}">
                            <a href="{{route('dashboard')}}" class="side-nav-link">
                                <i class="ri-dashboard-3-line"></i>
                                <span> Dashboard </span>
                            </a>
                        </li>
                        <li class="side-nav-title">Modules</li>
                        @foreach(config('sidebarmenu.admin') as $ki=>$item)
                        @include('auth.layouts.sidebar')
                        @endforeach
                    </ul>
                </div>   

            </div>     

            <div class="content-page">
                <div class="content">
                    <!-- Start Content-->
                    <div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    @yield('header')
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        @yield('content')
                    </div>
                </div>  

                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 text-center">
                                <script>document.write(new Date().getFullYear())</script> © Giraf
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->
            </div>   
        </div>
        <!-- /Wrapper -->
        <!-- Vendor js -->
        <script src="{{ asset('cms/assets/js/vendor.min.js')}}"></script>
        @yield('pre-js')
        <!-- App js -->
        <script src="{{ asset('cms/assets/js/app.min.js') }}"></script>
        <script src="{{asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
        <script src="{{ asset('cms/assets/vendor/pace-progress/pace.min.js') }}"></script>
        @include('sweetalert::alert')
        @yield('js')
        <script>
                                    $(document).on('click', '.table .destroy', function (e) {
                                        e.preventDefault();
                                        var href = $(this).attr('href');
                                        var thisTr = $(this).closest('tr');
                                        Swal.fire({
                                            title: "Are you sure want to delete this?",
                                            text: "Can not recover the data once it is deleted.",
                                            icon: "warning",
                                            showCancelButton: true, // Show the cancel button
                                            confirmButtonText: "Delete", // Text for the confirm button
                                            cancelButtonText: "Cancel"
                                        })
                                                .then((result) => {
                                                    if (result.isConfirmed) {
                                                        Pace.restart();
                                                        Pace.track(function () {
                                                            $.ajax({
                                                                url: href,
                                                                method: 'DELETE',
                                                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                                                success: function (response) {
                                                                    if (response.status) {
                                                                        thisTr.remove();
                                                                        Swal.fire("Done!", response.message, "success");
                                                                    } else {
                                                                        Swal.fire("Failed!", response.message, "error");
                                                                    }
                                                                },
                                                                error: function (xhr, ajaxOptions, thrownError) {
                                                                    Swal.fire('Error deleting!', 'Please try again', 'error');
                                                                }
                                                            });
                                                        });
                                                    } else {
                                                        return true;
                                                    }
                                                });
                                    });
        </script>
    </body>
</html>