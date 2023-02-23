const flashData = $('.flash-data').data('flashdata');
  if (flashData) {
    Swal.fire({
    title: 'Berhasil!',
    text: flashData,
    type: 'success'
  })
}

$('.tombol-hapus').on('click', function(e){
  e.preventDefault();
  const hrefHapus = $(this).attr('href');

    Swal.fire({
    title: 'Apakah anda yakin?',
    text: "Data yang telah terhapus masih dapat diaktifkan kembali",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, Hapus!'
  }).then((result) => {
    if (result.value) {
      document.location.href = hrefHapus;
    }
  })
})

//AWAL PILIH PROV KAB KEC DESA ALL
$(document).on("change", ".action_wilayah", function() {
  if($(this).val() != '')
  {
   var action = $(this).attr("id");
   var query = $(this).val();
   var result = '';
   if(action == "id_prov")
   {
    result = 'id_kab';
   }
   fetchDataWilayah(action, query, result);
  }
 });

function fetchDataWilayah(action, query, result){
  $.ajax({
    url : base_url+'lahan/fetch',
    method:"POST",
    data:{postaction:action, query:query},
    success:function(data){
     $('#'+result).html(data);
    }
  })
}
//AKHIR PILIH PROV KAB KEC DESA ALL

//AWAL CABANG
  $("#cancelcabang").hide();
  $("#ubahcabang").hide();
  $("#txt-ubah-cabang").hide();
  $('.status_cabang').hide();
//AKHIR CABANG

$(document).ready( function () {
  // AWAL DATATABLE      
  $('#cabang').DataTable();
  // AKHIR DATATABLE

  $(".select2").each(function(){
        $(this).select2({
          placeholder: ($(this).attr("data-placeholder") ? $(this).attr("data-placeholder") : "Pilih"),
          multiple: ($(this).attr("data-multiple") === "true" ? true : false),
          maximumselectionlength: ($(this).attr("data-maximumselectionlength") ? $(this).attr("data-maximumselectionlength") : 0),
        })
    });
});

//AWAL AJAX CABANG
function pilihdataCabang(idx){
  $("#cancelcabang").show();
  $("#ubahcabang").show();
  $("#tambahcabang").hide();
  $("#txt-ubah-cabang").show();
  $("#txt-tambah-cabang").hide();
  $('.form-text').hide();

  $.ajax({
    type: "POST",
    data: "id="+idx,
    url : base_url+'cabang/getData',
    beforeSend: function(){
      $("#id_kab").html("");
    },
    success : function(result){
      var objResult=JSON.parse(result);
      $("#id_plant").val(objResult.id_plant).trigger("change");
      $("#kode_cabang").val(objResult.kode_cabang);
      $("#nama_cabang").val(objResult.nama_cabang);
      $("#id_prov").val(objResult.id_prov).trigger("change.select2");
      $('.status_cabang').show();
      $("#id2").val(objResult.id);
      $('#ubah_form_cabang').attr('action', base_url+"cabang/ubahData");
      if (objResult.aktif == 1){
        console.log('aktif');
        document.getElementById("aktif").checked = true;
        document.getElementById("nonaktif").checked = false;      
      }else{
        document.getElementById("nonaktif").checked = true;
        document.getElementById("aktif").checked = false;
      }
      $.each(objResult.kab, function(i,v){
        $("#id_kab").append("<option value='"+v.id+"'>"+v.nama_kab+"</option>");          
      });
      $("#id_kab").val(objResult.id_kab);
    }
  });
}

$("#cancelcabang").click(function(event) {
  $("#cancelcabang").hide();
  $("#ubahcabang").hide();
  $("#tambahcabang").show();
  $("#txt-ubah-cabang").hide();
  $("#txt-tambah-cabang").show();
  $('#ubah_form_cabang').attr('action', base_url+"cabang/tambahcabang");
  $("#id_plant").val("");
  $("#kode_cabang").val("");
  $("#nama_cabang").val("");
  $("#id_prov").val("");
  $("#id_kab").html("<option value=''>Pilih Kabupaten</option>");
  $('.status_cabang').hide();
});
//AKHIR AJAX CABANG

//AWAL AJAX CABANG
$(document).on("change", ".pilih_cabang", function() {
  if($(this).val() != '')
  {
   var action = $(this).attr("id");
   var query = $(this).val();
   var result = '';
   if(action == "id_plant")
   {
    result = 'id_cabang';
   }
   fetchDataCabang(action, query, result);
  }
 });

function fetchDataCabang(action, query, result){
$.ajax({

    url : base_url+'plant/fetch',
    method:"POST",
    data:{postaction:action, query:query},
    success:function(data){
     $('#'+result).html(data);
    }
  })
}
//AKHIR AJAX CABANG

