    <?php
          $url=url()->current();
          $rayfleet_key="rayfleet";
          $eclipse_key="eclipse";
          if (strpos($url, $rayfleet_key) == true) {  ?>
				 
				      <footer class="footer"> 
				      	 Developed by&nbsp;&nbsp;<a href="http://www.tecnositafgulf.qa" target="blank">Gulf Business Development Group</a>
				        <div class="footer-bottom" >
				        RAYFLEET &nbsp;Version 0.1
				        </div>
				      </footer>
				   
          <?php } 
          else if (strpos($url, $eclipse_key) == true) { ?>
                <footer class="footer"> 
			      	Developed by&nbsp; <a href="http://vstmobility.com" target="blank">VST Mobility Solutions</a>
			        <div class="footer-bottom">
			         ECLIPSE &nbsp;Version 0.1
			        </div>
		        </footer>
  <?php }
          else { ?>

				<footer class="footer"> 
			      	Developed by&nbsp; <a href="http://vstmobility.com" target="blank">VST Mobility Solutions</a>
			        <div class="footer-bottom">
			         ECLIPSE &nbsp;Version 0.1
			        </div>
		        </footer>

   <?php } ?>

<style type="text/css">
	.footer{
  padding: 5px 4%;
    width: 100%;
    background: #fbfbfb;
    color: #444242;
    text-transform: uppercase;
    font-size: 13px;
}

.footer-bottom{
  width: 13%;
  float: right;
  /*margin-left: 10%;*/
  color: #444242;
  text-transform: uppercase;
  font-size: 13px;
}
</style>