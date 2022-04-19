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
    <!-- Layout styles -->
    <link rel="stylesheet" href="../css/style.css">
    <!-- End layout styles -->
    <script src="https://kit.fontawesome.com/09a05bb41f.js" crossorigin="anonymous"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <style>
      #studentview{
        display: none;
      }
      #upload{
      display: none;
    }
    </style>
  </head>
  <body>

      <!-- partial:partials/_navbar.html -->
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
                    @if ( $Adminprofile -> profilePicture != 0)
                    <img src="../images/admin/{{ $Adminprofile -> profilePicture }}" alt="image" width="100px" height="100px">
                @else
                    <img src="../images/profile.png" alt="image" width="100px" height="100px">
                @endif
                  <span class="availability-status online"></span>
                </div>
                <div class="nav-profile-text">
                    <p class="mb-1 text-black">{{ $Adminprofile -> name }}</p>
                </div>
              </a>
              <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                <a class="dropdown-item" href="/admin/profile">
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
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item">
              <a class="nav-link" href="/admin/dashboard">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/admin/librarian">
                <span class="menu-title">Librarian</span>
                <i class="fa-solid fa-user-pen menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/admin/books">
                <span class="menu-title">Books</span>
                <i class="fa-solid fa-book menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/admin/students">
                <span class="menu-title">Students</span>
                <i class="fa-solid fa-user-graduate menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/admin/department">
                <span class="menu-title">Department</span>
                <i class="mdi mdi-bank menu-icon"></i>
              </a>
            </li>
          </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                  <i class="fa-solid fa-user-graduate"></i>
                </span> Students
              </h3>

            </div>
            <div class="row">
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                  <div class="card-body" onclick="mystudent()">
                    <img src="../images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Students <i class="float-right">{{ $getStudentCount }}</i>
                    </h4>
                  </div>
                </div>
              </div>
              @include("Admin.add_icon")
            </div>
            <div class="row" id="studentview">
               <div class="col-lg-12 grid-margin stretch-card">
                 <div class="card">
                   <div class="card-body">
                     <table class="table">
                       <thead>
                         <tr>
                           <th style="font-weight:bold;">No</th>
                           <th style="font-weight:bold;">Profile Picture</th>
                           <th style="font-weight:bold;">Name</th>
                           <th style="font-weight:bold;">Registered/Unregistered</th>
                           <th style="font-weight:bold;">isActive</th>
                         </tr>
                       </thead>
                       <tbody>
                           <?php $i = 1 ?>
                            @if (count($getStudentList) != 0)
                                @foreach ( $getStudentList as $List )
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td class="py-1">
                                            @if ($List->profilePicture == null)
                                                <img src="../images/profile.png" alt="image" />
                                            @else
                                                <img src="../images/student/{{ $List->profilePicture }}" alt="image" />
                                            @endif
                                        </td>
                                        @if ($List->status == 1)
                                            <td><a href="#open-modal-student-{{ $List->id }}" class="badge badge-info">{{ $List -> name }}</a></td>
                                            <td>Registered</td>
                                        @else
                                            <td>{{ $List -> name }}</td>
                                            <td>Unregistered</td>
                                        @endif
                                        @if ($List->isActive == 1)
                                            <td><a href="#open-modal-editactive-{{ $List->id }}" class="badge badge-success">Active</a></td>
                                        @else
                                            <td><a href="#open-modal-editactive-{{ $List->id }}" class="badge badge-danger">Inactive</a></td>
                                        @endif
                                    </tr>
                                    <?php $i++ ?>
                                @endforeach
                            @else
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>No Students Added</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endif
                       </tbody>
                     </table>
                   </div>
                 </div>
               </div>
             </div>
             @include("Admin.fileUpload")
          </div>
               <!-- pop up modal -->
@foreach ( $getStudentList as $List )
    <form action="/admin/updatelibrarian" method="post" enctype="multipart/form-data">
        @csrf
        <div id="open-modal-editactive-{{ $List->id }}" class="modal-window">
            <div>
                <a href="#modal-close-edit" title="Close" class="modal-close"> &times;</a>
                <div class="input-field-pop">
                    <div class="white_box mb_30">
                        <div class="box_header ">
                            <div class="main-title">
                                <h3 class="mb-0">Book Status</h3>
                            </div>
                        </div>
                        <label for="status"></label>
                        <select name="isactive" id="isactive" class="form-control" required>
                            <option>Select</option>
                            <option value="1">Active</option>
                            <option value="0">In Active</option>
                        </select>
                    </div>
                </div> <br>
                <input type="hidden" name="id" id="id" value="{{ $List->id }}">
                <button class="btn btn-gradient-primary mr-2" type="submit" name="update">Update</button>
            </div>
        </div>
    </form>
@endforeach

@foreach($getstudentdetails as $list)
    <div id="open-modal-student-{{ $List->id }}" class="modal-window-pro">
        <div>
            <a href="#modal-close-edit" title="Close" class="modal-close"> &times;</a>
            <div class="input-field-pop">
                <div class="white_box mb_30">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                          <div class="card-body">
                            <div class="box_header ">
                                <div class="main-title">
                                    <h5 class="mb-0">{{ $list -> name }} Details:</h5>
                                </div>
                            </div>
                            <table class="table table-responsive">
                              <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Student Name</th>
                                    <th>Student Reg No</th>
                                    <th>Student Contact</th>
                                    <th>Student Department</th>
                                    <th>Student Year & Semester</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>{{ $list -> name }}</td>
                                    <td>{{ $list -> reg_name }}</td>
                                    <td>Phone: {{ $list -> phone }} <br> Email: {{ $list -> email }}</td>
                                    @foreach ( $getdepartment as $department)
                                        @if($department -> departmentId == $list -> departmentId_fk)
                                            <td>{{ $list -> department_name }}</td>
                                        @endif
                                    @endforeach
                                    <td>Year: {{ $list -> year }} <br> Semester: {{ $list -> semester }}</td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
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
     <script>
     function mystudent(){
      var b = document.getElementById("studentview");
      if(b.style.display === "block"){
        b.style.display = "none";
      }
      else{
        b.style.display = "block";
      }
    }
    function myupload(){
            var z = document.getElementById("upload");
            if(z.style.display === "block"){
              z.style.display = "none";
            }
            else{
              z.style.display = "block";
            }
          }
    </script>
    <!-- plugins:js -->
    <script src="../vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="../vendors/chart.js/Chart.min.js"></script>
    <script src="../js/jquery.cookie.js" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../js/off-canvas.js"></script>
    <script src="../js/hoverable-collapse.js"></script>
    <script src="../js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="../js/dashboard.js"></script>
    <script src="../js/todolist.js"></script>
    <!-- End custom js for this page -->
    <script src="../js/file-upload.js"></script>
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
