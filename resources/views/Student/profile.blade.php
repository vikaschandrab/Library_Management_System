<!DOCTYPE html>
<html lang="en">


<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Library Management System</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../css/style.css">
    <!-- End layout styles -->
    <script src="https://kit.fontawesome.com/09a05bb41f.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:../../partials/_navbar.html -->
      <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            <a class="navbar-brand brand-logo" href="/admin/dashboard"><img src="../images/logo.png" alt="logo" /></a>
            <a class="navbar-brand brand-logo-mini" href="/admin/dashboard"><img src="../images/profile.png" alt="logo" /></a>
          </div>
          <div class="navbar-menu-wrapper d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="mdi mdi-menu"></span>
            </button>
          <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
              <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <div class="nav-profile-img">
                    @if ($StudentProfile -> profilePicture == null)
                        <img src="../images/profile.png" alt="image">
                    @else
                        <img src="../images/student/{{ $StudentProfile -> profilePicture }}" alt="image">
                    @endif
                  <span class="availability-status online"></span>
                </div>
                <div class="nav-profile-text">
                  <p class="mb-1 text-black">{{ $StudentProfile -> name }}</p>
                </div>
              </a>
              <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                <a class="dropdown-item" href="/student/profile">
                  <i class="mdi mdi-account mr-2 text-success"></i> Profile </a>
                <div class="dropdown-divider"></div>
                <form class="modal-content-logout" id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="mdi mdi-power mr-2 text-primary"></i> Signout </a>
                </form>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">

            <li class="nav-item">
              <a class="nav-link" href="/student/dashboard">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/student/borrow-book">
                <span class="menu-title">Borrow Book</span>
                <i class="fa-solid fa-book menu-icon"></i>
              </a>
            </li>
          </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Profile </h3>
            </div>
            <div class="row">
              <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Profile Details</h4>
                    <form class="forms-sample" method="post" action="/student/profileupdate" enctype="multipart/form-data">
                        @csrf
                        @if($StudentProfile -> profilePicture == null)
                            <img src="../images/profile.png" alt="image" width="100px" height="100px"  class="imagecenter">
                        @else
                            <img src="../images/student/{{ $StudentProfile -> profilePicture }}" alt="image" width="100px" height="100px"  class="imagecenter">
                        @endif
                      <div class="row">
                        <div class="form-group" style="padding-top:15px;">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $StudentProfile -> name }}">
                        </div>
                        <div class="form-group" style="padding-top:15px; padding-left:15px;">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $StudentProfile -> email }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                          <label for="phone">Mobile</label>
                          <input type="text" class="form-control" id="phone" name="phone" value="{{ $StudentProfile -> phone }}">
                        </div>
                        <div class="form-group"  style="padding-left:15px;">
                          <label for="department">Department</label>
                          <select class="form-control" name="department" id="department" required>
                              <option value="">Select Department</option>
                              @foreach ($departments as $department)
                                <option value="{{ $department -> departmentId }}"> {{ $department -> department_name }}</option>
                              @endforeach
                          </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                          <label for="reg_num">Register Number</label>
                          @if ($StudentAcademicDetails != null)
                              <input type="text" class="form-control" id="reg_num" name="reg_num" value="{{ $StudentAcademicDetails -> reg_num }}">
                          @else
                              <input type="text" class="form-control" id="reg_num" name="reg_num" placeholder="Enter Register Number">
                          @endif
                        </div>
                      <div class="form-group"  style="padding-left:15px;>
                        <label for="year">Year</label>
                        @if ($StudentAcademicDetails != null)
                            <input type="text" class="form-control" id="year" name="year" value="{{ $StudentAcademicDetails -> year }}">
                        @else
                            <input type="text" class="form-control" id="year" name="year" placeholder="Enter Academic Year">
                        @endif
                      </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                          <label for="sem">Semester</label>
                          @if ($StudentAcademicDetails != null)
                              <input type="text" class="form-control" id="sem" name="sem" value="{{ $StudentAcademicDetails -> semester }}">
                          @else
                              <input type="text" class="form-control" id="sem" name="sem" placeholder="Enter Academic Semester">
                          @endif
                        </div>
                      <div class="form-group" style="padding-left:15px;">
                        <label>Photo upload</label>
                        <input type="file" name="img" class="file-upload-default">
                        <div class="input-group col-xs-12">
                          <input type="text" class="form-control file-upload-info @error('img') is-invalid @enderror" disabled value="{{ $StudentProfile -> profilePicture }}">
                          <span class="input-group-append">
                            <button class="file-upload-browse btn btn-gradient-primary" type="button">Browser</button>
                          </span>
                          @error('img')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                      </div>
                    </div>
                      <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
                    </form>
                  </div>
                </div>
              </div>
              </div>
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
          <footer class="footer">
            <div class="container-fluid clearfix">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">2022 Designed & Developed under nxtGIO Technologies LLP</span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../js/off-canvas.js"></script>
    <script src="../js/hoverable-collapse.js"></script>
    <script src="../js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="../js/file-upload.js"></script>
    <!-- End custom js for this page -->
    <script>
        @if (session('status'))
            swal({
            title: ' {{ session('status') }}',
            icon: "success",
            button: "Done",
            });
        @endif
    </script>
  </body>
</html>
