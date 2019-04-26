$(document).ready(function () {
    callBackDataTable();
});

function callBackDataTable(){
    var  data = {
    
    }; 


    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: 'etm-transfer-list',
            type: 'POST',
            data: {
                'data': data
            },
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },
       
        fnDrawCallback: function (oSettings, json) {

        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_Row_Index', orderable: false, searchable: false},
            {data: 'etm_details.name', name: 'etm_details.name'},
            {data: 'from_depot_details.name', name: 'from_depot_details.name'},
            {data: 'to_depot_details.name', name: 'to_depot_details.name'},
            {data: 'tarnferDate', name: 'tarnferDate',orderable: false, searchable: false}

            ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}


$('.etmData').on('change', function() {
   $("#to_depot option").css('display','block');
    var etmID=this.value;
    var data = { etmID : etmID };
    $.ajax({
        type:'POST',
        url: '/etm-transfer/depot-detils',
        data:data ,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {
          var CurrentDepot=res.etm.depot_id;
          var CurrentDepotName=res.etm.depot.name;
          $(".from_etm_depot").val(CurrentDepot); 
          $(".from_etm_depot_name").val(CurrentDepotName); 
          $("#to_depot option[value="+CurrentDepot+"]").hide();
        }
    });

  });





