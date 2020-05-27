function getUrl(){
    return $('meta[name = "domain"]').attr('content');
}
function DateCheck()
{
    var from_date       =   document.getElementById('from_date').value;
    var to_date         =   document.getElementById('to_date').value;
    var from_d          =   new Date(from_date.split("-").reverse().join("-"));
    var from_day        =   from_d.getDate();
    var from_month      =   from_d.getMonth()+1;
    var from_year       =   from_d.getFullYear();
    //from_date           =   from_year+""+from_month+""+from_day;
    var to_d            =   new Date(to_date.split("-").reverse().join("-"));
    var to_day          =   to_d.getDate();
    var to_month        =   to_d.getMonth()+1;
    var to_year         =   to_d.getFullYear();
    // to_date             =   to_year+""+to_month+""+to_day;
    var dateFrom        =   new Date(from_year, from_month, from_day); //Year, Month, Date    
    var dateTo          =   new Date(to_year, to_month, to_day); //Year, Month, Date    
    if(dateFrom > dateTo)
    {
        document.getElementById('from_date').value  =   "";
        document.getElementById('to_date').value    =   "";
        alert('From date should be less than To date');
        window.location.href = getUrl() + '/'+'gps-transfer-report' ;
    }
    else
    {
        return true;
    }
}

// for checkbox in  dealer-to-subdealer-client-view in GpsReport Module
function checkboxChecker()
{
    var dealer_subdealer            =   document.getElementById('dealer_subdealer');
    var dealer_client               =   document.getElementById('dealer_client');
    if(dealer_subdealer.checked == true && dealer_client.checked == true) 
    {
        $('.dealer_to_subdealer_section').show();
        $('.dealer_to_client_section').show();
    }
    else if(dealer_subdealer.checked == true && dealer_client.checked == false){
        $('.dealer_to_subdealer_section').show();
        $('.dealer_to_client_section').hide();
    }
    else if(dealer_subdealer.checked == false && dealer_client.checked == true){
        $('.dealer_to_subdealer_section').hide();
        $('.dealer_to_client_section').show();
    }
    else if(dealer_subdealer.checked == false && dealer_client.checked == false){
        $('.dealer_to_subdealer_section').hide();
        $('.dealer_to_client_section').hide();
    }
}