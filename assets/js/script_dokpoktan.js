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

//DOKPOKTAN
  $("#canceldokpoktan").hide();
  $("#ubahdokpoktan").hide();
  $("#txt-ubah-dokpoktan").hide();
  $('.status_dokpoktan').hide();
  $("#jns_dokumen_akhir").hide();
  $("#poktan_akhir").hide();
//AKHIR DOKPOKTAN

//AWAL SMALL TEXT UPLOAD DOKPOKTAN
$('#file_dokpoktan').change(function() {
  var filename = $('input[type=file]').val().split('\\').pop();
  var lastIndex = filename.lastIndexOf("\\");   
  $('#txt_upload small').text(filename);
});
//AKHIR SMALL TEXT UPLOAD DOKPOKTAN

$(document).ready( function () {
  // AWAL DATATABLE
  $('#tb_dokpoktan').DataTable();        
  // AKHIR DATATABLE
  $(".select2").each(function(){
        $(this).select2({
          placeholder: ($(this).attr("data-placeholder") ? $(this).attr("data-placeholder") : "Pilih"),
          multiple: ($(this).attr("data-multiple") === "true" ? true : false),
          maximumselectionlength: ($(this).attr("data-maximumselectionlength") ? $(this).attr("data-maximumselectionlength") : 0),
        })
    });
});

// AWAL AJAX DOKPOK
function pilihDataDokpok(idx){
  $("#canceldokpoktan").show();
  $("#ubahdokpoktan").show();
  $("#tambahdokpoktan").hide();
  $("#txt-ubah-dokpoktan").show();
  $("#txt-tambah-dokpoktan").hide();
  $('.form-text').hide();
  $("#email").attr('readonly', true).css('background-color','#eee');
  $.ajax({
    type: "POST",
    data: "id="+idx,
    url : base_url+'dokpoktan/getDataDokpok',
    success : function(result){
      var objResult=JSON.parse(result);
      $("#id_poktan_dok").val(objResult.id_poktan);
      $("#id_jns_dok").val(objResult.id_jns_dok);
      $("#location").val(objResult.location);
      $("#in_by").val(objResult.in_by);
      $("#in_date").val(objResult.in_date);
      $("#edit_by").val(objResult.edit_by);
      $("#edit_date").val(objResult.edit_date);
      $("#id_jns_dok_hidden").val(objResult.id_jns_dok);
      $("#id_poktan_hidden").val(objResult.id_poktan);
      $("#jns_dokumen_awal").hide();
      $("#jns_dokumen_akhir").show();

      //AMBIL NAMA DARI OPTION VALUE [2]
      var sel = document.getElementById("id_jns_dok");
      var hai = sel.options[sel.selectedIndex].text;
      document.getElementById("id_jns_dok2").value = hai;
      $("#id_jns_dok2").attr('readonly',true);
      $("#poktan_awal").hide();
      $("#poktan_akhir").show();

      //AMBIL NAMA DARI OPTION VALUE [2]
      var sel2 = document.getElementById("id_poktan_dok");
      var hai2 = sel2.options[sel2.selectedIndex].text;
      document.getElementById("id_poktan2").value = hai2;
      $("#id_poktan2").attr('readonly',true);
      $('#ubah_form_dokpoktan').attr('action', base_url+"dokpoktan/ubahData");
      $("#id2").val(objResult.id);
      $('.status_dokpoktan').show();
      if (objResult.file_poktan == null) {
          $('#txt_upload small').text('File tidak ada');
      }else{
          var txtimg_dokpok = objResult.file_poktan;
          $('#txt_upload small').text(txtimg_dokpok);
      }
      $('.status').show();
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

$("#canceldokpoktan").click(function() {
  $("#canceldokpoktan").hide();
  $("#ubahdokpoktan").hide();
  $("#tambahdokpoktan").show();
  $("#txt-ubah-dokpoktan").hide();
  $("#txt-tambah-dokpoktan").show();
  $('.status_dokpoktan').hide();
  $("#id_poktan_dok").val("");
  $("#id_jns_dok").val("");
  $("#jns_dokumen_awal").show();
  $("#jns_dokumen_akhir").hide();
  $("#poktan_awal").show();
  $("#poktan_akhir").hide();
  $("#poktan_dokumen_akhir").hide();
  $('#txt_upload small').text("No file uploaded.");
  $('#file_dokpoktan').val("");
  $("#email").attr('readonly', false).css('background-color','#fff');
  $('#ubah_form_dokpoktan').attr('action', base_url+"dokpoktan/tambah");
});
// AKHIR AJAX DOKPOK