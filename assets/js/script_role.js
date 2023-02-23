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
  console.log(hrefHapus);

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

//AWAL MODAL ROLE
if(window.location.href !== base_url+"admin/role" && window.location.href !== base_url+"admin/tambahrole"){
    $('#aksesModal').modal('show');
}
//AKHIR MODAL ROLE

//ROLE
  $("#cancelrole").hide();
  $("#ubahrole").hide();
  $("#txt-ubah-role").hide();
  $('.status_role').hide();
//AKHIR ROLE

// AWAL AJAX ROLE
function pilihdataRole(idx){
  $("#cancelrole").show();
  $("#ubahrole").show();
  $("#tambahrole").hide();
  $("#txt-ubah-role").show();
  $("#txt-tambah-role").hide();
  $('.form-text').hide();
  $.ajax({
      type: "POST",
      data: "id="+idx,
      url : base_url +'admin/getdataRole',
      success : function(result){
      var objResult=JSON.parse(result);
      $("#id_role").val(objResult.id);
      $("#role").val(objResult.nama_role);
      $('#ubah_form_role').attr('action', base_url +"admin/ubahrole");
      $('.status_role').show();
      if (objResult.aktif == 1){
          document.getElementById("aktif").checked = true;
          document.getElementById("nonaktif").checked = false;      
      }else if (objResult.aktif == 0) {
          document.getElementById("nonaktif").checked = true;
          document.getElementById("aktif").checked = false;
      }
      if (objResult.multiplant == 1){
          document.getElementById("yesmultiplant").checked = true;
          document.getElementById("nomultiplant").checked = false;      
      }else if (objResult.multiplant == 0) {
          document.getElementById("nomultiplant").checked = true;
          document.getElementById("yesmultiplant").checked = false;
      }
    }
  })
}

$("#cancelrole").click(function() {
  $("#cancelrole").hide();
  $("#ubahrole").hide();
  $("#tambahrole").show();
  $("#txt-ubah-role").hide();
  $("#txt-tambah-role").show();
  $('.status_role').hide();
  $("#id2").val("");
  $("#role").val("");
  document.getElementById("nonaktif").checked = false;
  document.getElementById("aktif").checked = true;
  $('#ubah_form').attr('action', "<?= base_url('admin/tambahUser') ?>");
});

//AKHIR AJAX ROLE

//AWAL AKSES ROLE
$('.akses').on('click', function(){
  const menuId = $(this).data('menu');
  const roleId = $(this).data('role');
  const parentId = $(this).data('parent');
  $.ajax({
    url: base_url+'admin/changeaccess',
    type: 'post',
    data: {
      menuId: menuId,
      roleId: roleId,
      parentId: parentId
    },
    success: function(){
    }
  });
});

$('.close1').on('click', function(){
   document.location.href = base_url+'admin/role';
})
//AKHIR AKSES ROLE