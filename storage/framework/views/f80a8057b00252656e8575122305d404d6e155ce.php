<div id="myDIV4">
    <form class="pt-3" method="GET" name="submitOTP" id="submitOTP" action="/forgotpassword" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
<h6 class="font-weight-bold" style="text-align: center;">Enter OTP Password</h6>
        <div class="form-group">
            <p class="form-control form-control-lg" type="text" name="emailId" id="emailId" autocomplete="off"></p>
        </div>
        <div class="form-group">
            <input type="text" class="form-control form-control-lg <?php $__errorArgs = ['OTP'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="OTP" placeholder="Enter OTP" name="OTP" oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/(\..*)\./g, '$1');" autocomplete="off" autofocus>
            <?php $__errorArgs = ['OTP'];
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
            <button class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" type="submit" name="verifyOTP" id="verifyOTP" value="verifyOTP">Verify OTP</button>
        </div>
    </form>
</div>
<?php /**PATH G:\nxtGIO projects\EWDP\LMS_Web\Library_Management_System\resources\views/Register_Login/EnterOTP.blade.php ENDPATH**/ ?>