<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Koperasi Tebu Manis Agung</title>

    <!-- Bootstrap and jQuery are included correctly -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom styles for this template-->
    <link href="{{ asset('/assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/css/sb-admin-2.css') }}" rel="stylesheet">
    <style>
        .image-container-car-detail {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .image-card-car-detail {
            position: relative;
            width: 18%;
            height: 200px;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 1px solid #ddd;
        }

        .image-card-car-detail img {
            height: 100%;
            width: 100%;
            object-fit: cover;
        }

        .image-card-car-detail .placeholder {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 16px;
            color: #888;
            text-align: center;
        }

        .image-card-car-detail input[type="file"] {
            display: none;
        }

        .delete-button {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: rgba(255, 0, 0, 0.7);
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-container-transaction-detail {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .image-card-transaction-detail {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }

        .image-card-transaction-detail img {
            max-width: 20%;
            max-height: 20%;
            object-fit: cover;
            cursor: pointer;
        }

        .alert-fixed {
            position: fixed;
            top: 20%;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1050;
            width: auto;
            padding: 1rem;
            display: block;
            opacity: 1;
            transition: opacity 2s linear;
        }

        @media print {
            .hide-print {
                display: none;
                /* Hide the button when printing */
            }
        }
    </style>
</head>

<body id="page-top">
    @if (session('success'))
        <div class="alert alert-success alert-fixed" role="alert" id="customAlert">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-fixed" role="alert" id="customAlert">
            {{ session('error') }}
        </div>
    @endif
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion hide-print" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-seedling"></i>
                </div>
                <div class="sidebar-brand-text mx-3">KTMA</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Charts -->
            @if (Auth::user()->role === 'ADMIN')
                <li class="nav-item {{ request()->routeIs('admin.user.index') ? 'active' : '' }}">
                    <a class="nav-link d-flex justify-content-between align-items-center"
                        href="{{ route('admin.user.index') }}">
                        <div>
                            <i class="fas fa-fw fa-user"></i>
                            <span>Users</span>
                        </div>
                        <!-- Badge aligned to the right end -->
                    </a>
                </li>
            @endif

            <!-- Nav Item - Tables -->
            <li class="nav-item {{ request()->routeIs('pinjaman.index') ? 'active' : '' }}">
                <a class="nav-link d-flex justify-content-between align-items-center"
                    href="{{ route('pinjaman.index') }}">
                    <div>
                        <i class="fas fa-fw fa-landmark"></i>
                        <span>Pinjaman</span>
                    </div>
                    <!-- Badge aligned to the right end -->
                    <span id="pinjaman-badge" class="badge badge-danger" style="display: none;"></span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('tagihan.index') ? 'active' : '' }}">
                <a class="nav-link d-flex justify-content-between align-items-center"
                    href="{{ route('tagihan.index') }}">
                    <div>
                        <i class="fas fa-fw fa-money-bill-wave"></i>
                        <span>Tagihan</span>
                    </div>
                    <!-- Badge aligned to the right end -->
                    <span id="tagihan-badge" class="badge badge-danger" style="display: none;"></span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('laporan.index') ? 'active' : '' }}">
                <a class="nav-link d-flex justify-content-between align-items-center"
                    href="{{ route('laporan.index') }}">
                    <div>
                        <i class="fas fa-fw fa-folder-open"></i>
                        <span>Laporan</span>
                    </div>
                    <!-- Badge aligned to the right end -->
                </a>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @auth
                                    @if (Auth::user()->role)
                                        <span
                                            class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                    @else
                                        <span class="mr-2 d-none d-lg-inline text-gray-600 small">User</span>
                                    @endif
                                @endauth


                                {{-- @if (Auth::check())
                                    <span
                                        class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->role }}</span>
                                @endif
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->id }}</span> --}}
                                {{-- class="mr-2 d-none d-lg-inline text-gray-600 small">ASD</span> --}}
                                <img class="img-profile rounded-circle"
                                    src="https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{route('profile')}}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    style="display: block; width:100%"
                                    onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('heading')
                    <!-- Content Row -->
                    @yield('content')
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Koperasi Tebu Manis Agung {{ date('Y') }}</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('/assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('/assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('/assets/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('/assets/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('/assets/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('/assets/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('/js/app.js') }}"></script>

</body>

</html>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function updateNotificationBadges() {
            fetch("{{ route('notification') }}")
                .then(response => response.json())
                .then(data => {
                    document.getElementById('pinjaman-badge').textContent = data.data.pinjamans;
                    if (data.data.pinjamans > 0) {
                        document.getElementById('pinjaman-badge').style.display = 'inline-block';
                    } else {
                        document.getElementById('pinjaman-badge').style.display = 'none';
                    }

                    document.getElementById('tagihan-badge').textContent = data.data.tagihans;
                    if (data.data.tagihans > 0) {
                        document.getElementById('tagihan-badge').style.display = 'inline-block';
                    } else {
                        document.getElementById('tagihan-badge').style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error fetching notification data:', error);
                });
        }
        updateNotificationBadges();
        setInterval(updateNotificationBadges, 5000); 
    });

    // window.onload = function() {
    //     const alert = document.getElementById('customAlert');
    //     if (alert) {
    //         setTimeout(function() {
    //             alert.style.opacity = '0';
    //             setTimeout(function() {
    //                 alert.remove();
    //             }, 2000);
    //         }, 2000);
    //     }
    // };

    // document.addEventListener('DOMContentLoaded', function() {
    //     const numberInputs = document.querySelectorAll('.numbers');

    //     numberInputs.forEach(inputElement => {
    //         inputElement.addEventListener('keydown', function(event) {
    //             // Check if the key pressed is a number
    //             if (event.key >= '0' && event.key <= '9') {
    //                 event.preventDefault();
    //             }
    //         });
    //     });
    // });

    // function setAction(action) {
    //     document.getElementById('action').value = action;
    // }

    // function showImageInModal(src) {
    //     document.getElementById('modalImage').src = src;
    // }

    // function deleteImage(userId) {
    //     if (confirm('Are you sure you want to delete this user?')) {
    //         fetch(`/admin/users/${userId}`, {
    //                 method: 'DELETE',
    //                 headers: {
    //                     'X-CSRF-TOKEN': '{{ csrf_token() }}',
    //                 },
    //             })
    //             .then(response => {
    //                 if (response.ok) {
    //                     window.location.href = '/admin/users';
    //                 } else {
    //                     console.error('Failed to delete the user.');
    //                 }
    //             })
    //             .catch(error => console.error('Error deleting user:', error));
    //     }
    // }
</script>
