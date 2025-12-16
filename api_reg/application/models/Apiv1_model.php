<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Apiv1_model extends CI_Model {


	public function __construct()
	{
		parent::__construct();
		$this->dbase  = $this->config->item('dbase', 'my_rest');
        // $this->appConfig  = $this->config->item('setting', 'my_rest');
        $this->refSwitch  = $this->config->item('switch', 'my_rest');		

        $this->buyerDB = $this->load->database($this->dbase['buyer'],TRUE);
        $this->exhibitorDB = $this->load->database($this->dbase['exhibitor'],TRUE);
        $this->masterDB = $this->load->database($this->dbase['master'],TRUE);
        $this->configDB = $this->load->database($this->dbase['config'],TRUE);
	}

//===================================================================
	    public function get_record($identity,$stakeholder){
	    	if(is_numeric($identity)){
	    		if($stakeholder=='buyer'){
	    			$q = "SELECT rep_code,fameplus_id,email,add_value,cont_per_fn,cont_per_ln,country,continent,co_name,title,webpage,add_st,mobile,supplier_info,b.validated,b.visitor_type
        			FROM v_contact_profile a INNER JOIN v_attendance b USING(rep_code)
        			WHERE TRUE
        			AND deleted=0 
        			-- AND b.app_system=?
        			AND rep_code=?";
	    			$db = $this->load->database($stakeholder,TRUE);
	    			$result = $db->query($q,[$identity]);
        			return $result->first_row('array');
	    		}
	    		elseif($stakeholder=='exhibitor'){
	    			$q = "SELECT ff_code,app_system,a.co_name,co_email,password,b.brand_name,tel_off,add_st,add_city,province,country,cont_per_fn,cont_per_ln,mi,title,owner_mobile,messaging_app,y_estab,tin,webpage,facebook,instagram,twitter,linkedin,social_others,exhibit_participation,direct_workers,indirect_workers,company_size,business_ownership,b.membership_assoc,app_system,fameplus_id,fair_stat_app,foreignlocal
        			FROM e_contact_profile a INNER JOIN e_attendance b USING(ff_code)
        			WHERE TRUE
        			AND deleted=0 
        			AND ff_code=?";
	    			$db = $this->load->database($stakeholder,TRUE);
	    			$result = $db->query($q,$identity);
        			return $result->first_row('array');
	    		}
	    	}
	    	else{
	    		if($stakeholder=='buyer'){
	    			$q = "SELECT rep_code,fameplus_id,email,add_value,cont_per_fn,cont_per_ln,country,continent,co_name,title,webpage,add_st,mobile,supplier_info,b.validated,b.visitor_type
        			FROM v_contact_profile a INNER JOIN v_attendance b USING(rep_code)
        			WHERE TRUE
        			AND deleted=0 
        			-- AND b.app_system=?
        			AND email=?";
	    			$db = $this->load->database($this->dbase['buyer'],TRUE);
	    			$result = $db->query($q,[$identity]);
        			return $result->first_row('array');
	    		}
	    		elseif($stakeholder=='exhibitor'){
	    			$q = "SELECT ff_code,app_system,a.co_name,co_email,password,b.brand_name,tel_off,add_st,add_city,province,country,cont_per_fn,cont_per_ln,mi,title,owner_mobile,messaging_app,y_estab,tin,webpage,facebook,instagram,twitter,linkedin,social_others,exhibit_participation,direct_workers,indirect_workers,company_size,business_ownership,b.membership_assoc,app_system,fameplus_id,fair_stat_app,foreignlocal
        			FROM e_contact_profile a INNER JOIN e_attendance b USING(ff_code)
        			WHERE TRUE
        			AND deleted=0 
        			AND co_email=?";
	    			$db = $this->load->database($this->dbase['exhibitor'],TRUE);
	    			$result = $db->query($q,$identity);
        			return $result->first_row('array');
	    		}
	    	}
	    }
//===================================================================
	    public function accessRights($module,$id){
	    	$getUserFromKey = function($x){return ($this->configDB->query('SELECT * FROM api_users a INNER JOIN api_keys b USING(user_id) LEFT JOIN api_roles c USING(role_id) WHERE true and b.key="'.$x.'"')->row_array());};
	    	$getRoles = function($id){return ($this->configDB->query('SELECT * FROM api_roles_permissions WHERE role_id='.$id)->result_array());};
	    	$user = $getUserFromKey(headercheck('x-api-key'));
	    	$rows= $getRoles($user['role_id']);
	    	$user['permissions']=[];
	    	foreach($rows as $row){
	    		if(!isset($user['permissions'][$row['perm_mod']])){
	    			$user['permissions'][$row['perm_mod']]=[];
	    		}
	    		$user['permissions'][$row['perm_mod']][] = $row['perm_id'] ;
	    	}
	    	return $user;
	    }

//===============================================
//for loading project settings
    public function _load_appConfig(){
        $getSystemFromKey = function($x){return ($this->configDB->get_where('api_keys',array('key'=>$x))->num_rows()==1) ? $this->configDB->get_where('api_keys',array('key'=>$x))->row()->app_system : '';};
        if(is_array(headercheck('x-api-key'))){
            // echo 'api key is an array on the loading configuration ';
            return false;
        }else{
            $app_system = $getSystemFromKey(headercheck('x-api-key'));
        }
        switch ($app_system) {
            case 'CREATE_DTCP':
                return $this->config->item('create_dtcp', 'my_rest');
                break;
            case 'CREATE_Registration':
                return $this->config->item('create_reg', 'my_rest');
                break;
            case 'FAME+ Registration':
                return $this->config->item('home', 'my_rest');
                break;
            case 'IFEX DTCP':
                return $this->config->item('ifex', 'my_rest');
                break;
            default:
                break;
        }
    }
    
    
//===================================================================
    public function get_majorproduct_code($value,$productfaircode){
        $q = "SELECT * FROM v_reference WHERE 1 AND switch='GP' AND sector LIKE ? AND c_profile =? AND fair_code LIKE ?";
        $result = $this->masterDB->query($q,['%'.$this->appConfig['sector_code'].'%',$value,'%'.$productfaircode.'%']);
        return $result->first_row('array');
    }
//===================================================================


}

/* End of file Apiv1_model.php */
/* Location: ./application/models/Apiv1_model.php */