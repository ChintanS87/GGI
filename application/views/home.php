
Hi, <strong>
    <?php //echo $username; ?>
</strong>! You are logged in now. 
    <?php //echo anchor('/auth/logout/', 'Logout'); ?>
<br/><br/>


<?php echo anchor('/auth/login/', 'Login'); ?>
<br/><br/>
<?php echo anchor('/auth/register/', 'Register Now'); ?>
<br/><br/>
<?php echo anchor('', 'Refer a friend'); ?>
<br/><br/>


Live Products<br/>
<?php
 $ctr=0; foreach ($live_products as $row) { $ctr++; 
echo $row->prod_name;
echo "<br/>";
 }
 ?>


<br/><br/> 
Upcoming Products<br/>
<?php
 $ctr=0; foreach ($upcoming_products as $row) { $ctr++; 
echo $row->prod_name;
echo "<br/>";
 }
?> 

<br/><br/>
Closed Products<br/>
<?php
 $ctr=0; foreach ($closed_products as $row) { $ctr++; 
echo $row->prod_name;
echo "<br/>";
 } 
?>