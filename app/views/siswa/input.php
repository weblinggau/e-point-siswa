<div class="row">
          <div class="col-lg-8">
          	<div class="card card-green card-outline">
              <div class="card-body">
                <div class="mt-5 mb-5" style="text-align: center;">
                  <div class="table-responsive">
                      <table class="table table-bordered" id="tableinputsiswa" width="100%" cellspacing="0">
                          <thead>
                              <tr>
                                  <th>No</th>
                                  <th>Nama Siswa</th>
                                  <th>NISN</th>
                                  <th>Tahun Masuk</th>
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
                <button data-toggle="modal" data-target="#tambah" type="button" class="btn btn-info mt-1"><i class="fa fa-user" ></i> Tambah Siswa</button>
                <button data-toggle="modal" data-target="#import" type="button" class="btn btn-warning mt-1 ml-1"><i class="fa fa-user" ></i> Import Data</button>
                <button data-toggle="modal" data-target="#upload" type="button" class="btn btn-success mt-1 ml-1"><i class="fa fa-user" ></i> Upload Data</button>
              </div>
            </div>
          </div>
</div>

<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Siswa</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formtambah">
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" class="form-control" id="nama" required>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label>NISN</label>
                            <input type="number" class="form-control" id="nisn" required>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label>Tahun Masuk</label>
                            <input type="number" class="form-control" id="tahun" required>
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

    <div class="modal fade" id="upload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Data</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="formupload">
                <div class="modal-body">
                    <div class="text-center"><p>Silahakn Pilih Kelas Untuk Melanjutkan Upload</p></div>
                    <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label>Kelas Siswa</label>
                            <select class="form-control" id="kelasInput">
                            </select>
                          </div>
                        </div>
                      </div>
                </div>
                <div class="modal-footer">
                    <button id="btnupload" type="submit" class="btn btn-info">Upload</button>
                </form>
                </div>
                
            </div>
        </div>
    </div>

    <div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Data</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                      <div class="col-12">
                        <a class="btn btn-block btn-info" href="<?= BASEURL.('/public/upload/contoh.xlsx'); ?>" download>Download Template Excel</a>
                      </div>
                    </div>
                    <form id="formulirimport" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="customFile">Import File Excel</label>
                        <div class="custom-file">
                          <input type="file" name="file" class="custom-file-input" id="customFile">
                          <label class="custom-file-label" for="customFile">upload File</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btnimport" type="submit" class="btn btn-info">Import Data</button>
                </form>
                </div>
                
            </div>
        </div>
    </div>
<script src="<?= BASEURL.('/public/');?>plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
        var fetch = "<?= BASEURL."/api/inputsiswa"?>";
        var api =  "<?= BASEURL."/api/siswa"?>"
        table = $('#tableinputsiswa').DataTable({
            processing: true,
            serverSide: true,
            ajax:{
              type : 'post',
              url : fetch,  
            } 
        });

        bsCustomFileInput.init();
        var datas = {
             action:'getkelas'
        };
        var atrs = {
                  atr:"#kelasInput",
                  html:'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>',
          }
        SingleAjax(datas,"<?= BASEURL."/api/siswa"?>",atrs);

        $("#datas").on('click', '#hapus' ,function(e) {
          var idsiswa = $(e.currentTarget).attr("idsiswa");
          var atribut = '[idsiswa='+$(e.currentTarget).attr("idsiswa")+']';
          var array = {
                action:'hapus',
                idsiswa:idsiswa,
            }
          var atr = {
                atr:atribut,
                html:'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>',
                fh:'<i class="fa fa-trash" ></i>',
                table:"active",
                tbl:"#tableinputsiswa"
          }
          apiAjax(array,api,fetch,atr)
        })

        $("#formupload").submit(function(e){
            e.preventDefault();
            var array = {
                action:'upload',
                kelas:$('#kelasInput').val(),
            }
            if ($('#kelasInput').val() === '0') {
              toastr.error('Kelas harus dipilih !');
            }else{
              var atr = {
                atr:"#btnupload",
                html:'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>',
                fh:"Upload",
                table:"active",
                tbl:"#tableinputsiswa"
              }
              apiAjax(array,api,fetch,atr)
              $('#upload').modal('hide')
            }
        });

        $("#formtambah").submit(function(e){
            e.preventDefault();
            var array = {
                action:'tambah',
                nama:$('#nama').val(),
                nis:$('#nisn').val(),
                tahun:$('#tahun').val(),
            }
            if ($('#nama').val() === '') {
              toastr.error('Masukan nama siswa terlebih dahulu !');
            }else if($('#nisn').val() === ''){
              toastr.error('Masukan nisn terlebih dahulu !');
            }else{
              var atr = {
                atr:"#btnadd",
                html:'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>',
                fh:"Tambah",
                table:"active",
                tbl:"#tableinputsiswa"
              }
              apiAjax(array,api,fetch,atr)
              $('#nama').val('')
              $('#nisn').val('')
              $('#tahun').val('')
              $('#tambah').modal('hide')

            }
        });

         $("#formulirimport").submit(function(e){
                e.preventDefault();
                var file_data = $('.custom-file-input').prop('files')[0];
                var array = new FormData();
                array.append('file', file_data);
                array.append('action', 'import');
                var atr = {
                  atr:"#btnimport",
                  html:'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>',
                  fh:"Import Data",
                  table:"active",
                  tbl:"#tableinputsiswa"
                }
                apiImport(array,api,fetch,atr)
                $('#customFile').val('')
                $('#import').modal('hide')
          });
    });
</script>