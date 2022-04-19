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
  </head>
  <style>
    #bookview{
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
                <?php if( $Adminprofile -> profilePicture != 0): ?>
                    <img src="../images/admin/<?php echo e($Adminprofile -> profilePicture); ?>" alt="image" width="100px" height="100px">
                <?php else: ?>
                    <img src="../images/profile.png" alt="image" width="100px" height="100px">
                <?php endif; ?>
                  <span class="availability-status online"></span>
                </div>
                <div class="nav-profile-text">
                  <p class="mb-1 text-black"><?php echo e($Adminprofile -> name); ?></p>
                </div>
              </a>
              <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                <a class="dropdown-item" href="/admin/profile">
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
                  <i class="fa-solid fa-book"></i>
                </span> Books
              </h3>

            </div>
            <div class="row">
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body" onclick="mybook()">
                    <img src="../images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Books <i class="float-right"><?php echo e($booksCount); ?></i>
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
                            <th>Remaining</th>
                            <th>Borrowed</th>
                            <th>Book code</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if(count($booksList) != null): ?>
                              <?php $i = 1 ?>
                              <?php $__currentLoopData = $booksList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $books): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <tr>
                                        <td><?php echo $i ?></td>
                                        <td class=" text-wrap"><?php echo e($books->publication); ?></td>
                                        <td><?php echo e($books->author); ?></td>
                                        <td class=" text-wrap"><?php echo e($books->title); ?></td>
                                        <td><?php echo e($books->total_books); ?></td>
                                        <td><?php echo e($books->remaining_books); ?>

                                            <div class="progress">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo e($books->remaining_books); ?>%" aria-valuenow="<?php echo e($books->remaining_books); ?>" aria-valuemin="0" aria-valuemax="<?php echo e($books->total_books); ?>"></div>
                                            </div>
                                        </td>
                                        <td><?php echo e($books->borrowed_books); ?>

                                            <div class="progress">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo e($books->borrowed_books); ?>%" aria-valuenow="<?php echo e($books->borrowed_books); ?>" aria-valuemin="0" aria-valuemax="<?php echo e($books->total_books); ?>"></div>
                                            </div>
                                        </td>
                                        <td><?php echo e($books->book_code); ?></td>
                                  </tr>
                                  <?php $i++ ?>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          <?php else: ?>
                          <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td>No Books Added</td>
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
  </body>
</html>
<?php /**PATH G:\nxtGIO projects\EWDP\LMS_Web\Library_Management_System\resources\views/Admin/dashboard.blade.php ENDPATH**/ ?>