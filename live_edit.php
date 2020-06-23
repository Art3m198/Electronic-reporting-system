<?php
require 'db.php';
$input = filter_input_array(INPUT_POST);
if ($input['action'] == 'edit') {	
	$update_field='';
	if(isset($input['estimation'])) {
		$update_field.= "estimation='".$input['estimation']."'";
	} 
	if($update_field && $input['id']) {
	$sql_query = R::exec("UPDATE reports SET $update_field WHERE id='" . $input['id'] . "'");
	}
}
?>