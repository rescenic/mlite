var reader = new FileReader();
reader.addEventListener("load", function () {
  $("#photoPreview").attr('src', reader.result);
}, false);
$("input[name=photo]").change(function () {
  reader.readAsDataURL(this.files[0]);
});
$(function () {
  $(".tanggal").datetimepicker({
    format: 'YYYY-MM-DD',
    locale: 'id'
  });
});

$(document).ready(function () {
  jQuery('.timeline').timeline({
    //mode: 'horizontal',
    //visibleItems: 4
    //Remove this comment for see Timeline in Horizontal Format otherwise it will display in Vertical Direction Timeline
  });
});

$("#form").on("click", "#manage", function (event) {
  var baseURL = mlite.url + '/' + mlite.admin;
  event.preventDefault();
  var url = baseURL + '/profil/bridgingbkd?t=' + mlite.token;
  var bulan = $("input:hidden[name=bulan]").val();
  var tahun = $("input:hidden[name=tahun]").val();
  var nik = $("input:hidden[name=nik]").val();
  var shift = $("input:text[name='shift[]']").map(function () { return $(this).val(); }).get();
  var jam_datang = $("input:text[name='jam_datang[]']").map(function () { return $(this).val(); }).get();
  var jam_pulang = $("input:text[name='jam_pulang[]']").map(function () { return $(this).val(); }).get();

  // tampilkan dialog konfirmasi
  bootbox.confirm("Apakah Anda yakin ingin mengirim data ini?", function (result) {
    // ketika ditekan tombol ok
    if (result) {
      // mengirimkan perintah penghapusan
      $.post(url, {
        bulan: bulan,
        tahun: tahun,
        nik: nik,
        shift: shift,
        jam_datang: jam_datang,
        jam_pulang: jam_pulang,
      }, function (data) {
        console.log(data == 200);
        if (data == 200) {
          $("#display").load(baseURL + '/profil/rekap_presensi?t=' + mlite.token);
          $('#notif').html("<div class=\"alert alert-success alert-dismissible fade in\" role=\"alert\" style=\"border-radius:0px;margin-top:-15px;\">" +
            "Data presensi telah dikirim!" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">&times;</button>" +
            "</div>").show();
        } else {
          $("#display").load(baseURL + '/profil/rekap_presensi?t=' + mlite.token);
          $('#notif').html("<div class=\"alert alert-warning alert-dismissible fade in\" role=\"alert\" style=\"border-radius:0px;margin-top:-15px;\">" +
            "Data presensi gagal dikirim!" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">&times;</button>" +
            "</div>").show();
        }
        // sembunyikan form, tampilkan data yang sudah di perbaharui, tampilkan notif
      });
    }
  });
});

setTimeout(function(){
  $('#notif').fadeOut('fast');
}, 5000);


$("ul.nav-tabs a").click(function (e) {
  e.preventDefault();
    $(this).tab('show');
});

$("#pendum").on("click",".edit_pendum",function(event) {
  event.preventDefault();
  var ktpu = $(this).attr("data-ktpu");
  var negara = $(this).attr("data-negara");
  var prog_studi = $(this).attr("data-prog_studi");
  var jurusan = $(this).attr("data-jurusan");
  var nsek = $(this).attr("data-nsek");
  var tempat = $(this).attr("data-tempat");
  var nkepsek = $(this).attr("data-nkepsek");
  var nsttb = $(this).attr("data-nsttb");
  var tsttb = $(this).attr("data-tsttb");
  var isakhir = $(this).attr("data-isakhir");
  var id = $(this).attr("data-id");

  $("div.ktpu select").val(ktpu).change();
  $("input:text[name=NEGARA]").val(negara);
  $("input:text[name=PROG_STUDI]").val(prog_studi);
  $("input:text[name=JURUSAN]").val(jurusan);
  $("input:text[name=NSEK]").val(nsek);
  $("input:text[name=TEMPAT]").val(tempat);
  $("input:text[name=NKEPSEK]").val(nkepsek);
  $("input:text[name=NSTTB]").val(nsttb);
  $("input:text[name=TSTTB]").val(tsttb);
  document.getElementById("ID_PENDUM").value = id;

  if (isakhir === '1') {
    if ($('#isakhir').prop('checked')==false){
      $('#isakhir').prop('checked', true).change();
    }
  } else if(isakhir === '0'){
    if ($('#isakhir').prop('checked')==true){
      $('#isakhir').prop('checked', false).change();
    }
  }
})

$("#diknon").on("click",".edit_diknon",function(event) {
  event.preventDefault();
  var ktpu = $(this).attr("data-ktpu");
  var tempat = $(this).attr("data-negara");
  var prog_studi = $(this).attr("data-prog_studi");
  var jurusan = $(this).attr("data-jurusan");
  var nsek = $(this).attr("data-nsek");
  var tempat = $(this).attr("data-tempat");
  var nkepsek = $(this).attr("data-nkepsek");
  var nsttb = $(this).attr("data-nsttb");
  var tsttb = $(this).attr("data-tsttb");
  var isakhir = $(this).attr("data-isakhir");
  var id = $(this).attr("data-id");

  $("div.diknon select").val(ktpu).change();
  $("input:text[name=TEMPAT]").val(tempat);
  $("input:text[name=PAN]").val(prog_studi);
  $("input:text[name=ANGKATAN]").val(jurusan);
  $("input:text[name=TMULAI]").val(nsek);
  $("input:text[name=TAKHIR]").val(tempat);
  $("input:text[name=JAM]").val(nkepsek);
  $("input:text[name=NSTTPP]").val(nsttb);
  $("input:text[name=TSTTPP]").val(tsttb);
  document.getElementById("ID_DIKNSTR").value = id;

  if (isakhir === '1') {
    if ($('#isakhir').prop('checked')==false){
      $('#isakhir').prop('checked', true).change();
    }
  } else if(isakhir === '0'){
    if ($('#isakhir').prop('checked')==true){
      $('#isakhir').prop('checked', false).change();
    }
  }
})

$("#dikst").on("click",".edit_pendum",function(event) {
  event.preventDefault();
  var ktpu = $(this).attr("data-ktpu");
  var negara = $(this).attr("data-negara");
  var prog_studi = $(this).attr("data-prog_studi");
  var jurusan = $(this).attr("data-jurusan");
  var nsek = $(this).attr("data-nsek");
  var tempat = $(this).attr("data-tempat");
  var nkepsek = $(this).attr("data-nkepsek");
  var nsttb = $(this).attr("data-nsttb");
  var tsttb = $(this).attr("data-tsttb");
  var isakhir = $(this).attr("data-isakhir");
  var id = $(this).attr("data-id");

  $("div.dikstr select").val(ktpu).change();
  $("input:text[name=TEMPAT]").val(negara);
  $("input:text[name=PAN]").val(prog_studi);
  $("input:text[name=ANGKATAN]").val(jurusan);
  $("input:text[name=TMULAI]").val(nsek);
  $("input:text[name=TAKHIR]").val(tempat);
  $("input:text[name=JAM]").val(nkepsek);
  $("input:text[name=NSTTPP]").val(nsttb);
  $("input:text[name=TSTTPP]").val(tsttb);
  document.getElementById("ID_DIKSTR").value = id;

  if (isakhir === '1') {
    if ($('#isakhir').prop('checked')==false){
      $('#isakhir').prop('checked', true).change();
    }
  } else if(isakhir === '0'){
    if ($('#isakhir').prop('checked')==true){
      $('#isakhir').prop('checked', false).change();
    }
  }
})

$("#dikfun").on("click",".edit_pendum",function(event) {
  event.preventDefault();
  var ktpu = $(this).attr("data-ktpu");
  var negara = $(this).attr("data-negara");
  var prog_studi = $(this).attr("data-prog_studi");
  var jurusan = $(this).attr("data-jurusan");
  var nsek = $(this).attr("data-nsek");
  var tempat = $(this).attr("data-tempat");
  var nkepsek = $(this).attr("data-nkepsek");
  var nsttb = $(this).attr("data-nsttb");
  var tsttb = $(this).attr("data-tsttb");
  var isakhir = $(this).attr("data-isakhir");
  var id = $(this).attr("data-id");

  $("input:text[name=NDIKFUNG]").val(ktpu);
  $("input:text[name=TEMPAT]").val(negara);
  $("input:text[name=PAN]").val(prog_studi);
  $("input:text[name=ANGKATAN]").val(jurusan);
  $("input:text[name=TMULAI]").val(nsek);
  $("input:text[name=TAKHIR]").val(tempat);
  $("input:text[name=JAM]").val(nkepsek);
  $("input:text[name=NSTTPP]").val(nsttb);
  $("input:text[name=TSTTPP]").val(tsttb);
  document.getElementById("ID_DIKFUNG").value = id;

  if (isakhir === '1') {
    if ($('#isakhir').prop('checked')==false){
      $('#isakhir').prop('checked', true).change();
    }
  } else if(isakhir === '0'){
    if ($('#isakhir').prop('checked')==true){
      $('#isakhir').prop('checked', false).change();
    }
  }
})

$("#diktek").on("click",".edit_pendum",function(event) {
  event.preventDefault();
  var ktpu = $(this).attr("data-ktpu");
  var negara = $(this).attr("data-negara");
  var prog_studi = $(this).attr("data-prog_studi");
  var jurusan = $(this).attr("data-jurusan");
  var nsek = $(this).attr("data-nsek");
  var tempat = $(this).attr("data-tempat");
  var nkepsek = $(this).attr("data-nkepsek");
  var nsttb = $(this).attr("data-nsttb");
  var tsttb = $(this).attr("data-tsttb");
  var isakhir = $(this).attr("data-isakhir");
  var id = $(this).attr("data-id");

  $("input:text[name=NDIKTEK]").val(ktpu);
  $("input:text[name=TEMPAT]").val(negara);
  $("input:text[name=PAN]").val(prog_studi);
  $("input:text[name=ANGKATAN]").val(jurusan);
  $("input:text[name=TMULAI]").val(nsek);
  $("input:text[name=TAKHIR]").val(tempat);
  $("input:text[name=JAM]").val(nkepsek);
  $("input:text[name=NSTTPP]").val(nsttb);
  $("input:text[name=TSTTPP]").val(tsttb);
  document.getElementById("ID_DIKTEK").value = id;

  if (isakhir === '1') {
    if ($('#isakhir').prop('checked')==false){
      $('#isakhir').prop('checked', true).change();
    }
  } else if(isakhir === '0'){
    if ($('#isakhir').prop('checked')==true){
      $('#isakhir').prop('checked', false).change();
    }
  }
})

$("#sem").on("click",".edit_pendum",function(event) {
  event.preventDefault();
  var ktpu = $(this).attr("data-ktpu");
  var negara = $(this).attr("data-negara");
  var prog_studi = $(this).attr("data-prog_studi");
  var jurusan = $(this).attr("data-jurusan");
  var nsek = $(this).attr("data-nsek");
  var tempat = $(this).attr("data-tempat");
  var nkepsek = $(this).attr("data-nkepsek");
  var nsttb = $(this).attr("data-nsttb");
  var id = $(this).attr("data-id");

  $("input:text[name=NSEMINAR]").val(ktpu);
  $("input:text[name=TEMPAT]").val(negara);
  $("input:text[name=PAN]").val(prog_studi);
  $("input:text[name=TMULAI]").val(jurusan);
  $("input:text[name=TAKHIR]").val(nsek);
  $("input:text[name=JAM]").val(tempat);
  $("input:text[name=NPIAGAM]").val(nkepsek);
  $("input:text[name=TPIAGAM]").val(nsttb);
  document.getElementById("ID_SEMINAR").value = id;

})

$("#tubel").on("click",".edit_pendum",function(event) {
  event.preventDefault();
  var ktpu = $(this).attr("data-ktpu");
  var prog_studi = $(this).attr("data-prog_studi");
  var jurusan = $(this).attr("data-jurusan");
  var nsek = $(this).attr("data-nsttb");
  var tempat = $(this).attr("data-tsttb");
  var isakhir = $(this).attr("data-isakhir");
  var id = $(this).attr("data-id");

  $("input:text[name=NSEK]").val(ktpu);
  $("input:text[name=PROG_STUDI]").val(prog_studi);
  $("input:text[name=JURUSAN]").val(jurusan);
  $("input:text[name=NSTTB]").val(nsek);
  $("input:text[name=TSTTB]").val(tempat);
  $("div.status select").val(isakhir).change();
  document.getElementById("ID_TUBEL").value = id;
})

$("#pangkat").on("click",".edit_pangkat",function(event) {
  event.preventDefault();
  var gol = $(this).attr("data-gol");
  var npang = $(this).attr("data-npang");
  var tmt = $(this).attr("data-tmt");
  var nsk = $(this).attr("data-nsk");
  var tsk = $(this).attr("data-tsk");
  var pejabat = $(this).attr("data-pejabat");
  var isakhir = $(this).attr("data-isakhir");
  var id = $(this).attr("data-id");
  console.log(gol);

  $("div.gol select").val(gol).change();
  $("div.npang select").val(npang).change();
  $("input:text[name=TMTPANG]").val(tmt);
  $("input:text[name=NSKPANG]").val(nsk);
  $("input:text[name=TSKPANG]").val(tsk);
  $("input:text[name=NPEJABAT]").val(pejabat);
  document.getElementById("ID_PANGKAT").value = id;

  if (isakhir === '1') {
    if ($('#isakhir_pangkat').prop('checked')==false){
      $('#isakhir_pangkat').prop('checked', true).change();
    }
  } else if(isakhir === '0'){
    if ($('#isakhir_pangkat').prop('checked')==true){
      $('#isakhir_pangkat').prop('checked', false).change();
    }
  }
  // alert('Jancok');
})

$("#riwsk").on("click",".edit_pangkat",function(event) {
  event.preventDefault();
  var gol = $(this).attr("data-gol");
  var npang = $(this).attr("data-npang");
  var tmt = $(this).attr("data-tmt");
  var nsk = $(this).attr("data-nsk");
  var tsk = $(this).attr("data-tsk");
  var isakhir = $(this).attr("data-isakhir");
  var id = $(this).attr("data-id");

  $("div.gol select").val(gol).change();
  $("input:text[name=npej]").val(npang);
  $("input:text[name=tgl_tmt]").val(tmt);
  $("input:text[name=no_sk]").val(nsk);
  $("input:text[name=tgl_sk]").val(tsk);
  document.getElementById("idsk").value = id;

  if (isakhir === '1') {
    if ($('#isakhir_pangkat').prop('checked')==false){
      $('#isakhir_pangkat').prop('checked', true).change();
    }
  } else if(isakhir === '0'){
    if ($('#isakhir_pangkat').prop('checked')==true){
      $('#isakhir_pangkat').prop('checked', false).change();
    }
  }
})

$("#jabatan").on("click",".edit_jabatan",function(event) {
  event.preventDefault();
  var unker = $(this).attr("data-unker");
  var jnsjab = $(this).attr("data-jnsjab");
  var eselon = $(this).attr("data-eselon");
  var jab = $(this).attr("data-jab");
  var tmtjab = $(this).attr("data-tmtjab");
  var nskjab = $(this).attr("data-nskjab");
  var tskjab = $(this).attr("data-tskjab");
  var isakhir = $(this).attr("data-isakhir");
  var id = $(this).attr("data-id");

  $("input:text[name=NUNKER]").val(unker);
  $("div.jnsjab select").val(jnsjab).change();
  $("div.eselon select").val(eselon).change();
  $("input:text[name=NJAB]").val(jab);
  $("input:text[name=TMTJABAT]").val(tmtjab);
  $("input:text[name=NSKJABAT]").val(nskjab);
  $("input:text[name=TSKJABAT]").val(tskjab);
  document.getElementById("ID_JAB").value = id;

  if (isakhir === '1') {
    if ($('#isakhir_jab').prop('checked')==false){
      $('#isakhir_jab').prop('checked', true).change();
    }
  } else if(isakhir === '0'){
    if ($('#isakhir_jab').prop('checked')==true){
      $('#isakhir_jab ').prop('checked', false).change();
    }
  }
})

$("#skp").on("click",".edit_skp",function(event) {
  event.preventDefault();
  var thn = $(this).attr("data-thn");
  var nsetia = $(this).attr("data-nsetia");
  var npres = $(this).attr("data-npres");
  var ninisiatif = $(this).attr("data-ninisiatif");
  var ntjawab = $(this).attr("data-ntjawab");
  var ntaat = $(this).attr("data-ntaat");
  var njujur = $(this).attr("data-njujur");
  var nksama = $(this).attr("data-nksama");
  var npkarsa = $(this).attr("data-npkarsa");
  var npimpin = $(this).attr("data-npimpin");
  var jabnil = $(this).attr("data-jabnil");
  var atjabnil = $(this).attr("data-atjabnil");
  var id = $(this).attr("data-id");

  $("input:text[name=THNILAI]").val(thn);
  $("input:text[name=NSETIA]").val(nsetia);
  $("input:text[name=NPRES]").val(npres);
  $("input:text[name=NINISIATIF]").val(ninisiatif);
  $("input:text[name=NTJAWAB]").val(ntjawab);
  $("input:text[name=NTAAT]").val(ntaat);
  $("input:text[name=NJUJUR]").val(njujur);
  $("input:text[name=NKSAMA]").val(nksama);
  $("input:text[name=NPKARSA]").val(npkarsa);
  $("input:text[name=NPIMPIN]").val(npimpin);
  $("input:text[name=jabat_nilai]").val(jabnil);
  $("input:text[name=atasan_jabat_nilai]").val(atjabnil);
  document.getElementById("ID_DP3").value = id;

})

$("#gajiber").on("click",".edit_gkkhir",function(event) {
  event.preventDefault();
  var npejabat = $(this).attr("data-npejabat");
  var no_sk = $(this).attr("data-no_sk");
  var tgl_sk = $(this).attr("data-tgl_sk");
  var tmtngaji = $(this).attr("data-tmtngaji");
  var kgolru = $(this).attr("data-kgolru");
  var mskerja = $(this).attr("data-mskerja");
  var mskerjabln = $(this).attr("data-mskerjabln");
  var gpokkhir = $(this).attr("data-gpokkhir");
  var id = $(this).attr("data-id");

  $("input:text[name=NPEJABAT]").val(npejabat);
  $("input:text[name=NO_SK]").val(no_sk);
  $("input:text[name=TGL_SK]").val(tgl_sk);
  $("input:text[name=TMTNGAJ]").val(tmtngaji);
  $("div.golru select").val(kgolru).change();
  $("input:text[name=MSKERJA]").val(mskerja);
  $("input:text[name=MSKERJA_BLN]").val(mskerjabln);
  $("input:text[name=GPOKKHIR]").val(gpokkhir);
  document.getElementById("ID_KGB").value = id;

})

$("#angkre").on("click",".edit_angkre",function(event) {
  event.preventDefault();
  var no_sk = $(this).attr("data-no_sk");
  var tgl_sk = $(this).attr("data-tgl_sk");
  var utama = $(this).attr("data-utama");
  var penunjang = $(this).attr("data-penunjang");
  var total = $(this).attr("data-total");
  var id = $(this).attr("data-id");

  $("input:text[name=no_sk]").val(no_sk);
  $("input:text[name=tgl_sk]").val(tgl_sk);
  $("input:text[name=utama]").val(utama);
  $("input:text[name=penunjang]").val(penunjang);
  $("input:text[name=total]").val(total);
  document.getElementById("id").value = id;
})

$("#riwser").on("click",".edit_riwser",function(event) {
  event.preventDefault();
  var id_profesi = $(this).attr("data-id_profesi");
  var no_str = $(this).attr("data-no_str");
  var tgl_str = $(this).attr("data-tgl_str");
  var tgl_laku_str = $(this).attr("data-tgl_laku_str");
  var no_sip = $(this).attr("data-no_sip");
  var tgl_sip = $(this).attr("data-tgl_sip");
  var tgl_laku_sip = $(this).attr("data-tgl_laku_sip");
  var id = $(this).attr("data-id");

  $("div.profesi select").val(id_profesi).change();
  $("input:text[name=no_str]").val(no_str);
  $("input:text[name=tgl_str]").val(tgl_str);
  $("input:text[name=tgl_laku_str]").val(tgl_laku_str);
  $("input:text[name=no_sip]").val(no_sip);
  $("input:text[name=tgl_sip]").val(tgl_sip);
  $("input:text[name=tgl_laku_sip]").val(tgl_laku_sip);
  document.getElementById("id").value = id;
})

$("#ayah").on("click",".edit_ayah",function(event) {
  event.preventDefault();
  var nayah = $(this).attr("data-nayah");
  var tlahir = $(this).attr("data-tlahir");
  var tgllahir = $(this).attr("data-tgllahir");
  var nkerja = $(this).attr("data-nkerja");
  var aljalan = $(this).attr("data-aljalan");
  var notelp = $(this).attr("data-notelp");
  var wil = $(this).attr("data-wil");
  var kpos = $(this).attr("data-kpos");
  var id = $(this).attr("data-id");

  $("input:text[name=NAYAH]").val(nayah);
  $("input:text[name=TLAHIR]").val(tlahir);
  $("input:text[name=TGLLAHIR]").val(tgllahir);
  $("input:text[name=NKERJA]").val(nkerja);
  $("input:text[name=ALJALAN]").val(aljalan);
  $("input:text[name=NOTELP]").val(notelp);
  $("input:text[name=WIL]").val(wil);
  $("input:text[name=KPOS]").val(kpos);
  document.getElementById("ID_AYAH").value = id;
})

$("#ibu").on("click",".edit_ibu",function(event) {
  event.preventDefault();
  var nibu = $(this).attr("data-nibu");
  var tlahir = $(this).attr("data-tlahir");
  var tgllahir = $(this).attr("data-tgllahir");
  var nkerja = $(this).attr("data-nkerja");
  var aljalan = $(this).attr("data-aljalan");
  var notelp = $(this).attr("data-notelp");
  var wil = $(this).attr("data-wil");
  var kpos = $(this).attr("data-kpos");
  var id = $(this).attr("data-id");

  $("input:text[name=NIBU]").val(nibu);
  $("input:text[name=TLAHIR]").val(tlahir);
  $("input:text[name=TGLLAHIR]").val(tgllahir);
  $("input:text[name=NKERJA]").val(nkerja);
  $("input:text[name=ALJALAN]").val(aljalan);
  $("input:text[name=NOTELP]").val(notelp);
  $("input:text[name=WIL]").val(wil);
  $("input:text[name=KPOS]").val(kpos);
  document.getElementById("ID_IBU").value = id;
})

$("#issu").on("click",".edit_issu",function(event) {
  event.preventDefault();
  var nisua = $(this).attr("data-nisua");
  var tlahir = $(this).attr("data-tlahir");
  var ktlahir = $(this).attr("data-ktlahir");
  var nkerja = $(this).attr("data-nkerja");
  var tijasah = $(this).attr("data-tijasah");
  var tkawin = $(this).attr("data-tkawin");
  var stunj = $(this).attr("data-stunj");
  var status = $(this).attr("data-status");
  var id = $(this).attr("data-id");

  $("input:text[name=NISUA]").val(nisua);
  $("input:text[name=TLAHIR]").val(tlahir);
  $("input:text[name=KTLAHIR]").val(ktlahir);
  $("input:text[name=NKERJA]").val(nkerja);
  $("input:text[name=TIJASAH]").val(tijasah);
  $("input:text[name=TKAWIN]").val(tkawin);
  $("div.stunj select").val(stunj).change();
  $("div.status select").val(status).change();
  document.getElementById("ID_ISTRI").value = id;
})

$("#anak").on("click",".edit_anak",function(event) {
  event.preventDefault();
  var nanak = $(this).attr("data-nanak");
  var tlahir = $(this).attr("data-tlahir");
  var tgllahir = $(this).attr("data-tgllahir");
  var nkerja = $(this).attr("data-nkerja");
  var tijasah = $(this).attr("data-tijasah");
  var keluarga = $(this).attr("data-keluarga");
  var tunj = $(this).attr("data-tunj");
  var kjkel = $(this).attr("data-kjkel");
  var status = $(this).attr("data-status");
  var id = $(this).attr("data-id");

  $("input:text[name=NANAK]").val(nanak);
  $("input:text[name=TLAHIR]").val(tlahir);
  $("input:text[name=TGLLAHIR]").val(tgllahir);
  $("input:text[name=NKERJA]").val(nkerja);
  $("input:text[name=TIJASAH]").val(tijasah);
  $("div.keluarga select").val(keluarga).change();
  $("div.tunj select").val(tunj).change();
  $("div.kjkel select").val(kjkel).change();
  $("div.status select").val(status).change();
  document.getElementById("ID_ANAK").value = id;
})

$("#kel").on("click",".edit_kel",function(event) {
  event.preventDefault();
  var nama = $(this).attr("data-nama");
  var tlahir = $(this).attr("data-tlahir");
  var tgllahir = $(this).attr("data-tgllahir");
  var nkerja = $(this).attr("data-nkerja");
  var notelp = $(this).attr("data-notelp");
  var keluarga = $(this).attr("data-keluarga");
  var aljalan = $(this).attr("data-aljalan");
  var kjkel = $(this).attr("data-kjkel");
  var wil = $(this).attr("data-wil");
  var kpos = $(this).attr("data-kpos");
  var id = $(this).attr("data-id");

  $("input:text[name=NAMA]").val(nama);
  $("input:text[name=TLAHIR]").val(tlahir);
  $("input:text[name=TGLLAHIR]").val(tgllahir);
  $("input:text[name=NKERJA]").val(nkerja);
  $("input:text[name=NOTELP]").val(notelp);
  $("div.keluarga select").val(keluarga).change();
  $("input:text[name=ALJALAN]").val(aljalan);
  $("div.kjkel select").val(kjkel).change();
  $("input:text[name=WIL]").val(wil);
  $("input:text[name=KPOS]").val(kpos);
  document.getElementById("ID_KELUARGA").value = id;
})

function setTextField(ddl) {
    document.getElementById('make_text').value = ddl.options[ddl.selectedIndex].text;
}

$(".del").on("click",function(event) {
  var baseURL = mlite.url + '/' + mlite.admin;
  event.preventDefault();
  var url = baseURL + '/profil/deletesimpeg?t=' + mlite.token;
  var tabel = $(this).attr("data-tabel");
  var id = $(this).attr("data-id");

  bootbox.confirm("Apakah Anda yakin ingin menghapus data ini?", function (result) {
    // ketika ditekan tombol ok
    if (result) {
      // mengirimkan perintah penghapusan
      $.post(url, {
        tabel: tabel,
        id: id,
      }, function (data) {
        console.log(data);
        bootbox.alert({
          message: data,
          callback: function(){
            // $('.table').
            window.location.reload($(location).attr('href'));
          }
        });

        // sembunyikan form, tampilkan data yang sudah di perbaharui, tampilkan notif
      });
    }
  });
})

check("#file-pangkat");
check("#file-jabatan");
check("#file-skp");
check("#file-gajiber");
check("#file-angkre");
check("#file-str");
check("#file-pendum");
check("#file-diknstr");
check("#file-dikstr");
check("#file-dikfung");
check("#file-diktek");
check("#file-sem");
check("#file-tubel");
check("#file-riwsk");
check("#file-bkstambah");


function check(params) {
  $(params).bind('change', function() {
    if (this.files[0].size/1024/1024 > 2) {
      bootbox.alert('File Terlalu Besar');
    } else {
      var nameId = $(this).attr('id');
      // var i = document.querySelector('input');
      var file = $('#'+nameId)[0].files[0].name;
      $(this).prev().text(file);
    }
  });
}
