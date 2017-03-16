<?php 

$author_role = get_role('user');


$post_types = get_post_types();




echo $_GET['pagination'] ? 'PAGINATION TRUE' : '';

echo 'maxnumpages'.$wp_query->max_num_pages;

	



//echo 'strtotime: '. strtotime('Wed Feb 15 2017 10:00 am');
//echo 'date: '. date('h:i a', 1487196000);

//echo  'Author-ID: ' . get_the_author_meta( 'ID' );


//echo '<br>the_id: ' .get_the_id();

?>

<!--<pre><?php //var_dump($author_role->capabilities) ?></pre>-->

