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
        window.location.href = getUrl() + '/'+'trip-report-client' ;
    }
    else
    {
        return true;
    }
}