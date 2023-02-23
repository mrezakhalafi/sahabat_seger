const flashData = $('.flash-data').data('flashdata');
  if (flashData) {
    Swal.fire({
    title: 'Berhasil!',
    text: flashData,
    type: 'success'
  })
}

function deleteData(idx){
  const hrefHapus= "kunjungan/deletehasil/"+idx;
  console.log(hrefHapus);
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
var dateToday = new Date();

$(document).ready(function(){

$(document).on("click", ".tambah_plus", function(e){
      var staff = $('#id_staff_hasil').val();

      $.ajax({
      type: "POST",
      data: "id="+staff,
      url : base_url+'kunjungan/getpoktan',
      beforeSend : function(){
        $("#id_poktan").html("<option value=''>Pilih Poktan</option>").trigger('change.select2');
      },
      success : function(result){

      var objResult=JSON.parse(result);
       $.each(objResult, function(i,v){    
          $("#id_poktan").append("<option value='"+v.id+"'>"+v.nama_poktan+"</option>");
      });
}});

   
  });



  $(".select2").each(function(){
        $(this).select2({
          width: 'resolve',
          placeholder: ($(this).attr("data-placeholder") ? $(this).attr("data-placeholder") : "Pilih"),
          multiple: ($(this).attr("data-multiple") === "true" ? true : false),
          maximumselectionlength: ($(this).attr("data-maximumselectionlength") ? $(this).attr("data-maximumselectionlength") : 0),
        })
    });


// $('#tgl_kunjungan_hasil').datepicker('setDate', 'dateToday');

//AWALMENYIMPAN VARIABEL STAFF
$('#id_staff_hasil').change(function() {
  $('#tgl_kunjungan_hasil').attr('disabled',false);
   var konten = $(this).val();
   localStorage.setItem('id_staff_hasil', konten);
})
//AKHIR MENYIMPAN VARIABEL STAFF

  if(localStorage.getItem("id_staff_hasil")==""){
   $('#tgl_kunjungan_hasil').attr('disabled',true);
  }
  else{
  savedataLoad2();
  }
  $('.tipe_wrapper').hide();
  $('#id_poktan').attr('disabled',true);

  $('#tipe_kunjungan').change(function() {
    if($('#tipe_kunjungan').val() == 3){
      $('#id_poktan').attr('disabled',true);
      $('#id_poktan').val("");
      $('#hasil_kunjungan').val("");  
      $('#aktual_kunjungan_input').attr('disabled',true);
      $('#hasil_kunjungan').attr('readonly',true);
          
    }else{
      $('#id_poktan').attr('disabled',false);
      $('#aktual_kunjungan_input').attr('disabled',false);
      $('#hasil_kunjungan').attr('readonly',false);
    }
  })
})
 
//AWAL VALIDASI MODAL  
function check(){
  var lolo = $('#tipe_kunjungan').val();
  var lolo2 = $('#id_poktan').val();

  if((lolo!="" && lolo2!="") ||  lolo == 3){
    $('#btn-tambah').attr('type','submit');
  }else if(lolo=="" || lolo2==""){
    Swal.fire({
      type: 'error',
      title: 'Data tidak lengkap',
      text: 'Silahkan lengkapi form.',

    })
    $('#btn-tambah').attr('type','button');
  };
};
//AKHIR VALIDASI MODAL

//AWAL PEMANGGILAN DATA FILTER
var konten2 = localStorage.getItem("id_staff_hasil");
$('#id_staff_hasil').val(konten2)

var konten4 = localStorage.getItem("tgl_kunjungan_hasil"); 
$('#tgl_kunjungan_hasil').val(konten4)
;

if(konten4==null){
  $('#tgl_kunjungan_kunjungan').attr('disabled',true);
}
//AKHIR PEMANGGILAN DATA FILTER

//AWAL DATEPICKER

$("#tgl_kunjungan_hasil").datepicker({
    dateFormat: 'dd/mm/yy',
 beforeShowDay:function(date){ 
    var day = date.getDay(); 
    return [(day == 1),""];
  }    
});

$("#aktual_kunjungan_input").datepicker({
  minDate: dateToday, 
  dateFormat: 'dd-mm-yy'
});
//AKHIR DATEPICKER

//AWAL HASIL KUNJUNGAN
$('#btn-kunjungan').attr('disabled',true);
$('#btn-hasil').hide();
$('#text-edit').hide();
$('#btn-edit').hide();
$('#btn-editTemp').hide();
$('#btn-tambah-hasil').hide();
//AKHIR HASIL KUNJUNGAN

//AWAL GET STATUS TANAM
  $('#id_poktan').change(function() {
  idx = $('#id_poktan').val();

  $.ajax({
      type: "POST",
      data: "id="+idx,
      url : base_url+'kunjungan/getstatusTanam',
      success : function(result){
      var objResult=JSON.parse(result);

         $('#id_poktan_tanam').val(objResult.id);
      }
  })
});
//AKHIR GET STATUS TANAM

//AWAL AJAX TGL KUNJUNGAN
function showModal2(tanggal,bulan,tahun){
    $('#id_poktan').attr('disabled',false);
    $('.tipe_wrapper').show();
    $('#btn-tambah-hasil').hide();
    $('#form_tancana').attr('action',base_url+'kunjungan/tambahhasiltancana');

    $(document).on("change", "#id_poktan", function() {
      $('#alamat_edit').val($("#id_poktan option:selected" ).attr("data-alamat"));
    });
    
    $('#btn-tambah').show();
    $('#text-tambah').show();
    $('#text-edit').hide();
    $('#btn-edit').hide();
    $('#modalKunjungan').modal('show');
    $('#tipe_kunjungan').val("");
    $('#id_poktan').val("");
    $('#id2').val("");
    $('#alamat').val("");
    $('#btn-editTemp').hide();
    if(bulan>=10){
    var bln_baru = "-"+bulan;
    }
    else if(bulan<10) {
    var bln_baru = "-"+"0"+bulan;
    }
    if(tanggal>=10){
    var tgl_baru = tanggal;
    }
    else if(tanggal<10) {
    var tgl_baru = "0"+tanggal;
    }
    var thn_baru = "-"+tahun;
    var hasil = tgl_baru+bln_baru+thn_baru;
    $('#tgl_kunjungan_input').val(hasil);

    if(bulan>=10){
    var bln_baru2 = bulan+"-";
    }
    else if(bulan<10) {
    var bln_baru2 = "0"+bulan+"-";
    }
    if(tanggal>=10){
    var tgl_baru2 = tanggal;
    }
    else if(tanggal<10) {
    var tgl_baru2 = "0"+tanggal;
    }
    var thn_baru2 = tahun+"-";
    var hasil2 = thn_baru2+bln_baru2+tgl_baru2;
    var hasil3 = tgl_baru2+bln_baru2+thn_baru2;
    let now = new Date(hasil2);
    let onejan = new Date(now.getFullYear(), 0, 1);
    week = Math.ceil( (((now - onejan) / 86400000) + onejan.getDay() + 1) / 7 );

    $('#periode').val(week);
    $('#aktual_kunjungan_input').val(hasil);

    var dt = new Date(hasil2);
    var currentWeekDay = dt.getDay();
    var lessDays = currentWeekDay == 0 ? 6 : currentWeekDay - 1;
    var wkStart = new Date(new Date(dt).setDate(dt.getDate() - lessDays));
    var wkEnd = new Date(new Date(wkStart).setDate(wkStart.getDate() + 5));

    var tgl_awal = wkStart.getDate();
    var bln_awal = wkStart.getMonth();
    var thn_awal = wkStart.getFullYear();
    var tgl_akhir = wkEnd.getDate();
    var bln_akhir = wkEnd.getMonth();
    var thn_akhir = wkEnd.getFullYear();

   if(bln_awal>=10){
    var bln_awal_baru = bln_awal+"-";
    }
    else if(bln_awal<10) {
    var bln_awal_baru = "0"+bln_awal+"-";
    }
    if(tgl_awal>=10){
    var tgl_awal_baru = tgl_awal;
    }
    else if(tgl_awal<10) {
    var tgl_awal_baru = "0"+tgl_awal;
    }
    var thn_awal_baru = thn_awal+"-";
    var hasil_awal = thn_awal_baru+bln_awal_baru+tgl_awal_baru;

   if(bln_akhir>=10){
    var bln_akhir_baru = bln_akhir+"-";
    }
    else if(bln_akhir<10) {
    var bln_akhir_baru = "0"+bln_akhir+"-";
    }
    if(tgl_akhir>=10){
    var tgl_akhir_baru = tgl_akhir;
    }
    else if(tgl_akhir<10) {
    var tgl_akhir_baru = "0"+tgl_akhir;
    }
    var thn_akhir_baru = thn_akhir+"-";
    var hasil_akhir = thn_akhir_baru+bln_akhir_baru+tgl_akhir_baru;

  $('#tgl_mulai').val(hasil_awal);
  $('#tgl_akhir').val(hasil_akhir);
}

function showTambah(idx){
  $('#id_poktan').attr('disabled',true);
  $('.tipe_wrapper').hide();
  $('#modalKunjungan').modal('show');
  $('#btn-tambah').show();
  $('#text-tambah').show();
  $('#text-edit').hide();
  $('#btn-edit').hide();
  $('#hasil_kunjungan').val("");
  $('#btn-tambah-hasil').show();
  $('#btn-tambah').hide();

  $.ajax({
    type: "POST",
    data: "id="+idx,
    url : base_url+'kunjungan/getdatakunjungan',
    success : function(result){
      var objResult=JSON.parse(result);
      let date_start = new Date(objResult.tgl_kunjungan);
      var hehe = generateDate(date_start, "dd-mm-yyyy");
      console.log(hehe);
      $('#id2').val(objResult.id);
      $('#tgl_kunjungan_input').val(hehe);
      $('#id_poktan').val(objResult.id_poktan);
      $('#aktual_kunjungan_input').val(hehe);
    }
  });
}

function showEditHasil(idx){
  $('#id_poktan').attr('disabled',true);
  $('.tipe_wrapper').hide();
  $('#modalKunjungan').modal('show');
  $('#btn-tambah').hide();
  $('#text-tambah').hide();
  $('#text-edit').show();
  $('#btn-edit').show();
  $('#btn-tambah-hasil').hide();
  $.ajax({
    type: "POST",
    data: "id="+idx,
    url : base_url+'kunjungan/getdatakunjungan',
    success : function(result){

      var objResult=JSON.parse(result);
      let date_start = new Date(objResult.tgl_kunjungan);
      var hehe = generateDate(date_start, "dd-mm-yyyy");
      $('#id2').val(objResult.id);
      $('#tgl_kunjungan_input').val(hehe);


      $.each(objResult.id_poktan, function(i,v){
          $("#id_poktan").append("<option value='"+v.id+"'>"+v.nama_poktan+"</option>");
      });

      $('#id_poktan').val(objResult.id_poktan).trigger('change.select2');




      var rapidate = $.date(objResult.aktual_kunjungan);
      $('#aktual_kunjungan_input').val(rapidate);
      $('#hasil_kunjungan').val(objResult.hasil_kunjungan);
    }
  });
}

//AWAL FORMAT DATE
$.date = function(dateObject) {
    var d = new Date(dateObject);
    var day = d.getDate();
    var month = d.getMonth() + 1;
    var year = d.getFullYear();
    if (day < 10) {
        day = "0" + day;
    }
    if (month < 10) {
        month = "0" + month;
    }
    var date = day + "-" + month + "-" + year;
    return date;
};
//AKHIR FORMAT DATE

//AWAL MENYIMPAN VARIABEL TANGGAL
$(document).on("change", "#tgl_kunjungan_hasil", function() {
  var konten4 = $(this).val();
  localStorage.setItem('tgl_kunjungan_hasil', konten4);
  savedataLoad2();
});
//AKHIR MENYIMPAN VARIABEL TANGGAL

//AWAL CETAK DATA
function savedataLoad2(){
  $("#tabel_tampil_hasil tbody").html("");
  let tgl2 = $('#tgl_kunjungan_hasil').val();
  tgl = tgl2.split("/").reverse().join("-");
  let date_start = new Date(tgl);

  for (var i = 0; i <= 5; i++) {
    let rowspan = 1;
    if(i > 0)
    date_start.setDate(date_start.getDate() + 1);
    var tanggal = date_start.getDate() < 10 ? "0"+date_start.getDate() : date_start.getDate();
    var bulan = (date_start.getMonth()+1) < 10 ? "0"+(date_start.getMonth()+1): (date_start.getMonth()+1);
    var tahun = date_start.getFullYear();
    var outputModal = "";
    var output = "";

    output += "<tr class='"+generateDate(date_start, "dd-mm-yyyy")+"'>";
    output += "   <td class='no'>"+(i+1)+"</td>";
    output += "   <td class='tgl'>"+generateDate(date_start, "dd-mm-yyyy")+"</td>";
    output += "  <td class='text-center butt'><button type='button' onclick='showModal2("+tanggal+","+bulan+","+tahun+")' class='btn btn-kirana btn-circle tambah_plus'><i class='fas fa-plus'></i></button></td>";
    output += "</tr>";
    $("#tabel_tampil_hasil tbody").append(output);

    //AJAX HARI BIASA
    $.ajax({
      type: "POST",
      dataType: "json",
      data: {
        tgl : generateDate(date_start, "yyyy-mm-dd"),
        staff : $("#id_staff_hasil").val()
      },
      url : base_url+'poktantanam/tampilKunjungan',
      success : function(result){

        if(result && result.length > 0){
          $.each(result, function(i, v){
          let dates = new Date(v.tgl_kunjungan);
            if(i == 0){

              if(v.id_poktan==null){
                $("tr."+generateDate(dates, "dd-mm-yyyy")+" .tambah_plus").attr("disabled",false);
                output2 += "<td>Hari Libur Nasional</td>";
                output2 += "<td>Hari Libur Nasional</td>";
                output2 += "<td>Hari Libur Nasional</td>";
                output2 += "<td>Hari Libur Nasional</td>";
                output2 += "<td>-</td>";
                let elem = $("tr."+generateDate(dates, "dd-mm-yyyy")).eq(i);
                elem.append(output2);
              }else{
              if(v.aktual_kunjungan!="0000-00-00"){
                output2 = "<td>"+($.date(v.aktual_kunjungan))+"</td>";
              }else{
                output2 = "<td></td>";
              }
              output2 += "<td>"+(v.nama_poktan)+"</td>";
              output2 += "<td>"+(v.hasil_kunjungan)+"</td>";

              var today = new Date();
              var dd = String(today.getDate()).padStart(2, '0');
              var mm = String(today.getMonth() + 1).padStart(2, '0');
              var yyyy = today.getFullYear();
              today = yyyy + '-' + mm + '-' + dd;

 

                $.ajax({
                  type: "POST",
                  dataType: "json",
                  data: {
                    tanam : v.id_poktan_tanam
                  },
                  url : base_url+'poktantanam/tampilStatus',
                  success : function(result){

                    $.each(result, function(i, v){
                    var today = new Date();
                    var dd = today.getDate();
                    var mm = today.getMonth() + 1
                    var yyyy = today.getFullYear();
                    if (dd < 10) {
                      dd = '0' + dd;
                    } 
                    if (mm < 10) {
                      mm = '0' + mm;
                    } 
                    var today = yyyy + '-' + mm + '-' + dd;
                  if(v.tgl_panen<today){
                  $("."+v.id).html("Belum Tersedia");
                  }
                });

              }});
              if(v.id_poktan_tanam!=0){
                output2 += "<td class='"+v.id_poktan_tanam+"'><a href='"+base_url+"poktantanam/direct/?id="+v.id_poktan_tanam+"'>Tersedia</a></td>";

                var staff_tanam = v.id_poktan_tanam;
                localStorage.setItem('id_staff_tanam', staff_tanam);

                }if(v.id_poktan_tanam==0){
                  output2 += "<td><a>Belum Tersedia</a></td>"; 
                }   


                if(v.hasil_kunjungan=="" && v.aktual_kunjungan=="0000-00-00"){
                  output2 += "<td class='text-center'><button type='button' onclick='showTambah("+v.id+")' class='btn btn-sm btn-info'>Tambah</button>";
                }else{
                  output2 += "<td class='text-center'><button type='button' data-id='"+v.id+"' onclick='showEditHasil("+v.id+")' class='btn btn-sm btn-success'>Edit</button> <a class='tombol-hapus'><button onclick='deleteData("+v.id+")' type='button' class='btn btn-sm btn-danger btn-hapus'>Delete</button></a></td>";
                }

                let elem = $("tr."+generateDate(dates, "dd-mm-yyyy")).eq(i);
                elem.append(output2);
              }
            }else{
              $("tr."+generateDate(dates, "dd-mm-yyyy")+" td").eq(0).attr("rowspan", result.length);
              $("tr."+generateDate(dates, "dd-mm-yyyy")+" td").eq(1).attr("rowspan", result.length);
              $("tr."+generateDate(dates, "dd-mm-yyyy")+" td").eq(2).attr("rowspan", result.length);
              
              if(v.id_poktan==null){
              
              var output2 = "<tr class='"+generateDate(dates, "dd-mm-yyyy")+"'>";
              output2 += "<td>Hari Libur Nasional</td>";
              output2 += "<td>Hari Libur Nasional</td>";
              output2 += "<td>Hari Libur Nasional</td>";
              output2 += "<td>Hari Libur Nasional</td>";
              output2 += "<td>-</td>";
              output2 += "</tr>"; 
              let elem = $("tr."+generateDate(dates, "dd-mm-yyyy")).eq(i-1);
              $(output2).insertAfter(elem);
              }
              else{
              var output2 = "<tr class='"+generateDate(dates, "dd-mm-yyyy")+"'>";
              
              if(v.aktual_kunjungan!="0000-00-00"){
                output2 += "<td>"+($.date(v.aktual_kunjungan))+"</td>";
              }else{
                output2 += "<td></td>";
              }
              output2 += "<td>"+(v.nama_poktan)+"</td>";
              output2 += "<td>"+(v.hasil_kunjungan)+"</td>";
 
              if(v.id_poktan_tanam!=0){
                output2 += "<td><a href='"+base_url+"poktantanam/direct/?id="+v.id_poktan_tanam+"'>Tersedia</a></td>";
              }if(v.id_poktan_tanam==0){
                output2 += "<td><a>Belum Tersedia</a></td>"; 
              }

              if(v.hasil_kunjungan=="" && v.aktual_kunjungan=="0000-00-00"){
                output2 += "<td class='text-center'><button type='button' onclick='showTambah("+v.id+")' class='btn btn-sm btn-info'>Tambah</button>";
              }else{
                output2 += "<td class='text-center'><button type='button' onclick='showEditHasil("+v.id+")' class='btn btn-sm btn-success'>Edit</button> <a class='tombol-hapus'><button onclick='deleteData("+v.id+");' type='button'  class='btn btn-sm btn-danger btn-hapus'>Delete</button></a></td>";
              }

              output2 += "</tr>";
              let elem = $("tr."+generateDate(dates, "dd-mm-yyyy")).eq(i-1);
              $(output2).insertAfter(elem);
              }
            }
          });
        }
      }
    });
  }
};
//AKHIR CETAK DATA

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
//AKHIR PILIH DATE KUNJUNGAN SEMENTARA




