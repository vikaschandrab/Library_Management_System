<div id="myDIV3">
    <form class="pt-3" method="GET" name="EnterNewPass" id="EnterNewPass" action="/forgotpassword" enctype="multipart/form-data">
        @csrf
        <h6 class="font-weight-bold" style="text-align: center;">Enter New Password</h6>
        <div class="form-group">
            <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" id="password" name="password" placeholder="Create Password" required autocomplete="off">
            @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
            @enderror
        </div>
        <div class="form-group">
            <input type="password" class="form-control form-control-lg" id="RePassword" name="RePassword" placeholder="Confirm Password">
        </div>
        <div class="mt-3">
            <button class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" type="submit" name="EnterPass" id="EnterPass" value="EnterPass">Verify OTP</button>
        </div>
    </form>
</div>
