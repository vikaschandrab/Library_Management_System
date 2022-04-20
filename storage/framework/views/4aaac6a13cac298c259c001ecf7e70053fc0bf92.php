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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <style>
    #submitOTP {
    display:none;
    }
    #EnterNewPass {
    display:none;
    }
    </style>
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <h4 style="text-align: center;">Library Management System</h4>
                <form class="pt-3" method="GET" name="EnterEmail" id="EnterEmail" enctype="multipart/form-data">
                    <?php echo e(csrf_field()); ?>

                    <h6 class="font-weight-bold" style="text-align: center;">Forgot Password</h6>
                    <div class="form-group">
                        <input type="email" class="form-control form-control-lg <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="email" name="email" placeholder="Enter Valid Email" value="<?php echo e(old('email')); ?>" required autocomplete="off" autofocus>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback" role="alert">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <div class="mt-3">
                        <button class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" type=submit name="submit" id="submit" value="submit">Request OTP</button>
                    </div>
                </form>
                <div id="Enter_Otp">
                    <?php echo $__env->make('Register_Login.EnterOTP', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div id="Enter_new_Password">
                    <?php echo $__env->make('Register_Login.EnterNewPassword', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
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

    <script src="../vendors/jquery/jquery-3.2.1.min.js"></script>
    <script src="../js/main.js"></script>
    <script>
        $("#EnterEmail").on("submit",function(e){
        var Email = document.getElementById("email").value;
            document.getElementById('emailId').innerHTML = Email;
        e.preventDefault();
        });
    </script>

    <script>
        <?php if(session('status')): ?>
            swal({
                title: ' <?php echo e(session('status')); ?>',
                icon: "error",
                button: "Done",
            });
        <?php endif; ?>
    </script>

    <script>
        $("#EnterEmail").on("submit",function(e){
            var dataString=$(this).serialize();
            $.ajax({
                type:"GET",
                url:"/requestOTP",
                data:dataString,
                success:function(data)
                {
                    var AObj = JSON.parse(JSON.stringify(data));

                switch (AObj.IsSuccess) {
                    case "1":
                    swal({
                                        title: 'Email Does not exits',
                                        icon: "error",
                                        button: "Done",
                                    });
                        break;
                    case "2":
                                    var x1 = document.getElementById("submitOTP");
                            if (x1.style.display === "block") {
                                document.getElementById("EnterEmail").style.display = "block";
                                x1.style.display = "none";
                                } else {
                                document.getElementById("EnterEmail").style.display = "none";
                                x1.style.display = "block";
                                }
                        break;
                        default:
                        swal({
                                        title: 'Something Went Wrong Please Try Again Later',
                                        icon: "error",
                                        button: "Done",
                                    });
                        break;
                    }
                }
            });
            e.preventDefault();
        });
    </script>

    <script>
     $("#submitOTP").on("submit",function(e){
            var dataString=$(this).serialize();
            $.ajax({
            // alert("Requested OTP");
                type:"GET",
                url:"/verifyOTP",
                data:dataString,
                success:function(data)
                {
                    // console.log(data);
                    var AObj = JSON.parse(JSON.stringify(data));
                    // console.log(AObj);
                    // alert(AObj);
                    // var switchValue =JSON.stringify(AObj.IsSuccess);

                switch (AObj.IsSuccess) {
                    case "3":
                    swal({
                                        title: 'Email Does not Exits',
                                        icon: "error",
                                        button: "Done",
                                    });
                        break;
                    case "5":
                    swal({
                                        title: 'Invalid OTP',
                                        icon: "error",
                                        button: "Done",
                                    });
                        break;
                    case "4":
                                    var x1 = document.getElementById("EnterNewPass");
                            if (x1.style.display === "block") {
                                document.getElementById("submitOTP").style.display = "block";
                                x1.style.display = "none";
                                } else {
                                document.getElementById("submitOTP").style.display = "none";
                                x1.style.display = "block";
                                }
                        break;
                        default:
                        swal({
                                        title: 'Something Went Wrong Please Try Again Later',
                                        icon: "error",
                                        button: "Done",
                                    });
                        break;
                    }
                }
            });
            e.preventDefault();
        });
    </script>

    <script>
        $("#EnterNewPass").on("submit",function(e){
               var dataString=$(this).serialize();
               $.ajax({
               // alert("Requested OTP");
                   type:"GET",
                   url:"/NewPass",
                   data:dataString,
                   success:function(data)
                   {
                    var AObj = JSON.parse(JSON.stringify(data));
                    console.log(AObj);
                    switch (AObj.IsSuccess) {
                    case "6":
                    window.location = '/login';
                    function preventBack() {
                window.history.forward();
            }

            setTimeout("preventBack()", 0);

            window.onunload = function () { null };
                       swal({
                                           title: 'Password Changed Successfully',
                                           icon: "success",
                                           button: "Done",
                                       });
                    break;
                    case "7":
                    swal({
                                        title: 'Password Did not Match',
                                        icon: "error",
                                        button: "Done",
                                    });
                        break;

                   }
                   }
               });
               e.preventDefault();
           });
       </script>
  </body>
</html>
<?php /**PATH G:\nxtGIO projects\EWDP\LMS_Web\Library_Management_System\resources\views/Register_Login/forgotpwd.blade.php ENDPATH**/ ?>