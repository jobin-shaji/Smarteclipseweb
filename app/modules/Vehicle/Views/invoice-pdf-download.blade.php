<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.2/css/bootstrap.css" rel="stylesheet"/>
<table class="table table-bordered">
   <tbody>
      <tr>
         <th>#</th>
         <th>Date</th>
         <th>Vehicle Name</th>
         <th>Duration</th>
         <th>K.M</th>
      </tr>

  <?php for($i=1;$i<=30;$i++){?>
      <tr>
         <td><?=$i?></td>
         <td>01-08-2019</td>
         <td>Innova</td>
         <td>100M</td>
         <td>50</td>
      </tr>

    <?php } ?>
      
   </tbody>
</table>