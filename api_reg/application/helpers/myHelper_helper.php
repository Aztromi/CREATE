<?php 


function remove_disallowed_field($raw_data,$allowed_field){
	$new_data = array_filter($raw_data,function($key)use($allowed_field){
		return in_array($key,array_values($allowed_field));
	},ARRAY_FILTER_USE_KEY);
	return $new_data;

}





 ?>