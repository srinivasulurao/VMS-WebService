<?php echo view('header'); ?>
<div class='container'>
<div id='playground'>
<?php 
$data=array();
$data['vouchers']=$vouchers;
echo view('voucher-input',$data); 
?>	
</div>
</div> <!-- Container Ends here --> 
<?php echo view('footer') ?>