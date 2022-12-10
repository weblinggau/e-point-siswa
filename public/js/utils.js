// data,url,fetch,atr
// ss

function singleEkrip(a) {
    var arr = CryptoJS.AES.encrypt(JSON.stringify(a), key, {
        format: CryptoJSAesJson
    }).toString();
    var json = JSON.stringify(arr)
    return json;
}
function loginAjax(a, b, d) {
    $(d.atr).empty();
    $(d.atr).append(d.html);
    $(d.atr).attr("disabled", "");
    var arr = CryptoJS.AES.encrypt(JSON.stringify(a), key, {
        format: CryptoJSAesJson
    }).toString();
    $.ajax({
        type: 'post',
        url: b,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        data: JSON.stringify(arr),
        success: function(data) {
            const obj = JSON.parse(JSON.stringify(data));
            var letsee = {
                ct: obj.ct,
                iv: obj.iv,
                s: obj.s
            }
            var odgj = JSON.parse(CryptoJS.AES.decrypt(JSON.stringify(letsee), key, {
                format: CryptoJSAesJson
            }).toString(CryptoJS.enc.Utf8));
            // console.log(odgj);
            var status = odgj.status;
            if (status === 'error') {
                toastr.error(odgj.pesan);
                $(d.atr).removeAttr("disabled");
                $(d.atr).empty();
                $(d.atr).append(d.fh);
            } else if (status === 'sukses') {
                toastr.success(odgj.pesan);
                // console.log(odgj.href);
                setTimeout(function() {
                    $(location).attr('href', odgj.href);
                }, 600);
            }
        },
        error: function(e, x, settings, exception) {
            var pesanError = {
                '400': "Server understood the request, but request content was invalid.",
                '401': "Unauthorized access.",
                '403': "Forbidden resource can't be accessed.",
                '500': "Internal server error.",
                '503': "Service unavailable."
            };
            if (e.status == 0) {
                toastr.error(e.statusText);
            } else {
                toastr.error(pesanError[e.status]);
            }
            $(d.atr).removeAttr("disabled");
            $(d.atr).empty();
            $(d.atr).append(d.fh);
        }
    });
}

function apiAjax(data,url,fetch,atr) {
  if (atr.type == 'content') {
      $(atr.atr).addClass("text-center");
      $(atr.atr).append(atr.html);
  }else{
      $(atr.atr).empty();
      $(atr.atr).append(atr.html);
      $(atr.atr).attr("disabled","");
  }
  var arr = CryptoJS.AES.encrypt(JSON.stringify(data), key, {format: CryptoJSAesJson}).toString();
  $.ajax({
    type : 'post',
    url : url,
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    data : JSON.stringify(arr),
    success : function(data){
      const obj = JSON.parse(JSON.stringify(data));
      var letsee = {
          ct:obj.ct,
          iv:obj.iv,
          s:obj.s
        }
      var odgj = JSON.parse(CryptoJS.AES.decrypt(JSON.stringify(letsee), key, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8));
      var status = odgj.status;
      if (status === 'error') {
        toastr.error(odgj.pesan);
            $(atr.atr).removeAttr("disabled");
            $(atr.atr).empty();
            $(atr.atr).append(atr.fh);
      }else if (status === 'sukses') {
        if (atr.type == 'content') {
            $(atr.atr).removeClass("text-center");
            $(atr.atr).empty();
            $(atr.content).html(odgj.content);
            if ("fh" in atr) {
              $(atr.atr).append(atr.fh);
            }
        }else{
            toastr.success(odgj.pesan);
            $(atr.atr).removeAttr("disabled");
            $(atr.atr).empty();
            $(atr.atr).append(atr.fh);
        }
      }

      if (atr.table == 'active') {
        table.destroy();
        table = $(atr.tbl).DataTable({
            processing: true,
            serverSide: true,
            ajax:{
              type : 'post',
              url : fetch,  
            } 
        });
      }
    },
    error : function (e, x, settings, exception) {
      var pesanError = {
        '400' : "Server understood the request, but request content was invalid.",
        '401' : "Unauthorized access.",
        '403' : "Forbidden resource can't be accessed.",
        '500' : "Internal server error.",
        '503' : "Service unavailable."
      };
      if (e.status == 0) {
        toastr.error(e.statusText);
      }else {
        toastr.error(pesanError[e.status]);
      }
      $(atr.atr).removeAttr("disabled");
      $(atr.atr).empty();
      $(atr.atr).append(atr.fh);
    }
  });
}

function PswGnr() {
    var chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    var passwordLength = 5;
    var password = "";
    for (var i = 0; i <= passwordLength; i++) {
        var randomNumber = Math.floor(Math.random() * chars.length);
        password += chars.substring(randomNumber, randomNumber +1);
    }
    return password;
}

function SingleAjax(data,url,atr) {
  $(atr.atr).empty();
  $(atr.atr).addClass("text-center");
  $(atr.atr).append(atr.html);
  var arr = CryptoJS.AES.encrypt(JSON.stringify(data), key, {format: CryptoJSAesJson}).toString();
  $.ajax({
    type : 'post',
    url : url,
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    data : JSON.stringify(arr),
    success : function(data){
      const obj = JSON.parse(JSON.stringify(data));
      var letsee = {
          ct:obj.ct,
          iv:obj.iv,
          s:obj.s
        }
      var odgj = JSON.parse(CryptoJS.AES.decrypt(JSON.stringify(letsee), key, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8));
      var status = odgj.status;
      if (status === 'error') {
        toastr.error(odgj.pesan);
        $(atr.atr).removeClass("text-center");
        $(atr.atr).empty();
      }else if (status === 'sukses') {
        $(atr.atr).removeClass("text-center");
        $(atr.atr).empty();
        $(atr.atr).html(odgj.content);
      }
    },
    error : function (e, x, settings, exception) {
      var pesanError = {
        '400' : "Server understood the request, but request content was invalid.",
        '401' : "Unauthorized access.",
        '403' : "Forbidden resource can't be accessed.",
        '500' : "Internal server error.",
        '503' : "Service unavailable."
      };
      if (e.status == 0) {
        toastr.error(e.statusText);
      }else {
        toastr.error(pesanError[e.status]);
      }
      $(atr.atr).removeClass("text-center");
      $(atr.atr).empty();
    }
  });
}

function AjaxEdit(data,url,fetch,atr) {
  $(atr.atr).empty();
  $(atr.input).empty();
  $(atr.atr).append(atr.html);
  var arr = CryptoJS.AES.encrypt(JSON.stringify(data), key, {format: CryptoJSAesJson}).toString();
  $.ajax({
    type : 'post',
    url : url,
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    data : JSON.stringify(arr),
    success : function(data){
      const obj = JSON.parse(JSON.stringify(data));
      var letsee = {
          ct:obj.ct,
          iv:obj.iv,
          s:obj.s
        }
      var odgj = JSON.parse(CryptoJS.AES.decrypt(JSON.stringify(letsee), key, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8));
      var status = odgj.status;
      if (status === 'error') {
        toastr.error(odgj.pesan);
            $(atr.atr).removeAttr("disabled");
            $(atr.atr).empty();
            $(atr.atr).append(atr.fh);
      }else if (status === 'sukses') {
            $(atr.atr).removeAttr("disabled");
            $(atr.atr).empty();
            $(atr.atr).append(atr.fh);
            if (atr.maker === 'pengeluaran') {
              $('#namatrk').val(odgj.content.namatrk);
              $('#jumlah').val(odgj.content.jumlah);
              $('#total').val(odgj.content.total);
              $('#kode').val('');
              var inputs = '<input type="hidden" id="idedittrk" value='+odgj.content.idtrk+'><input type="hidden" id="nomor_trk" value='+odgj.content.nomor_trk+'>';
              $(atr.input).append(inputs);
            }else if (atr.maker === 'stock') {
              $('#namatrk').val(odgj.content.namatrk);
              $('#harga').val(odgj.content.harga);
              var inputs = '<input type="hidden" id="idstockss" value='+odgj.content.idstock+'>';
              $(atr.input).append(inputs);
            }else if (atr.maker === 'inventory') {
              $('#kondisi').empty();
              $('#nama').val(odgj.content.nama)
              $('#harga').val(odgj.content.harga)
              $('#tglbeli').val(odgj.content.tanggal)
              $('#kondisi').append(odgj.content.status);
              var input2 = '<div class="form-group"><label>No Inventory</label><input type="text" class="form-control" value="'+odgj.content.noinventori+'" readonly></div>'
              var inputs = '<input type="hidden" id="idivt" value='+odgj.content.idinvent+'>'+input2;
              $(atr.input).append(inputs);
            }else if (atr.maker === 'produk') {
              $('#produkname').val(odgj.content.nama)
              $('#kodeproduk').val(odgj.content.kodeproduk)
              $('#harga').val(odgj.content.harga)
              if (odgj.content.jnsproduk === 'non_stock') {
                $('#jnsstock').attr("disabled","");
              }else{
                $('#jnsstock').removeAttr("disabled");
                $('#stockview').append(odgj.content.jnsstock)
              }
              $('#produkview').append(odgj.content.jnsproduk)
              var inputs = '<input type="hidden" id="idprodu" value='+odgj.content.idproduk+'>';
              $(atr.input).append(inputs);
            }else if (atr.maker === 'export') {
              toastr.success(odgj.pesan);
              setTimeout(function() {
                    $(location).attr('href', odgj.download);
              }, 400);
            }
      }
      if (atr.table == 'active') {
        table.destroy();
        table = $(atr.tbl).DataTable({
            processing: true,
            serverSide: true,
            ajax:{
              type : 'post',
              url : fetch,  
            } 
        });
      }
    },
    error : function (e, x, settings, exception) {
      var pesanError = {
        '400' : "Server understood the request, but request content was invalid.",
        '401' : "Unauthorized access.",
        '403' : "Forbidden resource can't be accessed.",
        '500' : "Internal server error.",
        '503' : "Service unavailable."
      };
      if (e.status == 0) {
        toastr.error(e.statusText);
      }else {
        toastr.error(pesanError[e.status]);
      }
      $(atr.atr).removeAttr("disabled");
      $(atr.atr).empty();
      $(atr.atr).append(atr.fh);
    }
  });
}

function apiImport(dat,url,fetch,atr) {
  if (atr.type == 'content') {
      $(atr.atr).addClass("text-center");
      $(atr.atr).append(atr.html);
  }else{
      $(atr.atr).empty();
      $(atr.atr).append(atr.html);
      $(atr.atr).attr("disabled","");
  }
  $.ajax({
    type : 'post',
    url : url,
    contentType: false,
    processData: false,
    dataType: "json",
    data : dat,
    success : function(data){
      const obj = JSON.parse(JSON.stringify(data));
      var letsee = {
          ct:obj.ct,
          iv:obj.iv,
          s:obj.s
        }
      var odgj = JSON.parse(CryptoJS.AES.decrypt(JSON.stringify(letsee), key, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8));
      var status = odgj.status;
      if (status === 'error') {
        toastr.error(odgj.pesan);
            $(atr.atr).removeAttr("disabled");
            $(atr.atr).empty();
            $(atr.atr).append(atr.fh);
      }else if (status === 'sukses') {
        if (atr.type == 'content') {
            $(atr.atr).removeClass("text-center");
            $(atr.atr).empty();
            $(atr.content).html(odgj.content);
            if ("fh" in atr) {
              $(atr.atr).append(atr.fh);
            }
        }else{
            toastr.success(odgj.pesan);
            $(atr.atr).removeAttr("disabled");
            $(atr.atr).empty();
            $(atr.atr).append(atr.fh);
        }
      }

      if (atr.table == 'active') {
        table.destroy();
        table = $(atr.tbl).DataTable({
            processing: true,
            serverSide: true,
            ajax:{
              type : 'post',
              url : fetch,  
            } 
        });
      }
    },
    error : function (e, x, settings, exception) {
      var pesanError = {
        '400' : "Server understood the request, but request content was invalid.",
        '401' : "Unauthorized access.",
        '403' : "Forbidden resource can't be accessed.",
        '500' : "Internal server error.",
        '503' : "Service unavailable."
      };
      if (e.status == 0) {
        toastr.error(e.statusText);
      }else {
        toastr.error(pesanError[e.status]);
      }
      $(atr.atr).removeAttr("disabled");
      $(atr.atr).empty();
      $(atr.atr).append(atr.fh);
    }
  });
}