



<?php  

global $htmlTest;

ob_start(); ?>

<h1><?php echo get_the_title(120);?></h1>


<?php $htmlTest = ob_get_contents();
ob_end_clean();
?>


