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

//AWAL PETANI
  $(".status_petani").hide();
//AKHIR PETANI

//AWAL SMALL TEXT UPLOAD PETANI
$('#file_ktp').change(function() {
  var filename = $('#file_ktp').val().split('\\').pop();
  var lastIndex = filename.lastIndexOf("\\");   
  $('#txt_upload small').text(filename);
});
$('#file_kk').change(function() {
  var filename = $('#file_kk').val().split('\\').pop();
  var lastIndex = filename.lastIndexOf("\\");   
  $('#txt_upload2 small').text(filename);
});
//AKHIR SMALL TEXT UPLOAD PETANI

//TGL LAHIR
$("#tgl_lahir").datepicker({
  dateFormat: 'dd/mm/yy',
  defaultDate: new Date('01/01/1980'),
  changeYear: true 
});

$(document).ready( function () {
  // AWAL DATATABLE
  $('#tb_petani').DataTable();        
  // AKHIR DATATABLE
  

  $(".select2").each(function(){
        $(this).select2({
          placeholder: ($(this).attr("data-placeholder") ? $(this).attr("data-placeholder") : "Pilih"),
          multiple: ($(this).attr("data-multiple") === "true" ? true : false),
          maximumselectionlength: ($(this).attr("data-maximumselectionlength") ? $(this).attr("data-maximumselectionlength") : 0),
        })
    });
});

//AWAL FILTER PETANI
$('#id_poktan_poktanam').change(function() {
  var id_poktan = $(this).val();
  var id_staff = $('#id_staff_poktanam').val();
  var id_plant = $('#id_plant_cabang_poktanam').val();
  $('#tb_petani tbody').html("");

  $.ajax({
        type: "POST",
        dataType: "json",
        data: {
          id_poktan : id_poktan,
          id_staff : id_staff,
          id_plant : id_plant
        },
        url : base_url+'petani/tampilFilter',
        success : function(result){
          var i = 1;
          if(result!=""){
          $.each(result, function(i, v){
          var output = "";

          output += "<tr>";
          output += "<td>"+(1+i)+"</td>";
          output += "<td class='min-width-150'>"+v.nama_petani+"</td>";
          output += "<td>"+v.no_ktp+"</td>";
          output += "<td>"+v.no_kk+"</td>";
          if(v.jns_kelamin=="Laki-Laki"){
          output += "<td class='text-center min-width-150'><i class='fas fa-mars icon-male'></i></td>";
          }else{
           output += "<td class='text-center min-width-150'><i class='fas fa-venus icon-female'></i></td>";           
          }
          output += "<td class='min-width-150'>"+v.tmpt_lahir+"</td>";
          var date = new Date(v.tgl_lahir);
          var tgl = date.getDate() < 10 ? "0"+date.getDate() : date.getDate();
          var bln = (date.getMonth()+1) < 10 ? "0"+(date.getMonth()+1): (date.getMonth()+1);
          var thn = date.getFullYear();
          output += "<td class='min-width-150'>"+tgl+"-"+bln+"-"+thn+"</td>";
          output += "<td>"+v.tlp+"</td>";
          output += "<td class='min-width-150'>"+v.nama_prov+"</td>";
          output += "<td class='min-width-150'>"+v.nama_kab+"</td>";
          output += "<td class='min-width-150'>"+v.nama_kec+"</td>";
          output += "<td class='min-width-150'>"+v.nama_desa+"</td>";
          output += "<td class='min-width-150'>"+v.nama_pasangan+"</td>";
          output += "<td class='min-width-120'><a href='"+base_url+"assets/file/petani/file_ktp/"+v.file_ktp+"' target='_blank'>"+v.file_ktp+"</a></td>";
          output += "<td class='min-width-120'><a href='"+base_url+"assets/file/petani/file_kk/"+v.file_kk+"' target='_blank'>"+v.file_kk+"</a></td>";
          output += "<td class='min-width-150'>"+v.nama_bank+"</td>";
          output += "<td class='min-width-150'>"+v.rek_cabang+"</td>";
          output += "<td class='min-width-150'>"+v.rek_nama+"</td>";
          output += "<td class='min-width-150'>"+v.rek_no+"</td>";
          output += "<td class='min-width-150'>"+v.nama_poktan+"</td>";
          output += "<td class='min-width-150'>"+v.fullname+"</td>";
          output += "<td class='"+v.id+"''>";

          $.ajax({
            type: "POST",
            dataType: "json",
            data: {
              id_petani : v.id_staff
            },
            url : base_url+'petani/tampilDataPlant',
            beforeSend : function(result){

            },
            success : function(result){
              $.each(result, function(i, v){
              output ="";


              output += v.nama_cabang+"<br/>";
              $('td.'+v.id).html(output);
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
          output += "<td class='min-width-btn text-center'><a href='petani/ubahPetani?id="+v.id+"'><button class='btn btn-success btn-sm'>Edit</button></a> <button onclick='deleteData()' data-link='petani/delete/"+v.id+"' class='btn-hapus btn btn-danger btn-sm'>Delete</button></td>";
          }else{
              output += "<td class='min-width-btn text-center'><a href='petani/ubahPetani?id="+v.id+"'><button class='btn btn-success btn-sm'>Edit</button></a> <a href='petani/aktif/"+v.id+"'><button class='btn btn-primary min-width-btn-59 btn-sm'>Aktif</button></a></td>";
          }
          output += "</tr>";
          $('#tb_petani tbody').append(output);
          i++;
      })
      }else{
        var cols = $("#tb_petani").find("th").length;
        output = "<tr class='text-center'>";
        output += "<td colspan='"+cols+"'>No matching records found</td>";
        output += "</tr>";
        $('#tb_petani tbody').append(output);
      }
    }
  })
});

$('#id_staff_poktanam').change(function() {
  var id_staff1 = $(this).val();
  var id_plant =  $('#id_plant_cabang_poktanam').val();
  var id_poktan = $('#id_poktan_poktanam').val();

  $('#tb_petani tbody').html("");
    $.ajax({
      type: "POST",
      dataType: "json",
      data: {
        id_staff : id_staff1,
        id_plant : id_plant,
        id_poktan : id_poktan
      },
      url : base_url+'petani/tampilFilterStaff',
      success : function(result){
      var j = 1;
      if(result!=""){
      $.each(result, function(i, v){
      var output = "";

          output += "<tr>";
          output += "<td>"+(1+i)+"</td>";
          output += "<td class='min-width-150'>"+v.nama_petani+"</td>";
          output += "<td>"+v.no_ktp+"</td>";
          output += "<td>"+v.no_kk+"</td>";
          if(v.jns_kelamin=="Laki-Laki"){
          output += "<td class='text-center min-width-150'><i class='fas fa-mars icon-male'></i></td>";
          }else{
           output += "<td class='text-center min-width-150'><i class='fas fa-venus icon-female'></i></td>";           
          }
          output += "<td class='min-width-150'>"+v.tmpt_lahir+"</td>";
          var date = new Date(v.tgl_lahir);
          var tgl = date.getDate() < 10 ? "0"+date.getDate() : date.getDate();
          var bln = (date.getMonth()+1) < 10 ? "0"+(date.getMonth()+1): (date.getMonth()+1);
          var thn = date.getFullYear();
          output += "<td class='min-width-150'>"+tgl+"-"+bln+"-"+thn+"</td>";
          output += "<td>"+v.tlp+"</td>";
          output += "<td class='min-width-150'>"+v.nama_prov+"</td>";
          output += "<td class='min-width-150'>"+v.nama_kab+"</td>";
          output += "<td class='min-width-150'>"+v.nama_kec+"</td>";
          output += "<td class='min-width-150'>"+v.nama_desa+"</td>";
          output += "<td class='min-width-150'>"+v.nama_pasangan+"</td>";
          output += "<td class='min-width-120'><a href='"+base_url+"assets/file/petani/file_ktp/"+v.file_ktp+"' target='_blank'>"+v.file_ktp+"</a></td>";
          output += "<td class='min-width-120'><a href='"+base_url+"assets/file/petani/file_kk/"+v.file_kk+"' target='_blank'>"+v.file_kk+"</a></td>";
          output += "<td class='min-width-150'>"+v.nama_bank+"</td>";
          output += "<td class='min-width-150'>"+v.rek_cabang+"</td>";
          output += "<td class='min-width-150'>"+v.rek_nama+"</td>";
          output += "<td class='min-width-150'>"+v.rek_no+"</td>";
          output += "<td class='min-width-150'>"+v.nama_poktan+"</td>";
          output += "<td class='min-width-150'>"+v.fullname+"</td>";
          output += "<td class='"+v.id+"''>";

        $.ajax({
          type: "POST",
          dataType: "json",
          data: {
            id_petani : v.id_staff
          },
          url : base_url+'petani/tampilDataPlant',
          beforeSend : function(result){

          },
          success : function(result){
            $.each(result, function(i, v){
            output ="";
            output += v.nama_cabang+"<br/>";
            $('td.'+v.id).html(output);
           });
          }});

        output += "</td>";
          
        if(v.aktif==1){
          output += "<td><i class='fas fa-check-circle icon-check'></i></td>";
        }else{
            output += "<td><i class='fas fa-times-circle icon-uncheck'></i></td>";
        }

        if (v.aktif==1) {
          output += "<td class='min-width-btn text-center'><a href='petani/ubahPetani?id="+v.id+"'><button class='btn btn-success btn-sm'>Edit</button></a> <button onclick='deleteData()' data-link='petani/delete/"+v.id+"' class='btn-hapus btn btn-danger btn-sm'>Delete</button></td>";
        }else{
            output += "<td class='min-width-btn text-center'><a href='petani/ubahPetani?id="+v.id+"'><button class='btn btn-success btn-sm'>Edit</button></a> <a href='petani/aktif/"+v.id+"'><button class='btn btn-primary min-width-btn-59 btn-sm'>Aktif</button></a></td>";
        }
        output += "</tr>";
        $('#tb_petani tbody').append(output);
        j++;
      })
      }else{
        var cols = $("#tb_petani").find("th").length;
        output = "<tr class='text-center'>";
        output += "<td colspan='"+cols+"'>No matching records found</td>";
        output += "</tr>";
        $('#tb_petani tbody').append(output);
      }
    }
  })
});

$('#id_plant_cabang_poktanam').change(function() {
  var id_plant = $(this).val();
  var id_staff = $('#id_staff_poktanam').val();
  var id_poktan = $('#id_poktan_poktanam').val(); 
  $('#tb_petani tbody').html("");
    $.ajax({
      type: "POST",
      dataType: "json",
      data: {
        id_plant : id_plant,
        id_staff : id_staff,
        id_poktan : id_poktan
      },
      url : base_url+'petani/tampilFilterPlant',
      success : function(result){

      var j = 1;
      if(result!=""){
      $.each(result, function(i, v){
      var output = "";
      
        output += "<tr>";
        output += "<td>"+(1+i)+"</td>";
        output += "<td class='min-width-150'>"+v.nama_petani+"</td>";
        output += "<td>"+v.no_ktp+"</td>";
        output += "<td>"+v.no_kk+"</td>";
        if(v.jns_kelamin=="Laki-Laki"){
        output += "<td class='text-center min-width-150'><i class='fas fa-mars icon-male'></i></td>";
        }else{
         output += "<td class='text-center min-width-150'><i class='fas fa-venus icon-female'></i></td>";           
        }
        output += "<td class='min-width-150'>"+v.tmpt_lahir+"</td>";
        var date = new Date(v.tgl_lahir);
        var tgl = date.getDate() < 10 ? "0"+date.getDate() : date.getDate();
        var bln = (date.getMonth()+1) < 10 ? "0"+(date.getMonth()+1): (date.getMonth()+1);
        var thn = date.getFullYear();
        output += "<td class='min-width-150'>"+tgl+"-"+bln+"-"+thn+"</td>";
        output += "<td>"+v.tlp+"</td>";
        output += "<td class='min-width-150'>"+v.nama_prov+"</td>";
        output += "<td class='min-width-150'>"+v.nama_kab+"</td>";
        output += "<td class='min-width-150'>"+v.nama_kec+"</td>";
        output += "<td class='min-width-150'>"+v.nama_desa+"</td>";
        output += "<td class='min-width-150'>"+v.nama_pasangan+"</td>";
        output += "<td class='min-width-120'><a href='"+base_url+"assets/file/petani/file_ktp/"+v.file_ktp+"' target='_blank'>"+v.file_ktp+"</a></td>";
        output += "<td class='min-width-120'><a href='"+base_url+"assets/file/petani/file_kk/"+v.file_kk+"' target='_blank'>"+v.file_kk+"</a></td>";
        output += "<td class='min-width-150'>"+v.nama_bank+"</td>";
        output += "<td class='min-width-150'>"+v.rek_cabang+"</td>";
        output += "<td class='min-width-150'>"+v.rek_nama+"</td>";
        output += "<td class='min-width-150'>"+v.rek_no+"</td>";
        // output += "<td class='min-width-150'>"+v.nama_poktan+"</td>";

        output += "<td class='"+v.id+"  min-width-150'>";

          $.ajax({
            type: "POST",
            dataType: "json",
            data: {
              id_staff : v.id_staff
            },
            url : base_url+'petani/tampilDataPoktan',
            beforeSend : function(result){
                $('td.'+v.id).html("");          
            },
            success : function(result){
              console.log(result);
              $.each(result, function(i, v){
              output ="";
              output += v.nama_poktan+"<br/>";
              $('td.'+v.id).html(output);
             });
           }});

          output += "</td>";    



        output += "<td class='min-width-150'>"+v.fullname+"</td>";
        output += "<td class='min-width-150'>"+v.nama_cabang+"</td>";
        // output += "<td class='"+v.id+"''>";

        //   $.ajax({
        //     type: "POST",
        //     dataType: "json",
        //     data: {
        //       id_petani : v.id_staff
        //     },
        //     url : base_url+'petani/tampilDataPlant',
        //     beforeSend : function(result){

        //     },
        //     success : function(result){
        //       $.each(result, function(i, v){
        //       output ="";
        //       output += v.nama_cabang+"<br/>";
        //       $('td.'+v.id).html(output);
        //      });
        //    }});

        //   output += "</td>";     
          
        if(v.aktif==1){
          output += "<td><i class='fas fa-check-circle icon-check'></i></td>";
        }else{
            output += "<td><i class='fas fa-times-circle icon-uncheck'></i></td>";
        }

        if (v.aktif==1) {
          output += "<td class='min-width-btn text-center'><a href='petani/ubahPetani?id="+v.id+"'><button class='btn btn-success btn-sm'>Edit</button></a> <button onclick='deleteData()' data-link='petani/delete/"+v.id+"' class='btn-hapus btn btn-danger btn-sm'>Delete</button></td>";
        }else{
            output += "<td class='min-width-btn text-center'><a href='petani/ubahPetani?id="+v.id+"'><button class='btn btn-success btn-sm'>Edit</button></a> <a href='petani/aktif/"+v.id+"'><button class='btn btn-primary min-width-btn-59 btn-sm'>Aktif</button></a></td>";
        }
        
        output += "</tr>";
        $('#tb_petani tbody').append(output);
        j++;
      })
      }else{
        var cols = $("#tb_petani").find("th").length;
        output = "<tr class='text-center'>";
        output += "<td colspan='"+cols+"'>No matching records found</td>";
        output += "</tr>";
        $('#tb_petani tbody').append(output);
      }
    }
  })
});
//AKHIR FILTER PETANI

//AWAL AJAX PETANI
function pilihdataPetani(idx){
  $.ajax({
    type: "POST",
    data: "id="+idx,
    url : base_url + 'petani/getdataPetani',
    beforeSend: function(){
      $("#id_kab").html("");
      $("#id_kec").html("");
      $("#id_desa").html("");
    },
    success : function(result){
      var objResult=JSON.parse(result);
      $("#nama_petani").val(objResult.nama_petani);
      $("#no_ktp").val(objResult.no_ktp);
      $("#no_kk").val(objResult.no_kk);
      $("#jns_kelamin").val(objResult.jns_kelamin);
      $("#tmpt_lahir").val(objResult.tmpt_lahir);
      var tgl_lahir = generateDate(new Date(objResult.tgl_lahir), 'dd/mm/yyyy');
      $("#tgl_lahir").val(tgl_lahir);
      $("#tgl_lahir").datepicker({
        dateFormat: 'dd/mm/yy',
        defaultDate: new Date(objResult.tgl_lahir)             
      });
      var num_tlp = objResult.tlp;
      while(num_tlp.charAt(0) === '0')
      {
        num_tlp = num_tlp.substr(1);
      }
      $("#tlp").val(num_tlp);
      $("#id_prov").val(objResult.id_prov).trigger("change.select2");
      $("#id_kab").val(objResult.id_kab);
      $("#id_kec").val(objResult.id_kec);
      $("#id_desa").val(objResult.id_desa);
      $("#nama_pasangan").val(objResult.nama_pasangan);
      $("#rek_bank").val(objResult.rek_bank);
      $("#rek_cabang").val(objResult.rek_cabang);
      $("#rek_nama").val(objResult.rek_nama);
      $("#rek_no").val(objResult.rek_no);
      $("#aktif").val(objResult.aktif);
      $("#id2").val(objResult.id);
      if (!objResult.file_ktp) {
        $('#txt_upload small').text('File tidak ada');
      }else{
        $('#txt_upload small').text(objResult.file_ktp);
      }
      if(!objResult.file_kk){
        $('#txt_upload2 small').text('File tidak ada');
      }else{
        $('#txt_upload2 small').text(objResult.file_kk);
      }
      $.each(objResult.kab, function(i,v){
        $("#id_kab").append("<option value='"+v.id+"'>"+v.nama_kab+"</option>");          
      });

      $.each(objResult.kec, function(i,v){
        $("#id_kec").append("<option value='"+v.id+"'>"+v.nama_kec+"</option>");          
      });

      $.each(objResult.desa, function(i,v){
        $("#id_desa").append("<option value='"+v.id+"'>"+v.nama_desa+"</option>");          
      });

      $("#id_kab").val(objResult.id_kab).trigger("change.select2");;
      $("#id_kec").val(objResult.id_kec).trigger("change.select2");;
      $("#id_desa").val(objResult.id_desa).trigger("change.select2");;

      if (objResult.jns_kelamin == "Laki-Laki"){
          document.getElementById("jns_kelamin_petani").checked = true;
          document.getElementById("jns_kelamin_petani2").checked = false;      
      }else if (objResult.jns_kelamin == "Perempuan") {
          document.getElementById("jns_kelamin_petani2").checked = true;
          document.getElementById("jns_kelamin_petani").checked = false;
      }

      if (objResult.aktif == 1){
          document.getElementById("aktifpetani").checked = true;
          document.getElementById("nonaktifpetani").checked = false;      
      }else if (objResult.aktif == 0) {
          document.getElementById("nonaktifpetani").checked = true;
          document.getElementById("aktifpetani").checked = false;
      }
    }
  })
}
//AKHIR AJAX PETANI

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

//AWAL SWITCH DATE
function generateDate(date, format){
  var tgl = date.getDate() < 10 ? "0"+date.getDate() : date.getDate();
  var bln = (date.getMonth()+1) < 10 ? "0"+(date.getMonth()+1): (date.getMonth()+1);
  var thn = date.getFullYear();
  switch(format){
    case 'dd-mm-yyyy' : return tgl+"-"+bln+"-"+thn;
    case 'dd.mm.yyyy' : return tgl+"."+bln+"."+thn;
    case 'dd/mm/yyyy' : return tgl+"/"+bln+"/"+thn;
    case 'yyyy-mm-dd' : return thn+"-"+bln+"-"+tgl;
    default : return tgl+"-"+bln+"-"+thn;
  }
}
//AKHIR SWITCH DATE

