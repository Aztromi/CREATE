<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_rest_lib {

//===================================================================
//	GENERATE SQL QUERY
    public function generate_query($sector_code=null,...$args){
    	// echo $sector_code;diagnostics($args);exit();


    	
	//database fields setup
	$fields = function(...$args){
		if(array_key_exists("fields",$args[0]) AND !empty($args[0]['fields'])){
			return $args[0]['fields'];
		}
		else{
			if(array_key_exists("stakeholder",$args[0]) AND !empty($args[0]['stakeholder'])){
				$defaultFields = "a.ff_code,a.co_name,password,b.brand_name,a.cont_per_fn,a.mi,a.cont_per_ln,a.title,y_estab,add_st,add_city,tel_off,country,continent,owner_mobile,owner_email,co_email,tin,webpage,facebook,instagram,twitter,b.membership_assoc,linkedin,social_others,messaging_app,b.date_apply,b.fair_code,fair_stat_app,fair_stat_app_date,fair_stat_part,foreignlocal,sector_code,exhibit_participation,c.cont_per_fn as 'rep_fname',c.cont_per_ln as 'rep_lname',c.mi as rep_mi, c.title as rep_title,c.email as rep_email,c.mobile as rep_mobile,c.message_app as 'rep_messaging_app',direct_workers,indirect_workers,company_size,business_ownership,app_system";
			}else{
				$defaultFields = "*";
			}
			return $defaultFields;
		}
	};
	//database filter setup
	$filter = function(...$args){
		if(array_key_exists('q', $args[0]) and !empty($args[0]['q'])){
			$filter_array = json_decode($args[0]['q'],true);
			$where_clause='';
			foreach($filter_array as $key=>$value){
				if(is_array($value)){
					$where_clause.=" AND (";
					for($x=0; $x<count($value);$x+=1){
						$where_clause .= $key.' ="'.$value[$x].'"';
						if($x < count($value)-1){
							$where_clause.=" OR ";
						}
					}
					$where_clause.=" ) ";
				}
				else{
					$where_clause .=" AND ".$key."='".$value."'";
				} 
			}
			$where_clause.='';
			return $where_clause;
		}
	};
	//database filter LIKE setup
	$filterlike = function(...$args){
		if(array_key_exists('l', $args[0]) and !empty($args[0]['l'])){
			$filter_array = json_decode($args[0]['l'],true);
			$where_like_clause='';
			$ctr=0;
			foreach($filter_array as $key=>$value){
				if(is_array($value)){
					$where_like_clause.=" OR LIKE (";
					for($x=0; $x<count($value);$x+=1){
						$where_like_clause .= $key.' ="'.$value[$x].'"';
						if($x < count($value)-1){
							$where_like_clause.=" OR ";
						}
					}
					$where_clause.=" ) ";
				}
				else{
					$where_like_clause .= $ctr==0? ' AND '.$key." LIKE '".$value."'":" OR ".$key." LIKE '".$value."' ";
					$ctr++;
				}
			}
			return $where_like_clause;
		}
	};
	//database filter count setup
	$filterCount = function(...$args){
		if(array_key_exists('q', $args[0]) and !empty($args[0]['q'])){
			$filter_array = json_decode($args[0]['q'],true);
			$where_clause='';
			foreach($filter_array as $key=>$value){
				if(is_array($value)){
					$where_clause.=" AND (";
					for($x=0; $x<count($value);$x+=1){
						$where_clause .= $key.' ="'.$value[$x].'"';
						if($x < count($value)-1){
							$where_clause.=" OR ";
						}
					}
					$where_clause.=" ) ";
				}
				else{
					$where_clause .=" AND ".$key."='".$value."'";
				} 
			}
			return $where_clause;
		}
		return "";
	};
	//database offset setup
	$paging = function(...$args){
		if(array_key_exists("limit",$args[0])){
			if(array_key_exists("offset",$args[0])){
				return "LIMIT ".$args[0]['limit']." OFFSET ".$args[0]['offset'];
			}elseif($args[0]['limit']==0){
				return "";
			}else{
				return "LIMIT ".$args[0]['limit'];
			}
		}
		else{
			return "LIMIT 25";
		}
	};
	$table  = $args[0]['table'];
	$where = "WHERE TRUE AND b.sector_code=".$sector_code;
	
	if(count($args)>0){
		$q = "SELECT ". $fields(...$args)." FROM $table ".$where.$filter(...$args).$filterlike(...$args)." ".$paging(...$args);
		$q_count = "SELECT count(*) as count FROM $table ".$where;
		$q_count_filtered = "SELECT count(*) as count FROM $table ".$where.$filter(...$args).$filterlike(...$args);
	}else{
		echo 'failed generating query statement';
	}

	return array(
		'query' => $q,
		'query_count'=>$q_count,
		'query_filter_count'=>$q_count_filtered,
	);
    }


//===================================================================
//endpoint debug activation shows sql statement in json output result
    	public function is_debug(...$args){
    		if(array_key_exists('set', $args[0]) and !empty($args[0]['set'])){
	        	return $args[0]['set']=="debug"?true:false;
	        }
    	}
//===================================================================

        public function generate_sql(...$args)
        {
        	$table  = "v_contact_profile a INNER JOIN v_attendance b USING(rep_code)";

			$fields = function(...$args){
				if(array_key_exists("fields",$args[0]) AND !empty($args[0]['fields'])){
					return $args[0]['fields'];
				}
				else{
					$defaultFields = "rep_code,fameplus_id,email,add_value,cont_per_fn,cont_per_ln,mi,country,continent,
					co_name,tel_off,nationality,title,webpage,
					facebook,twitter,instagram,social_others,
					add_st,add_city,region,zipcode,mobile,b.visitor_status,b.visitor_status_remarks,supplier_info,b.validated,b.visitor_type,b.validation_status";
					return $defaultFields;
				}
			};

			$filter = function(...$args){
				if(array_key_exists('q', $args[0]) and !empty($args[0]['q'])){
					$filter_array = json_decode($args[0]['q'],true);
					$where_clause='';
					foreach($filter_array as $key=>$value){
						if(is_array($value)){
							$where_clause.=" AND (";
							for($x=0; $x<count($value);$x+=1){
								$where_clause .= $key.' ="'.$value[$x].'"';
								if($x < count($value)-1){
									$where_clause.=" OR ";
								}
							}
							$where_clause.=" ) ";
						}
						else{
							$where_clause .=' AND '.$key.'="'.$value.'"';
						} 
					}
					$where_clause.=' AND deleted=0';
					return $where_clause;
				}
				return "AND deleted=0 AND b.app_system=?";
			};

			$paging = function(...$args){
				if(array_key_exists("limit",$args[0])){
					if(array_key_exists("offset",$args[0])){
						return "LIMIT ".$args[0]['limit']." OFFSET ".$args[0]['offset'];
					}else{
						return "LIMIT ".$args[0]['limit'];
					}
				}
				else{
					return "LIMIT 25";
				}
			};

			if(count($args)>0){
				$q = "SELECT ". $fields(...$args)." FROM $table ". "WHERE TRUE ".$filter(...$args). " ".$paging(...$args);
				$q_count = "SELECT count(*) as count FROM $table ". "WHERE TRUE ".$filter(...$args);
			}else{
				echo 'failed generating query statement';
			}

			return array(
				'query' => $q,
				'count_query'=>$q_count,
			);

	    }
//===================================================================


        public function generate_exhibitor_query(...$args)
        {
        	$table  = "e_contact_profile a INNER JOIN e_attendance b USING(ff_code) LEFT JOIN e_representative c ON a.ff_code=c.ff_code";

			$fields = function(...$args){
				if(array_key_exists("fields",$args[0]) AND !empty($args[0]['fields'])){
					return $args[0]['fields'];
				}
				else{
					$defaultFields = "a.ff_code,a.co_name,password,b.brand_name,a.cont_per_fn,a.mi,a.cont_per_ln,a.title,y_estab,add_st,add_city,tel_off,country,continent,owner_mobile,owner_email,co_email,tin,webpage,facebook,instagram,twitter,b.membership_assoc,linkedin,social_others,messaging_app,b.date_apply,b.fair_code,fair_stat_app,fair_stat_app_date,fair_stat_part,foreignlocal,sector_code,exhibit_participation,c.cont_per_fn as 'rep_fname',c.cont_per_ln as 'rep_lname',c.mi as rep_mi, c.title as rep_title,c.email as rep_email,c.mobile as rep_mobile,c.message_app as 'rep_messaging_app',direct_workers,indirect_workers,company_size,business_ownership,app_system";
					return $defaultFields;
				}
			};

			$filter = function(...$args){
				if(array_key_exists('q', $args[0]) and !empty($args[0]['q'])){
					$filter_array = json_decode($args[0]['q'],true);
					$where_clause='';
					foreach($filter_array as $key=>$value){
						if(is_array($value)){
							$where_clause.=" AND (";
							for($x=0; $x<count($value);$x+=1){
								$where_clause .= $key.' ="'.$value[$x].'"';
								if($x < count($value)-1){
									$where_clause.=" OR ";
								}
							}
							$where_clause.=" ) ";
						}
						else{
							$where_clause .=' AND '.$key.'="'.$value.'"';
						} 
					}
					$where_clause.=' AND deleted=0';
					return $where_clause;
				}
				return "AND deleted=0 and sector_code=? GROUP BY a.ff_code";
			};

			$filterCount = function(...$args){
				if(array_key_exists('q', $args[0]) and !empty($args[0]['q'])){
					$filter_array = json_decode($args[0]['q'],true);
					$where_clause='';
					foreach($filter_array as $key=>$value){
						if(is_array($value)){
							$where_clause.=" AND (";
							for($x=0; $x<count($value);$x+=1){
								$where_clause .= $key.' ="'.$value[$x].'"';
								if($x < count($value)-1){
									$where_clause.=" OR ";
								}
							}
							$where_clause.=" ) ";
						}
						else{
							$where_clause .=' AND '.$key.'="'.$value.'"';
						} 
					}
					$where_clause.=' AND deleted=0';
					return $where_clause;
				}
				return "AND deleted=0 and sector_code=?";
			};

			$paging = function(...$args){
				if(array_key_exists("limit",$args[0])){
					if(array_key_exists("offset",$args[0])){
						return "LIMIT ".$args[0]['limit']." OFFSET ".$args[0]['offset'];
					}else{
						return "LIMIT ".$args[0]['limit'];
					}
				}
				else{
					return "LIMIT 25";
				}
			};

			if(count($args)>0){
				$q = "SELECT ". $fields(...$args)." FROM $table ". "WHERE TRUE ".$filter(...$args). " ".$paging(...$args);
				$q_count = "SELECT count(*) as count FROM $table ". "WHERE TRUE ".$filterCount(...$args);
			}else{
				echo 'failed generating query statement';
			}

			return array(
				'query' => $q,
				'count_query'=>$q_count,
			);

	    }



//===================================================================


        public function generate_ctmbuyer_sql(...$args)
        {
        	$table  = "v_contact_profile a INNER JOIN v_attendance b USING(rep_code)";

			$fields = function(...$args){
				if(array_key_exists("fields",$args[0]) AND !empty($args[0]['fields'])){
					return $args[0]['fields'];
				}
				else{
					// $defaultFields = "rep_code,fameplus_id,email,add_value,cont_per_fn,cont_per_ln,country,continent,
					// co_name,title,webpage,add_st,mobile,supplier_info,b.validated,b.visitor_type,b.validation_status";
					$defaultFields = "*";
					return $defaultFields;
				}
			};

			$filter = function(...$args){
				if(array_key_exists('q', $args[0]) and !empty($args[0]['q'])){
					$filter_array = json_decode($args[0]['q'],true);
					$where_clause='';
					foreach($filter_array as $key=>$value){
						if(is_array($value)){
							$where_clause.=" AND (";
							for($x=0; $x<count($value);$x+=1){
								$where_clause .= $key.' ="'.$value[$x].'"';
								if($x < count($value)-1){
									$where_clause.=" OR ";
								}
							}
							$where_clause.=" ) ";
						}
						else{
							$where_clause .=' AND '.$key.'="'.$value.'"';
						} 
					}
					$where_clause.=' AND deleted=0';
					return $where_clause;
				}
				return "AND deleted=0 ";
			};

			$paging = function(...$args){
				if(array_key_exists("limit",$args[0])){
					if(array_key_exists("offset",$args[0])){
						return "LIMIT ".$args[0]['limit']." OFFSET ".$args[0]['offset'];
					}else{
						return "LIMIT ".$args[0]['limit'];
					}
				}
				else{
					return "LIMIT 25";
				}
			};

			if(count($args)>0){
				$q = "SELECT ". $fields(...$args)." FROM $table ". "WHERE TRUE ".$filter(...$args). " ".$paging(...$args);
				$q_count = "SELECT count(*) as count FROM $table ". "WHERE TRUE ".$filter(...$args);
			}else{
				echo 'failed generating query statement';
			}

			return array(
				'query' => $q,
				'count_query'=>$q_count,
			);

	    }


//===================================================================


        public function generate_ctmexhibitor_sql(...$args)
        {
        	$table  = "e_contact_profile a INNER JOIN e_attendance b USING(ff_code) LEFT JOIN e_representative c ON a.ff_code=c.ff_code";

			$fields = function(...$args){
				if(array_key_exists("fields",$args[0]) AND !empty($args[0]['fields'])){
					return $args[0]['fields'];
				}
				else{
					// $defaultFields = "rep_code,fameplus_id,email,add_value,cont_per_fn,cont_per_ln,country,continent,
					// co_name,title,webpage,add_st,mobile,supplier_info,b.validated,b.visitor_type,b.validation_status";
					$defaultFields = "*";
					return $defaultFields;
				}
			};

			$filter = function(...$args){
				if(array_key_exists('q', $args[0]) and !empty($args[0]['q'])){
					$filter_array = json_decode($args[0]['q'],true);
					$where_clause='';
					foreach($filter_array as $key=>$value){
						if(is_array($value)){
							$where_clause.=" AND (";
							for($x=0; $x<count($value);$x+=1){
								$where_clause .= $key.' ="'.$value[$x].'"';
								if($x < count($value)-1){
									$where_clause.=" OR ";
								}
							}
							$where_clause.=" ) ";
						}
						else{
							$where_clause .=' AND '.$key.'="'.$value.'"';
						} 
					}
					$where_clause.=' AND deleted=0';
					return $where_clause;
				}
				return "AND deleted=0 ";
			};

			$paging = function(...$args){
				if(array_key_exists("limit",$args[0])){
					if(array_key_exists("offset",$args[0])){
						return "LIMIT ".$args[0]['limit']." OFFSET ".$args[0]['offset'];
					}else{
						return "LIMIT ".$args[0]['limit'];
					}
				}
				else{
					return "LIMIT 25";
				}
			};

			if(count($args)>0){
				$q = "SELECT ". $fields(...$args)." FROM $table ". "WHERE TRUE ".$filter(...$args). " ".$paging(...$args);
				$q_count = "SELECT count(*) as count FROM $table ". "WHERE TRUE ".$filter(...$args);
			}else{
				echo 'failed generating query statement';
			}

			return array(
				'query' => $q,
				'count_query'=>$q_count,
			);

	    }

//===================================================================
//===================================================================

        public function generate_subscriptions_sql(...$args)
        {
        	$table  = "v_contact_profile a INNER JOIN v_attendance b USING(rep_code)";

			$fields = function(...$args){
				if(array_key_exists("fields",$args[0]) AND !empty($args[0]['fields'])){
					return $args[0]['fields'];
				}
				else{
					$defaultFields = "rep_code,fameplus_id,email,add_value,cont_per_fn,cont_per_ln,country,continent,
					co_name,title,webpage,add_st,mobile,supplier_info,b.validated,b.visitor_type,b.validation_status";
					return $defaultFields;
				}
			};

			$filter = function(...$args){
				if(array_key_exists('q', $args[0]) and !empty($args[0]['q'])){
					$filter_array = json_decode($args[0]['q'],true);
					$where_clause='';
					foreach($filter_array as $key=>$value){
						if(is_array($value)){
							$where_clause.=" AND (";
							for($x=0; $x<count($value);$x+=1){
								$where_clause .= $key.' ="'.$value[$x].'"';
								if($x < count($value)-1){
									$where_clause.=" OR ";
								}
							}
							$where_clause.=" ) ";
						}
						else{
							$where_clause .=' AND '.$key.'="'.$value.'"';
						} 
					}
					$where_clause.=' AND deleted=0';
					return $where_clause;
				}
				return "AND deleted=0 AND b.app_system=?";
			};

			$paging = function(...$args){
				if(array_key_exists("limit",$args[0])){
					if(array_key_exists("offset",$args[0])){
						return "LIMIT ".$args[0]['limit']." OFFSET ".$args[0]['offset'];
					}else{
						return "LIMIT ".$args[0]['limit'];
					}
				}
				else{
					return "LIMIT 25";
				}
			};

			if(count($args)>0){
				$q = "SELECT ". $fields(...$args)." FROM $table ". "WHERE TRUE ".$filter(...$args). " ".$paging(...$args);
				$q_count = "SELECT count(*) as count FROM $table ". "WHERE TRUE ".$filter(...$args);
			}else{
				echo 'failed generating query statement';
			}

			return array(
				'query' => $q,
				'count_query'=>$q_count,
			);

	    }

//===================================================================
	    public function validate_email($email){
	    	return (filter_var($email,FILTER_VALIDATE_EMAIL))? true:false;
	    }
//===================================================================
	    // $GetBuyerRecord = function($x){
	    // 	return function($y) use($x){
	    // 		if($x=='email'){
	    // 			return $y+$x;
	    // 		}
	    // 		if($x=='email'){
	    // 			return $y+$x;
	    // 		}
	    		
	    // 	};
	    // };


	 //    $add_partial = function($z){
		// 	return function($x,$y)use($z){
		// 		// return $add($x,$y,$z);
		// 		return $x+$y+$z;
		// 	};

		// };


};