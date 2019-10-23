<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>

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
				    <strong> <a href="https://www.linkedin.com/company/gulf-business-development-group/?originalSubdomain=in">Gulf Business Development Group .</a>.</strong>
				 </footer>
          <?php } 
          else if (strpos($url, $eclipse_key) == true) { ?>
                <footer class="main-footer">
				    <div class="pull-right hidden-xs">
				      <b>ECLIPSE</b> &nbsp;Version 0.1
				    </div>
				    Developed by  
				    <strong> <a href="http://vstmobility.com">VST Mobility Solutions</a>.</strong>
				 </footer>
          <?php }
          else { ?>
                <footer class="main-footer">
				    <div class="pull-right hidden-xs">
				      <b>ECLIPSE</b> &nbsp;Version 0.1
				    </div>
				    Developed by  
				    <strong> <a href="http://vstmobility.com">VST Mobility Solutions</a>.</strong>
				 </footer>
   <?php } ?>

