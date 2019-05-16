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
            url: 'geofence-list',
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
            {data: 'DT_RowIndex', name: 'DT_Row_Index', orderable: false, searchable: false},
            {data: 'name', name: 'name' },            
            {data: 'clients.name', name: 'clients.name',searchable: false},           
            {data: 'action', name: 'action', orderable: false, searchable: false},           
        ],        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}
function delGeofence(geofence){
    var url = 'geofence/delete';
    var data = {
        uid : geofence
    };
    backgroundPostData(url,data,'callBackDataTables',{alert:true});  
}
function activateGeofence(geofence){
    var url = 'geofence/activate';
    var data = {
        id : geofence
    };
    backgroundPostData(url,data,'callBackDataTables',{alert:true});  
}
 function mapsView(geofence_id){
         
    var url = 'geofence/show';
    var data = {
        uid : geofence_id
    };
    getPolygonData(url,data,'Coordinates',{alert:true});  
}

