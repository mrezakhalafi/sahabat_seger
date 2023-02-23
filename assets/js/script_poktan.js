

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

//AWAL FILTER STAFF
$('#id_staff_poktanam').change(function() {
  var id_staff1 = $(this).val();
  var id_plant = $('#id_plant_cabang_poktanam').val();
  $('#tb_poktan tbody').html("");
    $.ajax({
      type: "POST",
      dataType: "json",
      data: {
        id_staff : id_staff1,
        id_plant : id_plant
      },
      url : base_url+'poktan/tampilFilterStaff',
      success : function(result){
      var j = 1;
      if(result!=""){
      $.each(result, function(i, v){
      var output = "";
        output += "<tr>";
        output += "<td>"+(j)+"</td>";
        output += "<td class='min-width-150'>"+v.nama_poktan+"</td>";
        output += "<td class='min-width-150'>"+v.alamat+"</td>";
        output += "<td>"+v.email+"</td>";
        output += "<td class='min-width-150'>"+v.ketua+"</td>";
        output += "<td>"+v.sekretaris+"</td>";
        output += "<td>"+v.bendahara+"</td>";
        output += "<td class='min-width-150'>"+v.fullname+"</td>";
        output += "<td class='min-width-120'>"+v.jenis_mitra+"</td>";
        output += "<td class='min-width-150'>"+v.nama_komuditi+"</td>";
        output += "<td class='min-width-120'>"+v.nama_prov+"</td>";
        output += "<td class='min-width-120'>"+v.nama_kab+"</td>";
        output += "<td class='min-width-120'>"+v.nama_kec+"</td>";
        output += "<td class='min-width-120'>"+v.nama_desa+"</td>";
        output += "<td class='min-width-150'>"+v.nama_bank+"</td>";
        output += "<td class='min-width-150'>"+v.rek_cabang+"</td>";
        output += "<td class='min-width-150'>"+v.rek_nama+"</td>";
        output += "<td>"+v.rek_no+"</td>";
        output += "<td>"+v.tlp+"</td>";
        output += "<td class='"+v.id+"''>";

        $.ajax({
          type: "POST",
          dataType: "json",
          data: {
            id_poktan : v.id
          },
          url : base_url+'poktan/tampilDataPlant',
          beforeSend : function(result){

          },
          success : function(result){
            $.each(result, function(i, v){
              console.log(v);
            output ="";
            output += v.nama_cabang+"<br/>";
            $('td.'+v.id).append(output);
           });
        }});

        output += "</td>";
          
        if(v.aktif==1){
          output += "<td><i class='fas fa-check-circle icon-check'></i></td>";
        }else{
            output += "<td><i class='fas fa-times-circle icon-uncheck'></i></td>";
        }

        if (v.aktif==1) {
          output += "<td class='min-width-btn text-center'><a href='poktan/ubah?id="+v.id+"'><button class='btn btn-success btn-sm'>Edit</button></a> <button onclick='deleteData()' data-link='poktan/delete/"+v.id+"' class='btn-hapus btn btn-danger btn-sm'>Delete</button></td>";
        }else {
            output += "<td class='min-width-btn text-center'><a href='poktan/ubah?id="+v.id+"'><button class='btn btn-success btn-sm'>Edit</button></a> <a href='poktan/aktif/"+v.id+"'><button class='btn btn-primary min-width-btn-59 btn-sm'>Aktif</button></a></td>";
        }
        output += "</tr>";
        $('#tb_poktan tbody').append(output);
        j++;
      })
    }else{
      var cols = $("#tb_poktan").find("th").length;
      output = "<tr class='text-center'>";
      output += "<td colspan='"+cols+"'>No matching records found</td>";
      output += "</tr>";
      $('#tb_poktan tbody').append(output);
    }
    }
  })
});

$('#id_plant_cabang_poktanam').change(function() {
  var id_plant = $(this).val();
  var id_staff = $('#id_staff_poktanam').val();
  $('#tb_poktan tbody').html("");
    $.ajax({
      type: "POST",
      dataType: "json",
      data: {
        id_plant : id_plant,
        id_staff : id_staff
      },
      url : base_url+'poktan/tampilFilterPlant',
      success : function(result){

      console.log(result);
      var j = 1;
      if(result!=""){
      $.each(result, function(i, v){
      var output = "";
        output += "<tr>";
        output += "<td>"+(j)+"</td>";
        output += "<td class='min-width-150'>"+v.nama_poktan+"</td>";
        output += "<td class='min-width-150'>"+v.alamat+"</td>";
        output += "<td>"+v.email+"</td>";
        output += "<td class='min-width-150'>"+v.ketua+"</td>";
        output += "<td>"+v.sekretaris+"</td>";
        output += "<td>"+v.bendahara+"</td>";
        output += "<td class='min-width-150'>"+v.fullname+"</td>";
        output += "<td class='min-width-120'>"+v.jenis_mitra+"</td>";
        output += "<td class='min-width-150'>"+v.nama_komuditi+"</td>";
        output += "<td class='min-width-120'>"+v.nama_prov+"</td>";
        output += "<td class='min-width-120'>"+v.nama_kab+"</td>";
        output += "<td class='min-width-120'>"+v.nama_kec+"</td>";
        output += "<td class='min-width-120'>"+v.nama_desa+"</td>";
        output += "<td class='min-width-150'>"+v.nama_bank+"</td>";
        output += "<td class='min-width-150'>"+v.rek_cabang+"</td>";
        output += "<td class='min-width-150'>"+v.rek_nama+"</td>";
        output += "<td>"+v.rek_no+"</td>";
        output += "<td>"+v.tlp+"</td>";
        output += "<td class='"+v.id+"''>";

          $.ajax({
            type: "POST",
            dataType: "json",
            data: {
              id_poktan : v.id
            },
            url : base_url+'poktan/tampilDataPlant',
            beforeSend : function(result){

            },
            success : function(result){
              $.each(result, function(i, v){
                console.log(v.id);
              output = v.nama_cabang+"<br/>";
              $('td.'+v.id).append(output);
             });
           }});

          output += "</td>";     

        var date1 = new Date(v.tgl_tanam);
        var date2 = new Date();
        var diffDays = parseInt((date2 - date1) / (1000 * 60 * 60 * 24)); 
        var hasil = diffDays/120*100;

        if (hasil >=50 && hasil<=99) {
        output += "<td class='min-width-150'><div class='progress progress-bar mr-2'><div class='progress-bar bg-success prosesbar' role='progressbar' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100' style='width: "+hasil+"%'></div></div><small>"+diffDays+"/120 hari ("+Math.round(hasil)+"% )</small></td>";
        }else if(hasil < 50){
        output += "<td class='min-width-150'><div class='progress progress-bar mr-2'><div class='progress-bar bg-warning prosesbar' role='progressbar' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100' style='width: "+hasil+"%'></div></div><small>"+diffDays+"/120 hari ("+Math.round(hasil)+"% )</small></td>";
        }else if(hasil>=100){
        output += "<td class='min-width-150'><div class='progress progress-bar mr-2'><div class='progress-bar bg-primary prosesbar' role='progressbar' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100' style='width: "+hasil+"%'></div></div><small>120/120 hari (100% )</small></td>";
        }
          
        if(v.aktif==1){
          output += "<td><i class='fas fa-check-circle icon-check'></i></td>";
        }else{
            output += "<td><i class='fas fa-times-circle icon-uncheck'></i></td>";
        }

        if (v.aktif==1) {
          output += "<td class='min-width-btn text-center'><a href='poktan/ubah?id="+v.id+"'><button class='btn btn-success btn-sm'>Edit</button></a> <button onclick='deleteData()' data-link='poktan/delete/"+v.id+"' class='btn-hapus btn btn-danger btn-sm'>Delete</button></td>";
        }else {
            output += "<td class='min-width-btn text-center'><a href='poktan/ubah?id="+v.id+"'><button class='btn btn-success btn-sm'>Edit</button></a> <a href='poktan/aktif/"+v.id+"'><button class='btn btn-primary min-width-btn-59 btn-sm'>Aktif</button></a></td>";
        }

        
        output += "</tr>";
        $('#tb_poktan tbody').append(output);
        j++;
      })
      }else{
        var cols = $("#tb_poktan").find("th").length;
        output = "<tr class='text-center'>";
        output += "<td colspan='"+cols+"'>No matching records found</td>";
        output += "</tr>";
        $('#tb_poktan tbody').append(output);
      }
    }
  })
});
//AKHIR FILTER STAFF

//AWAL POKTAN
  $('.status_poktan').hide();
//AKHIR POKTAN

$(document).ready( function () {
  // AWAL DATATABLE
  $('#tb_poktan').DataTable();        
  // AKHIR DATATABLE


  $(".select2").each(function(){
        $(this).select2({
          placeholder: ($(this).attr("data-placeholder") ? $(this).attr("data-placeholder") : "Pilih"),
          multiple: ($(this).attr("data-multiple") === "true" ? true : false),
          maximumselectionlength: ($(this).attr("data-maximumselectionlength") ? $(this).attr("data-maximumselectionlength") : 0),
        })
    });
});

//AWAL AJAX POKTAN
function pilihdataPoktan(idx){
  $.ajax({
    type: "POST",
    data: "id="+idx,
    url : base_url+'poktan/getdataPoktan',
    beforeSend: function(){
      $("#id_kab").html("");
      $("#id_kec").html("");
      $("#id_desa").html("");
    },
    success : function(result){
      var objResult=JSON.parse(result);
      $("#id_staff").val(objResult.id_staff).trigger("change.select2");;
      $("#id_kategori").val(objResult.id_kategori);
      $("#id_jenis_mitra").val(objResult.id_jenis_mitra).trigger("change.select2");;
      $("#id_komuditi").val(objResult.id_komuditi).trigger("change.select2");;
      $("#id_prov").val(objResult.id_provinsi).trigger("change.select2");;
      $("#nama_poktan").val(objResult.nama_poktan);
      $("#alamat").val(objResult.alamat);
      $("#email").val(objResult.email);
      $("#ketua").val(objResult.ketua);
      $("#sekretaris").val(objResult.sekretaris);
      $("#bendahara").val(objResult.bendahara);
      $("#rek_bank").val(objResult.rek_bank).trigger("change.select2");;
      $("#rek_cabang").val(objResult.rek_cabang);
      $("#rek_nama").val(objResult.rek_nama);
      $("#rek_no").val(objResult.rek_no);
      var num_tlp = objResult.tlp;
      while(num_tlp.charAt(0) === '0')
      {
        num_tlp = num_tlp.substr(1);
      }
      $("#tlp").val(num_tlp);
      $("#aktif").val(objResult.aktif);
      $("#id3").val(objResult.id);
      
      $.each(objResult.kabupaten, function(i,v){
        $("#id_kab").append("<option value='"+v.id+"'>"+v.nama_kab+"</option>");          
      });

      $.each(objResult.kecamatan, function(i,v){
        $("#id_kec").append("<option value='"+v.id+"'>"+v.nama_kec+"</option>");          
      });

      $.each(objResult.desa, function(i,v){
        $("#id_desa").append("<option value='"+v.id+"'>"+v.nama_desa+"</option>");          
      });

      $("#id_kab").val(objResult.id_kabupaten);
      $("#id_kec").val(objResult.id_kecamatan);
      $("#id_desa").val(objResult.id_desa);

      if (objResult.aktif == 1){
          document.getElementById("aktifpoktan").checked = true;
          document.getElementById("nonaktifpoktan").checked = false;      
      }else if (objResult.aktif == 0) {
          document.getElementById("nonaktifpoktan").checked = true;
          document.getElementById("aktifpoktan").checked = false;
      }
    }
  })
}
//AKHIR AJAX POKTAN

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