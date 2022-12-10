<div class="row">
          <div class="col-lg-8">
          	<div class="card card-green card-outline">
              <div class="card-body">
                <div class="mt-5 mb-5" style="text-align: center;">
                  <div class="table-responsive">
                      <table class="table table-bordered" id="tableuser" width="100%" cellspacing="0">
                          <thead>
                              <tr>
                                  <th>No</th>
                                  <th>Nama</th>
                                  <th>Username</th>
                                  <th>Role</th>
                                  <th>Action</th>
                              </tr>
                          </thead>
                          <tbody id="datas">
                                                  
                          </tbody>
                        </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
          	<div class="card card-green card-outline">
              <div class="card-body">
                <button data-toggle="modal" data-target="#tambah" type="button" class="btn btn-info"><i class="fa fa-user" ></i> Tambah User</button>
              </div>
            </div>
          </div>
</div>

<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formtambah">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label>Nama</label>
                          <input type="text" class="form-control" id="nama" required>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label>Username</label>
                          <input type="text" class="form-control" id="username" required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-6">
                          <label>Role User</label>
                          <select class="form-control" id="role">
                            <option value="superadmin">Superadmin</option>
                            <option value="guru">Guru</option>
                            <option value="kepsek">Kepala Sekolah</option>
                          </select>
                      </div>
                       <div class="col-lg-6">
                          <label>Password</label>
                          <input type="text" class="form-control" id="passwords" required disabled>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a id="generate" class="btn btn-warning">Generate Password</a>
                    <button id="btnadd" type="submit" class="btn btn-info">Tambah</button>
                    
                </form>
                </div>
                
            </div>
        </div>
    </div>


    <div class="modal fade" id="edituser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="formedit">
                <div class="modal-body" id="dataedit">
                </div>
                <div class="modal-footer">
                    <a id="resetpass" class="btn btn-warning">Reset Password</a>
                    <button id="btnedit" type="submit" class="btn btn-info">Edit</button>
                    
                </form>
                </div>
                
            </div>
        </div>
    </div>

<script type="text/javascript">
  $(document).ready(function(){
        var fetch = "<?= BASEURL."/api/userlist"?>";
        var api =  "<?= BASEURL."/api/user"?>"
        table = $('#tableuser').DataTable({
            processing: true,
            serverSide: true,
            ajax:{
              type : 'post',
              url : fetch,  
            } 
        });

        $("#generate").click(function() {
             var psw = PswGnr();
             $('#passwords').val(psw);
             console.log(psw);

        })

        $("#resetpass").click(function() {
             var psw = PswGnr();
             $('#passwordEdit').val(psw);

        })

        $("#datas").on('click', '#hapus' ,function(e) {
          var iduser = $(e.currentTarget).attr("iduser");
          var atribut = '[iduser='+$(e.currentTarget).attr("iduser")+']';
          var array = {
                action:'hapus',
                iduser:iduser,
            }
          var atr = {
                atr:atribut,
                html:'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>',
                fh:'<i class="fa fa-trash" ></i>',
                table:"active",
                tbl:"#tableuser"
          }
          apiAjax(array,api,fetch,atr)

        
        })

        $('#edituser').on('show.bs.modal', function (e) {
           var iduser = $(e.relatedTarget).attr("iduser");
           var array = {
                action:'praedit',
                id:iduser,
            }
            var atr = {
                atr:"#dataedit",
                html:'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>',
                content:"#dataedit",
                type:"content"
              }
            apiAjax(array,api,fetch,atr)


        })

        $("#formedit").submit(function(e){
            e.preventDefault();
            var array = {
                action:'updateUser',
                iduser:$('#iduserEdit').val(),
                nama:$('#namaEdit').val(),
                password:$('#passwordEdit').val(),
                role:$('#roleEdit').val(),
            }
            var atr = {
                atr:"#btnedit",
                html:'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>',
                fh:"Edit",
                table:"active",
                tbl:"#tableuser"
            }
            apiAjax(array,api,fetch,atr)
              $('#edituser').modal('hide')
        })

        $("#formtambah").submit(function(e){
            e.preventDefault();
            var array = {
                action:'tambah',
                nama:$('#nama').val(),
                username:$('#username').val(),
                password:$('#passwords').val(),
                role:$('#role').val(),
            }
            if ($('#passwords').val() === '') {
               toastr.error('Password tidak boleh kosong silahkan generate password !');
            }else{
              var atr = {
                atr:"#btnadd",
                html:'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>',
                fh:"Tambah",
                table:"active",
                tbl:"#tableuser"
              }
              apiAjax(array,api,fetch,atr)
              $('#nama').val('')
              $('#username').val('')
              $('#password').val('')
              $('#tambah').modal('hide')

            }
        });
    });
</script>