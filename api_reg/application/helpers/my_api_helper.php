<?php 
	function remove_unallowed_fields($raw_data,$allowed_field){
		$new_data = array_filter($raw_data,function($key)use($allowed_field){
			return in_array($key,array_values($allowed_field));
		},ARRAY_FILTER_USE_KEY);
		return $new_data;
	}

//============================================================================
	 function barcode($rep_code){
	 	return $rep_code+2000000;
	 }

//============================================================================
	function explodeToArr($separator,$x){
		$arr = explode($separator, $x);
		$trimData = function($x){return trim($x);};
		$newArr = array_map($trimData, $arr);
		return $newArr;
	}

//============================================================================
	function explodeToArr2($separator,$x){
		$arr = explode($separator, $x);
		return array_map('trim',explode($separator,$x));
	}

//============================================================================
	function getGenderBySalutation($salutation){
		if(strtolower($salutation)=="mr." OR strtolower($salutation)=="mr"){
			$gender='Male';
		}
		if(strtolower($salutation)=="ms." OR strtolower($salutation)=="ms" OR strtolower($salutation)=="mrs" OR strtolower($salutation)=="mrs."){
			$gender='Female';
		}
		return $gender;
	}

//============================================================================
	function getUrlParam($fieldset){
		$newdata=[];
		foreach($fieldset as $row){
			if(isset($_GET[$row])){
				$newdata[$row] = $_GET[$row];
			}
		}
		return $newdata;
	}

//============================================================================

	function headercheck($x=null){
		$headers=array();
		foreach (getallheaders() as $name => $value){
			$headers[strtolower($name)] = $value;
		}
		return $headers[$x]??$headers;
	}	        
//============================================================================
//For user access rights
	function checkAccess($user,$module,$id){
          $module_exist = $user['permissions'][$module]?? null;
          return ($module_exist)? in_array($id, $user['permissions'][$module]):false;
      }

//============================================================================
//Clean array, removing array with no values
	function cleanAssocArr($arr){
		$newArr = array();
		foreach($arr as $key=>$value){
			if($value!==''){
				$newArr[$key]=$value;
			}
		}
		return $newArr;
	}

//=====================================
	function searchFromArray($filter,$data,$field){
	    $search = $filter;
	        $keys = array_keys(
	        array_filter($data,
	            function ($v) use ($search){ 
	                return  $v['ff_code'] == $search['ff_code'] && $v['fair_code'] == $search['fair_code']; 
	            }
	        )
	    );
	    return ($keys)? explodeToArr('|',$data[$keys[0]][$field]):'';
	}

//============================================================================
	function isMultiArray($x){
	    foreach($x as $v) if(is_array($v)) return TRUE;
	    return FALSE;
	}

//============================================================================
	function myArrayUP($x){
	    $Arr = array_values($x);
	    return $Arr;
	}
//=====================================
	/**
	 * 	
	 */
	function myCapitalize($x){
		return ucfirst(strtolower($x));
	}

//=====================================
	/**
	 * 	
	 */
	function myTitle($x){
		return ucwords(strtolower($x));
	}
//============================================================================

	/**
	 * Dump helper. Functions to dump variables to the screen, in a nicley formatted manner.
	 * @author Joost van Veen
	 * @version 1.0
	 */
	if (!function_exists('dump')) {
	    function dump ($var, $label = 'Dump', $echo = TRUE)
	    {
	        // Store dump in variable 
	        ob_start();
	        var_dump($var);
	        $output = ob_get_clean();
	        
	        // Add formatting
	        $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
	        $output = '<pre style="background: #FFFEEF; color: #000; border: 1px dotted #000; padding: 10px; margin: 10px 0; text-align: left;">' . $label . ' => ' . $output . '</pre>';
	        
	        // Output
	        if ($echo == TRUE) {
	            echo $output;
	        }
	        else {
	            return $output;
	        }
	    }
	}
	if (!function_exists('dump_exit')) {
	    function dump_exit($var, $label = 'Dump', $echo = TRUE) {
	        dump ($var, $label, $echo);
	        exit;
	    }
	}

	/**
	 * Dump helper. Functions to dump variables to the screen, in a nicley formatted manner.
	 * @author Joost van Veen
	 * @version 1.0
	 */

//============================================================================
	function diagnostics($var){
		if(ENVIRONMENT=='development'){
			dump($var);
		}
	}
//============================================================================
	function cleanStakeholderData($data){
		//removing extra stripslash
		$stepOne = json_decode(stripslashes(json_encode($data)),true);
		return $stepOne;
	}

//============================================================================
	function cleanExhibitorData($data){
		//removing extra stripslash
		$stepOne = json_decode(stripslashes(json_encode($data)),true);
		// $stepTwo = json_decode('"'.json_encode($stepOne).'"',true);
		// return $stepTwo;
		return $stepOne;
	}



//====================================================================================

 ?>