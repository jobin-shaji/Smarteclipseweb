var items = [];
var command_items = [];

window.onload = function()
{
    document.getElementById('gps_id').value             = "";
    document.getElementById('command').value            = "";
    document.getElementById('selected_gps_id').value    = "";
    document.getElementById('selected_command').value   = "";
}

$(function () {
    $("#gps_id").change(function () {
        var selectedImei  = $(this).find("option:selected").text();
        var selectedGpsId = $(this).val();
        var position = jQuery.inArray(selectedGpsId, items);
        if(position !='-1'){
            toastr.error('Device Exists');
        }else{
            items.push(selectedGpsId);
            var gps_id              = selectedGpsId;
            var gps_imei_serial_no  = selectedImei;
            $("#selected_gps_id").val(items);
            var old_device_count    = $('#device_count').text();
            var device_count        = parseInt(old_device_count)+1;
            $('#device_count').text(device_count);
            var device_markup       = "<tr class='cover_gps_"+gps_id+"'><td>" + gps_imei_serial_no + "</td><td><button type='button' class='btn btn-xs btn-danger' onclick='return deleteFromGpsArray("+gps_id+");'>Remove</button></td></tr>";
            $(".device-table-row").append(device_markup);
            var device_array    = $('#selected_gps_id').val();
            var command_array   = $('#selected_command').val();
            if (device_array) 
            {
                $("#device_count_section").show();
                $("#device_table").show();
            }
            if(device_array.length > 0 && command_array.length > 0)
            {
                $("#submit_button").show();
            }
            toastr.success('Device Added Successfully');
        }
    });

    // $("#command").change(function () {
    //     var selectedCommand = $(this).val();
    //     var position        = jQuery.inArray(selectedCommand, command_items);
    //     if(position !='-1'){
    //         toastr.error('Command Exists');
    //     }else{
    //         command_items.push(selectedCommand);
    //         var command              = selectedCommand;
    //         var trimmed_command      = command.split(" ").join("");
    //         $("#selected_command").val(command_items);
    //         var old_command_count    = $('#command_count').text();
    //         var command_count        = parseInt(old_command_count)+1;
    //         $('#command_count').text(command_count);
    //         var command_markup      = "<tr class='cover_command_"+trimmed_command+"'><td>" + command + "</td><td><button class='btn btn-xs btn-danger' onclick='return deleteFromCommandArray(\"" + trimmed_command + "\")'>Remove</button></td></tr>";
    //         $(".command-table-row").append(command_markup);
    //         var command_array   = $('#selected_command').val();
    //         var device_array    = $('#selected_gps_id').val();
    //         if (command_array) 
    //         {
    //             $("#command_count_section").show();
    //             $("#command_table").show();
    //         }
    //         if(device_array.length > 0 && command_array.length > 0)
    //         {
    //             $("#submit_button").show();
    //         }
    //         toastr.success('Command Added Successfully');
    //     }
    // });
});

function clickOnAddCommand() 
{
    var selectedCommand = document.getElementById('command').value;
    document.getElementById('command').value = "";
    if(selectedCommand.length == 0)
    {
        alert("Please type your command");
    }
    else
    {
        var position        = jQuery.inArray(selectedCommand, command_items);
        if(position !='-1'){
            toastr.error('Command Exists');
        }else{
            command_items.push(selectedCommand);
            var command              = selectedCommand;
            var trimmed_command      = command.split(" ").join("");
            $("#selected_command").val(command_items);
            var old_command_count    = $('#command_count').text();
            var command_count        = parseInt(old_command_count)+1;
            $('#command_count').text(command_count);
            var command_markup      = "<tr class='cover_command_"+trimmed_command+"'><td>" + command + "</td><td><button type='button' class='btn btn-xs btn-danger' onclick='return deleteFromCommandArray(\"" + trimmed_command + "\")'>Remove</button></td></tr>";
            $(".command-table-row").append(command_markup);
            var command_array   = $('#selected_command').val();
            var device_array    = $('#selected_gps_id').val();
            if (command_array) 
            {
                $("#command_count_section").show();
                $("#command_table").show();
            }
            if(device_array.length > 0 && command_array.length > 0)
            {
                $("#submit_button").show();
            }
            toastr.success('Command Added Successfully');
        }
    }
    
    
}

function deleteFromGpsArray(gps_id)
{
    if( confirm('Do you want to remove this ?') )
    {
        var item_data = items.indexOf(gps_id);
        if (item_data != null) {
            items.splice(item_data, 1);
            $('.cover_gps_'+gps_id).remove();
            var old_device_count= $('#device_count').text();
            var device_count    = parseInt(old_device_count)-1;
            $('#device_count').text(device_count);
            $('#selected_gps_id').val(items); 
            var device_array    = $('#selected_gps_id').val();
            var command_array   = $('#selected_command').val();
            if(device_array.length > 0 && command_array.length > 0)
            {
                $("#submit_button").show();
            }
            if (device_array) 
            {
                $("#device_count_section").show();
                $("#device_table").show();
            }else{
                $("#device_count_section").hide();
                $("#device_table").hide();
                $("#submit_button").hide();
            }
            toastr.info('Device Removed Successfully');
        }
    }
    else
    {
        return false;
    }
}

function deleteFromCommandArray(command)
{
    if( confirm('Do you want to remove this ?') )
    {
        var command_item_data   = command_items.indexOf(command);
        if (command_item_data != null) {
            command_items.splice(command_item_data, 1);
            $('.cover_command_'+command).remove();
            var old_command_count = $('#command_count').text();
            var command_count = parseInt(old_command_count)-1;
            $('#command_count').text(command_count);
            $('#selected_command').val(command_items); 
            var device_array    = $('#selected_gps_id').val();
            var command_array   = $('#selected_command').val();
            if(device_array.length > 0 && command_array.length > 0)
            {
                $("#submit_button").show();
            }
            if (command_array) 
            {
                $("#command_count_section").show();
                $("#command_table").show();
            }else{
                $("#command_count_section").hide();
                $("#command_table").hide();
                $("#submit_button").hide();
            }
            toastr.info('Command Removed Successfully');
        }
    }
    else
    {
        return false;
    }
}
