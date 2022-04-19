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

    <style>
      #bookview{
      display: none;
    }
    #requestview{
        display: none;
    }
    #returnview{
        display: none;
    }
    #requestedbooks{
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
        <!-- partial:partials/_sidebar.html -->
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
                <span class="menu-title">Borrow and Return Book</span>
                <i class="fa-solid fa-book menu-icon"></i>
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
                </span> Borrow Book
              </h3>

            </div>
            <div class="row">
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                  <div class="card-body" onclick="mybook()">
                    <img src="../images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Borrow New Books<i class="float-right">{{ $countBooks }}</i>
                    </h4>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                  <div class="card-body" onclick="myrequestlist()">
                    <img src="../images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Return Request List<i class="float-right">{{ $countReturnRequest }}</i>
                    </h4>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                  <div class="card-body" onclick="myretunbooks()">
                    <img src="../images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Return Books<i class="float-right">{{ $countReturnBooks }}</i>
                    </h4>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                  <div class="card-body" onclick="myrequestedbooks()">
                    <img src="../images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Requested Books<i class="float-right">{{ $countRequestedBooks }}</i>
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
                          <th>Remaining</th>
                          <th>Book code</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                            @if (count($getBooks) != null)
                                <?php $i=1; ?>
                                @foreach ( $getBooks as $books)
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td class=" text-wrap">{{ $books -> publication }}</td>
                                        <td>{{ $books -> author }}</td>
                                        <td class=" text-wrap">{{ $books -> title }}</td>
                                        <td>{{ $books -> remaining_books }}</td>
                                        <td>{{ $books -> book_code }}</td>
                                        <td>
                                            <a href="#open-modal-editactive-{{ $books -> book_code }}" class="status_btn">Borrow</a>
                                        </td>
                                    </tr>
                                    <?php $i++ ?>
                                @endforeach
                            @else
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>No Books Available</td>
                                    <td></td>
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

            <div class="row" id="requestview">
                <div class="col-lg-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <table class="table table-responsive">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Publication</th>
                            <th>Author</th>
                            <th>Book Code</th>
                            <th>Borrow Date</th>
                            <th>Return Date</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @if (count($ReturnRequest) == null)
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>No Return Request</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @else
                            <?php $i = 1 ?>
                                @foreach ( $ReturnRequest as $list)
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td class=" text-wrap">{{ $list -> title }}</td>
                                        <td class=" text-wrap">{{ $list -> publication }}</td>
                                        <td>{{ $list -> author }}</td>
                                        <td>{{ $list -> book_code }}</td>
                                        <td>{{ $list -> borrow_date }}</td>
                                        <td>{{ $list -> return_date }}</td>
                                        <td>
                                            <a href="#open-modal-editrequest-{{ $list -> booksborrowId }}" class="status_btn">Return</a>
                                        </td>
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

            <div class="row" id="returnview">
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
                            <th>Book code</th>
                            <th>Return Date</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @if(count($ReturnBooks) == null)
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>No Books Due Ro Return</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @else
                            <?php $i = 1 ?>
                                @foreach ( $ReturnBooks as $books )
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td class=" text-wrap">{{ $books -> publication }}</td>
                                        <td>{{ $books -> author }}</td>
                                        <td class=" text-wrap">{{ $books -> title }}</td>
                                        <td>{{ $books -> book_code }}</td>
                                        <td>{{ $books -> return_date }}</td>
                                        <td>
                                            <a href="#open-modal-returnbook-{{ $books -> booksborrowId }}" class="status_btn">Return</a>
                                        </td>
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

              <div class="row" id="requestedbooks">
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
                            <th>Book code</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                            @if(count($requestedBooks) == null)
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>No Books Requested</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @else
                                <?php $i=1; ?>
                                @foreach($requestedBooks as $books)
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td class=" text-wrap">{{ $books -> publication }}</td>
                                        <td>{{ $books -> author }}</td>
                                        <td class=" text-wrap">{{ $books -> title }}</td>
                                        <td>{{ $books -> book_code }}</td>
                                        @if ($books -> isAccepted == '0')
                                            <td>Rejected</td>
                                        @elseif($books -> isAccepted == 1)
                                            <td>Accepted</td>
                                        @elseif($books -> isAccepted == null)
                                            <td>Waiting For Response</td>
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

@foreach ( $getBooks as $books)
<form action="/student/bookRequest" method="post" enctype="multipart/form-data">
    @csrf
    <div id="open-modal-editactive-{{ $books -> book_code }}" class="modal-window">
        <div>
            <a href="#modal-close-edit" title="Close" class="modal-close"> &times;</a>
            <div class="input-field-pop">
                <div class="white_box mb_30">
                    <div class="box_header ">
                        <div class="main-title">
                            <h3 class="mb-0">Borrow Book</h3>
                        </div>
                    </div>
                    <label for="status"></label>
                    <select name="isactive" id="isactive" class="form-control" required>
                        <option>Select Option</option>
                        <option value="1">Borrow Book</option>
                    </select>
                </div>
                <input type="hidden" id="book_code" name="book_code" value="{{ $books -> book_code }}">
            </div> <br>
            <button  class="btn btn-gradient-primary mr-2" type="submit" name="requestbook" id="requestbook">Request</button>
        </div>
    </div>
</form>
@endforeach

@foreach ( $ReturnRequest as $list)
    <form action="/student/bookRequest" method="post" enctype="multipart/form-data">
        @csrf
        <div id="open-modal-editrequest-{{ $list -> booksborrowId }}" class="modal-window">
            <div>
                <div class="input-field-pop">
                    <div class="white_box mb_30">
                        <div class="box_header ">
                            <div class="main-title">
                                <h3 class="mb-0">Request Replay Status</h3>
                            </div>
                        </div>
                        <label for="status"></label>
                        <select name="isactive" id="isactive" class="form-control" required>
                            <option>Select Option</option>
                            <option value="1">Accept Request</option>
                            <option value="0">Reject Request</option>
                        </select>
                    </div>
                    <input type="hidden" name="id" id="id" value="{{ $list -> booksborrowId }}">
                </div> <br>
                <button type="submit"  class="btn btn-gradient-primary mr-2" id="rtnReqRes" name="rtnReqRes">Replay Response</button>
            </div>
        </div>
    </form>
@endforeach

@foreach ( $ReturnBooks as $books )
    <form action="/student/bookRequest" method="POST" enctype="multipart/form-data">
        @csrf
        <div id="open-modal-returnbook-{{ $books -> booksborrowId }}" class="modal-window">
            <div>
                <div class="input-field-pop">
                    <div class="white_box mb_30">
                        <div class="box_header ">
                            <div class="main-title">
                                <h3 class="mb-0">Return Book</h3>
                            </div>
                        </div>
                        <label for="status"></label>
                        <select name="isactive" id="isactive" class="form-control" required>
                            <option>Select Option</option>
                            <option value="1">Return</option>
                            <option value="0">Do Not Return</option>
                        </select>
                    </div>
                    <input type="hidden" id="id" name="id" value="{{ $books -> booksborrowId }}">
                </div> <br>
                <button type="submit" id="updatereturn" name="updatereturn"  class="btn btn-gradient-primary mr-2">Update</button>
            </div>
        </div>
    </form>
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
     function myrequestlist(){
      var b = document.getElementById("requestview");
      if(b.style.display === "block"){
        b.style.display = "none";
      }
      else{
        b.style.display = "block";
      }
     }
     function myretunbooks(){
      var c = document.getElementById("returnview");
      if(c.style.display === "block"){
        c.style.display = "none";
      }
      else{
        c.style.display = "block";
      }
     }
     function myrequestedbooks(){
      var d = document.getElementById("requestedbooks");
      if(d.style.display === "block"){
        d.style.display = "none";
      }
      else{
        d.style.display = "block";
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
    <script>
        @if (session('failure'))
            swal({
            title: ' {{ session('failure') }}',
            icon: "error",
            button: "Done",
            });
        @endif
    </script>
  </body>
</html>
