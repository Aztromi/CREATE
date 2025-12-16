<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subscriptionv1_model extends CI_model{

	protected $_table='v_contact_profile';
	protected $_primary_key='rep_code';

	public $errors;
	public $messages;

	public function __construct(){
		parent::__construct();
		$this->dbase  = $this->config->item('dbase', 'my_rest');
        $this->refSwitch   = $this->config->item('switch', 'my_rest');  
        $this->allowedData = $this->config->item('allowed_field', 'my_rest');

        $this->subscriptionDB = $this->load->database($this->dbase['subscription'],TRUE);
        $this->exhibitorDB = $this->load->database($this->dbase['exhibitor'],TRUE);
        $this->masterDB = $this->load->database($this->dbase['master'],TRUE);
        $this->configDB = $this->load->database($this->dbase['config'],TRUE);

        $this->load->model('apiv1_model');
        $this->appConfig = $this->apiv1_model->_load_appConfig();
        
	}

//===================================================================
//=====                    SUBSCRIPTION                          ====
//=====                                                          ====
//===================================================================


    public function add_subscriber($data){
        $this->buyerDB->insert('v_contact_profile',$data);
        return $insert_id = $this->buyerDB->insert_id();
    }

//===================================================================
    public function prepare_add_subscriptions_data($data){
        $getContinent = function($x){return ($this->masterDB->get_where('v_reference',array('c_profile'=>$x,'switch'=>'R1'))->num_rows()==1) ? $this->masterDB->get_where('v_reference',array('c_profile'=>$x,'switch'=>'R1'))->row()->c_code : '';};
        $datetime = new DateTime('NOW');
        $date_created = $datetime->format('Y-m-d H:i:s'); 
        //Removed unknown fields
        $additional_data=array(
            'date_apply'=>$date_created,
            'reg_status'=>'T',
            'visitor_type'=>'GUEST',
            'sector'=>(isset($data['sector'])? $data['sector']:$this->appConfig['sector_code']),
        );
        if(isset($data['country'])){
            $additional_data['continent'] = $getContinent($data['country']);
        }
        if(isset($data['rep_code'])){
            $additional_data['barcode'] = barcode($data['rep_code']);
        }
        return array_merge($data,$additional_data);
    }
//===================================================================
//add exhibitor to contact
    public function add_buyer_contact_profile($data,$rep_code=null){
        $cleaned_data = remove_unallowed_fields($data,$this->allowedData['v_contact_profile']);
        if($rep_code==null){
            $this->subscriptionDB->insert('v_contact_profile',$cleaned_data);
            return $insert_id = $this->subscriptionDB->insert_id();
        }else{
            //update data to contact_profile
            return $this->subscriptionDB->update('v_contact_profile', $cleaned_data, ['rep_code' => $rep_code])? true:false;
        }
    }
//===================================================================
    // 
    //  sector: HOME, FOOD, CREATE, GENERAL, CPHIL, SSX, VIP, BIZDIV
    // 
    public function add_subscription_attendance($data,$rep_code){
        //Add generic Sector in the attendance
        $data = remove_unallowed_fields($data,$this->allowedData['v_attendance']);
        $datetime = new DateTime('NOW');
        $date_created = $datetime->format('Y-m-d H:i:s');  
        $AttendanceData=array();
        $genericData=array(
            'rep_code'=>$rep_code,
            'barcode'=>barcode($rep_code),
            'fair_code'=>(isset($data['fair_code'])? $data['fair_code']:$this->appConfig['sector_fair_code']),
            'sector'=>(isset($data['sector'])? $data['sector']:$this->appConfig['sector_code']),
            'reg_status'=>'T',
            'date_apply'=>(isset($data['date_apply'])? $data['date_apply']:$date_created),
            'visitor_type'=>'GUEST',
            'app_system'=>$this->appConfig['system1'],
        );
        array_push($AttendanceData,$genericData);
        $eventData=array(
                'rep_code'=>$rep_code,
                'barcode'=>barcode($rep_code),
                'fair_code'=>(isset($data['fair_code'])? $data['fair_code']:$this->appConfig['current_fair_code']),
                'sector'=>(isset($data['sector'])? $data['sector']:$this->appConfig['sector_code']),
                'date_apply'=>(isset($data['date_apply'])? $data['date_apply']:$date_created),
                'reg_status'=>'F',
                'visitor_type'=>'GUEST',
                'app_system'=>$this->appConfig['system'],
        );
        array_push($AttendanceData,$eventData);
        return ($this->subscriptionDB->insert_batch('v_attendance', $AttendanceData))? true:false;
    }
//===================================================================
    //MULTI VALUED  //good
    public function add_subscription_interest($data,$rep_code){
        $dataArray = explodeToArr('|',$data);
        $data = array();
        foreach($dataArray as $row){
            $product_detail = $this->get_majorproduct_code($row);
            $data[]=array(
                'rep_code'=>$rep_code,
                'barcode'=>barcode($rep_code),
                'prod_cat'=>$product_detail['c_code']??'',
                // 'prod_code'=>$product_detail['prod_code'],
                'remarks_major'=>$product_detail['c_profile']??$row,
                // 'remarks_minor'=>$product_detail['prod_desc'],
                'fair_code'=>$this->appConfig['sector_fair_code'],
                'sector'=>$this->appConfig['sector_code'],
                );
            $data[]=array(
                'rep_code'=>$rep_code,
                'barcode'=>barcode($rep_code),
                'prod_cat'=>$product_detail['c_code']??'',
                // 'prod_code'=>$product_detail['prod_code'],
                'remarks_major'=>$product_detail['c_profile']??$row,
                // 'remarks_minor'=>$product_detail['prod_desc'],
                'fair_code'=>$this->appConfig['current_fair_code'],
                'sector'=>$this->appConfig['sector_code'],
                );
        }
        //delete existing data of the user in reference to the fair_code
        $this->subscriptionDB->delete('v_genproducts', array('rep_code' => $rep_code,'fair_code'=>$this->appConfig['sector_fair_code']));
        $this->subscriptionDB->delete('v_genproducts', array('rep_code' => $rep_code,'fair_code'=>$this->appConfig['current_fair_code']));
        //insert new informthru data
        if($this->subscriptionDB->insert_batch('v_genproducts', $data)){
            return true;
        }
        else{
            return false;
        }
    }
//===================================================================
    //SUBSCRIBER REPRESENTATION
    //MULTI VALUED  //ISSUE ON THE SEPARATOR
    public function add_subscription_representation($data,$rep_code){
        $switch=$this->refSwitch['industry_representation'];
        $rows = explodeToArr('|',$data);
        $data = array();
        foreach($rows as $row){
            $item_code = $this->get_item_codev3($row,$switch,$this->appConfig['sector_code'],$this->appConfig['sector_code'],$this->appConfig['productfaircode']);

            $data[]=array(
                'rep_code'=>$rep_code,
                'barcode'=>barcode($rep_code),
                'item_code'=>$item_code,
                'remarks'=>$row,
                'fair_code'=>$this->appConfig['sector_fair_code'],
                'sector'=>$this->appConfig['sector_code'],
                );
            $data[]=array(
                'rep_code'=>$rep_code,
                'barcode'=>barcode($rep_code),
                'item_code'=>$item_code,
                'remarks'=>$row,
                'fair_code'=>$this->appConfig['current_fair_code'],
                'sector'=>$this->appConfig['sector_code'],
                );
        }
        //delete existing data of the user in reference to the fair_code
        $this->subscriptionDB->delete('v_representation', array('rep_code' => $rep_code,'fair_code'=>$this->appConfig['sector_fair_code']));
        $this->subscriptionDB->delete('v_representation', array('rep_code' => $rep_code,'fair_code'=>$this->appConfig['current_fair_code']));
        //insert new informthru data
        if($this->subscriptionDB->insert_batch('v_representation', $data)){
            return true;
        }
        else{
            return false;
        }
    }
//===================================================================
    //Valid EMail
    public function update_valid_email($rep_code){
        $data = array(
            'valid_email'=>1,
            'user_agreement'=>'Yes',
            'fair_code'=>$this->appConfig['current_fair_code'],
        );
        if($this->update_buyer_fair_participation($data,$rep_code)){
            $data = array(
                'valid_email'=>1,
                'user_agreement'=>'Yes',
                'fair_code'=>$this->appConfig['sector_fair_code'],
            );
            $success = $this->update_buyer_fair_participation($data,$rep_code);
        }
        return ($success) ? true:false;
    }
//===================================================================
    //Update Subscription in attendance
    public function update_attendance_subscription($rep_code){
        $data = array(
            'subscription'=>'Yes',
            'fair_code'=>$this->appConfig['sector_fair_code']
        );
        if($this->update_buyer_fair_participation($data,$rep_code)){
            $data = array(
                'subscription'=>'Yes',
                'fair_code'=>$this->appConfig['current_fair_code'],
            );
            $success = $this->update_buyer_fair_participation($data,$rep_code);
        }
        return ($success) ? true:false;
    }
//===================================================================
    // 
    //  sector: HOME, FOOD, CREATE, GENERAL, CPHIL, SSX, VIP, BIZDIV
    // 
    public function update_subscription_attendance($data,$rep_code){
        //Add generic Sector in the attendance
        $checkParticipation = function($buyer_id,$fair_code){
            return ($this->subscriptionDB->get_where('v_attendance',array('rep_code'=>$buyer_id,'fair_code'=>$fair_code))->num_rows()==1) ? true : false;
        };
        $allowed_attendance_data = remove_unallowed_fields($data,$this->allowedData['v_attendance']);
        //check generic attendance record
        if(!$checkParticipation($rep_code,$this->appConfig['sector_fair_code'])){
            // add attendance record if no generic attendance record
            $additional_data=array(
                'rep_code'=>$rep_code,
                'barcode'=>barcode($rep_code),
                'fair_code'=>$this->appConfig['sector_fair_code'],
                'sector'=>$this->appConfig['sector_code'],
                'reg_status'=>'T',
                'app_system'=>$this->appConfig['system1'],
                'visitor_type'=>'GUEST',
            );
            $prep_data = (count($additional_data)>0 ? array_merge($allowed_attendance_data,$additional_data) : $allowed_attendance_data);

            $refno = $this->add_buyer_participation($prep_data);
            if(!$refno){
                //return an error
                return $data = array('error'=>'An unexpected error occurred while adding buyer generic attendance 1');
            }else{
                //successfully added a generic attendance-> do an add or update for the event participation
                if($this->_update_current_attendance($allowed_attendance_data,$rep_code,$this->appConfig['current_fair_code'],$this->appConfig['sector_code'])){
                    return true;
                }
                else{
                }
            }
        }
        else{// with existing generic record attendance will do an update
            $additional_data=array(
                'rep_code'=>$rep_code,
                'fair_code'=>$this->appConfig['sector_fair_code'],
                'reg_status'=>'T',
                'app_system'=>$this->appConfig['system1'],
            );
            $prep_data = (count($additional_data)>0 ? array_merge($allowed_attendance_data,$additional_data) : $allowed_attendance_data);
            //unset updating of date_apply for generic attendance
            unset($prep_data['date_apply']);
            $updated = $this->update_buyer_fair_participation($prep_data,$rep_code);
            if(!$updated){
                return $data=array('error'=>'An unexpected error occurred while updating buyer generic attendance 2');
            }
            else{
                if($this->_update_subscription_current_attendance($allowed_attendance_data,$rep_code,$this->appConfig['sector_code'],$this->appConfig['sector_code'])){
                    return true;
                }
            }
        }       
    }
//===============================================
// Add or Update of Event Participation
    private function _update_subscription_current_attendance($data,$rep_code,$fair_code,$sector){
        $datetime = new DateTime('NOW');
        $date_created = $datetime->format('Y-m-d H:i:s'); 
        //FUNCTIONS to check for existing current event record
        $checkParticipation = function($buyer_id,$fair_code){
            return ($this->subscriptionDB->get_where('v_attendance',array('rep_code'=>$buyer_id,'fair_code'=>$fair_code))->num_rows()==1) ? true : false;
        };
        //check current attendance record
        if(!$checkParticipation($rep_code,$this->appConfig['current_fair_code'])){
            // add event attendance record
            $additional_data=array(
                'rep_code'=>$rep_code,
                'barcode'=>barcode($rep_code),
                'fair_code'=>$this->appConfig['current_fair_code'],
                'sector'=>$this->appConfig['sector_code'],
                'app_system'=>$this->appConfig['system'],
                // 'reg_status'=>'T',
                'date_apply'=>(isset($data['date_apply'])? $data['date_apply']:$date_created),
                'visitor_type'=>'GUEST',
            );
            $prep_data = (count($additional_data)>0 ? array_merge($data,$additional_data) : $allowed_attendance_data);
            $refno = $this->add_buyer_participation($prep_data);
            if(!$refno){
                return false;
            }else{
                return true;
            }
        }
        else{// update current attendance          
            $additional_data=array(
                'rep_code'=>$rep_code,
                'fair_code'=>$this->appConfig['current_fair_code'],
                'app_system'=>$this->appConfig['system'],
            );
            $prep_data = (count($additional_data)>0 ? array_merge($data,$additional_data) : $allowed_attendance_data);
            $updated = $this->update_buyer_fair_participation($prep_data,$rep_code);
            if(!$updated){
                return false;
            }else{
                return true;
            }

        }
    }

//===================================================================
    public function update_buyer_fair_participation($data,$id){
        // print_r($data);exit();
        $this->subscriptionDB->update('v_attendance', $data, array('rep_code' => $id,'fair_code'=>$data['fair_code']));
        if($this->subscriptionDB->affected_rows()>=0){
            return true;
        }else{
            return false;
        }
    }
//===================================================================
    public function getSubscriptionRepresentation(){
        // ini_set("memory_limit","4096M");
        $q = "SELECT rep_code,GROUP_CONCAT(remarks SEPARATOR '|')as representation FROM v_representation
        WHERE 1
        AND fair_code=?
        GROUP BY rep_code";
        $result = $this->subscriptionDB->query($q,[$this->appConfig['current_fair_code']]);
        return $result->result_array();
    }

//===================================================================
    public function getSubscriptionInterest(){
        // ini_set("memory_limit","4096M");
        $q = "SELECT rep_code,GROUP_CONCAT(remarks_major SEPARATOR '|')as interest FROM v_genproducts
        WHERE 1
        AND fair_code=?
        GROUP BY rep_code";
        $result = $this->subscriptionDB->query($q,[$this->appConfig['current_fair_code']]);
        return $result->result_array();
    }

//===================================================================
    //create barcode and pid
    public function add_barcode_pid($data,$rep_code){
        $data = remove_unallowed_fields($data,$this->allowedData['v_contact_profile']);
        $data['barcode'] = barcode($rep_code);
        $data['pid'] = md5($rep_code.$data['email']); 
        $this->subscriptionDB->update('v_contact_profile', $data, ['rep_code' => $rep_code]);
        return ($this->subscriptionDB->affected_rows()>=1)?true:false;
    }

//===================================================================

    public function prepare_addbuyer_data($data){
        $masterfile_db = $this->load->database('masterfile',TRUE);
        $getContinent = function($x,$db){return ($db->get_where('v_reference',array('c_profile'=>$x,'switch'=>'R1'))->num_rows()==1) ? $db->get_where('v_reference',array('c_profile'=>$x,'switch'=>'R1'))->row()->c_code : '';};
        //Removed unknown fields
        $additional_data=array(
            'reg_status'=>'T',
            'sector'=>(isset($data['sector'])? $data['sector']:$this->appConfig['sector_code']),
        );
        if(isset($data['country'])){
            $additional_data['continent'] = $getContinent($data['country'],$masterfile_db);
        }
        return array_merge($data,$additional_data);
    }

//===================================================================
    public function update_subscription($data,$id){
        // $db = $this->load->database($this->dbase['buyer'],TRUE);
        return ($this->subscriptionDB->update('v_contact_profile', $data, array('rep_code' => $id)))? true:false;
    }

//===================================================================
    public function get_majorproduct_code($value){
        $q = "SELECT * FROM v_reference WHERE 1 AND switch='GP' AND sector LIKE ? AND c_profile =? AND fair_code LIKE ?";
        $result = $this->masterDB->query($q,['%'.$this->appConfig['sector_code'].'%',$value,'%'.$this->appConfig['current_fair_code'].'%']);
        return $result->first_row('array');
    }


//===================================================================

    public function get_buyer_contact_by_email($email){
        $q = "SELECT rep_code,fameplus_id,email,add_value,cont_per_fn,cont_per_ln,country,continent,co_name,position,webpage,add_st,mobile
        FROM v_contact_profile
        WHERE TRUE
        AND email=?";
        $result = $this->subscriptionDB->query($q,[$email]);
        return $result->first_row('array');
    }

//===================================================================
    public function add_buyer_participation($data){
        $checkParticipation = function($buyer_id,$fair_code){
            return ($this->subscriptionDB->get_where('v_attendance',array('rep_code'=>$buyer_id,'fair_code'=>$fair_code))->num_rows()==1) ? true : false;};
        $buyer_db = $this->load->database($this->dbase['buyer'],TRUE);
        $buyer_db->insert('v_attendance',$data);
        return $insert_id = $buyer_db->insert_id();
    }






//===================================================================


//===================================================================
//=====                    SUBCRIPTION                           ====
//=====                                                          ====
//===================================================================


//===============================================
// Add or Update of Event Participation
    private function _update_current_attendance($data,$rep_code){
        $datetime = new DateTime('NOW');
        $date_created = $datetime->format('Y-m-d H:i:s'); 
        //FUNCTIONS to check for existing current event record
        $checkParticipation = function($buyer_id,$fair_code){
            $buyer_db = $this->load->database('default',TRUE);
            return ($buyer_db->get_where('v_attendance',array('rep_code'=>$buyer_id,'fair_code'=>$fair_code))->num_rows()==1) ? true : false;
        };
        //check current attendance record
        if(!$checkParticipation($rep_code,$this->appConfig1['current_fair_code'])){
            // add event attendance record
            $additional_data=array(
                'rep_code'=>$rep_code,
                'barcode'=>barcode($rep_code),
                'fair_code'=>$this->appConfig1['current_fair_code'],
                'sector'=>$this->appConfig1['sector_code'],
                'app_system'=>$this->appConfig1['system'],
                // 'reg_status'=>'T',
                'date_apply'=>(isset($data['date_apply'])? $data['date_apply']:$date_created),
                'visitor_type'=>'GUEST',
                // 'validation_status'=>'INCOMPLETE TRADE',
            );
            $prep_data = (count($additional_data)>0 ? array_merge($data,$additional_data) : $allowed_attendance_data);
            $refno = $this->buyerv1_model->add_buyer_participation($prep_data);
            if(!$refno){
                //return an error
                return false;
            }else{
                return true;
            }
        }
        else{// update current attendance
            
            $additional_data=array(
                'rep_code'=>$rep_code,
                // 'barcode'=>barcode($rep_code),
                'fair_code'=>$this->appConfig['current_fair_code'],
                // 'sector'=>$sector,
                'app_system'=>$this->appConfig['system'],
                // 'reg_status'=>'T',
                // 'date_apply'=>$prep_data['date_apply'],
                // 'visitor_type'=>'TRADE BUYER',
            );
            $prep_data = (count($additional_data)>0 ? array_merge($data,$additional_data) : $allowed_attendance_data);
            $updated = $this->buyerv1_model->update_buyer_fair_participation($prep_data,$rep_code);
            if(!$updated){
                // return $data=array('error'=>'An unexpected error occurred while updating buyer generic attendance');
                return false;
            }else{
                return true;
            }

        }
    }



//===============================================

    public function getContact($mysql){
        // ini_set("memory_limit","4096M");
        $result = $this->subscriptionDB->query($mysql,[$this->appConfig['system']]);
        return $result->result_array();
    }


//===================================================================
    public function getContactv2($mysql){
        // ini_set("memory_limit","4096M");
        // $db     = $this->load->database($this->dbase['buyer'],TRUE);
        $result = $this->subscriptionDB->query($mysql,[$this->appConfig['system']]);
        return $result->result_array();
    }


//===================================================================

    public function total_contact_record_count($sql){
        // ini_set("memory_limit","4096M");
        $result = $this->subscriptionDB->query($sql,[$this->appConfig['system']]);
        // return $result->num_rows();
        return $result->row_array();
    }

//===================================================================

    public function getMajorProduct(){
        // ini_set("memory_limit","4096M");
        $q = "SELECT rep_code,GROUP_CONCAT(DISTINCT remarks_major SEPARATOR '|')as majorproduct FROM v_genproducts
        WHERE 1
        AND fair_code=?
        GROUP BY rep_code";
        $result = $this->subscriptionDB->query($q,[$this->appConfig['current_fair_code']]);
        return $result->result_array();
    }

//===================================================================

    public function getMinorProduct(){
        // ini_set("memory_limit","4096M");
        $q = "SELECT rep_code,GROUP_CONCAT(DISTINCT remarks_minor SEPARATOR '|')as minorproduct FROM v_genproducts
        WHERE 1
        AND fair_code=?
        GROUP BY rep_code";
        $result = $this->subscriptionDB->query($q,[$this->appConfig['current_fair_code']]);
        return $result->result_array();
    }

//===================================================================

    public function getProducts(){
        // ini_set("memory_limit","4096M");
        $q = "SELECT rep_code,GROUP_CONCAT(CONCAT(remarks_major,':',remarks_minor)SEPARATOR '|') as products 
        FROM v_genproducts
        WHERE 1
        AND fair_code=?
        GROUP BY rep_code";
        $result = $this->subscriptionDB->query($q,[$this->appConfig['current_fair_code']]);
        return $result->result_array();
    }

//===================================================================
    public function getProductInterest(){
        // ini_set("memory_limit","4096M");
        $q = "SELECT rep_code,GROUP_CONCAT(remarks SEPARATOR '|')as product_interest FROM v_product_technique
        WHERE 1
        AND fair_code=?
        GROUP BY rep_code";
        $result = $this->subscriptionDB->query($q,[$this->appConfig['current_fair_code']]);
        return $result->result_array();

    }
//===================================================================
    public function getReason(){
        // ini_set("memory_limit","4096M");
        $q = "SELECT rep_code,GROUP_CONCAT(remarks SEPARATOR '|')as reason FROM v_showreason
        WHERE 1
        AND fair_code=?
        GROUP BY rep_code";
        $result = $this->subscriptionDB->query($q,[$this->appConfig['current_fair_code']]);
        return $result->result_array();
    }

//===================================================================
    public function getRepresentation(){
        // ini_set("memory_limit","4096M");
        $q = "SELECT rep_code,GROUP_CONCAT(remarks SEPARATOR '|')as representation FROM v_representation
        WHERE 1
        AND fair_code=?
        GROUP BY rep_code";
        $result = $this->subscriptionDB->query($q,[$this->appConfig['current_fair_code']]);
        return $result->result_array();
    }

//===================================================================
    //good
    public function get_item_code($value){
        $this->table = 'v_reference';
        $getItemCode = function($x){return ($this->masterDB->get_where($this->table,array('c_profile'=>$x))->num_rows()>=1) ? $this->masterDB->get_where($this->table,array('c_profile'=>$x))->row()->c_code : '';};
        return (isset($value)?$getItemCode($value):'');
    }
//===================================================================

    //good item code with switchparam
    //$this->get_item_code($value)
    public function get_item_codev2($value,$switch,$fair_code=null){
        $this->table = 'v_reference';
        $getItemCode = function($x,$switch){return ($this->masterDB->get_where($this->table,array('c_profile'=>$x,'switch'=>$switch))->num_rows()>=1) ? $this->masterDB->get_where($this->table,array('c_profile'=>$x,'switch'=>$switch))->row()->c_code : $this->masterDB->get_where($this->table,array('c_profile'=>'others','switch'=>$switch))->row()->c_code;};
        return (isset($value)?$getItemCode($value,$switch):'');
    }

//===================================================================

    //good item code with switchparam
    //$this->get_item_code($value)
    public function get_item_codev3($value,$switch,$sector,$fair_code=null){
        $this->table = 'v_reference';
        $this->masterDB->from('v_reference');
            $this->masterDB->like('sector',$sector);
            $this->masterDB->like('fair_code',$fair_code);
            $this->masterDB->where('c_profile',$value);
            $this->masterDB->where('switch',$switch);
            return ($this->masterDB->get()->row()->c_code)??'';
    }
  
//===================================================================
        //good
    public function get_product_code($value){
        $this->masterDB->from('v_product_lib as a');
        $this->masterDB->join('v_reference as b','a.prod_cat=b.c_code','left');
        $this->masterDB->like('a.sector',$this->appConfig['sector_code']);
        $this->masterDB->like('a.fair_code',$this->appConfig['productfaircode']);
        $this->masterDB->where('prod_desc',$value);
        return $this->masterDB->get()->first_row('array');
    }


//===================================================================

//===================================================================

    public function get_buyer_by($identity,$email=null){
        // ini_set("memory_limit","4096M");
        $q = "SELECT
        rep_code,fameplus_id,email,add_value,cont_per_fn,cont_per_ln,mi,country,continent,
                    co_name,tel_off,nationality,title,webpage,
                    facebook,twitter,instagram,social_others,
                    add_st,add_city,region,zipcode,mobile,b.visitor_status,b.visitor_status_remarks,supplier_info,b.validated,b.visitor_type,b.validation_status
        FROM v_contact_profile a INNER JOIN v_attendance b USING(rep_code)
        WHERE TRUE
        AND deleted=0 
        AND b.app_system=?";
        $q = ($identity=='email')? $q."AND email=?" : $q."AND id=?";
        $result = $this->subscriptionDB->query($q,[$this->appConfig['system'],$email]);
        return $result->first_row('array');
    }



//===================================================================
    public function getInformthru(){
        // ini_set("memory_limit","4096M");
        $q = "SELECT rep_code,GROUP_CONCAT(remarks SEPARATOR '|')as informthru FROM v_informthru
        WHERE 1
        AND fair_code=?
        GROUP BY rep_code";
        $result = $this->subscriptionDB->query($q,[$this->appConfig['current_fair_code']]);
        return $result->result_array();
    }


//===================================================================

    public function getJobfunction(){
        // ini_set("memory_limit","4096M");
        $q = "SELECT rep_code,GROUP_CONCAT(DISTINCT remarks SEPARATOR '|')as jobfunction FROM v_job_function
        WHERE 1
        AND fair_code=?
        GROUP BY rep_code";
        $result = $this->subscriptionDB->query($q,[$this->appConfig['current_fair_code']]);
        return $result->result_array();
    }

//===================================================================
    public function getMarketSegment(){
        // ini_set("memory_limit","4096M");
        $q = "SELECT rep_code,GROUP_CONCAT(remarks SEPARATOR '|')as marketSegment FROM v_mn_marketsegment
        WHERE 1
        AND fair_code=?
        GROUP BY rep_code";
        $result = $this->subscriptionDB->query($q,[$this->appConfig['current_fair_code']]);
        return $result->result_array();
    }

//===================================================================

    public function getAnnualsales(){
        // ini_set("memory_limit","4096M");
        $q = "SELECT rep_code,GROUP_CONCAT(DISTINCT remarks SEPARATOR '|')as annualsales FROM v_mn_annualsales
        WHERE 1
        AND fair_code=?
        GROUP BY rep_code";
        $result = $this->subscriptionDB->query($q,[$this->appConfig['current_fair_code']]);
        return $result->result_array();
    }

//===================================================================

//===================================================================


}

/* End of file v1_model.php */
/* Location: ./application/models/v1_model.php */