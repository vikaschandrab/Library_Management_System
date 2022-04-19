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
    #duebooks{
    	display: none;
    }
    #requeslist{
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
                        <?php if($getLibrarianProfile -> profilePicture == null): ?>
                            <img src="../images/profile.png" alt="image">
                        <?php else: ?>
                            <img src="../images/librarian/<?php echo e($getLibrarianProfile -> profilePicture); ?>" alt="image">
                        <?php endif; ?>
                      <span class="availability-status online"></span>
                    </div>
                    <div class="nav-profile-text">
                      <p class="mb-1 text-black"><?php echo e($getLibrarianProfile -> name); ?></p>
                    </div>
                  </a>
                  <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="/librarian/profile">
                      <i class="mdi mdi-account mr-2 text-success"></i> Profile </a>
                    <div class="dropdown-divider"></div>
                    <form class="modal-content-logout" id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                        <?php echo csrf_field(); ?>
                    <a class="dropdown-item" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="mdi mdi-power mr-2 text-primary"></i> Signout </a>
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
                  <i class="mdi mdi-book-open-page-variant"></i>
                </span> Due
              </h3>
            </div>
            <div class="row">
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body" onclick="mydue()">
                    <img src="../images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Due<i class="float-right"><?php echo e($getDueBooksCount); ?></i>
                    </h4>
                  </div>
                </div>
              </div>
                <div class="col-md-4 stretch-card grid-margin">
                  <div class="card bg-gradient-info card-img-holder text-white">
                    <div class="card-body" onclick="myRequestlist()">
                      <img src="../images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                      <h4 class="font-weight-normal mb-3">Request List<i class="float-right"><?php echo e($getRequestCount); ?></i>
                      </h4>
                    </div>
                  </div>
                </div>
              </div>

            <div class="row" id="duebooks">
                <div class="col-lg-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <table class="table table-responsive">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Book Title</th>
                            <th>Book Code</th>
                            <th>Student Name</th>
                            <th>Borrowed Date</th>
                            <th>Due Date</th>
                            <th>Retrun Request</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php if(count($getDueBooksList) == null): ?>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>No Books Due</td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                        <?php else: ?>
                          <?php $__currentLoopData = $getDueBooksList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <tr>
                              <td>1</td>
                              <td><?php echo e($list -> title); ?></td>
                              <td><?php echo e($list -> book_code); ?></td>
                              <td><a href="#open-modal-students-<?php echo e($list -> studentId); ?>" class="badge badge-info"><?php echo e($list -> name); ?></a></td>
                              <td><?php echo e($list -> borrow_date); ?></td>
                              <td><?php echo e($list -> return_date); ?></td>
                              <?php if($list -> return_request == 0): ?>
                              <td>-</td>
                                <td>
                                    <a href="#open-modal-notify-<?php echo e($list -> booksborrowId); ?>" class="badge badge-danger">Return Request</a>
                                </td>
                              <?php else: ?>
                              <td>Requested</td>
                                <td>-</td>
                              <?php endif; ?>
                          </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row" id="requeslist">
                <div class="col-lg-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <table class="table table-responsive">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Book Title</th>
                            <th>Student Name</th>
                            <th>Student Reg No</th>
                            <th>Student Department</th>
                            <th>Student Contact Details</th>
                            <th>Year & Sem</th>
                            <th>Request Date</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php if(count($getRequestList) != null): ?>
                                <?php $i = 1 ?>
                                    <?php $__currentLoopData = $getRequestList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $books): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo $i ?></td>
                                            <td>
                                                <a href="#open-modal-bookdetails-<?php echo e($books -> booksborrowId); ?>" class="badge badge-warning text-wrap"><?php echo e($books -> title); ?></a>
                                            </td>
                                            <td><a href="#open-modal-student-<?php echo e($books -> studentId_fk); ?>" class="badge badge-info"><?php echo e($books -> name); ?></a></td>
                                            <td><?php echo e($books -> reg_num); ?></td>
                                            <?php $__currentLoopData = $getdepartment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($department -> departmentId == $books -> departmentId_fk): ?>
                                                    <td class=" text-wrap"><?php echo e($department -> department_name); ?></td>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <td><b>Phone:</b> <?php echo e($books -> phone); ?> <br> <b>Email:</b> <?php echo e($books -> email); ?></td>
                                            <td><b>Year:</b> <?php echo e($books -> year); ?> <br> <b>Semester:</b> <?php echo e($books -> semester); ?></td>
                                            <td>10/03/2022</td>
                                            <td>
                                                <a href="#open-modal-reply-<?php echo e($books -> booksborrowId); ?>" class="badge badge-danger">Replay</a>
                                            </td>
                                        </tr>
                                        <?php $i++ ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>No Requests</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
          </div>

        <?php $__currentLoopData = $getRequestList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $books): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <form action="/librarian/reply-request" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div id="open-modal-reply-<?php echo e($books -> booksborrowId); ?>" class="modal-window">
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
                                <option value="1">Accept</option>
                                <option value="0">Reject</option>
                            </select> <br>
                            <input class="form-control" type="date" name="returnDate" id="returnDate" placeholder="Select Return Date">
                        </div>
                        <input type="hidden" id="booksborrowId" name="booksborrowId" value="<?php echo e($books -> booksborrowId); ?>">
                    </div> <br>
                    <button  class="btn btn-gradient-primary mr-2" type="submit" name="replyrequest" id="replyrequest">Reply</button>
                </div>
            </div>
        </form>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php $__currentLoopData = $getDueBooksList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $books): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <form action="/librarian/reply-request" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div id="open-modal-notify-<?php echo e($books -> booksborrowId); ?>" class="modal-window">
                <div>
                    <a href="#modal-close-edit" title="Close" class="modal-close"> &times;</a>
                    <div class="input-field-pop">
                        <div class="white_box mb_30">
                            <div class="box_header ">
                                <div class="main-title">
                                    <h3 class="mb-0">Request Return Book</h3>
                                </div>
                            </div>
                            <label for="status"></label>
                            <select name="isactive" id="isactive" class="form-control" required>
                                <option>Select Option</option>
                                <option value="1">Request Return</option>
                            </select>
                        </div>
                        <input type="hidden" id="booksborrowId" name="booksborrowId" value="<?php echo e($books -> booksborrowId); ?>">
                    </div> <br>
                    <button  class="btn btn-gradient-primary mr-2" type="submit" name="requestreturn" id="requestreturn">Request Return</button>
                </div>
            </div>
        </form>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php $__currentLoopData = $getDueBooksList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lists): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div id="open-modal-students-<?php echo e($lists -> studentId_fk); ?>" class="modal-window-pro">
                <div>
                    <a href="#modal-close-edit" title="Close" class="modal-close"> &times;</a>
                    <div class="input-field-pop">
                        <div class="white_box mb_30">
                            <div class="col-lg-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="box_header ">
                                            <div class="main-title">
                                                <h5 class="mb-0">Name Borrowed Books List</h5>
                                            </div>
                                        </div>
                                        <table class="table table-responsive">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Title</th>
                                                    <th>Publication</th>
                                                    <th>Author</th>
                                                    <th>BookId</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1 ?>
                                                <?php $__currentLoopData = $booksListofStudent; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $books): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if( $lists -> studentId_fk == $books -> studentId_fk): ?>
                                                        <tr>
                                                            <td><?php echo $i ?></td>
                                                            <td><?php echo e($books -> title); ?></td>
                                                            <td><?php echo e($books -> publication); ?></td>
                                                            <td><?php echo e($books -> author); ?></td>
                                                            <td><?php echo e($books -> book_code); ?></td>
                                                        </tr>
                                                        <?php $i++ ?>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php $__currentLoopData = $getDueBooksList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div id="open-modal-student-<?php echo e($list -> studentId); ?>" class="modal-window-pro">
            <div>
                <a href="#modal-close-edit" title="Close" class="modal-close"> &times;</a>
                <div class="input-field-pop">
                    <div class="white_box mb_30">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                              <div class="card-body">
                                <div class="box_header ">
                                    <div class="main-title">
                                        <h5 class="mb-0">Book Name: <?php echo e($list -> title); ?></h5>
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
                                        <td><?php echo e($list -> name); ?></td>
                                        <td><?php echo e($list -> reg_name); ?></td>
                                        <td><b>Phone:</b> <?php echo e($list -> phone); ?> <br> <b>Email:</b> <?php echo e($list -> email); ?></td>
                                        <?php $__currentLoopData = $getdepartment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($department -> departmentId == $list -> departmentId_fk): ?>
                                                <td><?php echo e($department -> department_name); ?></td>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <td><b>Year:</b> <?php echo e($list -> year); ?> <br> <b>Semester:</b> <?php echo e($list -> semester); ?></td>
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
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
     function mydue(){
      var b = document.getElementById("duebooks");
      if(b.style.display === "block"){
        b.style.display = "none";
      }
      else{
        b.style.display = "block";
      }
     }
     function myRequestlist(){
        var c = document.getElementById("requeslist");
      if(c.style.display === "block"){
        c.style.display = "none";
      }
      else{
        c.style.display = "block";
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
        <?php if(session('status')): ?>
            swal({
            title: ' <?php echo e(session('status')); ?>',
            icon: "success",
            button: "Done",
            });
        <?php endif; ?>
    </script>
  </body>
</html>
<?php /**PATH G:\nxtGIO projects\EWDP\LMS_Web\Library_Management_System\resources\views/Librarian/booksDue.blade.php ENDPATH**/ ?>