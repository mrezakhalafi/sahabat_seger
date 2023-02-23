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

$(document).ready( function () {
  $(".select2").each(function(){
        $(this).select2({
          placeholder: ($(this).attr("data-placeholder") ? $(this).attr("data-placeholder") : "Pilih"),
          multiple: ($(this).attr("data-multiple") === "true" ? true : false),
          // maximumselectionlength: ($(this).attr("data-maximumselectionlength") ? $(this).attr("data-maximumselectionlength") : 0),
        })
    });
  $('#userdong').DataTable();
  if($('#id_role').val()=="") {
      $("#id_plant_cabang").prop("disabled", true);
  }else{
      $("#id_plant_cabang").prop("disabled", false);
  }


  $(document).on("change", "#id_role", function(){
    $("#id_plant_cabang").prop("disabled", false);
    $("#id_plant_cabang").val("");
      if($('#id_role').val()=="") {
        $("#id_plant_cabang").prop("disabled", true);
      }
  
    console.log($('#id_role option:selected').attr('data-multiplant'));
      if($('#id_role option:selected').attr('data-multiplant')==0){
        // $('#id_plant_cabang option:selected').data('multiplant', true); 
        $('#id_plant_cabang').select2({
          placeholder: "Pilih Plant Cabang",
          multiple: true,
          maximumSelectionLength: 1
        })
      }else{
        $('#id_plant_cabang').select2({
              placeholder: "Pilih Plant Cabang",
              multiple: true,
        })
    }
  }) 
});

// USER
  $("#canceluser").hide();
  $("#ubahuser").hide();
  $("#txt-ubah-user").hide();
  $('.status_user').hide();
// AKHIR USER


// AWAL AJAX USER
function pilihData(idx){
  $("#canceluser").show();
  $("#ubahuser").show();
  $("#tambahuser").hide();
  $("#txt-ubah-user").show();
  $("#txt-tambah-user").hide();
  $("#email").attr('readonly', true).css('background-color','#eee');
  $("#id_plant_cabang").attr('disabled',false);
  $('.form-text').hide();

// AWAL AJAX GET NAMA PLANT
// $.ajax({
//     type: "POST",
//     data: "id="+idx,
//     url : base_url+'admin/getPlant',
//     beforeSend: function(){
//       $("#id_plant_cabang").val("");
//     },
//     success : function(result){
//       var objResult=JSON.parse(result);
      

//       if(objResult.length>1){
//         $('#id_plant_cabang').select2({
//           multiple: true
//         });
//         dt = [];

//         $.each(objResult, function(i, v){
//           dt.push(v.id_cabang);
//         });

//         $("#id_plant_cabang").val(dt).trigger("change");
//       }else{
//         $('#id_plant_cabang').select2({
//           multiple: true,
//           maximumSelectionLength: 1
//         });
//         $.each(objResult, function(i, v){
//           $("#id_plant_cabang").val(v.id_cabang).trigger("change");
//         });        
//       }

//   }});
// AKHIR AJAX GET NAMA PLANT

// AWAL AJAX GET NAMA USER
  $.ajax({
    type: "POST",
    data: "id="+idx,
    url : base_url+'admin/getData',
    beforeSend: function(){
       $('#id_role').val("");
    },
    success : function(result){
      var objResult=JSON.parse(result);

      // $('#id_role').select2({
      //   multiple: true,
      //   maximumSelectionLength: 1
      // })
      $("#id_role option[value="+objResult.id_role+"]").prop("selected",true).trigger("change");

      $("#id_user").val(objResult.id);
      $("#id_role").val(objResult.id_role).trigger("change.select2");
      $("#username").val(objResult.username);
      $("#fullname").val(objResult.fullname);
      $("#email").val(objResult.email);
      $("#pass").attr('placeholder','********');
      $("#pass2").attr('placeholder','********');
      $("#pass_bp").val(objResult.pass);     
      $("#in_by").val(objResult.in_by);
      $("#in_date").val(objResult.in_date);
      $("#edit_by").val(objResult.edit_by);
      $("#edit_date").val(objResult.edit_date);
      $('#ubah_form').attr('action', base_url+"admin/ubahData");
      $('.status_user').show();
      if (objResult.aktif == 1){
          document.getElementById("aktif").checked = true;
          document.getElementById("nonaktif").checked = false;      
      }else{
          document.getElementById("nonaktif").checked = true;
          document.getElementById("aktif").checked = false;
      }
      
      if(objResult.multiplant == 1){
        $('#id_plant_cabang').select2({
          multiple: true
        });
      }else{
        $('#id_plant_cabang').select2({
          multiple: true,
          maximumSelectionLength: 1
        });
      }

      sessionStorage.setItem("plant_user", JSON.stringify(objResult.plant));
    },
    complete: function(){
      var objPlant = JSON.parse(sessionStorage.getItem("plant_user"));

      if(objPlant.length>1){
        dt = [];
        $.each(objPlant, function(i, v){
          dt.push(v.id_cabang);
        });
        
        $("#id_plant_cabang").val(dt).trigger("change");
      }else{
        $.each(objPlant, function(i, v){
          $("#id_plant_cabang").val(v.id_cabang).trigger("change");
        });        
      }

      sessionStorage.removeItem("plant_user");
    }
  });
}
// AKHIR AJAX GET NAMA USER

//AWAL CANCEL USER
$("#canceluser").click(function() {
  $("#id_plant_cabang").prop("disabled", true);
    $("#id_plant_cabang").val("");
  
      if($('#id_role option:selected').attr('data-multiplant')==1){
        $("#id_plant_cabang").select2({
          placeholder: "   Pilih Plant (Multiple)",
          multiple: true
        });
      }else{
        $("#id_plant_cabang").select2({
          placeholder: "   Pilih Plant (Single)",
          allowClear: true,
          maximumSelectionLength: 1
        });
      }

  $('#id_plant_cabang').val('');
  $('#id_plant_cabang').trigger('change');
  $("#canceluser").hide();
  $("#ubahuser").hide();
  $("#tambahuser").show();
  $("#txt-ubah-user").hide();
  $("#txt-tambah-user").show();
  $("#id2").val("");
  $("#id_role").val("");
  $("#id_plant").val("");
  $("#pass").attr('placeholder','');
  $("#pass2").attr('placeholder','');
  $("#username").val("");
  $("#fullname").val("");
  $("#email").val("");
  $("#in_by").val("");
  $("#in_date").val("");
  $("#edit_by").val("");
  $("#edit_date").val("");
  $("#email").attr('readonly', false).css('background-color','#fff');
  $('#ubah_form').attr('action', "<?= base_url('admin/tambahUser') ?>");
  $('.status_user').hide();
});
// AKHIR CANCEL USER

// AWAL KELOLA PLANT
$('.akses2').on('click', function(){
  const plantId = $(this).data('plant');
  const cabangId = $(this).data('cabang');
  const userId = $(this).data('id');
  $.ajax({
    url: base_url+'admin/changeaccess2',
    type: 'post',
    data: {
      plantId: plantId,
      cabangId: cabangId,
      userId: userId
    },
    success: function(){
    }
  });
});

$('.close2').on('click', function(){
   document.location.href = base_url+'admin/tampildatauser';
})
// AKHIR KELOLA PLANT

//AWAL SINGLE MULTIPLANT CHECKED
$(".coba4").on('click', function() {
  var $box = $(this);
  if ($box.is(":checked")) {
    var group = "input:checkbox[name='" + $box.attr("name") + "']";
    $(group).prop("checked", false);
    $box.prop("checked", true);
    } 
  else {
    $box.prop("checked", false);
  }
});
//AKHIR SINGLE MULTIPLANT CHECKED

//AWAL KELOLA PLANT & CABANG
$('.akses3').on('click', function(){
  const plantId = $(this).data('plant');
  const cabangId = $(this).data('cabang');
  const userId = $(this).data('id');
  $.ajax({
    url: base_url+'admin/changeaccess3',
    type: 'post',
    data: {
      plantId: plantId,
      cabangId: cabangId,
      userId: userId
    },
    success: function(){
    }
  });
});

$('.close2').on('click', function(){
 document.location.href = base_url+'admin/tampildatauser';
})
//AKHIR KELOLA PLANT & CABANG

//CHANGE AVA KET
$('.custom-file-input').on('change', function(){
  let fileName = $(this).val().split('\\').pop();
  $(this).next('.custom-file-label').addClass("selected").html(fileName);
});
//AKHIR CHANGE AVA KET