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
  <style>
    #bookview{
      display: none;
    }
    #studentview{
        display: none;
    }
</style>
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
                        @if($getLibrarianProfile -> profilePicture == null)
                            <img src="../images/profile.png" alt="image">
                        @else
                            <img src="../images/librarian/{{ $getLibrarianProfile -> profilePicture }}" alt="image">
                        @endif
                      <span class="availability-status online"></span>
                    </div>
                    <div class="nav-profile-text">
                      <p class="mb-1 text-black">{{ $getLibrarianProfile -> name }}</p>
                    </div>
                  </a>
                  <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="/librarian/profile">
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
              <a class="nav-link" href="/librarian/dashboard">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/librarian/books">
                <span class="menu-title">Books</span>
                <i class="fa-solid fa-book menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/librarian/books-due">
                <span class="menu-title">Request and Due</span>
                <i class="mdi mdi-book-open-page-variant menu-icon"></i>
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
                  <i class="fa-solid fa-book"></i>
                </span> Books
              </h3>
            </div>
            <div class="row">
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body" onclick="mybook();">
                    <img src="../images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Books List<i class="float-right">{{ $getBooksCount }}</i>
                    </h4>
                  </div>
                </div>
              </div>
            </div>
            <div class="row" id="bookview">
                <div class="col-lg-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <table class="table table-responsive">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Publication</th>
                            <th>Author</th>
                            <th>Title</th>
                            <th>Number of books</th>
                            <th>Borrowed</th>
                            <th>Remaining Books</th>
                            <th>Book code</th>
                            <th>Borrow List</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                            @if (count($getBooksList) == null)
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>No Books Added</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @else
                            <?php $i=1 ?>
                                @foreach($getBooksList as $list)
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td class=" text-wrap">{{ $list -> publication }}</td>
                                        <td>{{ $list -> author }}</td>
                                        <td class=" text-wrap">{{ $list -> title }}</td>
                                        <td>{{ $list -> total_books }}</td>
                                        <td>{{ $list -> borrowed_books }}</td>
                                        <td><?php echo  ($list -> total_books - $list -> borrowed_books) ?></td>
                                        <td>{{ $list -> book_code }}</td>
                                        @if( $list -> borrowed_books == 0)
                                            <td> - </td>
                                        @else
                                            <td>
                                                <a href="#open-modal-bowworlist-{{ $list -> booksId }}" class="badge badge-info">List</a>
                                            </td>
                                        @endif
                                        @if ( $list -> status == 1 )
                                            <td>
                                                <a href="#open-modal-editactive-{{ $list -> booksId }}" class="badge badge-success">Active</a>
                                            </td>
                                        @else
                                            <td>
                                                <a href="#open-modal-editactive-{{ $list -> booksId }}" class="badge badge-danger">InActive</a>
                                            </td>
                                        @endif
                                    </tr>
                                    <?php $i++ ?>
                                @endforeach
                            @endif
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
          </div>


@foreach($getBooksList as $list)
    <form action="/librarian/books-update" method="post" enctype="multipart/form-data">
        @csrf
        <div id="open-modal-editactive-{{ $list -> booksId }}" class="modal-window">
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
                        <input type="hidden" name="bookId" id="bookId" value="{{ $list -> booksId }}">
                    </div>
                </div> <br>
                <button class="btn btn-gradient-primary mr-2" type="submit">Update</button>
            </div>
        </div>
    </form>
@endforeach

@foreach ($getBooksList as $list)
    <div id="open-modal-bowworlist-{{ $list -> booksId }}" class="modal-window-pro">
        <div>
            <a href="#modal-close-edit" title="Close" class="modal-close"> &times;</a>
            <div class="input-field-pop">
                <div class="white_box mb_30">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                          <div class="card-body">
                            <table class="table table-responsive">
                              <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Student Name</th>
                                    <th>Student Reg No</th>
                                    <th>Student Contact</th>
                                    <th>Student Department</th>
                                    <th>Student Year & Semester</th>
                                    <th>Borrowed Date</th>
                                    <th>Due Date</th>
                                </tr>
                              </thead>
                              <tbody>
                                  @foreach ( $getborrowlist as $books )
                                    @if ( $list -> booksId == $books -> booksId_fk)
                                        <tr>
                                            <td>1</td>
                                            <td>{{ $books -> name }}</td>
                                            <td>{{ $books -> reg_num }}</td>
                                            <td><b>Phone:</b> {{ $books -> phone }} <br> <b>Email:</b> {{ $books -> email }}</td>
                                            @foreach ( $getdepartment as $department)
                                                @if($department -> departmentId == $books -> departmentId_fk)
                                                    <td class=" text-wrap">{{ $department -> department_name }}</td>
                                                @endif
                                            @endforeach
                                            <td><b>Year:</b> {{ $books -> year }} <br> <b>Semester:</b> {{ $books -> semester }}</td>
                                            <td>{{ $books -> borrow_date }}</td>
                                            <td>{{ $books -> return_date }}</td>
                                        </tr>
                                    @endif
                                  @endforeach
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
     function mybook(){
      var a = document.getElementById("bookview");
      if(a.style.display === "block"){
        a.style.display = "none";
      }
      else{
        a.style.display = "block";
      }
     }
     function mystudent(){
      var b = document.getElementById("studentview");
      if(b.style.display === "block"){
        b.style.display = "none";
      }
      else{
        b.style.display = "block";
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
