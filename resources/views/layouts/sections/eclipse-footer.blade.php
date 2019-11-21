    <?php
          $url=url()->current();
          $rayfleet_key="rayfleet";
          $eclipse_key="eclipse";
          if (strpos($url, $rayfleet_key) == true) {  ?>
				 <div class="container">
				  <div class="row">
				    <div class="col-md-12">
				      <footer class="footer"> 
				        <div class="footer-bottom">
				          <b>RAYFLEET</b> &nbsp;Version 0.1&nbsp;&nbsp;&nbsp;&nbsp; Developed by<a href="http://www.tecnositafgulf.qa" target="blank">Gulf Business Development Group</a>
				        </div>
				      </footer>
				    </div>
				  </div>
				</div>
          <?php } 
          else if (strpos($url, $eclipse_key) == true) { ?>
                <div class="container">
				  <div class="row">
				    <div class="col-md-12">
				      <footer class="footer"> 
				        <div class="footer-bottom">
				          Developed by <a href="http://vstmobility.com" target="blank">VST Mobility Solutions</a>&nbsp;&nbsp;&nbsp;&nbsp;<b>ECLIPSE</b> &nbsp;Version 0.1
				        </div>
				      </footer>
				    </div>
				  </div>
				</div>
          <?php }
          else { ?>

          		<div class="container">
				  <div class="row">
				    <div class="col-md-12">
				      <footer class="footer"> 
				        <div class="footer-bottom">
				          Developed by <a href="http://vstmobility.com" target="blank">VST Mobility Solutions</a>&nbsp;&nbsp;&nbsp;&nbsp;<b>ECLIPSE</b> &nbsp;Version 0.1
				        </div>
				      </footer>
				    </div>
				  </div>
				</div>
                


   <?php } ?>

<style type="text/css">
	.footer{
  padding: 0px 0;
    width: 76%;
    /*background: #dcdcdc;*/
    color: #fff;
}

.footer-bottom{
  width: 60%;
  text-align: center;
  margin-left: 35%;
  color: #444242;
}
</style>