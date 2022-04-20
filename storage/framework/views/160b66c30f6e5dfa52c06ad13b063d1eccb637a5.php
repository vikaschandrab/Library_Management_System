<div id="myDIV3">
    <form class="pt-3" method="GET" name="EnterNewPass" id="EnterNewPass" action="/forgotpassword" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <h6 class="font-weight-bold" style="text-align: center;">Enter New Password</h6>
        <div class="form-group">
            <input type="password" class="form-control form-control-lg <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="password" name="password" placeholder="Create Password" required autocomplete="off">
            <?php $__errorArgs = ['password'];
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
        <div class="form-group">
            <input type="password" class="form-control form-control-lg" id="RePassword" name="RePassword" placeholder="Confirm Password">
        </div>
        <div class="mt-3">
            <button class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" type="submit" name="EnterPass" id="EnterPass" value="EnterPass">Verify OTP</button>
        </div>
    </form>
</div>
<?php /**PATH G:\nxtGIO projects\EWDP\LMS_Web\Library_Management_System\resources\views/Register_Login/EnterNewPassword.blade.php ENDPATH**/ ?>