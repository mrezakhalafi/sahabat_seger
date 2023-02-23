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

$(document).ready( function () {
  // AWAL DATATABLE
  $('#tb_poktantanam').DataTable({
  });        
  // AKHIR DATATABLE
  $(".select2").each(function(){
        $(this).select2({
          placeholder: ($(this).attr("data-placeholder") ? $(this).attr("data-placeholder") : "Pilih"),
          multiple: ($(this).attr("data-multiple") === "true" ? true : false),
          maximumselectionlength: ($(this).attr("data-maximumselectionlength") ? $(this).attr("data-maximumselectionlength") : 0),
        })
  });
});



var tutu = localStorage.getItem('id_staff_tanam');

//AWAL FILTER POKTANTANAM
$('#id_staff_poktanam').change(function() {
  var id_plant = $('#id_plant_cabang_poktanam').val();
  var id_staff1 = $(this).val();
  var id_poktan = $('#id_poktan_poktanam').val();
  $('#tb_poktantanam tbody').html("");
    $.ajax({
      type: "POST",
      dataType: "json",
      data: {
        id_staff : id_staff1,
        id_plant : id_plant,
        id_poktan : id_poktan
      },
      url : base_url+'poktantanam/tampilFilterStaff',
      success : function(result){
      var j = 1;
      if(result!=""){
      $.each(result, function(i, v){
      var output = "";
      var d = new Date(v.tgl_tanam);
      var e = new Date(v.tgl_panen);

      d.setDate(d.getDate() + 1);
        var tanggal = d.getDate() < 10 ? "0"+d.getDate() : d.getDate();
        var bulan = (d.getMonth()+1) < 10 ? "0"+(d.getMonth()+1): (d.getMonth()+1);
        var tahun = d.getFullYear();
        var tanam = tanggal+"-"+bulan+"-"+tahun;
      e.setDate(e.getDate() + 1);
        var tanggal2 = e.getDate() < 10 ? "0"+e.getDate() : e.getDate();
        var bulan2 = (e.getMonth()+1) < 10 ? "0"+(e.getMonth()+1): (e.getMonth()+1);
        var tahun2 = e.getFullYear();
        var panen = tanggal2+"-"+bulan2+"-"+tahun2;

        output += "<tr>";
        output += "<td>"+(j)+"</td>";
        output += "<td>"+tanam+"</td>";
        output += "<td>"+panen+"</td>";
        output += "<td>"+v.nama_poktan+"</td>";
        output += "<td>"+v.fullname+"</td>";
        output += "<td class='"+v.id+"''>";

        $.ajax({
          type: "POST",
          dataType: "json",
          data: {
            id_tanam : v.id
          },
          url : base_url+'poktantanam/tampilDataPlant',
          beforeSend : function(result){

          },
          success : function(result){
            $.each(result, function(i, v){
            output ="";
            output += v.nama_cabang+"<br/>";
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
        }else if(hasil < 50 && hasil >0){
        output += "<td class='min-width-150'><div class='progress progress-bar mr-2'><div class='progress-bar bg-warning prosesbar' role='progressbar' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100' style='width: "+hasil+"%'></div></div><small>"+diffDays+"/120 hari ("+Math.round(hasil)+"% )</small></td>";
        }else if(hasil>=100){
        output += "<td class='min-width-150'><div class='progress progress-bar mr-2'><div class='progress-bar bg-primary prosesbar' role='progressbar' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100' style='width: "+hasil+"%'></div></div><small>120/120 hari (100% )</small></td>";
        }else if(hasil<0){
        output += "<td class='min-width-150'><div class='progress progress-bar mr-2'><div class='progress-bar prosesbar' role='progressbar' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100' style='width: "+hasil+"%'></div></div><small>0/120 hari (0% )</small></td>";
        }
          
        if(v.aktif==1){
          output += "<td><i class='fas fa-check-circle icon-check'></i></td>";
        }else{
            output += "<td><i class='fas fa-times-circle icon-uncheck'></i></td>";
        }

        // if(v.aktif==1){
        //     output += "<td class='min-width-btn text-center'><button class='btn btn-info btn-sm' onclick='showmodalpoktantanam("+v.id+")' data-toggle='modal' data-target='#modalpoktantanam'>Detail fgdfg</button> <a href='poktantanam/ubahpoktanTanam?id="+v.id+"'><button class='btn btn-success btn-sm'>Edit</button></a> <button onclick='deleteData()' data-link='poktantanam/delete/"+v.id+"' class='btn btn-hapus'>Delete</button></td>";
        // }else{
        //     output += "<td class='min-width-btn text-center'><button class='btn btn-info btn-sm' onclick='showmodalpoktantanam("+v.id+")' data-toggle='modal' data-target='#modalpoktantanam'>Detail</button> <a href='poktantanam/ubahpoktanTanam?id="+v.id+"'><button class='btn btn-success btn-sm'>Edit</button></a><a href='poktantanam/aktif/"+v.id+"'><button class='btn btn-primary min-width-btn-59 btn-sm'>Aktif</button></a></td>";
        // }
        output += "<td class='min-width-btn text-center'><div class='dropdown'><button class='btn btn-secondary btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Action </button><div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>";
        if (hasil >=120) {
          output += "<a class='dropdown-item' href='#' onclick='showmodalpoktantanam120("+v.id+")' data-toggle='modal' data-target='#modalpoktantanam'>Detail</a>";
        }else{
          output += "<a class='dropdown-item' href='#' onclick='showmodalpoktantanam("+v.id+")' data-toggle='modal' data-target='#modalpoktantanam'>Detail</a>";
        }
        if(v.aktif==1){
            output += "<a href='#' class='btn-hapus dropdown-item tombol-hapus' onclick='deleteData()' data-link='poktantanam/delete/"+v.id+"'>Delete</a>";
        }else{
            output += "<a class='dropdown-item' href='poktantanam/aktif/"+v.id+"'>Aktif</a>";
        }
        output += "<a class='dropdown-item' href='poktantanam/ubahpoktanTanam?id="+v.id+"'>Edit</a><div class='dropdown-divider'></div><a class='dropdown-item' href='#' onclick='showmodalhasil("+v.id+");'>Tambah Hasil</a><a class='dropdown-item' href='#' onclick='showmodalhasiledit("+v.id+");'>Edit Hasil</a></div></td>";
       


        output += "</tr>";
        $('#tb_poktantanam tbody').append(output);
        j++;
      })
      }else{
      var cols = $("#tb_poktantanam").find("th").length;
      output = "<tr class='text-center'>";
      output += "<td colspan='"+cols+"'>No matching records found</td>";
      output += "</tr>";
      $('#tb_poktantanam tbody').append(output);
      }
    }
  })
});


$('#id_poktan_poktanam').change(function() {
  var id_poktan = $(this).val();
  var id_plant = $('#id_plant_cabang_poktanam').val();
  var id_staff = $('#id_staff_poktanam').val();
  $('#tb_poktantanam tbody').html("");

  $.ajax({
        type: "POST",
        dataType: "json",
        data: {
          id_poktan : id_poktan,
          id_plant : id_plant,
          id_staff : id_staff
        },
        url : base_url+'poktantanam/tampilFilter',
        success : function(result){
          var i = 1;
          if(result!=""){
          $.each(result, function(i, v){
          var output = "";
          var d = new Date(v.tgl_tanam);
          var e = new Date(v.tgl_panen);

          d.setDate(d.getDate() + 1);
            var tanggal = d.getDate() < 10 ? "0"+d.getDate() : d.getDate();
            var bulan = (d.getMonth()+1) < 10 ? "0"+(d.getMonth()+1): (d.getMonth()+1);
            var tahun = d.getFullYear();
            var tanam = tanggal+"-"+bulan+"-"+tahun;
          e.setDate(e.getDate() + 1);
            var tanggal2 = e.getDate() < 10 ? "0"+e.getDate() : e.getDate();
            var bulan2 = (e.getMonth()+1) < 10 ? "0"+(e.getMonth()+1): (e.getMonth()+1);
            var tahun2 = e.getFullYear();
            var panen = tanggal2+"-"+bulan2+"-"+tahun2;

          output += "<tr>";
          output += "<td>"+(1+i)+"</td>";
          output += "<td>"+tanam+"</td>";
          output += "<td>"+panen+"</td>";
          output += "<td>"+v.nama_poktan+"</td>";
          output += "<td>"+v.fullname+"</td>";
          output += "<td class='"+v.id+"''>";

          $.ajax({
            type: "POST",
            dataType: "json",
            data: {
              id_tanam : v.id
            },
            url : base_url+'poktantanam/tampilDataPlant',
            beforeSend : function(result){

            },
            success : function(result){
              $.each(result, function(i, v){
              output ="";
              output += v.nama_cabang+"<br/>";
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
          }else if(hasil < 50 && hasil >0){
            output += "<td class='min-width-150'><div class='progress progress-bar mr-2'><div class='progress-bar bg-warning prosesbar' role='progressbar' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100' style='width: "+hasil+"%'></div></div><small>"+diffDays+"/120 hari ("+Math.round(hasil)+"% )</small></td>";
          }else if(hasil>=100){
            output += "<td class='min-width-150'><div class='progress progress-bar mr-2'><div class='progress-bar bg-primary prosesbar' role='progressbar' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100' style='width: "+hasil+"%'></div></div><small>120/120 hari (100% )</small></td>";
          }else if(hasil<0){
          output += "<td class='min-width-150'><div class='progress progress-bar mr-2'><div class='progress-bar prosesbar' role='progressbar' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100' style='width: "+hasil+"%'></div></div><small>0/120 hari (0% )</small></td>";
          }
               
          if(v.aktif==1){
            output += "<td><i class='fas fa-check-circle icon-check'></i></td>";  
          }else{
            output += "<td><i class='fas fa-times-circle icon-uncheck'></i></td>";
          }

          output += "<td class='min-width-btn text-center'><div class='dropdown'><button class='btn btn-secondary btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Action </button><div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>";
          if (hasil >=120) {
            output += "<a class='dropdown-item' href='#' onclick='showmodalpoktantanam120("+v.id+")' data-toggle='modal' data-target='#modalpoktantanam'>Detail</a>";
          }else{
            output += "<a class='dropdown-item' href='#' onclick='showmodalpoktantanam("+v.id+")' data-toggle='modal' data-target='#modalpoktantanam'>Detail</a>";
          }
          if(v.aktif==1){
              output += "<a href='#' class='btn-hapus dropdown-item tombol-hapus' onclick='deleteData()' data-link='poktantanam/delete/"+v.id+"'>Delete</a>";
          }else{
              output += "<a class='dropdown-item' href='poktantanam/aktif/"+v.id+"'>Aktif</a>";
          }
          output += "<a class='dropdown-item' href='poktantanam/ubahpoktanTanam?id="+v.id+"'>Edit</a><div class='dropdown-divider'></div><a class='dropdown-item' href='#' onclick='showmodalhasil("+v.id+");'>Tambah Hasil</a><a class='dropdown-item' href='#' onclick='showmodalhasiledit("+v.id+");'>Edit Hasil</a></div></td>";

          output += "</tr>";
          $('#tb_poktantanam tbody').append(output);
          i++;
      })
      }else{
      var cols = $("#tb_poktantanam").find("th").length;
      output = "<tr class='text-center'>";
      output += "<td colspan='"+cols+"'>No matching records found</td>";
      output += "</tr>";
      $('#tb_poktantanam tbody').append(output);
      }
    }
  })
});

$('#id_plant_cabang_poktanam').change(function() {
  var id_plant = $(this).val();
  var id_staff = $('#id_staff_poktanam').val();
  var id_poktan = $('#id_poktan_poktanam').val();

  $('#tb_poktantanam tbody').html("");
    $.ajax({
      type: "POST",
      dataType: "json",
      data: {
        id_plant : id_plant,
        id_staff : id_staff,
        id_poktan : id_poktan
      },
      url : base_url+'poktantanam/tampilFilterPlant',
      success : function(result){

      var j = 1;
      if(result!=""){
      $.each(result, function(i, v){
      var output = "";
      var d = new Date(v.tgl_tanam);
      var e = new Date(v.tgl_panen);

      d.setDate(d.getDate() + 1);
        var tanggal = d.getDate() < 10 ? "0"+d.getDate() : d.getDate();
        var bulan = (d.getMonth()+1) < 10 ? "0"+(d.getMonth()+1): (d.getMonth()+1);
        var tahun = d.getFullYear();
        var tanam = tanggal+"-"+bulan+"-"+tahun;
      e.setDate(e.getDate() + 1);
        var tanggal2 = e.getDate() < 10 ? "0"+e.getDate() : e.getDate();
        var bulan2 = (e.getMonth()+1) < 10 ? "0"+(e.getMonth()+1): (e.getMonth()+1);
        var tahun2 = e.getFullYear();
        var panen = tanggal2+"-"+bulan2+"-"+tahun2;

        output += "<tr>";
        output += "<td>"+(j)+"</td>";
        output += "<td>"+tanam+"</td>";
        output += "<td>"+panen+"</td>";
        output += "<td>"+v.nama_poktan+"</td>";
        output += "<td>"+v.fullname+"</td>";
        output += "<td class='"+v.id+"''>";

          $.ajax({
            type: "POST",
            dataType: "json",
            data: {
              id_tanam : v.id
            },
            url : base_url+'poktantanam/tampilDataPlant',
            beforeSend : function(result){

            },
            success : function(result){
              $.each(result, function(i, v){
              output ="";
              output += v.nama_cabang+"<br/>";
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
        }else if(hasil < 50 && hasil >0){
        output += "<td class='min-width-150'><div class='progress progress-bar mr-2'><div class='progress-bar bg-warning prosesbar' role='progressbar' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100' style='width: "+hasil+"%'></div></div><small>"+diffDays+"/120 hari ("+Math.round(hasil)+"% )</small></td>";
        }else if(hasil>=100){
        output += "<td class='min-width-150'><div class='progress progress-bar mr-2'><div class='progress-bar bg-primary prosesbar' role='progressbar' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100' style='width: "+hasil+"%'></div></div><small>120/120 hari (100% )</small></td>";
        }else if(hasil<0){
        output += "<td class='min-width-150'><div class='progress progress-bar mr-2'><div class='progress-bar prosesbar' role='progressbar' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100' style='width: "+hasil+"%'></div></div><small>0/120 hari (0% )</small></td>";
        }
          
        if(v.aktif==1){
          output += "<td><i class='fas fa-check-circle icon-check'></i></td>";
        }else{
            output += "<td><i class='fas fa-times-circle icon-uncheck'></i></td>";
        }

        output += "<td class='min-width-btn text-center'><div class='dropdown'><button class='btn btn-secondary btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Action </button><div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>";
        if (hasil >=120) {
          output += "<a class='dropdown-item' href='#' onclick='showmodalpoktantanam120("+v.id+")' data-toggle='modal' data-target='#modalpoktantanam'>Detail</a>";
        }else{
          output += "<a class='dropdown-item' href='#' onclick='showmodalpoktantanam("+v.id+")' data-toggle='modal' data-target='#modalpoktantanam'>Detail</a>";
        }
        if(v.aktif==1){
            output += "<a href='#' class='btn-hapus dropdown-item tombol-hapus' onclick='deleteData()' data-link='poktantanam/delete/"+v.id+"'>Delete</a>";
        }else{
            output += "<a class='dropdown-item' href='poktantanam/aktif/"+v.id+"'>Aktif</a>";
        }
        output += "<a class='dropdown-item' href='poktantanam/ubahpoktanTanam?id="+v.id+"'>Edit</a><div class='dropdown-divider'></div><a class='dropdown-item' href='#' onclick='showmodalhasil("+v.id+");'>Tambah Hasil</a><a class='dropdown-item' href='#' onclick='showmodalhasiledit("+v.id+");'>Edit Hasil</a></div></td>";

        output += "</tr>";
        $('#tb_poktantanam tbody').append(output);
        j++;
      })
      }else{
      var cols = $("#tb_poktantanam").find("th").length;
      output = "<tr class='text-center'>";
      output += "<td colspan='"+cols+"'>No matching records found</td>";
      output += "</tr>";
      $('#tb_poktantanam tbody').append(output);
      }
    }
  })
});
//AKHIR FILTER POKTANTANAM

function fetchDataFilter(action, query, result){
  $.ajax({
    url : base_url+'poktantanam/fetch',
    method:"POST",
    data:{postaction:action, query:query},
    success:function(data){
     $('#'+result).append(data);
    }
  })
}

//AWAL DATEPICKER
var dateToday = new Date();
$("#tgl_tanam").datepicker({
  // minDate: dateToday,
  dateFormat: 'dd/mm/yy',
  changeYear: true 
});
//AKHIR DATEPICKER

//AWAL POKTAN TANAM

$('#penyakit_desc').hide();
$('#penyakit').change(function() {
var ket = $('#penyakit').val();
if (ket == 'Ada'){
  $('#penyakit_desc').show();
}else{
  $('#penyakit_desc').hide();
  }
});
//AKHIR POKTAN TANAM

// AWAL AJAX POKTAN TANAM
function pilihdatapoktanTanam(idx){
  console.log(idx);
  $.ajax({
    type: "POST",
    data: "id="+idx,
    url : base_url+'poktantanam/getdatapoktanTanam',
    success : function(result){
      var objResult=JSON.parse(result);
      $("#id_poktan_tanam").val(objResult.id_poktan).trigger("change.select2");;
      var tgl_tanam = generateDate(new Date(objResult.tgl_tanam), 'dd/mm/yyyy');
      $("#tgl_tanam").val(tgl_tanam);
      $("#tgl_tanam").datepicker({
        dateFormat: 'dd/mm/yy',
        defaultDate: new Date(objResult.tgl_tanam)             
       });
      var tgl_panen = generateDate(new Date(objResult.tgl_panen), 'dd/mm/yyyy');
      $("#tgl_panen").val(tgl_panen);
      // $("#tgl_panen").datepicker({
      //   dateFormat: 'dd/mm/yy',
      //   defaultDate: new Date(objResult.tgl_panen)             
      // });
      $("#luas_tanam").val(objResult.luas_tanam);
      $("#pengairan1").val(objResult.pengairan1);
      $("#pemupukan1").val(objResult.pemupukan1);
      $("#penjarangan").val(objResult.penjarangan);
      $("#penyiangan").val(objResult.penyiangan);
      $("#nama_poktan").val(objResult.nama_poktan);
      $("#penyakit").val(objResult.penyakit);
      $("#pemupukan2").val(objResult.pemupukan2);
      $("#pengairan2").val(objResult.pengairan2);
      $("#pengairan3").val(objResult.pengairan3);
      // $("#staff").val(objResult.staff).trigger("change.select2");

      $.each(objResult.staff, function(i,v){
        $("#staff").append("<option value='"+v.id+"'>"+v.fullname+"</option>");   
        console.log(v.id_staff);
      $("#staff").val(v.id_staff).trigger("change.select2");

       
      });
      





      $("#prediksi_tonase").val(objResult.prediksi_tonase);
      if (objResult.penyakit == 'Ada') {
          $('#penyakit_desc').show();
          $("#penyakit_desc").val(objResult.penyakit_desc);
      }else{
          $('#penyakit_desc').hide();
      }
      $('#penyakit').change(function() {
        var ket = $('#penyakit').val();
        if (ket == 'Ada'){
          //desc
        }else{
          $("#penyakit_desc").val("");
        }
      });

      $('#tgl_panen').css({"color": "#6e707e"});
      $("#id2").val(objResult.id);
      if (objResult.aktif == 1){
       document.getElementById("aktif_poktantanam").checked = true;
        document.getElementById("nonaktif_poktantanam").checked = false;      
      }else{
        document.getElementById("nonaktif_poktantanam").checked = true;
        document.getElementById("aktif_poktantanam").checked = false;
      }
    }
  })
}
//AKHIR AJAX POKTAN TANAM

//AWAL AJAX BATAS LUAS TANAM
$('#id_poktan_tanam').change(function(){
  idx = $('#id_poktan_tanam').val();
  $.ajax({
      type: "POST",
      data: "id="+idx,
      url : base_url+'poktantanam/fetchpoktantanam',
      success : function(result){
      var objResult=JSON.parse(result);
      
 items = 0;

      $.each(objResult, function(i, v){

  items+=parseInt(v.luas);  
      $('#luas_lahan').val(items);
      $('#angkaluas').text(items);

      localStorage.setItem('luas', items);

    });

      }});
    });

$('#luas_lahan').val(localStorage.getItem('luas'));
$('#angkaluas').text(localStorage.getItem('luas'));

//AKHIR AJAX BATAS LUAS TANAM


//AWAL SHOW MODAL POKTAN TANAM
function showmodalpoktantanam120(idx){
  $('#modalpoktantanam').modal('show');
 $.ajax({
    type: "POST",
    data: "id="+idx,
    url : base_url+'poktantanam/getdatapoktanTanam120',

    success : function(result){
      var objResult=JSON.parse(result);
      var tgl_tanam = generateDate(new Date(objResult.tgl_tanam), 'dd-mm-yyyy');
      $('#tgl_tanam_p').text(tgl_tanam);
      var tgl_panen = generateDate(new Date(objResult.tgl_panen), 'dd-mm-yyyy');
      $('#tgl_panen').text(tgl_panen);
      $('#luas_tanam').text(objResult.luas_tanam);
      $('#pengairan1').text(objResult.pengairan1);
      $('#pemupukan1').text(objResult.pemupukan1);
      $('#penjarangan').text(objResult.penjarangan);
      $('#penyiangan').text(objResult.penyiangan);
      $('#penyakit').text(objResult.penyakit);
      if (objResult.penyakit_desc) {
        $('#penyakit_description').text(objResult.penyakit_desc);
      }else{
        $('#penyakit_description').text('-');
      }    
      $('#pemupukan2').text(objResult.pemupukan2);
      $('#pengairan2').text(objResult.pengairan2);
      $('#pengairan3').text(objResult.pengairan3); 
      $("#prediksi_tonase").text(objResult.prediksi_tonase);


      $('#hasil_panen').text(objResult.hasil_panen);
      $('#kadar_air').text(objResult.kadar_air);
    
    }
  })
}
//AKHIR SHOW MODAL POKTAN TANAM


//AWAL SHOW MODAL POKTAN TANAM
function showmodalpoktantanam(idx){
  $('#modalpoktantanam').modal('show');
 $.ajax({
    type: "POST",
    data: "id="+idx,
    url : base_url+'poktantanam/getdatapoktanTanam',

    success : function(result){
      var objResult=JSON.parse(result);
      var tgl_tanam = generateDate(new Date(objResult.tgl_tanam), 'dd-mm-yyyy');
      $('#tgl_tanam_p').text(tgl_tanam);
      var tgl_panen = generateDate(new Date(objResult.tgl_panen), 'dd-mm-yyyy');
      $('#tgl_panen').text(tgl_panen);
      $('#luas_tanam').text(objResult.luas_tanam);
      $('#pengairan1').text(objResult.pengairan1);
      $('#pemupukan1').text(objResult.pemupukan1);
      $('#penjarangan').text(objResult.penjarangan);
      $('#penyiangan').text(objResult.penyiangan);
      $('#penyakit').text(objResult.penyakit);
      if (objResult.penyakit_desc) {
        $('#penyakit_description').text(objResult.penyakit_desc);
      }else{
        $('#penyakit_description').text('-');
      }    
      $('#pemupukan2').text(objResult.pemupukan2);
      $('#pengairan2').text(objResult.pengairan2);
      $('#pengairan3').text(objResult.pengairan3); 
      $("#prediksi_tonase").text(objResult.prediksi_tonase);


      $('#hasil_panen').text(objResult.hasil_panen);
      $('#kadar_air').text(objResult.kadar_air);
    
    }
  })
}
//AKHIR SHOW MODAL POKTAN TANAM

//AWAL SHOW MODAL HASIL POKTAN TANAM
function showmodalhasil(idx){
  $('#modalhasil').modal('show');
  $('#id_lahan').val("");
  $('#luas_tanam2').val("");
  $('.hasil_panen').val("");
  $('.kadar_air').val("");
  $('.id_tanam').val(idx);
  $('.text-tambah-hasil').text('Tambah Hasil Panen');
  $('#btn-tambah').text('Tambah');
  $('#btn-tambah').attr('onclick','check()');
  $('#form-tambah-hasil').attr('action', base_url+'poktantanam/tambahhasil');
   $.ajax({
      type: "POST",
      data: "id="+idx,
      url : base_url+'poktantanam/getdatapoktanTanam',

      success : function(result){
        var objResult=JSON.parse(result);
        $('#luas_tanam2').val(objResult.luas_tanam);
        $('#id_lahan').val(objResult.lahan);
      }

    })
}
//AKHIR SHOW MODAL HASIL POKTAN TANAM

//AWAL SHOW MODAL HASIL POKTAN TANAM
function showmodalhasiledit(idx){
  $('#id_lahan').val("");
  $('.id_tanam').val("");
  $('#luas_tanam2').val("");
  $('.hasil_panen').val("");
  $('.kadar_air').val("");
  $('#modalhasil').modal('show');
  $('.text-tambah-hasil').text('Ubah Hasil Panen');
  $('#btn-tambah').text('Ubah');
  $('#btn-tambah').attr('onclick','checkubah()');
  $('#form-tambah-hasil').attr('action', base_url+'poktantanam/ubahhasil');
   $.ajax({
      type: "POST",
      data: "id="+idx,
      url : base_url+'poktantanam/getdatahasilPanen',
    
      success : function(result){

        var objResult=JSON.parse(result);
        $('.id_tanam').val(objResult.id_tanam);
        $('#id_lahan').val(objResult.id_lahan);
        $('#luas_tanam2').val(objResult.luas_tanam);
        $('.hasil_panen').val(objResult.hasil_panen);
        $('.kadar_air').val(objResult.kadar_air);
      }
    })
}
//AKHIR SHOW MODAL HASIL POKTAN TANAM

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

//JQUERY TGL TANAM
$('#tgl_tanam').on('change', function() {
  var now = stringToDate($('#tgl_tanam').val(),"dd/MM/yyyy","/");
  now.setDate(now.getDate()+120); 
  var day = ("0" + now.getDate()).slice(-2);
  var month = ("0" + (now.getMonth() + 1)).slice(-2);
  var today = day+"/"+(month)+"/"+now.getFullYear();
  $('#tgl_panen').val(today);
  $('#tgl_panen').css({"color": "#6e707e"});
  });
// AKHIR JQUERY TANGGAL TANAM

//AWAL FORMAT DATE UNTUK DATEPICKER TANAM
function stringToDate(_date,_format,_delimiter)
{
  var formatLowerCase=_format.toLowerCase();
  var formatItems=formatLowerCase.split(_delimiter);
  var dateItems=_date.split(_delimiter);
  var monthIndex=formatItems.indexOf("mm");
  var dayIndex=formatItems.indexOf("dd");
  var yearIndex=formatItems.indexOf("yyyy");
  var month=parseInt(dateItems[monthIndex]);
  month-=1;
  var formatedDate = new Date(dateItems[yearIndex],month,dateItems[dayIndex]);
  return formatedDate;
}
//AKHIR FORMAT DATE UNTUK DATEPICKER TANAM

//AWAL VALIDASI MODAL  
function check(){
  var hasil_panen = $('.hasil_panen').val();
  var kadar_air = $('.kadar_air').val();
  var id_tanam = $('.id_tanam').val();

  if(hasil_panen!="" && kadar_air!=""){

   $.ajax({
      type: "POST",
      url : base_url+'poktantanam/cekhasil',
    
      success : function(result){
      console.log(result);


if(result.length<=4){
     $('#btn-tambah').attr('type','submit');
     $('#btn-tambah').click();
}else{

      var objResult=JSON.parse(result);


    if(id_tanam!=objResult.id_tanam){
    $('#btn-tambah').attr('type','submit');
    }else{
    Swal.fire({
      type: 'error',
      title: 'Data sudah ada',
      text: 'Silakan cek data.',

    })
    $('#btn-tambah').attr('type','button');
  };

}

}})









  }else{
    Swal.fire({
      type: 'error',
      title: 'Data tidak lengkap',
      text: 'Silakan lengkapi form.',

    })
    $('#btn-tambah').attr('type','button');
  };

};
//AKHIR VALIDASI MODAL

//AWAL VALIDASI MODAL  
function checkubah(){
  var hasil_panen = $('.hasil_panen').val();
  var kadar_air = $('.kadar_air').val();

  if(hasil_panen!="" && kadar_air!=""){

    $('#btn-tambah').attr('type','submit');

  }else{
    Swal.fire({
      type: 'error',
      title: 'Data tidak lengkap',
      text: 'Silakan lengkapi form.',

    })
    $('#btn-tambah').attr('type','button');
  };

}
//AKHIR VALIDASI MODAL

$(document).on("change", ".sort", function() {
  if($(this).val() != '')
  {
   var action = $(this).attr("id");
   var query = $(this).val();
   var result = '';
   if(action == "id_poktan_tanam")
   {
    result = 'staff';
   }
   fetchDataStaff(action, query, result);
  }
 });

function fetchDataStaff(action, query, result){
  $.ajax({
    url : base_url+'poktantanam/staffFetch',
    method:"POST",
    data:{postaction:action, query:query},
    success:function(data){
     $('#'+result).html(data);
    }
  })
}