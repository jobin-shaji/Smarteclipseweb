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
            url: 'version-rule-list',
            type: 'POST',
            data: {
                'data': data
            },
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },

        createdRow: function ( row, data, index ) {
            if ( data['deleted_at'] ) {
                $('td', row).css('background-color', 'rgb(243, 204, 204)');
            }
        },
       
        fnDrawCallback: function (oSettings, json) {

        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',searchable: false},
             {data: 'name', name: 'name',orderable: false},
            {data: 'android_version', name: 'android_version',orderable: false, searchable: false},
            {data: 'ios_version', name: 'ios_version',orderable: false},
            {data: 'description', name: 'description',orderable: false,searchable: false},
            {data: 'android_version_code', name: 'android_version_code',orderable: false},
            {data: 'android_version_priority', name: 'android_version_priority',orderable: false},
            {data: 'ios_version_code', name: 'ios_version_code',orderable: false},
            {data: 'ios_version_priority', name: 'ios_version_priority',orderable: false},
           ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}



