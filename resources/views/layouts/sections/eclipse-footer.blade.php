<?php
$url=url()->current();
$rayfleet_key="rayfleet";
$eclipse_key="eclipse";
if (strpos($url, $rayfleet_key) == true) { ?>
<footer class="footer"> 
Developed by&nbsp;&nbsp;<a href="https://www.tecnositafgulf.qa" target="blank">Gulf Business Development Group</a>
<div class="footer-bottom" >
RAYFLEET &nbsp;Version 0.1
</div>
</footer>
<?php } 
else { ?>
<footer class="footer"> 
Developed by&nbsp; <a href="https://vstmobility.com" target="blank">VST Mobility Solutions pvt ltd</a>
<div class="footer-bottom">
<span id ="versionClick">Eclipse Version 
<?php 
if( file_exists('storage/releasenotes/latest.txt') )
    {
  echo substr(file_get_contents('storage/releasenotes/latest.txt'),0,6);
    }
?></span>
</div>
</footer>
<?php } ?>


<div class="modal fade" id="versionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header modal-hed-new">
<h5 class="modal-title" id="exampleModalLabel">What's new ?</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body modal-body-subhead">
    <?php
    if(file_exists('storage/releasenotes/latest.txt')) {
    $release_note_file_name = substr(file_get_contents('storage/releasenotes/latest.txt'), 0, 6).'.txt';
    
    //After removing white spaces
    $release_note_name = preg_replace("/\s+/", "", $release_note_file_name);
    
    if( file_exists('storage/releasenotes/'.$release_note_name) )
    {
    $file_contents = file_get_contents('storage/releasenotes/'.$release_note_name);
    echo '<h1>Version '.substr(file_get_contents('storage/releasenotes/latest.txt'), 0, 6).'</h1>';
    foreach( explode(',', $file_contents) as $each_features)
    {
    echo $each_features.'<br>';
    }
    }
    }

    ?>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div> 
<script src="{{asset('js/gps/version-list.js')}}"></script>

<style type="text/css">
.footer{
padding: 5px 4%;
width: 100%;
background: #fbfbfb;
color: #444242;
text-transform: uppercase;
font-size: 13px;
}
.modal-hed-new{    
  background: #daa102;
  color: #fff;
  padding: 10px 1rem;
  }
.modal-hed-new h5 {
  font-size: 21px;
  font-weight: 600;
  }
.footer-bottom{
  width: 13%;
  float: right;
/*margin-left: 10%;*/
  color: #444242;
  text-transform: uppercase;
  font-size: 13px;
}
.modal-body-subhead h1{
  font-size: 19px;
  font-weight: normal;
}
</style>

