    <?php
          $url=url()->current();
          $rayfleet_key="rayfleet";
          $eclipse_key="eclipse";
          if (strpos($url, $rayfleet_key) == true) {  ?>
               <footer class="main-footer">
				    <div class="pull-right hidden-xs">
				      <b>RAYFLEET</b> &nbsp;Version 0.1
				    </div>
				    Developed by  
				    <strong> <a href="http://www.tecnositafgulf.qa" target="_blank">Gulf Business Development Group .</a>.</strong>
				 </footer>
          <?php } 
          else if (strpos($url, $eclipse_key) == true) { ?>
                <footer class="main-footer">
				    <div class="pull-right hidden-xs">
				      <b>ECLIPSE</b> &nbsp;Version 0.1
				    </div>
				    Developed by  
				    <strong> <a href="http://vstmobility.com" target="_blank">VST Mobility Solutions</a>.</strong>
				 </footer>
          <?php }
          else { ?>
                <footer class="main-footer">
				    <div class="pull-right hidden-xs">
				      <b>ECLIPSE</b> &nbsp;Version 0.1
				    </div>
				    Developed by  
				    <strong> <a href="http://vstmobility.com" target="_blank">VST Mobility Solutions</a>.</strong>
				 </footer>
   <?php } ?>

