<form action="/admin/updatelibrarian" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row" id="upload">
      <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="form-group">
                <label>File upload</label>
                <input type="file" name="file" class="file-upload-default">
                <div class="input-group col-xs-12">
                  <input type="file-upload-browse" name="file" class="form-control file-upload-info" placeholder="Upload File">
                  <span class="input-group-append">
                    <button class="file-upload-browse btn btn-gradient-primary" type="button">Browse</button>
                  </span>
                </div>
              </div>
          <button type="submit" name="addLibrarian" class="btn btn-gradient-primary mr-2">Submit</button>
          </div>
        </div>
      </div>
    </div>
</form>
