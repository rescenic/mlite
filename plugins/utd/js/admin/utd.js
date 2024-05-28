$('.dataTables').DataTable({
<<<<<<< HEAD
  "order": [[ 0, "desc" ]],
=======
  "order": [[ 1, "desc" ]],
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
  "pagingType": "full",
  "language": {
    "paginate": {
      "first": "&laquo;",
      "last": "&raquo;",
      "previous": "‹",
      "next":     "›"
    },
    "search": "",
    "searchPlaceholder": "Search..."
  },
  "lengthChange": false,
  "scrollX": true,
  dom: "<<'data-table-title'><'datatable-search'f>><'row'<'col-sm-12'tr>><<'pmd-datatable-pagination' l i p>>"
});
var t = $(".dataTables").DataTable().rows().count();
$(".data-table-title").html('<h3 style="display:inline;float:left;margin-top:0;" class="hidden-xs">Total: ' + t + '</h3>');
$('.dataTables_filter input').addClass('form-control pencarian');
$('.displayData').DataTable();

$(function () {
    $('.tanggaljam').datetimepicker({
      format: 'YYYY-MM-DD HH:mm:ss',
      locale: 'id'
    });
});

$(function () {
    $('.tanggal').datetimepicker({
      format: 'YYYY-MM-DD',
      locale: 'id'
    });
});
<<<<<<< HEAD
 
$(document).ready(function(){

  $('#utd_donor').on('click', '#submit_periode_rawat_jalan', function(event){
    var baseURL = mlite.url + '/' + mlite.admin;
    event.preventDefault();
    var url    = baseURL + '/utd/donor?t=' + mlite.token;
    var periode_rawat_jalan  = $('input:text[name=periode_rawat_jalan]').val();
    var periode_rawat_jalan_akhir  = $('input:text[name=periode_rawat_jalan_akhir]').val();
    var s  = $('input:text[name=s]').val();
  
    if(periode_rawat_jalan == '') {
      alert('Tanggal awal masih kosong!')
    }
    if(periode_rawat_jalan_akhir == '') {
      alert('Tanggal akhir masih kosong!')
    }

    var ss = decodeURI(s);

    var optionText = document.getElementById("bangsal").value;
    var option = optionText.toLowerCase();
    var opt = decodeURI(option);

    window.location.href = baseURL+'/utd/donor?awal='+periode_rawat_jalan+'&akhir='+periode_rawat_jalan_akhir + mlite.token;
    
    event.stopPropagation();
  
  });
});

// $(document).ready(function(){
//     $('#utd_donor').on('click', '#submit_periode_donor', function(event){
//         event.preventDefault();
//         // var baseURL = mlite.url + '/' + mlite.admin;
//         var url    = baseURL + '/utd/donor?t=' + mlite.token;
//         var periode_donor = $('input:text[name=periode_donor]').val();
//         var periode_donor_akhir = $('input:text[name=periode_donor_akhir]').val();

//         if (periode_donor == '' || periode_donor_akhir == '') {
//             alert('Harap isi kedua tanggal periode donor.');
//             return;
//         }

//         // Redirect ke halaman donor dengan parameter tanggal
//         window.location.href = baseURL + '/utd/donor?awal=' + periode_donor + '&akhir=' + periode_donor_akhir + mlite.token;
//     });
// });

  // $(function () {
  //      $('.periode_donor').datetimepicker({
  //        defaultDate: new Date(),
  //        format: 'YYYY-MM-DD',
  //        locale: 'id'
  //      });
  //  });

  

=======
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
