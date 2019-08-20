$(document).ready(function () {
    var url = 'gps-data-count';
    var gps_id = document.getElementById('hd_gps').value;
    var data = { 'gps_id':gps_id};  
     callBackDataTable(data);   
    window.setInterval(function(){
          backgroundPostData(url,data,'gpsdatacount',{alert:true});  
    }, 5000);    
});

function gpsdatacount(res){  
    var gps_id = document.getElementById('hd_gps').value;
    $("#gps_count").val(res.gpsdatacounts);
    var gpsdatacount= document.getElementById('gps_count').value;  
    gpscount = JSON.parse(localStorage.getItem("gps_count"));  
    if(!empty(gpsdatacoun))
    {
        if(gpsdatacount!=gpscount)
        {
            var gps_id = document.getElementById('hd_gps').value;
            var data = { 'gps_id':gps_id};
            callBackDataTable(data);         
        }
    }   
    
 var old_gpsdatacount= localStorage.setItem("gps_count", gpsdatacount);

}


function callBackDataTable(value){

    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: 'gps-data-list',
            type: 'POST',
            data: 'hello',          
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },   
         createdRow: function ( row, data, index ) {
            if ( data['header'] =='NRM') {
                $('td', row).css('background-color', 'rgb(128,255,128)');
            }
        },     

        fnDrawCallback: function (oSettings, json) {

        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_Row_Index', orderable: false, searchable: false},
            // {data: 'client.name', name: 'client.name', searchable: false},
            {data: 'gps.name', name: 'gps.name'},
            // {data: 'vehicle.name', name: 'vehicle.name'},
            {data: 'header', name: 'header'},
            {data: 'firmware_version', name: 'firmware_version'},
            {data: 'imei', name: 'imei'},
            {data: 'update_rate_ignition_on', name: 'update_rate_ignition_on'},
            {data: 'update_rate_ignition_off', name: 'update_rate_ignition_off'},
            {data: 'battery_percentage', name: 'battery_percentage'},
            {data: 'low_battery_threshold_value', name: 'low_battery_threshold_value'},
            {data: 'memory_percentage', name: 'memory_percentage'},
            {data: 'digital_io_status', name: 'digital_io_status'},
            {data: 'analog_io_status', name: 'analog_io_status'},
            {data: 'activation_key', name: 'activation_key'},
            {data: 'latitude', name: 'latitude'},
            {data: 'lat_dir', name: 'lat_dir'},
            {data: 'longitude', name: 'longitude'},
            {data: 'lon_dir', name: 'lon_dir'},
            {data: 'date', name: 'date'},
            {data: 'time', name: 'time'},
            {data: 'speed', name: 'speed'},
            {data: 'alert_id', name: 'alert_id'},
            {data: 'packet_status', name: 'packet_status'},
            {data: 'gps_fix', name: 'gps_fix'},
            {data: 'mcc', name: 'mcc'},
            {data: 'mnc', name: 'mnc'},
            {data: 'lac', name: 'lac'},
            {data: 'cell_id', name: 'cell_id'},
            {data: 'heading', name: 'heading'},
            {data: 'no_of_satelites', name: 'no_of_satelites'},
            {data: 'hdop', name: 'hdop'},
            {data: 'gsm_signal_strength', name: 'gsm_signal_strength'},
            {data: 'ignition', name: 'ignition'},
            {data: 'main_power_status', name: 'main_power_status'},
            {data: 'vehicle_mode', name: 'vehicle_mode'},
            {data: 'altitude', name: 'altitude'},
            {data: 'pdop', name: 'pdop'},
            {data: 'nw_op_name', name: 'nw_op_name'},
            {data: 'nmr', name: 'nmr'},
            {data: 'main_input_voltage', name: 'main_input_voltage'},
            {data: 'internal_battery_voltage', name: 'internal_battery_voltage'},
            {data: 'tamper_alert', name: 'tamper_alert'},
            {data: 'digital_input_status', name: 'digital_input_status'},
            {data: 'digital_output_status', name: 'digital_output_status'},
            {data: 'frame_number', name: 'frame_number'},
            {data: 'checksum', name: 'checksum'},
            {data: 'key1', name: 'key1'},
            {data: 'value1', name: 'value1'},
            {data: 'key2', name: 'key2'},
            {data: 'value2', name: 'value2'},
            {data: 'key3', name: 'key3'},
            {data: 'value3', name: 'value3'},
            {data: 'gf_id', name: 'gf_id'},            
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });

}

