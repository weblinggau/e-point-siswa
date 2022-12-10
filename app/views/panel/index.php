<div class="row">
    <div class="col-lg-12">
        <div class="card card-green card-outline">
            <div class="card-body">
                <center><h5>Selamat Datang Kembali Pada Aplikasi Point Pelanggaran Siswa</h5></center>
                <div class="mt-5 mb-5" style="text-align: center;">
                </div>

	            <div class="row">
	            	<div class="col-lg-6">
	            		<div class="card">
	            			<div class="card-header text-center"> Siswa Dengan Skor Pelanggaran Tertinggi</div>
	            			<div class="card-body table-responsive">
	            				<table class="table table-bordered table-head-fixed text-nowrap">
	                              <thead>                  
	                                <tr>
	                                  <th style="width: 10px">No</th>
	                                  <th>Nama Pelanggaran</th>
	                                  <th>Skor Pelangaran</th>
	                                </tr>
	                              </thead>
	                              <tbody id="wid1">
	                              </tbody>
	                            </table>
	            			</div>
	            		</div>
	            	</div>
	            	<div class="col-lg-6">
	            		<div class="card">
	            			<div class="card-header text-center"> Siswa Dengan Jumlah Pelanggran Terbanyak</div>
	            			<div class="card-body table-responsive">
	            				<table class="table table-bordered table-head-fixed text-nowrap">
	                              <thead>                  
	                                <tr>
	                                  <th style="width: 10px">No</th>
	                                  <th>Nama Pelanggaran</th>
	                                  <th>Jumlah Pelangaran</th>
	                                </tr>
	                              </thead>
	                              <tbody id="wid2">
	                              </tbody>
	                            </table>
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
        var api =  "<?= BASEURL."/api/panel"?>"

        var datas = {
             action:'wid1'
        };
        var atrs = {
                  atr:"#wid1",
                  html:'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>',
          }
        SingleAjax(datas,api,atrs);


        var data = {
             action:'wid2'
        };
        var atr = {
                  atr:"#wid2",
                  html:'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>',
          }
        SingleAjax(data,api,atr);
  });
</script>