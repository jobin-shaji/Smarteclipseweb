
function getUrl(){
  return $('meta[name = "domain"]').attr('content');
}

function toast(res){
   if(res.status == 1){
        toastr.success( res.message, res.title);
        console.log( res.message, res.title);
    }
    else if(res.status == 0) {
        console.log('Error', res.message);
        toastr.error(res.message, 'Error');
    }
    else if(res.status == 'dbcount'){
        dbcount(res);
    }      
}

function backgroundPostData(url, data, callBack, options) { 

    var purl = getUrl() + '/'+url ;

    var defaults = {
        type: 'POST',
        alert: false
    };

    jQuery.extend(defaults, options);
    $.ajax({
        type: defaults.type,
        url: purl,
        data: data,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {
           toast(res);
            if (callBack){
                if (callBack == 'callBackDataTables'){
                    callBackDataTable();
                }
            }
        },
        error: function (err) {
            var message = (err.responseJSON)?err.responseJSON.message:err.responseText;
            toastr.error(message, 'Error');
        }
    });

}

function downloadFile(url,data){

    var purl = getUrl() + '/'+url ;

    $.ajax({
            cache: false,
            type: 'POST',
            url: purl,
            data: data,
             //xhrFields is what did the trick to read the blob to pdf
            xhrFields: {
                responseType: 'blob'
            },
            headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response, status, xhr) {

                var filename = "";                   
                var disposition = xhr.getResponseHeader('Content-Disposition');

                 if (disposition) {
                    var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                    var matches = filenameRegex.exec(disposition);
                    if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                } 
                var linkelem = document.createElement('a');
                try {
                                           var blob = new Blob([response], { type: 'application/octet-stream' });                        

                    if (typeof window.navigator.msSaveBlob !== 'undefined') {
                        //   IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                        window.navigator.msSaveBlob(blob, filename);
                    } else {
                        var URL = window.URL || window.webkitURL;
                        var downloadUrl = URL.createObjectURL(blob);

                        if (filename) { 
                            // use HTML5 a[download] attribute to specify filename
                            var a = document.createElement("a");

                            // safari doesn't support this yet
                            if (typeof a.download === 'undefined') {
                                window.location = downloadUrl;
                            } else {
                                a.href = downloadUrl;
                                a.download = filename;
                                document.body.appendChild(a);
                                a.target = "_blank";
                                a.click();
                            }
                        } else {
                            window.location = downloadUrl;
                        }
                    }   

                } catch (ex) {
                    console.log(ex);
                } 
            }
        });
}



function downloadWayBill(id){
    var url = 'waybill/export';
    var data = {
        id : id
    };
  downloadFile(url,data);
}

function downloadAdvanceBookingWayBill(id){
    var url = 'agent-waybill/export';
    var data = {
        id : id
    };
  downloadFile(url,data);
}

function downloadPenalty(){
    var url = 'inspector-report/export';
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "depot"]').attr('content'),'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "depot"]').attr('content')
        };
        downloadFile(url,data);
    }
}

function downloadFareSlab(route){
    var url = 'fareslab/export';
    var data = {
        route : route ,
        vehicle_type : 1
    }

    downloadFile(url,data);
}
function downloadStageWise(){
    var url = 'stage-wise-report/export';
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "depot"]').attr('content'),'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "depot"]').attr('content')
        };
        downloadFile(url,data);
    }
}

function downloadTripWise(){
    var url = 'trip-wise-report/export';
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "depot"]').attr('content'),'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "depot"]').attr('content')
        };
        downloadFile(url,data);
    }
}

function downloadConductorWaybill(){
    var url = 'conductor-waybill-abstract-report/export';
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "depot"]').attr('content'),'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "depot"]').attr('content')
        };
        downloadFile(url,data);
    }
    
}
 
function downloadRoute(){
    var url = 'route-report/export';
    var routeID=$('#route').val();
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(routeID){
       if(fromDate){
            var data = {
            id : $('meta[name = "depot"]').attr('content'),'routeID':routeID,'fromDate':fromDate,'toDate':toDate
            };
            downloadFile(url,data);
        }else{
            var data = {
            id : $('meta[name = "depot"]').attr('content'),'routeID':routeID
            };
            downloadFile(url,data);
        }
    }else{
        alert("Please Select Route");
    }
}

function downloadSingleRoute(){
    var url = 'single-route-report/export';
    var routeID=$('#route').val();
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(routeID){
       if(fromDate){
            var data = {
            id : $('meta[name = "depot"]').attr('content'),'routeID':routeID,'fromDate':fromDate,'toDate':toDate
            };
            downloadFile(url,data);
        }else{
            var data = {
            id : $('meta[name = "depot"]').attr('content'),'routeID':routeID
            };
            downloadFile(url,data);
        }
    }else{
        alert("Please Select Route");
    }
}

function downloadAgentSingleRoute(){
    var url = 'agent-single-route-report/export';
    var routeID=$('#route').val();
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(routeID){
       if(fromDate){
            var data = {
            id : $('meta[name = "depot"]').attr('content'),'routeID':routeID,'fromDate':fromDate,'toDate':toDate
            };
            downloadFile(url,data);
        }else{
            var data = {
            id : $('meta[name = "depot"]').attr('content'),'routeID':routeID
            };
            downloadFile(url,data);
        }
    }else{
        alert("Please Select Route");
    }
}

function downloadCombinedRoute(){
    var url = 'combined-route-report/export';
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
   if(fromDate){
        var data = {
        id : $('meta[name = "depot"]').attr('content'),'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        alert("Please Select Dates");
    }
}

function downloadAgentCombinedRoute(){
    var url = 'agent-combined-route-report/export';
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
   if(fromDate){
        var data = {
        id : $('meta[name = "depot"]').attr('content'),'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        alert("Please Select Dates");
    }
}

function downloadSingleConductor(){
    var url = 'single-conductor-report/export';
    var conductorID=$('#conductor').val();
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(conductorID){
       if(fromDate){
            var data = {
            id : $('meta[name = "depot"]').attr('content'),'conductorID':conductorID,'fromDate':fromDate,'toDate':toDate
            };
            downloadFile(url,data);
        }else{
            var data = {
            id : $('meta[name = "depot"]').attr('content'),'conductorID':conductorID
            };
            downloadFile(url,data);
        }
    }else{
        alert("Please Select Conductor");
    }
}

function downloadTollTax(){
    var url = 'toll-tax-report/export';
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "depot"]').attr('content'),'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "depot"]').attr('content')
        };
        downloadFile(url,data);
    }
}

function downloadExpenseWise(){
    var url = 'expenditure-report/export';
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "depot"]').attr('content'),'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "depot"]').attr('content')
        };
        downloadFile(url,data);
    }
}

function downloadDailyCashCollection(){
    var url = 'dailycash-collection-report/export';
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "depot"]').attr('content'),'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "depot"]').attr('content')
        };
        downloadFile(url,data);
    }
}


function downloadconductorWise(){
    var url = 'conductor-wise-report/export';
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "depot"]').attr('content'),'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "depot"]').attr('content')
        };
        downloadFile(url,data);
    }
}

function downloadMachineStatus(){
    var url = 'machine-status-report/export';

    var data = {
        id : $('meta[name = "depot"]').attr('content')
    };
  downloadFile(url,data);
}

function downloadetmcollection(){
    var url = 'etmCollection-report/export';
    var data = {
        id : $('meta[name = "depot"]').attr('content')
    };
  downloadFile(url,data);
}

function downloadWaybillWiseTrip()
{
    var url = 'waybill-wise-trip-report/export';
    var waybillID=$("#waybill").val();
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(waybillID){
       if(fromDate){
            var data = {
            'waybillID' :waybillID,'fromDate':fromDate,'toDate':toDate
            };
            downloadFile(url,data);
        }else{
            var data = {
            'waybillID' :waybillID
            };
            downloadFile(url,data);
        }
    }else{
        alert("Please Select Waybill");
    }
}

function downloadroutewisetrip()
{
    var url = 'route-wise-conductor-report/export';
    var routeID=$('#route').val();
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(routeID){
       if(fromDate){
            var data = {
            id : $('meta[name = "depot"]').attr('content'),'routeID':routeID,'fromDate':fromDate,'toDate':toDate
            };
            downloadFile(url,data);
        }else{
            var data = {
            id : $('meta[name = "depot"]').attr('content'),'routeID':routeID
            };
            downloadFile(url,data);
        }
    }else{
        alert("Please Select Route");
    }
  
}

function downloadStateFare(){
    var url = 'state-fare-report/export';
    var stateID=$("#state").val();
    if(stateID){
            var data = {
            'stateID' :stateID
            };
            downloadFile(url,data);
    }else{
        alert("Please Select State");
    }
}

function downloadConcession(){
    var url = 'concessional-report/export';
    var concessionID=$('#concession').val();
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(concessionID){
       if(fromDate){
            var data = {
            id : $('meta[name = "depot"]').attr('content'),'concessionID':concessionID,'fromDate':fromDate,'toDate':toDate
            };
            downloadFile(url,data);
        }else{
            var data = {
            id : $('meta[name = "depot"]').attr('content'),'concessionID':concessionID
            };
            downloadFile(url,data);
        }
    }else{
        alert("Please Select Concession Type");
    }
}

function downloadSingleConcession(){
    var url = 'single-concession-report/export';
    var concessionID=$('#concession').val();
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(concessionID){
       if(fromDate){
            var data = {
            id : $('meta[name = "depot"]').attr('content'),'concessionID':concessionID,'fromDate':fromDate,'toDate':toDate
            };
            downloadFile(url,data);
        }else{
            var data = {
            id : $('meta[name = "depot"]').attr('content'),'concessionID':concessionID
            };
            downloadFile(url,data);
        }
    }else{
        alert("Please Select Concession Type");
    }
}

function downloadAgentSingleConcession(){
    var url = 'agent-single-concession-report/export';
    var concessionID=$('#concession').val();
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(concessionID){
       if(fromDate){
            var data = {
            id : $('meta[name = "depot"]').attr('content'),'concessionID':concessionID,'fromDate':fromDate,'toDate':toDate
            };
            downloadFile(url,data);
        }else{
            var data = {
            id : $('meta[name = "depot"]').attr('content'),'concessionID':concessionID
            };
            downloadFile(url,data);
        }
    }else{
        alert("Please Select Concession Type");
    }
}

function downloadCombinedConcession(){
    var url = 'combined-concession-report/export';
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "depot"]').attr('content'),'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        alert("Please Select Dates");
    }
    
}

function downloadAgentCombinedConcession(){
    var url = 'agent-combined-concession-report/export';
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "depot"]').attr('content'),'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        alert("Please Select Dates");
    }
    
}

function downloadCashReceipt(){
    var id=$('#waybill_id').val();
    var url = 'cash-receipt-report/export';
    var data = {
        id : id
    };
  downloadFile(url,data);
}



function downloadSingleetmcollection(){
    var url = 'etmsingleCollection-report/export';
    var etm=$('#etm').val();
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(etm)
    {
        if(fromDate){
             if(toDate){
                 var data = {

                    id : $('meta[name = "depot"]').attr('content'),'etm':etm,'fromDate':fromDate,'toDate':toDate
                };
                downloadFile(url,data);
            }
            else
            {
                alert("Please Select  To Date");
            }
        }
        else
        {
            alert("Please Select Date");
        }
    }
    else
    {
        alert("Please Select etm");
    }
   
}

function downloadcombinedetmcollection(){
    var url = 'etmCombinedCollection-report/export';
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        if(toDate){
            var data = {
            id : $('meta[name = "depot"]').attr('content'),'fromDate':fromDate,'toDate':toDate
            };
            downloadFile(url,data);
        }
    }
    else
    {
        var data = {
            id : $('meta[name = "depot"]').attr('content')
        };
        downloadFile(url,data);
    }  
}



function downloadformanyetmcollection(){
    var url = 'etmFormanyCollection-report/export';
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        if(toDate){
            var data = {
            id : $('meta[name = "depot"]').attr('content'),'fromDate':fromDate,'toDate':toDate
            };
            downloadFile(url,data);
        }
    }
    else
    {
        var data = {
            id : $('meta[name = "depot"]').attr('content')
        };
        downloadFile(url,data);
    }  
}

function downloadsingleconductorWise(){
    var conductor=$('#conductor').val();
    var url = 'singleconductor-wise-report/export';
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "depot"]').attr('content'),'conductor':conductor,'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "depot"]').attr('content')
        };
        downloadFile(url,data);
    }
}


function downloadCombinedConductor(){
    
    var url = 'combined-conductor-report/export';
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "depot"]').attr('content'),'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "depot"]').attr('content')
        };
        downloadFile(url,data);
    }
}


function downloadForManyConductor(){
    
    var url = 'formany-conductor-report/export';
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "depot"]').attr('content'),'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "depot"]').attr('content')
        };
        downloadFile(url,data);
    }
}


function downloadSingledrivercollection(){
    
    var url = 'single-driver-report/export';
     var driver=$('#driver').val();
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "depot"]').attr('content'),'driver':driver,'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "depot"]').attr('content')
        };
        downloadFile(url,data);
    }
}



function downloadCombinedDriver(){
    
    var url = 'combined-driver-report/export';
     
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "depot"]').attr('content'),'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "depot"]').attr('content')
        };
        downloadFile(url,data);
    }
}


function downloadformanyDriver(){
    
    var url = 'formany-driver-report/export';  
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "depot"]').attr('content'),'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "depot"]').attr('content')
        };
        downloadFile(url,data);
    }
}
function downloadSinglestatewise()
{   
    var url = 'single-state-wise-report/export';
    var state=$('#state').val();

    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "depot"]').attr('content'),'state':state,'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "depot"]').attr('content')
        };
        downloadFile(url,data);
    }
}


function downloadSinglegstcollection(){
    
    var url = 'single-gst-report/export';
    var state=$('#state').val();
    var vehicle_type=$('#vehicle_type').val();
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "depot"]').attr('content'),'state':state,'vehicle_type':vehicle_type,'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "depot"]').attr('content')
        };
        downloadFile(url,data);
    }
}


function downloadCombinedgstcollection(){
    
    var url = 'combined-gst-report/export';
    
    
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "depot"]').attr('content'),'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "depot"]').attr('content')
        };
        downloadFile(url,data);
    }
}

function downloadSinglestatecollection(){
    
    var url = 'single-state-report/export';
    var state=$('#state').val();
   
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "depot"]').attr('content'),'state':state,'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "depot"]').attr('content')
        };
        downloadFile(url,data);
    }
}




function downloadCombinedstatecollection(){
    
    var url = 'combined-state-report/export';
    
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "depot"]').attr('content'),'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "depot"]').attr('content')
        };
        downloadFile(url,data);
    }
}




function downloadadvanceSingleetmcollection(){
    
    var url = 'agent-etmsingleCollection-report/export';
    var etm=$('#etm').val();
   
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "depot"]').attr('content'),'etm':etm,'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "depot"]').attr('content')
        };
        downloadFile(url,data);
    }
}


function downloadadvancebookingcombinedetm(){
    
    var url = 'agent-etmCombinedCollection-report/export';
    
   
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "depot"]').attr('content'),'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "depot"]').attr('content')
        };
        downloadFile(url,data);
    }
}




function downloadadvancebookingformanydaysetm(){
    
    var url = 'agent-etmFormanyCollection-report/export';
    
   
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "depot"]').attr('content'),'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "depot"]').attr('content')
        };
        downloadFile(url,data);
    }
}


function downloadAdvanceWise(){
    var url = 'advance-wise-report/export';
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "depot"]').attr('content'),'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "depot"]').attr('content')
        };
        downloadFile(url,data);
    }
}



function downloadSingleAgent(){
    var url = 'single-agent-report/export';
    var agentID=$('#agent').val();
    
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(agentID){
       if(fromDate){
            var data = {
            id : $('meta[name = "depot"]').attr('content'),'agentID':agentID,'fromDate':fromDate,'toDate':toDate
            };
            downloadFile(url,data);
        }else{
            var data = {
            id : $('meta[name = "depot"]').attr('content'),'agentID':agentID
            };
            downloadFile(url,data);
        }
    }else{
        alert("Please Select Agent");
    }
}




function downloadCombinedAgent(){
    var url = 'combined-agent-report/export';
   
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
   
       if(fromDate){
            var data = {
            id : $('meta[name = "depot"]').attr('content'),'fromDate':fromDate,'toDate':toDate
            };
            downloadFile(url,data);
        }else{
            var data = {
            id : $('meta[name = "depot"]').attr('content')
            };
            downloadFile(url,data);
        }
    }


function downloadformanyAgent(){
    var url = 'formany-agent-report/export';
   
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
   
       if(fromDate){
            var data = {
            id : $('meta[name = "depot"]').attr('content'),'fromDate':fromDate,'toDate':toDate
            };
            downloadFile(url,data);
        }else{
            var data = {
            id : $('meta[name = "depot"]').attr('content')
            };
            downloadFile(url,data);
        }
    }


    function downloadAdvanceBookerWaybill(){
    var url = 'agent-waybill-abstract-report/export';
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "depot"]').attr('content'),'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "depot"]').attr('content')
        };
        downloadFile(url,data);
    }
    
}


function downloadAdvanceBookerWaybillWiseTrip()
{
    var url = 'agent-waybill-wise-trip-report/export';
    var waybillID=$("#waybill").val();
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(waybillID){
       if(fromDate){
            var data = {
             id : $('meta[name = "depot"]').attr('content'),'waybillID' :waybillID,'fromDate':fromDate,'toDate':toDate
            };
            downloadFile(url,data);
        }else{
            var data = {
             id : $('meta[name = "depot"]').attr('content'),'waybillID' :waybillID
            };
            downloadFile(url,data);
        }
    }else{
        alert("Please Select Waybill");
    }
}

