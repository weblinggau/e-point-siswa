<div class="row">
  <div class="col-lg-12">
    <div class="card card-green card-outline">
        <div class="card-body">
          <div class="row">
            <div class="col-lg-6">
              <div class="card">
                <div class="card-body">
                    <p class="text-center">Silahkan Filter Data</p>
                    <div class="row">
                        <div class="col-lg-12">
                          <form id="formfilter">
                          <div class="form-group">
                            <label>Filter Kelas</label>
                            <select class="form-control" id="filterkelas">
                              <option>pilih</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <button type="submit" id="filterbtn" class="btn btn-success mt-1">Filter Data</button>
                          </div>
                        </form>
                        </div>
                    </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <?php 
                    if ($_SESSION['role'] == 'guru' || $_SESSION['role'] == 'kepsek') {
                     ?>
                    <div class="col-lg-6 ">
                        <button id="download" type="button" class="btn btn-warning mt-1"><i class="fa far fa-edit" ></i> Download Data</button>
                    </div>
                    <?php }else{ ?>
                    <div class="col-lg-6 ">
                        <a href="<?= BASEURL.'/siswa/input'; ?>" type="button" class="btn btn-info"><i class="fa far fa-edit" ></i> Tambah Siswa</a>
                    </div>
                    <div class="col-lg-6 ">
                        <button id="download" type="button" class="btn btn-warning mt-1"><i class="fa far fa-edit" ></i> Download Data</button>
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
            
        </div>
    </div>
  </div>
</div>

<div class="row">
          <div class="col-lg-12">
          	<div class="card card-green card-outline">
              <div class="card-body">
                <div class="mt-5 mb-5" style="text-align: center;">
                  <div class="table-responsive">
                      <table class="table table-bordered" id="tablesiswa" width="100%" cellspacing="0">
                          <thead>
                              <tr>
                                  <th>No</th>
                                  <th>Nama Siswa</th>
                                  <th>NISN</th>
                                  <th>Kelas</th>
                                  <th>Jumlah Pelanggaran</th>
                                  <th>Total Skor Pelanggaran</th>
                                  <th>Detail</th>
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
</div>

<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Pelanggaran</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formtambah">
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label>Nama Pelanggaran</label>
                            <input type="text" class="form-control" id="nama" required>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label>Skor Pelanggaran</label>
                            <input type="number" class="form-control" id="point">
                          </div>
                        </div>
                      </div>
                    
                </div>
                <div class="modal-footer">
                    <button id="btnadd" type="submit" class="btn btn-info">Tambah</button>
                </form>
                </div>
                
            </div>
        </div>
    </div>


    <div class="modal fade" id="editsiswa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Siswa</h5>
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

    <div class="modal fade" id="detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Pelanggaran</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="datadetail">
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-info">Tutup</button>
                </div>
                
            </div>
        </div>
    </div>

<script type="text/javascript">
  $(document).ready(function(){
        var fetch = "<?= BASEURL."/api/siswalist"?>";
        var api =  "<?= BASEURL."/api/siswa"?>"
        table = $('#tablesiswa').DataTable({
            processing: true,
            serverSide: true,
            ajax:{
              type : 'post',
              url : fetch,  
            } 
        });


        var datas = {
             action:'getkelas'
        };
        var atrs = {
                  atr:"#filterkelas",
                  html:'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>',
          }
        SingleAjax(datas,"<?= BASEURL."/api/siswa"?>",atrs);


        $("#datas").on('click', '#hapus' ,function(e) {
          var idsiswa = $(e.currentTarget).attr("idsiswas");
          var atribut = '[idsiswas='+$(e.currentTarget).attr("idsiswas")+']';
          var array = {
                action:'hapus', 
                idsiswa:idsiswa,
            }
          var atr = {
                atr:atribut,
                html:'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>',
                fh:'<i class="fa fa-trash" ></i>',
                table:"active",
                tbl:"#tablesiswa"
          }
          apiAjax(array,api,fetch,atr)

        
        })

        $('#editsiswa').on('show.bs.modal', function (e) {
           var idsiswa = $(e.relatedTarget).attr("idsiswa");
           var array = {
                action:'praedit',
                id:idsiswa,
            }
            var atr = {
                atr:"#dataedit",
                html:'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>',
                content:"#dataedit",
                type:"content"
              }
            apiAjax(array,api,fetch,atr)


        })

        $('#detail').on('show.bs.modal', function (e) {
           var idsiswa = $(e.relatedTarget).attr("idsiswa");
           var array = {
                action:'detail',
                id:idsiswa,
            }
            var atr = {
                atr:"#datadetail",
                html:'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>',
                content:"#datadetail",
                type:"content"
              }
            apiAjax(array,api,fetch,atr)


        })

        $("#formedit").submit(function(e){
            e.preventDefault();
            var array = {
                action:'updateSiswa',
                idsiswa:$('#siswaEdit').val(),
                nama:$('#namaSiswa').val(),
                nis:$('#nisnSiswa').val(),
                kelas:$('#kelasSiswa').val(),
                tahun:$('#tahunSiswa').val(),
            }
            var atr = {
                atr:"#btnedit",
                html:'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>',
                fh:"Edit",
                table:"active",
                tbl:"#tablesiswa"
            }
            apiAjax(array,api,fetch,atr)
              $('#editsiswa').modal('hide')
        })

        $("#formfilter").submit(function(e){
            e.preventDefault();
            var array = {
                action:'filterAdd',
                keyword:$('#filterkelas').val()
            }
            var atr = {
                atr:"#filterbtn",
                html:'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>',
                fh:"Filter Data",
                table:"active",
                tbl:"#tablesiswa"
            }
            apiAjax(array,api,fetch,atr)
        })

        $('#download').on('click',function(e) {
            e.preventDefault(); 
            var array = {
                action:'download',
            }
            var atr = {
                atr:"#download",
                html:'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>',
                fh:'<i class="fa far fa-edit" ></i> Download Data',
                maker:'export'
            }
            AjaxEdit(array,api,fetch,atr)
            // window.location.href = 'uploads/file.doc';

        })
    });
</script>