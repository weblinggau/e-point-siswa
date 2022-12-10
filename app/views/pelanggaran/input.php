<div class="row">
          <div class="col-lg-12">
            <div class="card card-green card-outline">
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="card">
                      <div class="card-body text-center">
                        <h1>Input Pelanggaran Siswa</h1>
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
                            <form id="formtambah">
                            <div class="form-group">
                              <label>Nama Siswa</label>
                             <select class="form-control cari-siswa" id="siswaVal"></select>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label>Jenis Pelanggaran</label>
                              <select class="form-control cari-pelanggaran" id="point"></select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-6">
                            <textarea class="form-control" id="catatan" placeholder="Catatan"></textarea>
                          </div>
                          <div class="col-lg-6">
                            <button id='kirim' type="submit" class="btn btn-warning mt-1"><i class="fa far fa-edit" ></i> Kirim Data</button>
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
        var api =  "<?= BASEURL."/api/pelanggaran"?>";
        $('.cari-siswa').select2({
          theme: 'bootstrap4',
          ajax: {
            type: 'post',
            url: api,
            dataType: "json",
            delay: 250,
            data: function (key) {
              var query = {
                keyword : key.term,
                action : 'getSiswa'  
              }
              return singleEkrip(query);
            },
            processResults  : function (data) {
                  const obj = JSON.parse(JSON.stringify(data));
                  var letsee = {
                      ct: obj.ct,
                      iv: obj.iv,
                      s: obj.s
                  }
                  var odgj = JSON.parse(CryptoJS.AES.decrypt(JSON.stringify(letsee), key, {
                      format: CryptoJSAesJson
                  }).toString(CryptoJS.enc.Utf8));
                 return {
                  results: odgj,
                };
            },
            cache : false            
          }
        });


        $('.cari-pelanggaran').select2({
          theme: 'bootstrap4',
          ajax: {
            type: 'post',
            url: api,
            dataType: "json",
            data: function (key) {
              var query = {
                keyword : key.term,
                action : 'getPelanggaran'  
              }
              return singleEkrip(query);
            },
            processResults  : function (data) {
                  const obj = JSON.parse(JSON.stringify(data));
                  var letsee = {
                      ct: obj.ct,
                      iv: obj.iv,
                      s: obj.s
                  }
                  var odgj = JSON.parse(CryptoJS.AES.decrypt(JSON.stringify(letsee), key, {
                      format: CryptoJSAesJson
                  }).toString(CryptoJS.enc.Utf8));
                 return {results: odgj};
            }
            
          }
        });

        $("#formtambah").submit(function(e){
            e.preventDefault();
            var array = {
                action:'tambahPoint',
                nama:$('#siswaVal').val(),
                point:$('#point').val(),
                catatan:$('#catatan').val(),
            }
            if (array.nama === '') {
              toastr.error('Masukan siswa terlebih dahulu !');
            }else if(array.point === ''){
              toastr.error('Masukan skor pelanggaran terlebih dahulu !');
            }else{
              var atr = {
                atr:"#kirim",
                html:'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>',
                fh:"Kirim Data",
              }
              apiAjax(array,api,fetch,atr)
              $(".cari-siswa").val('').trigger('change') ;
              $(".cari-pelanggaran").val('').trigger('change') ;
            }
        });
    });
</script>