<div class="row">
          <div class="col-lg-12">
            <div class="card card-green card-outline">
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="card">
                      <div class="card-body text-center">
                        <h1>Ubah Password</h1>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="card">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-lg-6">
                            <form id="formpassword">
                            <div class="form-group">
                              <label>Password Lama</label>
                             <input type="password" class="form-control" id="passlama" required>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label>Password Baru</label>
                              <input type="password" class="form-control" id="passbaru" required>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-6">
                            <button id='kirim' type="submit" class="btn btn-warning mt-1"><i class="fa far fa-edit" ></i> Ubah Password</button>
                          </div>
                        </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
</div>


<script type="text/javascript">
  $(document).ready(function(){
        var fetch = "";
        var api =  "<?= BASEURL."/api/ubahpassword"?>";
        $("#formpassword").submit(function(e){
            e.preventDefault();
            var array = {
                action:'ubahpassword',
                passlama:$('#passlama').val(),
                passbaru:$('#passbaru').val(),
            }
            if (array.passlama === '') {
              toastr.error('Password lama harus dimasukan');
            }else if(array.passbaru === ''){
              toastr.error('Password baru tidak boleh kosong');
            }else{
              var atr = {
                atr:"#kirim",
                html:'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>',
                fh:'<i class="fa far fa-edit" ></i> Ubah Password',
                maker: 'export'
              }
              AjaxEdit(array,api,fetch,atr)
              $("#passlama").val('');
              $("#passbaru").val('');
            }
        });
    });
</script>