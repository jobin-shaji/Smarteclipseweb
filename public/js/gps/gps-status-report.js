function confirmDeviceStatusReportDownload(){
    if(confirm('Time taken for the report download depends on the number of records. Kindly wait until the report generation is completed.'))
    {
        return true; 
    }
    else
    {
        return false; 
    }
}
