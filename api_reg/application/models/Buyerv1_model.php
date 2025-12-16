<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Buyerv1_model extends CI_model{

	protected $_table='v_contact_profile';
	protected $_primary_key='rep_code';

	public $errors;
	public $messages;

	public function __construct(){
		parent::__construct();
		$this->dbase  = $this->config->item('dbase', 'my_rest');
        $this->refSwitch   = $this->config->item('switch', 'my_rest');  
        $this->allowedData = $this->config->item('allowed_field', 'my_rest');

        $this->buyerDB = $this->load->database($this->dbase['buyer'],TRUE);
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

    public function getSubscriptionRepresentation(){
        // ini_set("memory_limit","4096M");
        $q = "SELECT rep_code,GROUP_CONCAT(remarks SEPARATOR '|')as representation FROM v_representation
        WHERE 1
        AND fair_code=?
        GROUP BY rep_code";
        $result = $this->buyerDB->query($q,[$this->appConfig['current_fair_code']]);
        return $result->result_array();
    }

//===================================================================
    public function getSubscriptionInterest(){
        // ini_set("memory_limit","4096M");
        $q = "SELECT rep_code,GROUP_CONCAT(remarks_major SEPARATOR '|')as interest FROM v_genproducts
        WHERE 1
        AND fair_code=?
        GROUP BY rep_code";
        $result = $this->buyerDB->query($q,[$this->appConfig['current_fair_code']]);
        return $result->result_array();
    }

//===================================================================
    //create barcode and pid
    public function add_barcode_pid($data,$rep_code){
        $data = remove_unallowed_fields($data,$this->allowedData['v_contact_profile']);
        $data['barcode'] = barcode($rep_code);
        $data['pid'] = md5($rep_code.$data['email']); 
        $db = $this->load->database('default',TRUE);
        $db->update('v_contact_profile', $data, ['rep_code' => $rep_code]);
        return ($db->affected_rows()>=1)?true:false;
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
        $db = $this->load->database($this->dbase['buyer'],TRUE);
        return ($db->update('v_contact_profile', $data, array('rep_code' => $id)))? true:false;
    }

//===================================================================
    public function get_majorproduct_code($value){
        $q = "SELECT * FROM v_reference WHERE 1 AND switch='GP' AND sector LIKE ? AND c_profile =? AND fair_code LIKE ?";
        $result = $this->masterDB->query($q,['%'.$this->appConfig['sector_code'].'%',$value,'%'.$this->appConfig['current_fair_code'].'%']);
        return $result->first_row('array');
    }


//===================================================================
//=====                    TRADE BUYER                           ====
//=====                                                          ====
//===================================================================

    public function prep_v_contact_profile_data($data){
        $getContinent = function($x){return ($this->masterDB->get_where('v_reference',array('c_profile'=>$x,'switch'=>'R1'))->num_rows()==1) ? $this->masterDB->get_where('v_reference',array('c_profile'=>$x,'switch'=>'R1'))->row()->c_code : '';};
        $datetime = new DateTime('NOW');
        $date_created = $datetime->format('Y-m-d H:i:s');  
        //remove unknown fields
        $prep_data = remove_unallowed_fields(cleanAssocArr($data),$this->allowedData['v_contact_profile']);
        if(isset($prep_data['country'])){
            if(isset($prep_data['continent'])){
                $continent = $prep_data['continent'];
            }else{
                $continent = $getContinent($prep_data['country'])??'';
            }
        }
        $additional_data=array(
            'date_apply' => $prep_data['date_apply']?? $date_created,
            'continent' => $continent??'',
            // 'deleted'=>0,
        );
        return array_merge($prep_data,$additional_data);
    }
//===================================================================
    // public function prep_v_attendance_data($data){
    //     $datetime = new DateTime('NOW');
    //     $date_created = $datetime->format('Y-m-d H:i:s');  
    //     //remove unknown fields
    //     $prep_data = remove_unallowed_fields($data,$this->allowedData['v_attendance']);
    //     $additional_data=array(
    //         'date_apply'=>($prep_data['date_apply']?? $date_created),
    //         // 'deleted'=>0,
    //     );
    //     return array_merge($prep_data,$additional_data);
    //     print_r($prep_data);
    //     exit();
    // }
//===================================================================

    public function add_v_contact_profile($data,$rep_code=null){
        if($rep_code==null){
            $this->buyerDB->insert('v_contact_profile',$data);
            return $insert_id = $this->buyerDB->insert_id();
        }else{
            //update data to contact_profile
            return $this->buyerDB->update('v_contact_profile', $data, ['rep_code' => $rep_code])? true:false;
        }
    }
//===================================================================

    public function add_v_attendance($data,$rep_code){
        $data = remove_unallowed_fields($data,$this->allowedData['v_attendance']);
        $datetime = new DateTime('NOW');
        $date_created = $datetime->format('Y-m-d H:i:s');
        $AttendanceData=array();
        $genericData=array(
            'rep_code'=>$rep_code,
            'barcode'=>barcode($rep_code),
            'fair_code'=> $data['fair_code']?? $this->appConfig['sector_fair_code'],
            'sector'=> $data['sector'] ?? $this->appConfig['sector_code'],
            'reg_status' =>'T',
            'date_apply' => $data['date_apply'] ?? $date_created,
            'visitor_type' => 'GUEST',
            'visitor_status' => $data['visitor_status'] ?? 'NEW',
            'app_system' => $this->appConfig['system1'],
            'validation_status' => '',
            'subscription'=> $data['subscription']??'',
        );
        $genericData = array_merge($genericData,$data);
        array_push($AttendanceData,$genericData);
        $eventData=array(
                'rep_code'=> $rep_code,
                'barcode'=> barcode($rep_code),
                'fair_code' => $data['fair_code'] ?? $this->appConfig['current_fair_code'],
                'sector' => $data['sector'] ?? $this->appConfig['sector_code'],
                'date_apply' => $data['date_apply'] ?? $date_created,
                'reg_status' => 'F',
                'visitor_type' => 'GUEST',
                'visitor_status' => $data['visitor_status'] ?? 'NEW',
                'app_system' => $this->appConfig['system'],
                'validation_status' => 'INCOMPLETE TRADE',
                'subscription' => $data['subscription']??'',
        );
        $eventData = array_merge($eventData,$data);
        array_push($AttendanceData,$eventData);
        // print_r($AttendanceData);exit();
        return ($this->buyerDB->insert_batch('v_attendance', $AttendanceData))? true:false;
    }

//===================================================================
    //REFERENCE ID
    public function add_buyer_reference_id($data,$rep_code){
            $prepData = array(
            'rep_code' => $rep_code,
            'ref_id' => $data['reference_id'],
            // 'remarks' => ,
            'fair_code'=> $this->appConfig['current_fair_code'],
            'sector'=> $this->appConfig['sector_code'],
        );

        //check if reference id record exist
        if(!$this->buyerDB->get_where('v_dtcp_id',array('rep_code'=>$rep_code,'fair_code'=>$prepData['fair_code'],))->num_rows()>=1){
            return ($this->buyerDB->insert('v_dtcp_id',$prepData))? true:false;
        }else{
            //update new TRADE EXPERIENCE data
            return ($this->buyerDB->update('v_dtcp_id', $prepData, array('rep_code' => $rep_code)))? true:false;
        } 
    }



//===================================================================

    public function get_buyer_contact_by_email($email){
        $q = "SELECT rep_code,fameplus_id,email,add_value,cont_per_fn,cont_per_ln,country,continent,co_name,title,webpage,add_st,mobile
        FROM v_contact_profile
        WHERE TRUE
        AND email=?";
        $result = $this->buyerDB->query($q,[$email]);
        return $result->first_row('array');
    }

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
        $result = $this->buyerDB->query($q,[$this->appConfig['system'],$email]);
        return $result->first_row('array');
    }

//===================================================================

    public function get_buyer_by_email($email=null){
        // ini_set("memory_limit","4096M");
        $q = "SELECT
        rep_code,fameplus_id,email,add_value,cont_per_fn,cont_per_ln,country,continent,
                    co_name,title,webpage,add_st,mobile,supplier_info,b.validated,b.visitor_type
        FROM v_contact_profile a INNER JOIN v_attendance b USING(rep_code)
        WHERE TRUE
        AND deleted=0
        AND b.app_system=?
        AND email=?";
        $result = $this->buyerDB->query($q,[$this->appConfig['system'],$email]);
        return $result->first_row('array');
    }
//===================================================================

//check faircode if exist
    public function check_v_faircode($email,$fair_code){
        $q="SELECT * FROM v_contact_profile a INNER JOIN v_attendance b USING(ff_code) WHERE b.fair_code=? AND email=?";
        $result=$this->buyerDB->query($q,[$fair_code,$email]);
        return $result->num_rows()>0;
    }


//===================================================================

    public function update_v_attendance($data,$rep_code){

        $checkParticipation = function($buyer_id,$fair_code){
            return ($this->buyerDB->get_where('v_attendance',array('rep_code'=>$buyer_id,'fair_code'=>$fair_code))->num_rows()==1) ? true : false;};
        $getSectorParticipation = function($buyer_id,$fair_code){
            return ($this->buyerDB->get_where('v_attendance',array('rep_code'=>$buyer_id,'fair_code'=>$fair_code))->num_rows()>0) ? $this->buyerDB->get_where('v_attendance',array('rep_code'=>$buyer_id,'fair_code'=>$fair_code))->first_row('array') : '';};
        $datetime = new DateTime('NOW');
        $date_created = $datetime->format('Y-m-d H:i:s');  
        $data = remove_unallowed_fields($data,$this->allowedData['v_attendance']);
        $AttendanceData=array();
        if(!$checkParticipation($rep_code,$this->appConfig['sector_fair_code'])){
            //no generic record --for sure no current participation too
            $genericData = array(
                'rep_code'=> $rep_code,
                'barcode'=> $data['barcode'] ?? barcode($rep_code),
                'fair_code'=> $data['fair_code']?? $this->appConfig['sector_fair_code'],
                'sector'=> $data['sector'] ?? $this->appConfig['sector_code'],
                'reg_status' =>'T',
                'date_apply' => $data['date_apply'] ?? $date_created,
                'visitor_type' => 'GUEST',
                'visitor_status' => $data['visitor_status']??'',
                'app_system' => $this->appConfig['system1'],
                'validation_status' =>$data['validation_status']??'',
                'subscription'=> $data['subscription']??'',
            );
            array_push($AttendanceData,$genericData);
            $eventData=array(
                'rep_code'=> $rep_code,
                'barcode'=> $data['barcode'] ?? barcode($rep_code),
                'fair_code' => $data['fair_code'] ?? $this->appConfig['current_fair_code'],
                'sector' => $data['sector'] ?? $this->appConfig['sector_code'],
                'reg_status' => 'F',
                'date_apply' => $data['date_apply'] ?? $date_created,
                'visitor_type' => 'GUEST',
                'visitor_status' => 'NEW',
                'app_system' => $this->appConfig['system'],
                'validation_status' => 'INCOMPLETE TRADE',
                'subscription' => $data['subscription']??'',
            );
            array_push($AttendanceData,$eventData);
            return ($this->buyerDB->insert_batch('v_attendance', $AttendanceData))? true:false;
        }
        if(!$checkParticipation($rep_code,$this->appConfig['current_fair_code'])){
            //no current participation record
            $sectorParticipationData = $getSectorParticipation($rep_code,$this->appConfig['sector_fair_code']);

            if(isset($data['visitor_status']) && $data['visitor_status']!=''){
                //based on payload
                $visitor_stat = $data['visitor_status'];
            }else{
                //automate
                // $visitor_stat = ($sectorParticipationData['visitor_status']=='REGULAR')?'REGULAR':'NEW';
                $visitor_stat='';
            }
            //add a current participation
            $eventData=array(
                'rep_code'=> $rep_code,
                'barcode'=> $data['barcode'] ?? barcode($rep_code),
                'fair_code' => $data['fair_code'] ?? $this->appConfig['current_fair_code'],
                'sector' => $data['sector'] ?? $this->appConfig['sector_code'],
                'date_apply' => $data['date_apply'] ?? $date_created,
                'reg_status' => 'F',
                'visitor_type' => 'GUEST',
                'visitor_status' => ($visitor_stat!='')?$visitor_stat:'',
                'app_system' => $this->appConfig['system'],
                'validation_status' => 'INCOMPLETE TRADE',
                'subscription' => $data['subscription']??'',
            );
            $currentData = array_merge($eventData,$data);
            // print_r(cleanAssocArr($currentData));exit();
            $this->buyerDB->insert('v_attendance',cleanAssocArr($currentData));
            $insert_id = $this->buyerDB->insert_id();
            if(!$insert_id){
                //error adding of current participation
                return false;
            }
        }
        else{

            //update current participation record
            $sectorParticipationData = $getSectorParticipation($rep_code,$this->appConfig['sector_fair_code']);
            if(isset($data['visitor_status']) && $data['visitor_status']!=''){
                //based on payload
                $visitor_stat = $data['visitor_status'];
            }else{
                //automate
                // $visitor_stat = ($sectorParticipationData['visitor_status']=='REGULAR')?'REGULAR':'NEW';
                $visitor_stat='';
            }
            $eventData=array(
                'rep_code'=> $rep_code,
                'barcode'=> $data['barcode'] ?? barcode($rep_code),
                'fair_code' => $data['fair_code'] ?? $this->appConfig['current_fair_code'],
                'sector' => $data['sector'] ?? $this->appConfig['sector_code'],
                'date_apply' => $data['date_apply'] ?? $date_created,
                'reg_status' => $data['reg_status'] ?? '',
                'visitor_type' => $data['visitor_type'] ?? '',
                'visitor_status' => ($visitor_stat!='')?$visitor_stat:'',
                'app_system' => $this->appConfig['system'],
                'validation_status' => 'INCOMPLETE TRADE',
                'subscription' => $data['subscription']??'',
            );
            $currentData = array_merge($data,$eventData);
            // $this->buyerDB->insert('v_attendance',cleanAssocArr($currentData));
            return $this->buyerDB->update('v_attendance', cleanAssocArr($currentData), ['rep_code' => $rep_code, 'fair_code'=>$this->appConfig['current_fair_code']])? true:false;
        }    
    }

//===================================================================
    public function add_buyer_participation($data){
        $checkParticipation = function($buyer_id,$fair_code){
            return ($this->buyerDB->get_where('v_attendance',array('rep_code'=>$buyer_id,'fair_code'=>$fair_code))->num_rows()==1) ? true : false;};
        $buyer_db = $this->load->database($this->dbase['buyer'],TRUE);
        $buyer_db->insert('v_attendance',$data);
        return $insert_id = $buyer_db->insert_id();
    }

//===================================================================

    public function get_ctm_buyer_by($identity,$email=null){
        // ini_set("memory_limit","4096M");
        $q = "SELECT
        *
        FROM v_contact_profile
        WHERE TRUE
        AND deleted=0 ";
        $q = ($identity=='email')? $q."AND email=?" : $q."AND id=?";
        $result = $this->buyerDB->query($q,[$email]);
        return $result->first_row('array');
    }


//===================================================================
//======================= CHILD TABLES ==============================
//===================================================================

    //MULTI VALUED
    public function update_buyer_products($data,$rep_code){
        //prepare data for batch insert
        $fair_code = (isset($data['fair_code'])? $data['fair_code']:$this->appConfig['current_fair_code']);
        $dataArray = explodeToArr('|',$data);
        $data = array();
        foreach($dataArray as $row){
            $product_detail = $this->get_product_code($row);  
            $data[]=array(
                'rep_code'=>$rep_code,
                'barcode'=>barcode($rep_code),
                'prod_cat'=>$product_detail['prod_cat']??'',
                'prod_code'=>$product_detail['prod_code']??'',
                'remarks_major'=>$product_detail['c_profile']??'',
                'remarks_minor'=>$row,
                'fair_code'=>$this->appConfig['sector_fair_code'],
                'sector'=>$this->appConfig['sector_code'],
                );
            $data[]=array(
                'rep_code'=>$rep_code,
                'barcode'=>barcode($rep_code),
                'prod_cat'=>$product_detail['prod_cat']??'',
                'prod_code'=>$product_detail['prod_code']??'',
                'remarks_major'=>$product_detail['c_profile']??'',
                'remarks_minor'=>$row,
                'fair_code'=>$this->appConfig['current_fair_code'],
                'sector'=>$this->appConfig['sector_code'],
                );
        }
        // print_r($data);exit();
        $db = $this->load->database($this->dbase['buyer'],TRUE);
        //delete existing data of the user in reference to the fair_code
        $db->delete('v_genproducts', array('rep_code' => $rep_code,'fair_code'=>$this->appConfig['sector_fair_code']));
        $db->delete('v_genproducts', array('rep_code' => $rep_code,'fair_code'=>$this->appConfig['current_fair_code']));
        //insert a new product data
        if($db->insert_batch('v_genproducts', $data)){
            return true;
        }
        else{
            return false;
        }
    }


//===================================================================
    //MULTI VALUED  //good
    public function update_buyer_major_product($data,$rep_code){
        //prepare data for batch insert
        $fair_code = (isset($data['fair_code'])? $data['fair_code']:$this->appConfig['current_fair_code']);
        $dataArray = explodeToArr('|',$data);
        $prepdata = array();
        foreach($dataArray as $row){
            $product_detail = $this->apiv1_model->get_majorproduct_code($row,$this->appConfig['productfaircode']);  
            $prepData[]=array(
                'rep_code'=>$rep_code,
                'prod_cat'=>$product_detail['c_code']??'cat-'.round(microtime(true) * 1000),
                // 'prod_code'=>$product_detail['prod_code']??'',
                'remarks_major'=>$product_detail['c_profile']??$row,
                // 'remarks_minor'=>$row,
                'fair_code'=>$this->appConfig['sector_fair_code'],
                'sector'=>$this->appConfig['sector_code'],
                );
            $prepData[]=array(
                'rep_code'=>$rep_code,
                'prod_cat'=>$product_detail['c_code']??'cat-'.round(microtime(true) * 1000),
                // 'prod_code'=>$product_detail['prod_code']??'',
                'remarks_major'=>$product_detail['c_profile']??$row,
                // 'remarks_minor'=>$row,
                'fair_code'=>$this->appConfig['current_fair_code'],
                'sector'=>$this->appConfig['sector_code'],
                );
        }
        //delete existing data of the user in reference to the fair_code
        $this->buyerDB->delete('v_genproducts', array('rep_code' => $rep_code,'fair_code'=>$this->appConfig['sector_fair_code']));
        $this->buyerDB->delete('v_genproducts', array('rep_code' => $rep_code,'fair_code'=>$this->appConfig['current_fair_code']));
        //insert products data
        return ($this->buyerDB->insert_batch('v_genproducts', $prepData))? true:false;
    }

//===================================================================
    //SINGLE VALUED
    public function update_buyer_natureofbusiness($data,$rep_code,$fair_code=null){
        $sector=$this->appConfig['sector_code'];
        $nature = explodeToArr('|',$data);
        $switch=$this->refSwitch['natureofbusiness'];
        // print_r($nature);exit();
        $data = array();
        foreach($nature as $row){
            if($fair_code==null){
                $item_code = $this->get_item_codev3($row,$switch,$sector,$fair_code=null);
            }else{
                $item_code = $this->get_item_code($row);
            }
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
        $db = $this->load->database($this->dbase['buyer'],TRUE);
        //delete existing data of the user in reference to the fair_code
        $db->delete('v_representation', array('rep_code' => $rep_code,'fair_code'=>$this->appConfig['sector_fair_code']));
        $db->delete('v_representation', array('rep_code' => $rep_code,'fair_code'=>$this->appConfig['current_fair_code']));
        //insert new nature of business data
        if($db->insert_batch('v_representation', $data)){
            return true;
        }
        else{
            return false;
        }  
    }

//===================================================================

    //MULTI VALUED  //ISSUE ON THE SEPARATOR
    public function update_buyer_annual_sales($data,$rep_code,$fair_code){
        $sector=$this->appConfig['sector_code'];
        $annualsales = explodeToArr('|',$data);

        $data = array();
        foreach($annualsales as $annualsale){
            if($fair_code==null){
                $item_code = $this->get_item_codev3($annualsale,$switch,$sector,$fair_code=null);
            }else{
                $item_code = $this->get_item_code($annualsale);
            }
            $data[]=array(
                'rep_code'=>$rep_code,
                'barcode'=>barcode($rep_code),
                'item_code'=>$item_code,
                'remarks'=>$annualsale,
                'fair_code'=>$this->appConfig['sector_fair_code'],
                'sector'=>$this->appConfig['sector_code'],
                );
            $data[]=array(
                'rep_code'=>$rep_code,
                'barcode'=>barcode($rep_code),
                'item_code'=>$item_code,
                'remarks'=>$annualsale,
                'fair_code'=>$this->appConfig['current_fair_code'],
                'sector'=>$this->appConfig['sector_code'],
                );
        }
        $db = $this->load->database($this->dbase['buyer'],TRUE);
        //delete existing data of the user in reference to the fair_code
        $db->delete('v_mn_annualsales', array('rep_code' => $rep_code,'fair_code'=>$this->appConfig['sector_fair_code']));
        $db->delete('v_mn_annualsales', array('rep_code' => $rep_code,'fair_code'=>$this->appConfig['current_fair_code']));
        //insert new informthru data
        if($db->insert_batch('v_mn_annualsales', $data)){
            return true;
        }
        else{
            return false;
        }
    }



//===================================================================

    //SINGLE VALUED       //good
    public function update_buyer_job_function($description,$rep_code,$fair_code){

        $sector=$this->appConfig['sector_code'];
        // $annualsales = explodeToArr('|',$data);
        $data = array();
        if($fair_code==null){
            $item_code = $this->get_item_codev3($description,$switch,$sector,$fair_code=null);
        }else{
            $item_code = $this->get_item_code($description);
        }
        $data[]=array(
            'rep_code'=>$rep_code,
            'barcode'=>barcode($rep_code),
            'item_code'=>$item_code,
            'remarks'=>$description,
            'fair_code'=>$this->appConfig['sector_fair_code'],
            'sector'=>$this->appConfig['sector_code'],
            );
        $data[]=array(
            'rep_code'=>$rep_code,
            'barcode'=>barcode($rep_code),
            'item_code'=>$item_code,
            'remarks'=>$description,
            'fair_code'=>$this->appConfig['current_fair_code'],
            'sector'=>$this->appConfig['sector_code'],
            );    
        $db = $this->load->database($this->dbase['buyer'],TRUE);
        //delete existing data of the user in reference to the fair_code
        $db->delete('v_job_function', array('rep_code' => $rep_code,'fair_code'=>$this->appConfig['sector_fair_code']));
        $db->delete('v_job_function', array('rep_code' => $rep_code,'fair_code'=>$this->appConfig['current_fair_code']));
        //insert new informthru data
        if($db->insert_batch('v_job_function', $data)){
            return true;
        }
        else{
            return false;
        }    
    }

//===================================================================

    //SINGLE VALUED       //good
    public function update_buyer_arrangement($description,$rep_code,$fair_code){
        $arrangement = 'Interpreter';
        $sector=$this->appConfig['sector_code'];
        // $annualsales = explodeToArr('|',$data);
        $data = array();
        if($fair_code==null){
            $item_code = $this->get_item_codev3($description,$switch,$sector,$fair_code=null);
        }else{
            $item_code = $this->get_item_code($description);
        }
        $data[]=array(
            'rep_code'=>$rep_code,
            'barcode'=>barcode($rep_code),
            'item_code'=>$description,
            'remarks'=>$arrangement,
            'fair_code'=>$this->appConfig['sector_fair_code'],
            'sector'=>$this->appConfig['sector_code'],
            );
        $data[]=array(
            'rep_code'=>$rep_code,
            'barcode'=>barcode($rep_code),
            'item_code'=>$description,
            'remarks'=>$arrangement,
            'fair_code'=>$this->appConfig['current_fair_code'],
            'sector'=>$this->appConfig['sector_code'],
            );    
        $db = $this->load->database($this->dbase['buyer'],TRUE);
        //delete existing data of the user in reference to the fair_code
        $db->delete('v_existing_arrangement', array('rep_code' => $rep_code,'fair_code'=>$this->appConfig['sector_fair_code']));
        $db->delete('v_existing_arrangement', array('rep_code' => $rep_code,'fair_code'=>$this->appConfig['current_fair_code']));
        //insert new informthru data
        if($db->insert_batch('v_existing_arrangement', $data)){
            return true;
        }
        else{
            return false;
        }    
    }


//=====================================================================

    public function validate_buyer($validation,$buyer_id,$fair_code){
        $validation = strtolower($validation);
        $fair_code= $this->appConfig['current_fair_code'];
        $sector_fair_code= $this->appConfig['sector_fair_code'];
        $sector=$this->appConfig['sector_code'];
        $get_field_data = function($buyer_id,$generic_fair_code,$field){
            $buyer_db = $this->load->database($this->dbase['buyer'],TRUE);
            return $buyer_db->get_where('v_attendance',array('rep_code'=>$buyer_id,'fair_code'=>$generic_fair_code))->row($field);
        };
        $datetime = new DateTime('NOW');
        $currentDate = $datetime->format('Y-m-d H:i:s');
        //to get the validation numeric word equivalent
        $get_validation_status = function($x,$y){
            $x = strtolower($x);
            if(array_key_exists($x,$y)){
                    return $y[$x];
                };
        };
        $validation_stat_value=array(
            'pending'=>'PENDING TRADE',
            'approved'=>'APPROVED TRADE',
            'incomplete'=>'INCOMPLETE TRADE',
            'disapproved'=>'DISAPPROVED TRADE',
        );
        if($validation=='pending'){
            if($get_field_data($buyer_id,$this->appConfig['current_fair_code'],'validation_status')=='PENDING TRADE'){
                //do nothing
                return true;
            }
            $allowed_data['visitor_type'] = ($validation==1)? 'TRADE BUYER':'GUEST';
            $additional_data = array('fair_code'=>$this->appConfig['current_fair_code'],'visitor_type'=>$allowed_data['visitor_type'],);
            $prep_data = (count($additional_data)>0 ? array_merge($allowed_data,$additional_data) : $allowed_data);
            //update as trade buyer for the generic sector faircode in attendance
            $previous_generic_visitor_type = $get_field_data($buyer_id,$this->appConfig['sector_fair_code'],'previous_visitor_type');
            $visitor_type = ($previous_generic_visitor_type)? $previous_generic_visitor_type : 'VISITOR';
            $generic_data_update=['fair_code'=>$this->appConfig['sector_fair_code'],'visitor_type'=>$visitor_type,'previous_visitor_type'=>null];
            $generic_participation_update = $this->update_buyer_fair_participation($generic_data_update,$buyer_id);
            //update current trade fair
            $prep_data['validation_status'] = $get_validation_status($validation,$validation_stat_value);
            $prep_data['date_validated'] = $currentDate;
            $updated = $this->buyerv1_model->update_buyer_fair_participation($prep_data,$buyer_id);
            return ($updated)? true: false;         
        }
        if($validation=='approved' OR $validation=='incomplete' OR $validation=='disapproved'){
            $allowed_data['visitor_type'] = ($validation=='approved')? 'TRADE BUYER':'GUEST';
            if($validation=='approved'){
                $additional_data = array('fair_code'=>$fair_code,'date_validated'=>$currentDate,'visitor_type'=>$allowed_data['visitor_type'],);
            }else{
                $additional_data = array('fair_code'=>$fair_code,);
            }
            $additional_data['date_validated'] = $currentDate;
            $prep_data = (count($additional_data)>0 ? array_merge($allowed_data,$additional_data) : $allowed_data);
            //update as trade buyer for the generic sector faircode in attendance
            if($validation=='approved'){
                $current_generic_visitor_type = $get_field_data($buyer_id,$sector_fair_code,'visitor_type');
                $generic_data_update=['fair_code'=>$sector_fair_code,'visitor_type'=>$allowed_data['visitor_type'],'previous_visitor_type'=>$current_generic_visitor_type,];
            }else{
                $generic_data_update=['fair_code'=>$sector_fair_code,'visitor_type'=>$allowed_data['visitor_type'],];             
            }          
            $generic_participation_update = $this->update_buyer_fair_participation($generic_data_update,$buyer_id);
            //update current trade fair
            $prep_data['validation_status'] = $get_validation_status($validation,$validation_stat_value);
            $updated = $this->buyerv1_model->update_buyer_fair_participation($prep_data,$buyer_id);
            return ($updated)? true: false;
        }

    }

//===================================================================
    public function update_buyer_fair_participation($data,$id){
        // print_r($data);exit();
        $db = $this->load->database($this->dbase['buyer'],TRUE);
        $db->update('v_attendance', $data, array('rep_code' => $id,'fair_code'=>$data['fair_code']));
        if($this->db->affected_rows()>=0){
            return true;
        }else{
            return false;
        }
    }

//===================================================================


//===================================================================
//=====                    SUBCRIPTION                           ====
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
            $this->buyerDB->insert('v_contact_profile',$cleaned_data);
            return $insert_id = $this->buyerDB->insert_id();
        }else{
            //update data to contact_profile
            return $this->buyerDB->update('v_contact_profile', $cleaned_data, ['rep_code' => $rep_code])? true:false;
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
        return ($this->buyerDB->insert_batch('v_attendance', $AttendanceData))? true:false;
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
        $this->buyerDB->delete('v_genproducts', array('rep_code' => $rep_code,'fair_code'=>$this->appConfig['sector_fair_code']));
        $this->buyerDB->delete('v_genproducts', array('rep_code' => $rep_code,'fair_code'=>$this->appConfig['current_fair_code']));
        //insert new informthru data
        if($this->buyerDB->insert_batch('v_genproducts', $data)){
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
        $this->buyerDB->delete('v_representation', array('rep_code' => $rep_code,'fair_code'=>$this->appConfig['sector_fair_code']));
        $this->buyerDB->delete('v_representation', array('rep_code' => $rep_code,'fair_code'=>$this->appConfig['current_fair_code']));
        //insert new informthru data
        if($this->buyerDB->insert_batch('v_representation', $data)){
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
            return ($this->buyerDB->get_where('v_attendance',array('rep_code'=>$buyer_id,'fair_code'=>$fair_code))->num_rows()==1) ? true : false;
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
            return ($this->buyerDB->get_where('v_attendance',array('rep_code'=>$buyer_id,'fair_code'=>$fair_code))->num_rows()==1) ? true : false;
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
            $updated = $this->buyerv1_model->update_buyer_fair_participation($prep_data,$rep_code);
            if(!$updated){
                return false;
            }else{
                return true;
            }

        }
    }





//===============================================

    public function getContact($mysql){
        // ini_set("memory_limit","4096M");
        // echo $this->appConfig['system'];exit();
        $result = $this->buyerDB->query($mysql,[$this->appConfig['system']]);
        return $result->result_array();
    }


//===================================================================
    public function getContactv2($mysql){
        // ini_set("memory_limit","4096M");
        $db     = $this->load->database($this->dbase['buyer'],TRUE);
        $result = $db->query($mysql,[$this->appConfig['system']]);
        return $result->result_array();
    }


//===================================================================

    public function total_contact_record_count($sql){
        // ini_set("memory_limit","4096M");
        $result = $this->buyerDB->query($sql,[$this->appConfig['system']]);
        // return $result->num_rows();
        return $result->row_array();
    }
//===================================================================

    public function getJobfunction(){
        // ini_set("memory_limit","4096M");
        $q = "SELECT rep_code,GROUP_CONCAT(DISTINCT remarks SEPARATOR '|')as jobfunction FROM v_job_function
        WHERE 1
        AND fair_code=?
        GROUP BY rep_code";
        $result = $this->buyerDB->query($q,[$this->appConfig['current_fair_code']]);
        return $result->result_array();
    }

//===================================================================

    public function getAnnualsales(){
        // ini_set("memory_limit","4096M");
        $q = "SELECT rep_code,GROUP_CONCAT(DISTINCT remarks SEPARATOR '|')as annualsales FROM v_mn_annualsales
        WHERE 1
        AND fair_code=?
        GROUP BY rep_code";
        $result = $this->buyerDB->query($q,[$this->appConfig['current_fair_code']]);
        return $result->result_array();
    }

//===================================================================

    public function getMajorProduct(){
        // ini_set("memory_limit","4096M");
        $q = "SELECT rep_code,GROUP_CONCAT(DISTINCT remarks_major SEPARATOR '|')as majorproduct FROM v_genproducts
        WHERE 1
        AND fair_code=?
        GROUP BY rep_code";
        $result = $this->buyerDB->query($q,[$this->appConfig['current_fair_code']]);
        return $result->result_array();
    }

//===================================================================

    public function getMinorProduct(){
        // ini_set("memory_limit","4096M");
        $q = "SELECT rep_code,GROUP_CONCAT(DISTINCT remarks_minor SEPARATOR '|')as minorproduct FROM v_genproducts
        WHERE 1
        AND fair_code=?
        GROUP BY rep_code";
        $result = $this->buyerDB->query($q,[$this->appConfig['current_fair_code']]);
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
        $result = $this->buyerDB->query($q,[$this->appConfig['current_fair_code']]);
        return $result->result_array();
    }
    
//===================================================================
    public function getMarketSegment(){
        // ini_set("memory_limit","4096M");
        $q = "SELECT rep_code,GROUP_CONCAT(remarks SEPARATOR '|')as marketSegment FROM v_mn_marketsegment
        WHERE 1
        AND fair_code=?
        GROUP BY rep_code";
        $result = $this->buyerDB->query($q,[$this->appConfig['current_fair_code']]);
        return $result->result_array();
    }

//===================================================================
    public function getInformthru(){
        // ini_set("memory_limit","4096M");
        $q = "SELECT rep_code,GROUP_CONCAT(remarks SEPARATOR '|')as informthru FROM v_informthru
        WHERE 1
        AND fair_code=?
        GROUP BY rep_code";
        $result = $this->buyerDB->query($q,[$this->appConfig['current_fair_code']]);
        return $result->result_array();
    }

//===================================================================
    public function getProductInterest(){
        // ini_set("memory_limit","4096M");
        $q = "SELECT rep_code,GROUP_CONCAT(remarks SEPARATOR '|')as product_interest FROM v_product_technique
        WHERE 1
        AND fair_code=?
        GROUP BY rep_code";
        $result = $this->buyerDB->query($q,[$this->appConfig['current_fair_code']]);
        return $result->result_array();

    }
//===================================================================
    public function getReason(){
        // ini_set("memory_limit","4096M");
        $q = "SELECT rep_code,GROUP_CONCAT(remarks SEPARATOR '|')as reason FROM v_showreason
        WHERE 1
        AND fair_code=?
        GROUP BY rep_code";
        $result = $this->buyerDB->query($q,[$this->appConfig['current_fair_code']]);
        return $result->result_array();
    }

//===================================================================
    public function getRepresentation(){
        // ini_set("memory_limit","4096M");
        $q = "SELECT rep_code,GROUP_CONCAT(remarks SEPARATOR '|')as representation FROM v_representation
        WHERE 1
        AND fair_code=?
        GROUP BY rep_code";
        $result = $this->buyerDB->query($q,[$this->appConfig['current_fair_code']]);
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


}

/* End of file v1_model.php */
/* Location: ./application/models/v1_model.php */