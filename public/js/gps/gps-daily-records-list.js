function searchButtonClicked()
{
    var status  = false;       
    var imei    = document.getElementById('imei').value;
    var date    = document.getElementById('date').value;        
    if( imei == '')
    {
        alert('Please select GPS');
    }
    else if( date == '')
    {
        alert('Please select Date');
    } 
    else
    {
        status = true;
    }
    return status;
}