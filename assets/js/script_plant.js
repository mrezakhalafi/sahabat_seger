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

//AWAL PLANT
  $("#cancelplant").hide();
  $("#ubahplant").hide();
  $("#txt-ubah-plant").hide();
  $('.status_plant').hide();
//AKHIR PLANT

$(document).ready( function () {
  // AWAL DATATABLE
  $('#plant').DataTable();
  // AKHIR DATATABLE

  $(".select2").each(function(){
        $(this).select2({
          placeholder: ($(this).attr("data-placeholder") ? $(this).attr("data-placeholder") : "Pilih"),
          multiple: ($(this).attr("data-multiple") === "true" ? true : false),
          maximumselectionlength: ($(this).attr("data-maximumselectionlength") ? $(this).attr("data-maximumselectionlength") : 0),
        })
    });
});

//AJAX PLANT
function pilihdataPlant(idx){
  $("#cancelplant").show();
  $("#ubahplant").show();
  $("#tambahplant").hide();
  $("#txt-ubah-plant").show();
  $("#txt-tambah-plant").hide();

  $('.form-text').hide();

  $.ajax({
    type: "POST",
    data: "id="+idx,
    url : base_url+'plant/getData',
    success : function(result){

      var objResult=JSON.parse(result);
      $("#kode_plant").val(objResult.kode_plant);
      $("#nama_plant").val(objResult.nama_plant);
      $("#id_region").val(objResult.id_region).trigger("change.select2");;
      $('.status_plant').show();
      $("#id2").val(objResult.id);
      $('#ubah_form_plant').attr('action', base_url+"plant/ubahData");
      if (objResult.aktif == 1){
        document.getElementById("aktif").checked = true;
        document.getElementById("nonaktif").checked = false;      
      }else{
        document.getElementById("nonaktif").checked = true;
        document.getElementById("aktif").checked = false;
      }
    }
  });
}

$("#cancelplant").click(function(event) {
  $("#cancelplant").hide();
  $("#ubahplant").hide();
  $("#tambahplant").show();
  $("#txt-ubah-plant").hide();
  $("#txt-tambah-plant").show();
  $('#ubah_form_plant').attr('action', base_url+"plant/tambahPlant");
  $("#kode_plant").val("");
  $("#nama_plant").val("");
  $("#id_region").val("");
  $('.status_plant').hide();
});
//AKHIR AJAX PLANT



