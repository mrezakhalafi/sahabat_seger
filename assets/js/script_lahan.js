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

function deleteData(){
  const hrefHapus= $('.btn-hapus').data('link');
  Swal.fire({
    title: 'Apakah anda yakin?',
    text: "Data yang telah terhapus tidak dapat dikembalikan",
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
}

//LAHAN
  $("#cancellahan").hide();
  $("#ubahlahan").hide();
  $("#txt-ubah-lahan").hide();
  $('.status_lahan').hide();
//AKHIR LAHAN



$(document).ready( function () {
  // AWAL DATATABLE      
  $('#lahan').DataTable();
  // AKHIR DATATABLE
    // $("#id_plant_cabang_poktanam").select2({
    //   placeholder: "   Pilih Plant",
    //   multiple: true,
    // });
    $(".select2").each(function(){
        $(this).select2({
          width: 'resolve',
          placeholder: ($(this).attr("data-placeholder") ? $(this).attr("data-placeholder") : "Pilih"),
          multiple: ($(this).attr("data-multiple") === "true" ? true : false),
          maximumselectionlength: ($(this).attr("data-maximumselectionlength") ? $(this).attr("data-maximumselectionlength") : 0),
        })
    });
});

//AWAL FILTER PLANT
$('#id_plant_cabang_poktanam').change(function() {
  var id_plant = $(this).val();
  $('#lahan tbody').html("");
    $.ajax({
      type: "POST",
      dataType: "json",
      data: {
        id_plant : id_plant
      },
      url : base_url+'lahan/tampilFilterPlant',
      success : function(result){

      var j = 1;
      if(result!=""){
      $.each(result, function(i, v){
      var output = "";
        output += "<tr>";
        output += "<td>"+(j)+"</td>";
        output += "<td class='min-width-120'>"+v.nama_lahan+"</td>";
        output += "<td>"+v.luas+"</td>";
        output += "<td>"+v.kepemilikan+"</td>";
        output += "<td class='min-width-120'>"+v.nama_poktan+"</td>";
        output += "<td class='min-width-150'>"+v.nama_petani+"</td>";
        output += "<td class='"+v.id+"''>";

        $.ajax({
          type: "POST",
          dataType: "json",
          data: {
            id_plant : v.id
          },
          url : base_url+'lahan/tampilDataPlant',
          beforeSend : function(result){

          },
          success : function(result){
                        console.log(v.nama_cabang);

            $.each(result, function(i, v){

            output = v.nama_cabang+"<br/>";
            $('td.'+v.id).append(output);
           });
          }});

        output += "</td>";     
        output += "<td>"+v.nama_prov+"</td>";
        output += "<td>"+v.nama_kab+"</td>";
        output += "<td>"+v.nama_kec+"</td>";
        output += "<td>"+v.nama_desa+"</td>";

        if(v.aktif==1){
          output += "<td><i class='fas fa-check-circle icon-check'></i></td>";
        }else{
            output += "<td><i class='fas fa-times-circle icon-uncheck'></i></td>";
        }

        if(v.aktif==1){
          output += "<td class='min-width-btn text-center'><button class='btn btn-success btn-sm' onclick='pilihdataLahan("+v.id+");'>Edit</button> <button onclick='deleteData()' data-link='lahan/delete/"+v.id+"' class='btn btn-danger btn-sm btn-hapus'>Delete</button></td>";
        }else{
          output += "<td class='min-width-btn text-center'><button class='btn btn-success btn-sm' onclick='pilihdataLahan("+v.id+");'>Edit</button> <a href='lahan/aktif/"+v.id+"'><button class='btn btn-primary min-width-btn-59 btn-sm'>Aktif</button></a></td>";
        }

        
        output += "</tr>";
        $('#lahan tbody').append(output);
        j++;
      })
    }else{
        var cols = $("#lahan").find("th").length;
        output = "<tr class='text-center'>";
        output += "<td colspan='"+cols+"'>No matching records found</td>";
        output += "</tr>";
        $('#lahan tbody').append(output);
    }
    }
  })
});
//AKHIR FILTER PLANT

//AWAL AJAX LAHAN
function pilihdataLahan(idx){
  $("#cancellahan").show();
  $("#ubahlahan").show();
  $("#tambahlahan").hide();
  $("#txt-ubah-lahan").show();
  $("#txt-tambah-lahan").hide();
  $('.form-text').hide();

  $.ajax({
    type: "POST",
    data: "id="+idx,
    url : base_url +'lahan/getdataLahan',
    beforeSend: function(){
      $("#id_petani").html("");
      $("#id_kab").html("");
      $("#id_kec").html("");
      $("#id_desa").html("");
    },
    success : function(result){
      var objResult=JSON.parse(result);

      $("#id_poktan_lahan").val(objResult.id_poktan).trigger("change.select2");
      $("#id_prov").val(objResult.id_prov).trigger("change.select2");
      $("#nama_lahan").val(objResult.nama_lahan);
      $("#luas").val(objResult.luas);
      $("#kepemilikan").val(objResult.kepemilikan).trigger("change.select2");
      $("#in_by").val(objResult.in_by);
      $("#in_date").val(objResult.in_date);
      $("#edit_by").val(objResult.edit_by);
      $("#edit_date").val(objResult.edit_date);
      $("#id2").val(objResult.id);
      var txtimg_lahan = objResult.dok_mou;
      $('#txt_upload small').text(txtimg_lahan);
      $('.status_lahan').show();

      $.each(objResult.kab, function(i,v){
        $("#id_kab").append("<option value='"+v.id+"'>"+v.nama_kab+"</option>");          
      });

      $.each(objResult.kec, function(i,v){
        $("#id_kec").append("<option value='"+v.id+"'>"+v.nama_kec+"</option>");          
      });

      $.each(objResult.desa, function(i,v){
        $("#id_desa").append("<option value='"+v.id+"'>"+v.nama_desa+"</option>");          
      });

      $.each(objResult.petani, function(i,v){
        $("#id_petani").append("<option value='"+v.id+"'>"+v.nama_petani+"</option>");
        console.log(v.id);        
        console.log(v.nama_petani);
      });

      $("#id_kab").val(objResult.id_kab).trigger("change.select2");
      $("#id_kec").val(objResult.id_kec).trigger("change.select2");
      $("#id_desa").val(objResult.id_desa).trigger("change.select2");
      $("#id_petani").val(objResult.id_petani).trigger("change.select2"); 

      $('#ubah_form_lahan').attr('action', base_url +"lahan/ubahlahan");
      if (objResult.aktif == 1){
          document.getElementById("aktif").checked = true;
          document.getElementById("nonaktif").checked = false;      
      }else if (objResult.aktif == 0) {
        document.getElementById("nonaktif").checked = true;
          document.getElementById("aktif").checked = false;
      }
    }
  })
}

$("#cancellahan").click(function(event) {
  $("#cancellahan").hide();
  $("#ubahlahan").hide();
  $("#tambahlahan").show();
  $("#txt-ubah-lahan").hide();
  $("#txt-tambah-lahan").show();
  $("#id_poktan_lahan").val("");
  $("#id_petani").val("");
  $("#id_prov").val("");
  $("#id_kab").html("<option value=''>Pilih Kabupaten</option>");
  $("#id_kec").html("<option value=''>Pilih Kecamatan</option>");
  $("#id_desa").html("<option value=''>Pilih Desa</option>");
  $('#ubah_form_lahan').attr('action', base_url +"lahan/tambah");
  $("#nama_lahan").val("");
  $("#luas").val("");
  $('.select2').val("").trigger("change.select2")
  $("#in_by").val("");
  $("#in_date").val("");
  $("#edit_by").val("");
  $("#edit_date").val("");
  $("#id2").val("");
  $("#uploadhehe").val("");
  $('#id_poktan_lahan').val("");
  $('.status_lahan').hide();
  $('#txt_upload small').text("No file uploaded.");
  document.getElementById("aktif").checked = true;
});
//AKHIR AJAX LAHAN

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
   else if(action == "id_kab")
   {
    result = 'id_kec';
   }
   else if(action == "id_kec")
   {
    result = 'id_desa';
   }
   fetchDataWilayah(action, query, result);
  }
 });

$(document).on("change", ".sort", function() {
  if($(this).val() != '')
  {
   var action = $(this).attr("id");
   var query = $(this).val();
   var result = '';
   if(action == "id_poktan_lahan")
   {
    result = 'id_petani';
   }
   fetchDataPetani(action, query, result);
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

function fetchDataPetani(action, query, result){
  $.ajax({
    url : base_url+'lahan/petaniFetch',
    method:"POST",
    data:{postaction:action, query:query},
    success:function(data){
     $('#'+result).html(data);
    }
  })
}
//AKHIR PILIH PROV KAB KEC DESA ALL