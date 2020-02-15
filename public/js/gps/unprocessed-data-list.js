function searchButtonClicked()
{
    var status  = false;       
    var imei    = document.getElementById('imei').value;        
    var header  = document.getElementById('header').value; 
    if( imei == '')
    {
        alert('Please select GPS');
    }
    else if( header == '')
    {
        alert('Please select header');
    }  
    else
    {
        status = true;
    }
    return status;
}