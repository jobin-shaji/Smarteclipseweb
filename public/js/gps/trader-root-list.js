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
                url: 'get-trader-root-list',
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
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false},
                {data: 'name', name: 'name' },            
                {data: 'address', name: 'address',orderable: false},           
                {data: 'user.mobile', name: 'user.mobile', orderable: false},
                {data: 'user.email', name: 'user.email',orderable: false},         
                {data: 'sub_dealer.name', name: 'sub_dealer.name',orderable: false},
                {data: 'working_status', name: 'working_status',orderable: false}, 
               
            ],
            
            aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
        });
    }
       
    function disableTrader(trader_user_id)
           {
             if(confirm('Are you sure to deactivate this user?'))
                {
                     var url = 'trader/disable';
                     var data = {
                         id : trader_user_id
                        };
                        backgroundPostData(url,data,'callBackDataTables',{alert:true});  
                }
            }


    function enableTrader(trader_user_id)
        {
            if(confirm('Are you sure to activate this user?'))
            {
                var url = 'trader/enable';
                var data = {
                    id : trader_user_id
                };
                backgroundPostData(url,data,'callBackDataTables',{alert:true});  
            }
        }