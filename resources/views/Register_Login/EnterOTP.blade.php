<div id="myDIV4">
    <form class="pt-3" method="GET" name="submitOTP" id="submitOTP" action="/forgotpassword" enctype="multipart/form-data">
        @csrf
<h6 class="font-weight-bold" style="text-align: center;">Enter OTP Password</h6>
        <div class="form-group">
            <p class="form-control form-control-lg" type="text" name="emailId" id="emailId" autocomplete="off"></p>
        </div>
        <div class="form-group">
            <input type="text" class="form-control form-control-lg @error('OTP') is-invalid @enderror" id="OTP" placeholder="Enter OTP" name="OTP" oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/(\..*)\./g, '$1');" autocomplete="off" autofocus>
            @error('OTP')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="mt-3">
            <button class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" type="submit" name="verifyOTP" id="verifyOTP" value="verifyOTP">Verify OTP</button>
        </div>
    </form>
</div>
