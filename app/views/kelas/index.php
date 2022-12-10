<div class="row">
          <div class="col-lg-8">
          	<div class="card card-green card-outline">
              <div class="card-body">
                <div class="mt-5 mb-5" style="text-align: center;">
                  <div class="table-responsive">
                      <table class="table table-bordered" id="tablekelas" width="100%" cellspacing="0">
                          <thead>
                              <tr>
                                  <th>No</th>
                                  <th>Kelas</th>
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
                <button data-toggle="modal" data-target="#tambah" type="button" class="btn btn-info"><i class="fa fa-user" ></i> Tambah Kelas</button>
              </div>
            </div>
          </div>
</div>

<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kelas</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formtambah">
                        <div class="form-group">
                          <label>Nama Kelas</label>
                          <input type="text" class="form-control" id="nama" required>
                        </div>
                    
                </div>
                <div class="modal-footer">
                    <button id="btnadd" type="submit" class="btn btn-info">Tambah</button>
                </form>
                </div>
                
            </div>
        </div>
    </div>


    <div class="modal fade" id="editkelas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Kelas</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="formedit">
                <div class="modal-body" id="dataedit">
                </div>
                <div class="modal-footer">
                    <button id="btnedit" type="submit" class="btn btn-info">Edit</button>
                    
                </form>
                </div>
                
            </div>
        </div>
    </div>

<script type="text/javascript">
  $(document).ready(function(){
        var fetch = "<?= BASEURL."/api/kelaslist"?>";
        var api =  "<?= BASEURL."/api/kelas"?>"
        table = $('#tablekelas').DataTable({
            processing: true,
            serverSide: true,
            ajax:{
              type : 'post',
              url : fetch,  
            } 
        });

        $("#datas").on('click', '#hapus' ,function(e) {
          var idkelas = $(e.currentTarget).attr("idkelas");
          var atribut = '[idkelas='+$(e.currentTarget).attr("idkelas")+']';
          var array = {
                action:'hapus',
                idkelas:idkelas,
            }
          var atr = {
                atr:atribut,
                html:'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>',
                fh:'<i class="fa fa-trash" ></i>',
                table:"active",
                tbl:"#tablekelas"
          }
          apiAjax(array,api,fetch,atr)

        
        })

        $('#editkelas').on('show.bs.modal', function (e) {
           var idkelas = $(e.relatedTarget).attr("idkelas");
           var array = {
                action:'praedit',
                id:idkelas,
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
                action:'updateKelas',
                idkelas:$('#idKelas').val(),
                nama:$('#namaKelas').val()
            }
            var atr = {
                atr:"#btnedit",
                html:'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>',
                fh:"Edit",
                table:"active",
                tbl:"#tablekelas"
            }
            apiAjax(array,api,fetch,atr)
              $('#editkelas').modal('hide')
        })

        $("#formtambah").submit(function(e){
            e.preventDefault();
            var array = {
                action:'tambah',
                nama:$('#nama').val(),
            }
            if ($('#nama').val() === '') {
               toastr.error('Masukan nama kelas terlebih dahulu !');
            }else{
              var atr = {
                atr:"#btnadd",
                html:'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>',
                fh:"Tambah",
                table:"active",
                tbl:"#tablekelas"
              }
              apiAjax(array,api,fetch,atr)
              $('#nama').val('')
              $('#tambah').modal('hide')

            }
        });
    });
</script>