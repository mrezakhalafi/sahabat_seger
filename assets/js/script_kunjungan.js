const flashData = $('.flash-data').data('flashdata');
  if (flashData) {
    Swal.fire({
    title: 'Berhasil!',
    text: flashData,
    type: 'success'
  })
}

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


$(document).ready(function(){
$(document).on("click", ".tambah_plus", function(e){
      var staff = $('#id_staff_kunjungan').val();

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
          $("#id_poktan").append("<option value='"+v.id+"' data-alamat='"+v.alamat+"'>"+v.nama_poktan+"</option>");
      });
}});

   
  });








  // $('#tgl_kunjungan_kunjungan').attr('disabled',true);
  if(localStorage.getItem("id_staff_kunjungan")==""){
    $('#tgl_kunjungan_kunjungan').attr('disabled',true);
  }// Cetak Notice Awal
  else{
  savedataLoad();
  }
  $('#id_poktan').attr('disabled',false);
  
  $('#tipe_kunjungan').change(function() {
    if($('#tipe_kunjungan').val() == 3){
      $('#id_poktan').attr('disabled',true);
      $('#id_poktan').val("");
      $('#hasil_kunjungan').val("");  
      $('#aktual_kunjungan_input').attr('disabled',true);
      $('#hasil_kunjungan').attr('readonly',true);
      $('#cobaa').val("");
          
    }else{
      $('#id_poktan').attr('disabled',false);
      $('#aktual_kunjungan_input').attr('disabled',false);
      $('#hasil_kunjungan').attr('readonly',false);

    }
  })

  $(".select2").each(function(){
        $(this).select2({
          placeholder: ($(this).attr("data-placeholder") ? $(this).attr("data-placeholder") : "Pilih"),
          multiple: ($(this).attr("data-multiple") === "true" ? true : false),
          maximumselectionlength: ($(this).attr("data-maximumselectionlength") ? $(this).attr("data-maximumselectionlength") : 0),
        })
    });

  $('#id_poktan').change(function() {
  idx = $('#id_poktan').val();

    var alamat = $("#id_poktan option:selected" ).attr("data-alamat");
    $('#alamat_edit').val(alamat);



  $.ajax({
      type: "POST",
      data: "id="+idx,
      url : base_url+'kunjungan/getstatusTanam',
      success : function(result){
      var objResult=JSON.parse(result);
      if(objResult){
         $('#id_poktan_tanam').val(objResult.id);
       }
      }
  })
});

  //AWAL TAMBAH KUNJUNGAN TOTAL
  $(document).on("click", "#btn_tambah_kunjungan", function(e){
    let class_unique = [];
    $("#tabel_tampil_kunjungan tbody tr").each(function(){
      if(class_unique.includes($(this).attr("class")) == false && $("td", this).length == 7)
        class_unique.push($(this).attr("class"));
    });
    if(class_unique.length == 6){
      $("#form_kunjungan").submit();
    }else{
      Swal.fire({
        type: 'error',
        title: 'Data tidak lengkap',
        text: 'Silahkan lengkapi rencana jadwal selama satu minggu.',
        })
      }
    e.preventDefault();
    return false;
  });
  //AKHIR TAMBAH KUNJUNGAN TOTAL

  //AWAL FUNGSI EDIT
  $(document).on("click", ".edit", function(){
    let row = $(this).closest("tr").attr("data-row");
    let tanggal = $(this).closest("tr").find("input[name='tgl[]']").val();
    let poktan = $(this).closest("tr").find("input[name='id_poktan[]']").val();
    let alamat = $(this).closest("tr").find("input[name='alamat[]']").val();
    let tipe_kunjungan = $(this).closest("tr").find("input[name='tipe_kunjungan[]']").val();

    $('#modalKunjungan').modal('show');
    $('#btn-tambah').hide();
    $('#text-tambah').hide();
    $('#text-edit').show();
    $('#btn-edit').hide();
    $('#btn-editTemp').show();

    $('#tgl_kunjungan_input').val(tanggal);
    $("#id_poktan").val(poktan);
    $("#alamat_edit").val(alamat);
    $("#tipe_kunjungan").val(tipe_kunjungan);
    $("#editTempRow").val(row);
  });
  //AKHIR FUNGSI EDIT

  //AWAL FUNGSI DELETE
  $(document).on("click", ".delete", function(){
    let row = $(this).closest("tr").attr("data-row");
    let tanggal = $(this).closest("tr").find("input[name='tgl[]']").val();
     $("tr."+tanggal+"[data-row='0']").css('height','0.1');
     $(this).closest("tr").find('td.tipku2').remove();
     $(this).closest("tr").find('td.napok').remove();
     $(this).closest("tr").find('td.almate').remove();
     $(this).closest("tr").find('td.tonton').remove();
  });

  $(document).on("click", ".delete2", function(){
    let row = $(this).closest("tr").attr("data-row");
    let tanggal = $(this).closest("tr").find("input[name='tgl[]']").val();
    let jumlah = $("tr."+tanggal+"[data-row='0'] ").find('td.no').attr('rowspan');
    jumlah-=1;

    $("tr."+tanggal+"[data-row='0'] td.no").attr('rowspan',jumlah);
    $("tr."+tanggal+"[data-row='0'] td.tgl").attr('rowspan',jumlah);
    $("tr."+tanggal+"[data-row='0'] td.butt").attr('rowspan',jumlah);
    $(this).closest("tr").remove();
  });
  //AKHIR FUNGSI DELETE

  //AWAL FUNGSI DELETE SEMENTARA
  $(document).on("click", "#btn-editTemp", function(){
    let tanggal = $('#tgl_kunjungan_input').val();
    let poktan = $("#id_poktan").val();
    let alamat = $("#alamat_edit").val();
    let tipe_kunjungan = $("#tipe_kunjungan").val();

    var tipe_kunjungan_selected = $("#tipe_kunjungan option:selected" ).text();
    var id_poktan_selected = $("#id_poktan option:selected" ).text();
    var alamat_selected = $("#id_poktan option:selected" ).attr("data-alamat");
    let row = $("#editTempRow").val();

    output3 = id_poktan_selected+" <input type='hidden' name='id_poktan[]' value='"+poktan+"'/> <input type='hidden' name='tgl[]' value='"+tanggal+"'/>";
    output4 = alamat_selected+" <input type='hidden' name='alamat[]' value='"+alamat_selected+"'/>";
    output5 = tipe_kunjungan_selected+" <input type='hidden' name='tipe_kunjungan[]' value='"+tipe_kunjungan+"'/>";
    output6 = "<button type='button' class='btn btn-sm btn-success edit'>Edit</button> <button type='button' class='btn btn-sm btn-danger delete'>Delete</button>";

    $("tr."+tanggal+"[data-row='"+row+"'] td.napok").html(output3);
    $("tr."+tanggal+"[data-row='"+row+"'] td.almate").html(output4);
    $("tr."+tanggal+"[data-row='"+row+"'] td.tipku2").html(output5);
    $("tr."+tanggal+"[data-row='"+row+"'] td.tonton").html(output6);


    if($("#id_poktan").val()==""){
      Swal.fire({
      type: 'error',
      title: 'Data tidak lengkap',
      text: 'Silahkan lengkapi form.',
      })
      $('#modalKunjungan').modal('show');
    }else{
    $('#modalKunjungan').modal('toggle');
    }
    });
  });
  //AKHIR FUNGSI DELETE SEMENTARA

//AWAL MENGAMBIL DATA STAFF
var konten2 = localStorage.getItem("id_staff_kunjungan");
$('#id_staff_kunjungan').val(konten2)
//AKHIR MENGAMBIL DATA STAFF

//AWAL MENGAMBIL DATA TANGGAL
var konten4 = localStorage.getItem("tgl_kunjungan_kunjungan");
$('#tgl_kunjungan_kunjungan').val(konten4);
//AKHIR MENGAMBIL DATA TANGGAL



//AWAL DATEPICKER
var dateToday = new Date();
$("#tgl_kunjungan_kunjungan").datepicker({
  minDate: dateToday,
  dateFormat: 'dd/mm/yy',
  beforeShowDay:function(date){ 
    var day = date.getDay(); 
    return [(day == 1),""];
    }    
});
//AKHIR DATEPICKER

//AWAL KUNJUNGAN
$('#btn-kunjungan').attr('disabled',true);
$('#btn-hasil').hide();
$('#text-edit').hide();
$('#btn-edit').hide();
$('#btn-editTemp').hide();
//AKHIR KUNJUNGAN

//AWAL MENGAMBIL DATA STAFF
$('#id_staff_kunjungan').change(function() {
  var konten = $(this).val();
  localStorage.setItem('id_staff_kunjungan', konten);
  $('#tgl_kunjungan_kunjungan').attr('disabled',false);

  //  $.ajax({
  //   type: "POST",
  //   data: "id="+konten,
  //   url : base_url+'kunjungan/getdataoption',
  //   success : function(result){
  //     var objResult=JSON.parse(result);
  //     let date_start = new Date(objResult.tgl_kunjungan);
  //     var hehe = generateDate(date_start, "dd-mm-yyyy");
      
  //     $('#id2').val(objResult.id);
  //     $('#tgl_kunjungan_input').val(hehe);
  //     $('#id_poktan').val(objResult.id_poktan);
  //     $('#tipe_kunjungan').val(objResult.id_tipe_kunjungan);
  //     $('#alamat_edit').val(objResult.alamat);    
  //   }
  // });

})
//AKHIR MENGAMBIL DATA STAFF

//AWAL AJAX TGL KUNJUNGAN
function showModal(tanggal,bulan,tahun){
    $('#btn-tambah').show();
    $('#text-tambah').show();
    $('#text-edit').hide();
    $('#btn-edit').hide();
    $('#modalKunjungan').modal('show');
    $('#tipe_kunjungan').val("");
    // $('#id_poktan').val("");
    $("#id_poktan").val("").trigger("change.select2");
    $('#id2').val("");
    $('#alamat').val("");
    $('#btn-editTemp').hide();

    // $('#id_poktan').val(publik);

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
    let now = new Date(hasil2);
    let onejan = new Date(now.getFullYear(), 0, 1);
    week = Math.ceil( (((now - onejan) / 86400000) + onejan.getDay() + 1) / 7 );

    $('#periode').val(week);

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

//AWAL FUNGSI EDIT
function showEdit(idx){
  $('#id_poktan').attr('disabled',false);
  $('#modalKunjungan').modal('show');
  $('#btn-tambah').hide();
  $('#text-tambah').hide();
  $('#text-edit').show();
  $('#btn-edit').show();
  $('#btn-editTemp').hide();

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
      $('#id_poktan').val(objResult.id_poktan);
      $('#tipe_kunjungan').val(objResult.id_tipe_kunjungan);
      $('#alamat_edit').val(objResult.alamat);    
    }
  });
}

function showEdit2(idx){
  $('#id_poktan').attr('disabled',false);
  $('#modalKunjungan').modal('show');
  $('#btn-tambah').hide();
  $('#text-tambah').hide();
  $('#text-edit').show();
  $('#btn-edit').show();
  $('#btn-editTemp').hide();
  $('#id_poktan').attr('disabled',true);

  $.ajax({
    type: "POST",
    data: "id="+idx,
    url : base_url+'kunjungan/getdatakunjunganlibur',
    success : function(result){
      var objResult=JSON.parse(result);
      let date_start = new Date(objResult.tgl_kunjungan);
      var hehe = generateDate(date_start, "dd-mm-yyyy");
      
      $('#id2').val(objResult.id);
      $('#tgl_kunjungan_input').val(hehe);
      $('#id_poktan').val(objResult.id_poktan);
      $('#tipe_kunjungan').val(objResult.id_tipe_kunjungan);
      $('#alamat_edit').val(objResult.alamat);    
    }
  });
}
//AKHIR FUNGSI EDIT

//AWAL MENGAMBIL DATA KUNJUNGAN
$(document).on("change", "#tgl_kunjungan_kunjungan", function() {
  var konten3 = $('#tgl_kunjungan_kunjungan').val();
  localStorage.setItem('tgl_kunjungan_kunjungan', konten3);
  savedataLoad();
});
//AKHIR MENGAMBIL DATA KUNJUNGAN

//FUNGSI AMBIL DATA KUNJUNGAN
function savedataLoad(){
  $("#tabel_tampil_kunjungan tbody").html("");
  let tgl2 = $('#tgl_kunjungan_kunjungan').val();
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
    var urut = 0;

    output += "<tr class='"+generateDate(date_start, "dd-mm-yyyy")+"' data-row='"+urut+"'>";
    output += "   <td class='no'>"+(i+1)+"</td>";
    output += "   <td class='tgl'>"+generateDate(date_start, "dd-mm-yyyy")+"</td>";
    output += "   <td class='text-center butt'><button type='button' onclick='showModal("+tanggal+","+bulan+","+tahun+")' class='btn btn-kirana btn-circle tambah_plus'><i class='fas fa-plus'></i></button></td>";
    output += "</tr>";
    $("#tabel_tampil_kunjungan tbody").append(output);
    urut++;

    $.ajax({
      type: "POST",
      dataType: "json",
      data: {
        tgl : generateDate(date_start, "yyyy-mm-dd"),
        staff : $("#id_staff_kunjungan").val()
      },
      url : base_url+'poktantanam/tampilKunjungan',
      success : function(result){
        if(result && result.length > 0){
          $.each(result, function(i, v){
            let dates = new Date(v.tgl_kunjungan);
            if(i == 0){

              if(v.id_poktan==null){
              $("tr."+generateDate(dates, "dd-mm-yyyy")+" .tambah_plus").attr("disabled",false);
              
              output2 = "<td class='napok'>Hari Libur Nasional</td>";
              output2 += "<td>Hari Libur Nasional</td>";
              output2 += "<td>Hari Libur Nasional</td>";
              output2 += "<td class='text-center'><button type='button' onclick='showEdit2("+v.id+")' class='btn btn-success btn-sm'>Edit</button> <button onclick='deleteData()' data-link='"+base_url+"kunjungan/deletekunjungan/"+v.id+"' type='button' class='btn btn-sm btn-danger btn-hapus'>Delete</button></td>";
              let elem = $("tr."+generateDate(dates, "dd-mm-yyyy")).eq(i);
              elem.append(output2);
              }else{
              output2 = "<td class='napok'>"+(v.nama_poktan)+"</td>";
              output2 += "<td>"+(v.alamat)+"</td>";
              output2 += "<td>"+(v.tipe_kunjungan)+"</td>";
              output2 += "<td class='text-center'><button type='button' onclick='showEdit("+v.id+")' class='btn btn-success btn-sm'>Edit</button> <button onclick='deleteData()' data-link='"+base_url+"kunjungan/deletekunjungan/"+v.id+"' type='button' class='btn btn-sm btn-danger btn-hapus'>Delete</button></td>";
              let elem = $("tr."+generateDate(dates, "dd-mm-yyyy")).eq(i);
              elem.append(output2);
              }
            }else{
              $("tr."+generateDate(dates, "dd-mm-yyyy")+" td").eq(0).attr("rowspan", result.length);
              $("tr."+generateDate(dates, "dd-mm-yyyy")+" td").eq(1).attr("rowspan", result.length);
              $("tr."+generateDate(dates, "dd-mm-yyyy")+" td").eq(2).attr("rowspan", result.length);

              if(v.id_poktan==null){
              var output2 = "<tr class='"+generateDate(dates, "dd-mm-yyyy")+"' data-row='"+(i)+"'>";
              output2 += "<td class='napok'>Hari Libur Nasional</td>";
              output2 += "<td class='almate'>Hari Libur Nasional</td>";
              output2 += "<td class='tipku2'>Hari Libur Nasional</td>";
              output2 += "<td class='text-center'><button type='button' onclick='showEdit2("+v.id+")' class='btn btn-success btn-sm'>Edit</button> <button onclick='deleteData()' data-link='"+base_url+"kunjungan/deletekunjungan/"+v.id+"' type='button' class='btn btn-sm btn-danger btn-hapus'>Delete</button></td>";
              output2 += "</tr>";
              let elem = $("tr."+generateDate(dates, "dd-mm-yyyy")).eq(i-1);
              $(output2).insertAfter(elem);
              }
              else{
              var output2 = "<tr class='"+generateDate(dates, "dd-mm-yyyy")+"' data-row='"+(i)+"'>";
              output2 += "<td class='napok'>"+(v.nama_poktan)+"</td>";
              output2 += "<td class='almate'>"+(v.alamat)+"</td>";
              output2 += "<td class='tipku2'>"+(v.tipe_kunjungan)+"</td>";
              output2 += "<td class='text-center'><button type='button' onclick='showEdit("+v.id+")' class='btn btn-success btn-sm'>Edit</button> <button onclick='deleteData()' type='button' data-link='"+base_url+"kunjungan/deletekunjungan/"+v.id+"' class='btn btn-sm btn-danger btn-hapus'>Delete</button></td>";
              output2 += "</tr>";
              let elem = $("tr."+generateDate(dates, "dd-mm-yyyy")).eq(i-1);
              $(output2).insertAfter(elem);;
              }
            }
          });
        }
      }
    });
  }
}
//AKHIR FUNGSI AMBIL DATA KUNJUNGAN

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
  var dataTipeKunjungan = new Array(); 
  var dataPoktan = new Array(); 
//AWAL CETAK DATA SEMENTARA
function printdata(){
    var tgl_kunjungan = $('#tgl_kunjungan_input').val();
    var tipe_kunjungan = $('#tipe_kunjungan').val();
    var id_poktan = $('#id_poktan').val();
    // var meong = 0;

   
// dataTipeKunjungan.includes(tipe_kunjungan.toString())
  


  if((tipe_kunjungan!="" && id_poktan!="") ||  tipe_kunjungan==3) {
    $('#modalKunjungan').modal('hide');
    var tipe_kunjungan_selected = $("#tipe_kunjungan option:selected" ).text();
    var tipe_kunjungan = $("#tipe_kunjungan option:selected" ).val();
    var id_poktan_selected = $("#id_poktan option:selected" ).text();
    var alamat_selected = $("#id_poktan option:selected" ).attr("data-alamat");
    var tgl_kunjungan = $('#tgl_kunjungan_input').val();
    var id_poktan_tanam = $('#id_poktan_tanam').val();
    var periode = $('#periode').val();
    var tgl_mulai = $('#tgl_mulai').val();
    var tgl_akhir = $('#tgl_akhir').val();    
    var output = "";
    var elem = $("#tgl_kunjungan_input").val();
    var len = $("tr."+elem).length;
    var len_child = $("tr."+elem+" td.napok").length;

    if(len_child == 0){
      dataTipeKunjungan = [];
      dataPoktan = [];
      if(tipe_kunjungan==3){
      output += "<td class='napok' style='background-color:rgba(212, 243, 255,0.5)'>Hari Libur Nasional<input type='hidden' name='id_poktan[]' value=''/> <input type='hidden' name='tgl[]' value='"+tgl_kunjungan+"'/></td>";
      output += "<td class='almate' style='background-color:rgba(212, 243, 255,0.5)'>Hari Libur Nasional<input type='hidden' name='alamat[]' value=''/></td>";
      output += "<td class='tipku2' style='background-color:rgba(212, 243, 255,0.5)'>"+tipe_kunjungan_selected+" <input type='hidden' name='tipe_kunjungan[]' value='"+tipe_kunjungan+"'/></td>";
      output += "<td class='text-center tonton' style='background-color:rgba(212, 243, 255,0.5)'><button type='button' class='btn btn-sm btn-success edit'>Edit</button> <button type='button' class='btn btn-sm btn-danger delete'>Delete</button></td>";;
      output += "<input type='hidden' name='id_poktan_tanam[]' value=''/>";
      output += "<input type='hidden' name='periode[]' value=''/>";   
      output += "<input type='hidden' name='tgl_mulai[]' value=''/>";   
      output += "<input type='hidden' name='tgl_akhir[]' value=''/>";  

      }else{
      output += "<td class='napok' style='background-color:rgba(212, 243, 255,0.5)'>"+id_poktan_selected+" <input type='hidden' name='id_poktan[]' value='"+id_poktan+"'/> <input type='hidden' name='tgl[]' value='"+tgl_kunjungan+"'/></td>";
      output += "<td class='almate' style='background-color:rgba(212, 243, 255,0.5)'>"+alamat_selected+" <input type='hidden' name='alamat[]' value='"+alamat_selected+"'/></td>";
      output += "<td class='tipku2' style='background-color:rgba(212, 243, 255,0.5)'>"+tipe_kunjungan_selected+" <input type='hidden' name='tipe_kunjungan[]' value='"+tipe_kunjungan+"'/></td>";
      output += "<td class='text-center tonton' style='background-color:rgba(212, 243, 255,0.5)'><button type='button' class='btn btn-sm btn-success edit'>Edit</button> <button type='button' class='btn btn-sm btn-danger delete'>Delete</button></td>";
      output += "<input type='hidden' name='id_poktan_tanam[]' value='"+id_poktan_tanam+"'/>";
      output += "<input type='hidden' name='periode[]' value='"+periode+"'/>";   
      output += "<input type='hidden' name='tgl_mulai[]' value='"+tgl_mulai+"'/>";   
      output += "<input type='hidden' name='tgl_akhir[]' value='"+tgl_akhir+"'/>";      
      }
      $("tr."+elem).eq(len-1).append(output);
      $("tr."+elem).eq(len-1).attr("data-row",len_child);           
    }else{

      if (dataTipeKunjungan.includes(tipe_kunjungan.toString()) && dataPoktan.includes(id_poktan.toString())) {
        Swal.fire({
          title: 'Oops...!',
          text: 'Data tipe kunjungan dan nama poktan sudah tersedia',
          type: 'error'
        })
      }else{

      $("tr."+elem+" td").eq(0).attr("rowspan", len+1);
      $("tr."+elem+" td").eq(1).attr("rowspan", len+1);
      $("tr."+elem+" td").eq(2).attr("rowspan", len+1);          
      output += "<tr class='"+elem+"' data-row='"+len_child+"'>";
      
      if(tipe_kunjungan==3){
        output += "<td class='napok' style='background-color:rgba(212, 243, 255,0.5)'>Hari Libur Nasional<input type='hidden' name='id_poktan[]' value=''/> <input type='hidden' name='tgl[]' value='"+tgl_kunjungan+"'/></td>";
        output += "<td class='almate' style='background-color:rgba(212, 243, 255,0.5)'>Hari Libur Nasional<input type='hidden' name='alamat[]' value=''/></td>";
        output += "<td class='tipku2' style='background-color:rgba(212, 243, 255,0.5)'>"+tipe_kunjungan_selected+" <input type='hidden' name='tipe_kunjungan[]' value='"+tipe_kunjungan+"'/></td>";     
        output += "<td class='text-center tonton' style='background-color:rgba(212, 243, 255,0.5)'><button type='button' class='btn btn-sm btn-success edit'>Edit</button> <button type='button' class='btn btn-sm btn-danger delete2'>Delete</button></td>";
        output += "<input type='hidden' name='id_poktan_tanam[]' value=''/>";
        output += "<input type='hidden' name='periode[]' value=''/>";   
        output += "<input type='hidden' name='tgl_mulai[]' value=''/>";   
        output += "<input type='hidden' name='tgl_akhir[]' value=''/>";          
        output += "</tr>";
        $(output).insertAfter($("tr."+elem).eq(len-1));
      }else{
        output += "<td class='napok' style='background-color:rgba(212, 243, 255,0.5)'>"+id_poktan_selected+" <input type='hidden' name='id_poktan[]' value='"+id_poktan+"'/> <input type='hidden' name='tgl[]' value='"+tgl_kunjungan+"'/></td>";
        output += "<td class='almate' style='background-color:rgba(212, 243, 255,0.5)'>"+alamat_selected+" <input type='hidden' name='alamat[]' value='"+alamat_selected+"'/></td>";
        output += "<td class='tipku2' style='background-color:rgba(212, 243, 255,0.5)'>"+tipe_kunjungan_selected+" <input type='hidden' name='tipe_kunjungan[]' value='"+tipe_kunjungan+"'/></td>";
        output += "<td class='text-center tonton' style='background-color:rgba(212, 243, 255,0.5)'><button type='button' class='btn btn-sm btn-success edit'>Edit</button> <button type='button' class='btn btn-sm btn-danger delete2'>Delete</button></td>";
        output += "<input type='hidden' name='id_poktan_tanam[]' value='"+id_poktan_tanam+"'/>";
        output += "<input type='hidden' name='periode[]' value='"+periode+"'/>";   
        output += "<input type='hidden' name='tgl_mulai[]' value='"+tgl_mulai+"'/>";   
        output += "<input type='hidden' name='tgl_akhir[]' value='"+tgl_akhir+"'/>";     
        output += "</tr>";
        $(output).insertAfter($("tr."+elem).eq(len-1));
      }
    }
    }
    $('#id_poktan').val("");
    $('#alamat').val("");
    $('#tipe_kunjungan').val("");   

 // console.log($("#tabel_tampil_kunjungan tr."+tgl_kunjungan+"[data-row='0'] td.tipku2").find("input[name='tipe_kunjungan[]']").val());
 //     console.log($("#tabel_tampil_kunjungan tr."+tgl_kunjungan+"[data-row='1'] td.tipku2").find("input[name='tipe_kunjungan[]']").val());
 //      console.log($("#tabel_tampil_kunjungan tr."+tgl_kunjungan+"[data-row='2'] td.tipku2").find("input[name='tipe_kunjungan[]']").val());

 dataTipeKunjungan.push($("#tabel_tampil_kunjungan tr."+elem+"[data-row='"+len_child+"'] td.tipku2").find("input[name='tipe_kunjungan[]']").val());
dataPoktan.push($("#tabel_tampil_kunjungan tr."+elem+"[data-row='"+len_child+"'] td.napok").find("input[name='id_poktan[]']").val());
       console.log(dataTipeKunjungan);
       console.log(dataPoktan);
       console.log(len_child);
       






  }else if(tipe_kunjungan=="" || id_poktan==""){
    $('#modalKunjungan').modal('show');
    Swal.fire({
      type: 'error',
      title: 'Data tidak lengkap',
      text: 'Silahkan lengkapi form.',
    })
  }
  // }
}
//AKHIR CETAK DATA SEMENTARA
