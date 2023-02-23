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

$('.btn-tambahMenu').on('click', function(){
  const dataMenu = $(this).data('id-kategori');
  $('.parents').val(dataMenu);
})

//Halaman Menu Management
$(".hide_cancel").hide();
$(".btn_element2").hide();
$(".edit_menus").click(function() {
  $(".btn_element2").show();
  $(".btn_element").hide();
  $(".hide_cancel").show();
});

$(".cancelUbah").click(function() {
  $(".btn_element2").hide();
  $(".btn_element").show();
  $(".hide_cancel").hide();
});
//Akhir Halaman Menu Management

$(document).ready( function () {
  // AWAL DATATABLE
  $('#tb_kelola_menu').DataTable();
  // AKHIR DATATABLE
});

function pilihdatakategorimenu(idx){
  $.ajax({
    type: "POST",
    data: "id="+idx,
    url : base_url+'menu/getdatakategori',
    success : function(result){
      var objResult=JSON.parse(result);
      $("#kategori_menu_edit").val(objResult.kategori_menu);
      $("#id3").val(objResult.id);
      if (objResult.aktif == 1){
        document.getElementById("aktif_kategori_menu").checked = true;
        document.getElementById("nonaktif_kategori_menu").checked = false;      
      }else{
        document.getElementById("nonaktif_kategori_menu").checked = true;
        document.getElementById("aktif_kategori_menu").checked = false;
      }
    }
  });
}

function pilihdataMenu(idx){

  $.ajax({
    type: "POST",
    data: "id="+idx,
    url : base_url+'menu/getData',
    success : function(result){
      var objResult=JSON.parse(result);
      $("#title_edit").val(objResult.title);
      $("#url").val(objResult.url);
      $("#icon").val(objResult.icon);
      $("#parent").val(objResult.parent);
      $("#no_urut").val(objResult.no_urut);
      $("#id2").val(objResult.id);
      if (objResult.aktif == 1){
        document.getElementById("aktif_menu").checked = true;
        document.getElementById("nonaktif_menu").checked = false;      
      }else{
        document.getElementById("nonaktif_menu").checked = true;
        document.getElementById("aktif_menu").checked = false;
      }
    }
  });
}

