$(document).ready(function () {
    callBackDataTable();
});
function callBackDataTable() {

    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        // order: [[1, 'desc']],
        ajax: {
            url: 'assigned-gps-list',
            type: 'POST',
            data: function (d) {
                d.type = $('#type').val(); // or any JS variable
            },

            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },
        createdRow: function (row, data, index) {
            if (data['deleted_at']) {
                $('td', row).css('background-color', 'rgb(243, 204, 204)');
            }
        },

        fnDrawCallback: function (oSettings, json) {

        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'gps.imei', name: 'imei', orderable: false },

            { data: 'gps.e_sim_number', name: 'e_sim_number', orderable: false },

            { data: 'gps.installation_date_new', name: 'installation_date_new', orderable: false },
            { data: 'gps.validity_date', name: 'validity_date', orderable: false },
            { data: 'gps.validity', name: 'validity', orderable: false },
            { data: 'vehicle', name: 'vehicle', orderable: false },
            { data: 'callcenter', name: 'callcenter', orderable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
    var table = $('#dataTable').DataTable();
    table.search('').draw();
}
function disableSalesman(salesman) {
    if (confirm('Are you sure to deactivate this user?')) {
        var url = 'finance/disable';
        var data = {
            id: salesman
        };
        backgroundPostData(url, data, 'callBackDataTables', { alert: true });
    }
}
function enableSalesman(salesman) {
    if (confirm('Are you sure to activate this user?')) {
        var url = 'callcenter/enable';
        var data = {
            id: salesman
        };
        backgroundPostData(url, data, 'callBackDataTables', { alert: true });
    }
}