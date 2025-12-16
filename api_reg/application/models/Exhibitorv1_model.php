<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exhibitorv1_model extends CI_model{

	protected $_table='e_contact_profile';
	protected $_primary_key='ff_code';

	public $errors;
	public $messages;

	public function __construct(){
		parent::__construct();

        $this->load->model('apiv1_model');

        $this->dbase       = $this->config->item('dbase', 'my_rest');
        $this->refSwitch   = $this->config->item('switch', 'my_rest');        
        $this->appConfig   = $this->apiv1_model->_load_appConfig();
        $this->buyerDB     = $this->load->database($this->dbase['buyer'],TRUE);
        $this->exhibitorDB = $this->load->database($this->dbase['exhibitor'],TRUE);
        $this->masterDB    = $this->load->database($this->dbase['master'],TRUE);
        $this->configDB    = $this->load->database($this->dbase['config'],TRUE);
        
	}

//===================================================================
//run sql query
    public function runQuery($mysql){
        // echo $mysql;exit();
        // ini_set("memory_limit","4096M");
        // $result = $this->exhibitorDB->query($mysql,[$this->appConfig['system'],$this->appConfig['sector_code']]);
        $result = $this->exhibitorDB->query($mysql);
        return $result->result_array();
    }
//===================================================================
//run sql query count
    public function queryCount($sql){
        // ini_set("memory_limit","4096M");
        $result = $this->exhibitorDB->query($sql);
        // return $result->num_rows();
        return $result->row_array();
    }

//===================================================================
//check faircode if exist
    public function check_faircode($email,$fair_code){
        $q="SELECT * FROM e_contact_profile a INNER JOIN e_attendance b USING(ff_code) WHERE b.fair_code=? AND co_email=?";
        $result=$this->exhibitorDB->query($q,[$fair_code,$email]);
        return $result->num_rows()>0;
    }
//===================================================================

//===================================================================
//add exhibitor to contact
    public function add_exh_contact_profile($data,$ff_code=null){
        if($ff_code==null){
            $this->exhibitorDB->insert('e_contact_profile',$data);
            return $insert_id = $this->exhibitorDB->insert_id();
        }else{
            //update data to contact_profile
            return $this->exhibitorDB->update('e_contact_profile', $data, ['ff_code' => $ff_code])? true:false;
        }
    }
//===================================================================


//===================================================================
//add exhibitor to attendance
    public function add_exh_attendance($data,$ff_code=null){
        if($ff_code==null){
            //add data to attendance
            $this->exhibitorDB->insert('e_attendance',$data);
            return ($this->exhibitorDB->affected_rows()>=0) ? true:false;
        }else{
            //update data to attendance
            return $this->exhibitorDB->update('e_attendance', $data, ['ff_code' => $ff_code,'fair_code'=>$data['fair_code']])? true:false;
        }       
    }
//===================================================================

//===================================================================
    //REFERENCE ID
    public function add_exh_reference_id($data,$ff_code){
            $prepData = array(
            'ff_code' => $ff_code,
            'ref_id' => $data['reference_id'],
            // 'remarks' => ,
            'fair_code'=> $this->appConfig['sector_fair_code'],
            'sector'=> $this->appConfig['sector_code'],
        );

        //check if reference id record exist
        if(!$this->exhibitorDB->get_where('e_dtcp_id',array('ff_code'=>$ff_code,'fair_code'=>$prepData['fair_code'],))->num_rows()>=1){
            return ($this->exhibitorDB->insert('e_dtcp_id',$prepData))? true:false;
        }else{
            //update new TRADE EXPERIENCE data
            return ($this->exhibitorDB->update('e_dtcp_id', $prepData, array('ff_code' => $ff_code)))? true:false;
        } 
    }
//===================================================================



//===================================================================

	public function prep_e_contact_profile_data($data){
        $datetime = new DateTime('NOW');
        $date_created = $datetime->format('Y-m-d H:i:s');  
        $continentData = $this->_determineContinent($data);
        $additional_data=array(
            'date_apply' => $data['date_apply'] ?? $date_created,
            'continent'=> $continentData,
            'sector' => $data['sector'] ?? $this->appConfig['sector_code'],
        );
        $mergeData = array_merge($data,$additional_data);
        $cleanedData = remove_unallowed_fields($mergeData,$this->allowedData['e_contact_profile']);
        // diagnostics($cleanedData);exit();
        return $cleanedData;
	}

//===================================================================

    public function prep_e_attendance_data($data){
        // $getContinent = function($x,$db){return ($db->get_where('v_reference',array('c_profile'=>$x,'switch'=>'R1'))->num_rows()==1) ? $db->get_where('v_reference',array('c_profile'=>$x,'switch'=>'R1'))->row()->c_code : '';};
        $getSystemFromKey = function($x){return ($this->configDB->get_where('api_keys',array('key'=>$x))->num_rows()==1) ? $this->configDB->get_where('api_keys',array('key'=>$x))->row()->app_system : '';};
        //Removed unknown fields
        $datetime = new DateTime('NOW');
        $date_created = $datetime->format('Y-m-d H:i:s');    
        $additional_data=array(
            // 'refno'=>'','ff_code'=>'','co_name'=>'',
            // 'brand_name'=>'',
            // 'portfolio'=>'',
            // 'membership_assoc'=>'',
            // 'application_no'=>'',
            'date_apply'=>(isset($data['date_apply'])? $data['date_apply']:$date_created),
            // 'proj'=>'',
            'fair_code'=>(isset($data['fair_code'])? $data['fair_code']:$this->appConfig['current_fair_code']),
            // 'fair_class'=>'','acti'=>'','fair_type'=>'','fair_stat'=>'','fair_part'=>'','fair_date'=>'',
            // 'fair_stat_app'=>'',
            // 'fair_stat_app_date'=>'',
            // 'fair_stat_part'=>'Incomplete',
            // 'foreignlocal'=>'',
            // 'foreignlocalremarks'=>'','coordinator'=>'','manager'=>'',
            // 'participation_type'=>'',
            // 'company_type'=>'','backup'=>'','finished'=>'',
            'sector_code'=>(isset($data['sector_code'])? $data['sector_code']:$this->appConfig['sector_code']),
            // 'username'=>'','userdesc'=>'','datetimestamp'=>'','filename'=>'','emailStatus'=>'','emailApprovedStat'=>'','product_dev'=>'','includeInBoothDIrectory'=>'','product_dev_consultant'=>'',
            // 'exhibit_participation'=>'',
            // 'trading_agreement'=>'','trading_agreement_remarks'=>'','bizmatch'=>'','bizmatch_remarks'=>'',
            // 'direct_workers'=>'',
            // 'indirect_workers'=>'',
            // 'company_size'=>'',
            // 'business_ownership'=>'',
            // 'user_agreement' => 'Yes',
            'app_system'=> $getSystemFromKey(headercheck('x-api-key')) ,
        );
        // if(isset($data['country'])){
        //     $additional_data['continent'] = $getContinent($data['country'],$masterfile_db);
        // }

        return array_merge($data,$additional_data);
    }



//===================================================================

    public function update_prep_e_attendance_data($data){
        // $getContinent = function($x,$db){return ($db->get_where('v_reference',array('c_profile'=>$x,'switch'=>'R1'))->num_rows()==1) ? $db->get_where('v_reference',array('c_profile'=>$x,'switch'=>'R1'))->row()->c_code : '';};
        $getSystemFromKey = function($x){return ($this->configDB->get_where('api_keys',array('key'=>$x))->num_rows()==1) ? $this->configDB->get_where('api_keys',array('key'=>$x))->row()->app_system : '';};
        //Removed unknown fields
        $datetime = new DateTime('NOW');
        $date_created = $datetime->format('Y-m-d H:i:s');    
        $additional_data=array(
            // 'refno'=>'','ff_code'=>'','co_name'=>'',
            // 'brand_name'=>'',
            // 'portfolio'=>'',
            // 'membership_assoc'=>'',
            // 'application_no'=>'',
            // 'date_apply'=>(isset($data['date_apply'])? $data['date_apply']:$date_created),
            // 'proj'=>'',
            'fair_code'=>(isset($data['fair_code'])? $data['fair_code']:$this->appConfig['current_fair_code']),
            // 'fair_class'=>'','acti'=>'','fair_type'=>'','fair_stat'=>'','fair_part'=>'','fair_date'=>'',
            // 'fair_stat_app'=>'',
            // 'fair_stat_app_date'=>'',
            // 'fair_stat_part'=>'Incomplete',
            // 'foreignlocal'=>'',
            // 'foreignlocalremarks'=>'','coordinator'=>'','manager'=>'',
            // 'participation_type'=>'',
            // 'company_type'=>'','backup'=>'','finished'=>'',
            // 'sector_code'=>(isset($data['sector_code'])? $data['sector_code']:$this->appConfig['sector_code']),
            // 'username'=>'','userdesc'=>'','datetimestamp'=>'','filename'=>'','emailStatus'=>'','emailApprovedStat'=>'','product_dev'=>'','includeInBoothDIrectory'=>'','product_dev_consultant'=>'',
            // 'exhibit_participation'=>'',
            // 'trading_agreement'=>'','trading_agreement_remarks'=>'','bizmatch'=>'','bizmatch_remarks'=>'',
            // 'direct_workers'=>'',
            // 'indirect_workers'=>'',
            // 'company_size'=>'',
            // 'business_ownership'=>'',
            // 'user_agreement' => 'Yes',
            'app_system'=> $getSystemFromKey(headercheck('x-api-key')) ,
        );
        // if(isset($data['country'])){
        //     $additional_data['continent'] = $getContinent($data['country'],$masterfile_db);
        // }

        return array_merge($data,$additional_data);
    }


//===================================================================
    //ADD OTHER INFO - emails,
    //MULTI VALUED
    public function add_exh_other_info($data,$fair_code,$ff_code,$item_desc=null){
        $dataArr = explodeToArr('|',$data);
        foreach($dataArr as $row){
            $newData[]=array(
                'ff_code'    => $ff_code,
                'item_desc'  => $item_desc ??'',
                'remarks'    => $row,
                'fair_code'  => $fair_code,
                'sector'     => (isset($row['sector_code'])? $row['sector_code']:$this->appConfig['sector_code']),
                );
        }
        // delete existing data of the user in reference to the fair_code
        if($this->exhibitorDB->get_where('e_other_info',array('ff_code'=>$ff_code,'fair_code'=>$fair_code,'item_desc'=>$item_desc,))->num_rows()>=1){
            $this->exhibitorDB->delete('e_other_info', array('ff_code' => $ff_code,'fair_code'=>$fair_code,'item_desc'=>$item_desc,));
        }
        //insert data
        return ($this->exhibitorDB->insert_batch('e_other_info', $newData))? true:false;
    }


//===================================================================

    public function add_factory_address($data,$ff_code,$addr_type){
        $data = remove_unallowed_fields($data,$this->allowedData['e_addresses']);
        $getContinent = function($x){return ($this->masterDB->get_where('v_reference',array('c_profile'=>$x,'switch'=>'R1'))->num_rows()==1) ? $this->masterDB->get_where('v_reference',array('c_profile'=>$x,'switch'=>'R1'))->row()->c_code : '';};
        if(isset($data['fact_continent']) && $data['fact_continent']!=''){$continentData = $data['fact_continent'];}
        else{
            if(isset($data['fact_country']) && $data['fact_country']!=''){
                $continentData = $getContinent($data['fact_country']);}
            else{$continentData = '';}    
        }

        $addresses_data = array(
            'ff_code' => $ff_code,
            'add_st'=> $data['fact_st'] ?? '',
            'add_city'=> $data['fact_city'] ?? '',
            'zipcode'=> $data['fact_zipcode'] ?? '',
            'area'=> $data['fact_area'] ?? '',
            'province'=> $data['fact_province'] ?? '',
            'region'=> $data['fact_region'] ?? '',
            'state'=> $data['fact_state'] ?? '',
            'country'=> $data['fact_country'] ?? '',
            'continent'=> $continentData,
            'tel_off'=> $data['fact_tel_off'] ?? '',
            'fax'=> $data['fact_fax'] ?? '',
            'addr_type'=> $data['addr_type'] ?? 'F',
            // 'fair_code'=> $data['fair_code'] ?? $this->appConfig['current_fair_code'],
        );

        if(!$this->exhibitorDB->get_where('e_addresses',array('ff_code'=>$ff_code,'addr_type'=>$addr_type))->num_rows()>0){
            //add
            return ($this->exhibitorDB->insert('e_addresses',cleanAssocArr($addresses_data)))? true:false;
        }else{
            //update
            return ($this->exhibitorDB->update('e_addresses',cleanAssocArr($addresses_data), ['ff_code'=>$ff_code,'addr_type'=>$addr_type])) ? true:false;
        } 
    }

//===================================================================
    
    // SINGLE VALUE - TRADE EXPERIENCE
    public function add_exh_trade_experience($description,$ff_code){
        // GET SECTOR  BY FAIRCODE and reference switch 
        $sector=$this->appConfig['sector_code'];
        $switch=$this->refSwitch['trade_experience'];
        //prepare data for update
        if(strtolower($description)=='with'){
            $description='With Export Experience';
        }
        if(strtolower($description)=='without'){
            $description='Without Export Experience';
        }
        $data=array(
            'ff_code'   =>$ff_code,
            'item_code' =>$this->get_item_codev2($description,$switch),
            'remarks'   =>$description,
            'fair_code' =>(isset($data['fair_code'])? $data['fair_code']:$this->appConfig['current_fair_code']),
            'sector'    =>(isset($data['sector_code'])? $data['sector_code']:$this->appConfig['sector_code']),
            );
        //check if TRADE EXPERIENCE record exist
        if(!$this->exhibitorDB->get_where('e_trade_experience',array('ff_code'=>$ff_code,'fair_code'=>$data['fair_code']))->num_rows()>=1){
            return ($this->exhibitorDB->insert('e_trade_experience',$data))? true:false;
        }else{
            //update new TRADE EXPERIENCE data
            return ($this->exhibitorDB->update('e_trade_experience', $data, array('ff_code' => $data['ff_code'])))? true:false;
        } 
    }



//===================================================================
    //ADD MARKET SEGMENT
    //MULTI VALUED  //ISSUE ON THE SEPARATOR
    public function add_exh_market_segment($data,$ff_code){
        $fair_code = (isset($data['fair_code'])? $data['fair_code']:$this->appConfig['current_fair_code']);
        $market_segments = explodeToArr('|',$data);
        $switch=$this->refSwitch['marketsegment'];
        $data = array();
        foreach($market_segments as $market_segment){
            $data[]=array(
                'ff_code'    =>$ff_code,
                'item_code'  =>$this->get_item_codev2($market_segment,$switch),
                'remarks'    =>$market_segment,
                'fair_code'  =>$fair_code,
                'sector'     =>(isset($data['sector_code'])? $data['sector_code']:$this->appConfig['sector_code']),
                );
        }
        //delete existing data of the user in reference to the fair_code
        if($this->exhibitorDB->get_where('e_mn_marketsegment',array('ff_code'=>$ff_code,'fair_code'=>$fair_code))->num_rows()>=1){
            $this->exhibitorDB->delete('e_mn_marketsegment', array('ff_code' => $ff_code,'fair_code'=>$fair_code));
        }
        //insert market segment data
        return ($this->exhibitorDB->insert_batch('e_mn_marketsegment', $data))? true:false;
    }


//===================================================================
    //MULTI VALUED
    public function add_exh_products($data,$ff_code){
        //prepare data for batch insert
        $fair_code = $data['fair_code'];
        $dataArray = explodeToArr('|',$data['product_sub_category']);
        foreach($dataArray as $row){
            $product_detail = $this->get_product_code($row);
            $newData[] = array(
                'ff_code'       => $ff_code,
                'prod_cat'      => $product_detail['prod_cat']??'cat-'.round(microtime(true) * 1000),
                'prod_code'     => $product_detail['prod_code']??'code-'.round(microtime(true) * 1000),
                'remarks_major' => $product_detail['c_profile']??'',
                'remarks_minor' => $product_detail['prod_desc']??$row,
                'fair_code'     => $fair_code,
                'sector'        => (isset($data['sector_code'])? $data['sector_code']:$this->appConfig['sector_code']),
                );
        }
        //delete existing data of the user in reference to the fair_code
        if($this->exhibitorDB->get_where('e_genproducts',array('ff_code'=>$ff_code,'fair_code'=>$fair_code))->num_rows()>=1){
            $this->exhibitorDB->delete('e_genproducts', array('ff_code' => $ff_code,'fair_code'=>$fair_code));
        }
        //insert products data
        return ($this->exhibitorDB->insert_batch('e_genproducts', $newData))? true:false;
    }


//===================================================================
    //MULTI VALUED
    public function add_exh_create_services($data,$ff_code){
        //prepare data for batch insert
        $fair_code = $data['fair_code'];
        $dataArray = explodeToArr('|',$data['products_services']);
        $ctr = 1;
        foreach($dataArray as $row){
            $product_detail = $this->get_product_code($row);
            $ctr += 1;
            $newData[] = array(
                'ff_code'       => $ff_code,
                'prod_cat'      => $product_detail['prod_cat']??'cat-'.round(microtime(true) * 1000).'-'.$ctr,
                'prod_code'     => $product_detail['prod_code']??'code-'.round(microtime(true) * 1000).'-'.$ctr,
                'remarks_major' => $product_detail['c_profile']??'',
                'remarks_minor' => $product_detail['prod_desc']??$row,
                'fair_code'     => $fair_code,
                'sector'        => (isset($data['sector_code'])? $data['sector_code']:$this->appConfig['sector_code']),
                );
        }
        //delete existing data of the user in reference to the fair_code
        if($this->exhibitorDB->get_where('e_genproducts',array('ff_code'=>$ff_code,'fair_code'=>$fair_code))->num_rows()>=1){
            $this->exhibitorDB->delete('e_genproducts', array('ff_code' => $ff_code,'fair_code'=>$fair_code));
        }
        //insert products data
        return ($this->exhibitorDB->insert_batch('e_genproducts', $newData))? true:false;
    }

//===================================================================
    //MULTI VALUED  //good
    public function add_exh_major_product($data,$ff_code){
        $fair_code = $data['fair_code'];
        $dataArray = explodeToArr('|',$data['products_services']);
        foreach($dataArray as $row){
            $product_detail = $this->get_majorproduct_code($row,$this->appConfig['productfaircode']);
            $newData[] = array(
                'ff_code'          => $ff_code,
                'prod_cat'         => $product_detail['c_code']??'cat-'.round(microtime(true) * 1000),
                // 'prod_code'     => $product_detail['prod_code'],
                'remarks_major'    => $product_detail['c_profile']??$row,
                // 'remarks_minor' => $product_detail['prod_desc'],
                'fair_code'        => $fair_code,
                'sector'           => $this->appConfig['sector_code'],
                );
        }
        //delete existing data of the user in reference to the fair_code
        if($this->exhibitorDB->get_where('e_genproducts',array('ff_code'=>$ff_code,'fair_code'=>$fair_code))->num_rows()>=1){
            $this->exhibitorDB->delete('e_genproducts', array('ff_code' => $ff_code,'fair_code'=>$fair_code));
        }
        //insert products data
        return ($this->exhibitorDB->insert_batch('e_genproducts', $newData))? true:false;
    }


//===================================================================
    //SINGLE VALUED  //good
    public function add_exh_expertise($data,$ff_code){
        // GET SECTOR  BY FAIRCODE and reference switch 
        $fair_code = $data['fair_code'];
        //prepare data for update
        $product_details = $this->get_product_code($data['major_expertise']);
        $newData = array(
            'ff_code'   => $ff_code,
            'item_code' => $product_details['prod_code']??'',
            'remarks'   => $data['major_expertise'],
            'fair_code' => $fair_code,
            'sector'    => (isset($data['sector_code'])? $data['sector_code']:$this->appConfig['sector_code']),
            );
        //check if TRADE EXPERIENCE record exist
        if(!$this->exhibitorDB->get_where('e_expertise',array('ff_code'=>$ff_code,'fair_code'=>$fair_code))->num_rows()>=1){
            return ($this->exhibitorDB->insert('e_expertise',$newData))? true:false;
        }else{
            //update new TRADE EXPERIENCE data
            return ($this->exhibitorDB->update('e_expertise', $newData, array('ff_code' => $ff_code)))? true:false;
        }     
    }


//===================================================================
    public function get_majorproduct_code($value,$productfaircode){
        $q = "SELEC * FROM v_reference WHERE 1 AND switch='GP' AND sector LIKE ? AND c_profile =? AND fair_code LIKE ?";
        $result = $this->masterDB->query($q,['%'.$this->appConfig['sector_code'].'%',$value,'%'.$productfaircode.'%']);
        print_r($result->first_row('array'));exit();
        return $result->first_row('array');
    }
//===================================================================



//===================================================================
//===================================================================
//===================================================================
//===================================================================
    // SINGLE VALUE - ADD EXH Representative
    public function add_exh_representative($data,$ff_code){
        //prepare data for update
        $datetime = new DateTime('NOW');
        $date_created = $datetime->format('Y-m-d H:i:s'); 
        // $allowed_data = remove_unallowed_fields($data,$this->allowedData['e_representative']);
        $newData = array(
            'ff_code'   => $ff_code,
            'cont_per_fn' => $data['rep_cont_per_fn']??'',
            'cont_per_ln'   => $data['rep_cont_per_ln']??'',
            'mi' => $data['rep_mi']??'',
            'title' => $data['rep_title']??'',
            'email' => $data['rep_email']??'',
            'mobile' => $data['rep_mobile']??'',
            'message_app'=> $data['rep_messaging_app']??'',
            'date_created' => $data['date_created'] ?? $date_created,
        );
        $cleanData = cleanAssocArr($newData);
        //check if INDUSTRY REPRESENTATION record exist
        if(!$this->exhibitorDB->get_where('e_representative',array('ff_code'=>$ff_code))->num_rows()>0){
            return ($this->exhibitorDB->insert('e_representative',$cleanData))? true:false;
        }else{
            //update new INDUSTRY REPRESENTATION data
            return ($this->exhibitorDB->update('e_representative', $cleanData, array('ff_code' => $ff_code)))? true:false;
        }
    }



//===================================================================
    //SINGLE VALUED  //good INDUSTRY REPRESENTATION
    public function add_exh_industry_rep($data,$ff_code){
        // GET SECTOR  BY FAIRCODE and reference switch 
        $switch = $this->refSwitch['industry_representation'];
        $fair_code = $data['fair_code'];
        //prepare data for update
        // $product_details = $this->get_product_code($data['exhibitor_category']);
        $newData = array(
            'ff_code'   => $ff_code,
            'item_code' => $this->get_item_codev3($data['exhibitor_category'],$switch,$this->appConfig['sector_code']),
            'remarks'   => $data['exhibitor_category'],
            'fair_code' => $fair_code,
            'sector'    => (isset($data['sector_code'])? $data['sector_code']:$this->appConfig['sector_code']),
            );
        //check if TRADE EXPERIENCE record exist
        if(!$this->exhibitorDB->get_where('e_industry_representation',array('ff_code'=>$ff_code,'fair_code'=>$fair_code))->num_rows()>=1){
            // echo 1;exit();
            return ($this->exhibitorDB->insert('e_industry_representation',$newData))? true:false;
        }else{
            //update new TRADE EXPERIENCE data
            // echo 2;exit();
            return ($this->exhibitorDB->update('e_industry_representation', $newData, array('ff_code' => $ff_code,'fair_code'=>$fair_code)))? true:false;
        }     
    }

//===================================================================
    //TOP current COUNTRIES EXPORTING TO
    //MULTI VALUED  //ISSUE ON THE SEPARATOR
    public function add_exh_top_countries($data,$ff_code){
        $title         = fn($x)=> ucwords(strtolower($x));
        $fair_code     = $data['fair_code'];
        $top_countries = explodeToArr('|',$data['export_market']);
        $item_code     = 0;
        foreach($top_countries as $country){
            $newData[]=array(
                'ff_code'   => $ff_code,
                'item_code' => 'export'.$item_code++,
                'remarks'   => $title($country),
                'fair_code' => $fair_code,
                'sector'    => (isset($data['sector_code'])? $data['sector_code']:$this->appConfig['sector_code']),
                );
        }
        //delete existing data of the user in reference to the fair_code
        if($this->exhibitorDB->get_where('e_export_countries',array('ff_code'=>$ff_code,'fair_code'=>$fair_code))->num_rows()>=1){
            $this->exhibitorDB->delete('e_export_countries', array('ff_code' => $ff_code,'fair_code'=>$fair_code));
        }
        //insert export countries data
        return ($this->exhibitorDB->insert_batch('e_export_countries', $newData))? true:false;
    }
//===================================================================
    //TOP TARGET COUNTRIES FOR EXPORTING
    //MULTI VALUED  //ISSUE ON THE SEPARATOR
    public function add_exh_target_countries($data,$ff_code){
        $title         = fn($x)=> ucwords(strtolower($x));
        $fair_code     = $data['fair_code'];
        $top_countries = explodeToArr('|',$data['target_countries']);
        $item_code     = 0;
        foreach($top_countries as $country){
            $newData[]=array(
                'ff_code'   => $ff_code,
                'item_code' => 'target'.$item_code++,
                'remarks'   => $title($country),
                'fair_code' => $fair_code,
                'sector'    => (isset($data['sector_code'])? $data['sector_code']:$this->appConfig['sector_code']),
                );
        }
        //delete existing data of the user in reference to the fair_code
        if($this->exhibitorDB->get_where('e_target_countries',array('ff_code'=>$ff_code,'fair_code'=>$fair_code))->num_rows()>=1){
            $this->exhibitorDB->delete('e_target_countries', array('ff_code' => $ff_code,'fair_code'=>$fair_code));
        }
        //insert export countries data
        return ($this->exhibitorDB->insert_batch('e_target_countries', $newData))? true:false;
    }

//===================================================================
    // MULTI VALUE - ADD BUSINESS_NATURE
    public function add_exh_business_nature($data,$ff_code){
        // GET SECTOR  BY FAIRCODE and reference switch 
        $switch = $this->refSwitch['natureofbusiness'];
        $fair_code = $data['fair_code'];
        //prepare data for update
        $dataArr = explodeToArr('|',$data['nature_of_business']);
        foreach($dataArr as $row){
            $newData[] = array(
                'ff_code'   => $ff_code,
                'item_code' => $this->get_item_codev3($row,$switch,$this->appConfig['sector_code']),
                'remarks'   => $row,
                'fair_code' => $fair_code,
                'sector'    => (isset($row['sector_code'])? $row['sector_code']:$this->appConfig['sector_code']),
            );
        }
        //delete existing data of the user in reference to the fair_code
        if($this->exhibitorDB->get_where('e_business_nature',array('ff_code'=>$ff_code,'fair_code'=>$fair_code))->num_rows()>=1){
            $this->exhibitorDB->delete('e_business_nature', array('ff_code' => $ff_code,'fair_code'=>$fair_code));
        }
        //insert products data
        return ($this->exhibitorDB->insert_batch('e_business_nature', $newData))? true:false;
    }

//===================================================================
    // MULTI VALUE - ADD BUSINESS_NATURE -CREATE
    public function add_exh_category($data,$ff_code){
        // GET SECTOR  BY FAIRCODE and reference switch 
        $switch = $this->refSwitch['industry_representation'];
        $fair_code = $data['fair_code'];
        //prepare data for update
        $dataArr = explodeToArr('|',$data['exhibitor_category']);
        foreach($dataArr as $row){
            $newData[]=array(
                'ff_code'   => $ff_code,
                'item_code' => $this->get_item_codev3($row,$switch,$this->appConfig['sector_code']),
                'remarks'   => $row,
                'fair_code' => $data['fair_code'],
                'sector'    => (isset($row['sector_code'])? $row['sector_code']:$this->appConfig['sector_code']),
            );
        }
        //delete existing data of the user in reference to the fair_code
        if($this->exhibitorDB->get_where('e_industry_representation',array('ff_code'=>$ff_code,'fair_code'=>$fair_code))->num_rows()>=1){
            $this->exhibitorDB->delete('e_industry_representation', array('ff_code' => $ff_code,'fair_code'=>$fair_code));
        }
        //insert products data
        return ($this->exhibitorDB->insert_batch('e_industry_representation', $newData))? true:false;
    }
//===================================================================
    // MULTI VALUE - ADD CERTIFICATION
    public function add_exh_certification($data,$ff_code,$fair_code=null){
        // GET SECTOR  BY FAIRCODE and reference switch 
        $switch = $this->refSwitch['certification'];
        //prepare data for update
        $fair_code = $data['fair_code'];
        $dataArr = explodeToArr('|',$data['certification']);
        $ctr = 0;
        foreach($dataArr as $row){
            $item = $this->get_item_codev3($row,$switch,$this->appConfig['sector_code']);
            $ctr += 1;
            $newData[] = array(
            'ff_code'   => $ff_code,
            'item_code' => $item!=''? $item : ('itm-'.round(microtime(true) * 1000).'-'.$ctr),
            'remarks'   => $row,
            'fair_code' => $fair_code,
            'sector'    => (isset($row['sector_code'])? $row['sector_code']:$this->appConfig['sector_code']),
            );
        }
        //delete existing data of the user in reference to the fair_code
        if($this->exhibitorDB->get_where('e_certification',array('ff_code'=>$ff_code,'fair_code'=>$fair_code))->num_rows()>=1){
            $this->exhibitorDB->delete('e_certification', array('ff_code' => $ff_code,'fair_code'=>$fair_code));
        }
        //insert products data
        return ($this->exhibitorDB->insert_batch('e_certification', $newData))? true:false;
    }
//===================================================================

    public function add_exh_annualsales($data,$ff_code){
        // GET SECTOR  BY FAIRCODE and reference switch 
        $switch = $this->refSwitch['annualsales'];
        $fair_code = $data['fair_code'];
        //prepare data for update
        $newData = array(
            'ff_code'   => $ff_code,
            'item_code' => $this->get_item_codev3($data['annualsales'],$switch,$this->appConfig['sector_code']),
            'remarks'   => $data['annualsales'],
            'fair_code' => $fair_code,
            'sector'    => (isset($data['sector_code'])? $data['sector_code']:$this->appConfig['sector_code']),
            );
        //check if TRADE EXPERIENCE record exist
        if(!$this->exhibitorDB->get_where('e_mn_annualsales',array('ff_code'=>$ff_code,'fair_code'=>$fair_code))->num_rows()>=1){
            return ($this->exhibitorDB->insert('e_mn_annualsales',$newData))? true:false;
        }else{
            //update new TRADE EXPERIENCE data
            return ($this->exhibitorDB->update('e_mn_annualsales', $newData, array('ff_code' => $data['ff_code'])))? true:false;
        }     
    }

//===================================================================
    // SINGLE VALUE - ADD Document Link
    public function add_document_link($data,$ff_code){
        //prepare data for update
        // $allowed_data = remove_unallowed_fields($data,$this->allowedData['e_representative']);
        $newData = array(
            'ff_code'    =>$ff_code,
            'url'  => $data['url']??'',
            'remarks'    => $data['remarks']??'',
            'fair_code'  => (isset($data['fair_code'])? $data['fair_code']:$this->appConfig['current_fair_code']),
            'sector'     =>(isset($data['sector_code'])? $data['sector_code']:$this->appConfig['sector_code']),
        );
        $cleanData = cleanAssocArr($newData);
        //check if INDUSTRY REPRESENTATION record exist
        return ($this->exhibitorDB->insert('e_application_docs',$cleanData))? true:false;

        // if(!$this->exhibitorDB->get_where('e_application_docs',array('ff_code'=>$ff_code))->num_rows()>0){
        //     return ($this->exhibitorDB->insert('e_application_docs',$cleanData))? true:false;
        // }else{
        //     //update new INDUSTRY REPRESENTATION data
        //     return ($this->exhibitorDB->update('e_application_docs', $cleanData, array('ff_code' => $ff_code)))? true:false;
        // }
    }
//===================================================================
    //ADD MARKET SEGMENT
    //MULTI VALUED  //ISSUE ON THE SEPARATOR
    public function add_exh_target_buyers($data,$ff_code){
        $fair_code = $data['fair_code'];
        $dataArr = explodeToArr('|',$data['target_buyers']);
        $switch=$this->refSwitch['target_buyers'];
        foreach($dataArr as $row){
            $newData[] = array(
                'ff_code'    =>$ff_code,
                // 'barcode' =>barcode($rep_code),
                'item_code'  => $this->get_item_codev3($row,$switch,$this->appConfig['sector_code']),
                'remarks'    => $row,
                'fair_code'  => $fair_code,
                'sector'     => (isset($data['sector_code'])? $data['sector_code']:$this->appConfig['sector_code']),
                );
        }
        //delete existing data of the user in reference to the fair_code
        if($this->exhibitorDB->get_where('e_target_buyers',array('ff_code'=>$ff_code,'fair_code'=>$fair_code))->num_rows()>=1){
            $this->exhibitorDB->delete('e_target_buyers', array('ff_code' => $ff_code,'fair_code'=>$fair_code));
        }
        //insert products data
        return ($this->exhibitorDB->insert_batch('e_target_buyers', $newData))? true:false;
    }
//===================================================================

    public function validate_exhibitor($validation,$exhibitor_id){
        // $fair_code = $this->appConfig['current_fair_code'];
        // $sector=$this->appConfig['sector_code'];
        // $get_field_data = function($exhibitor_id,$fair_code,$field){
        //     return $this->$exhibitorDB->get_where('e_attendance',array('ff_code'=>$exhibitor_id,'fair_code'=>$fair_code))->row($field);
        // };
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
            'deleted'=>'Deleted',
            'approved'=>'Approved',
            'pending'=>'Pending',
            'incomplete'=>'Incomplete',
            'disapproved'=>'Disapproved',
        );
        //update current trade fair
        $prep_data['fair_stat_part'] = $get_validation_status(strtolower($validation['validation_status']),$validation_stat_value)?:'unknown';
        $prep_data['fair_code'] = $validation['fair_code']?$validation['fair_code']:$this->appConfig['current_fair_code'];
        $updated_attendance = $this->add_exh_attendance($prep_data,$exhibitor_id);
        // if($updated_attendance){
        //     $updated $this->add_exh_contact_profile($prep_data,$exhibitor_id)
        // }
        // $updated $this->add_exh_contact_profile($prep_data,$exhibitor_id)
        if($updated_attendance){
            return "Exhibitor validation status updated to ".$prep_data['fair_stat_part'];
        }
        // return ($updated)? true: false;
    }

//===================================================================
//============================GET====================================

//===================================================================

    public function getContact($mysql){
        // ini_set("memory_limit","4096M");
        // $result = $this->exhibitorDB->query($mysql,[$this->appConfig['system'],$this->appConfig['sector_code']]);
        $result = $this->exhibitorDB->query($mysql,[$this->appConfig['sector_code']]);
        // $result = $this->exhibitorDB->query($mysql,[$this->appConfig['system']]);
        return $result->result_array();
    }
//===================================================================

    public function total_contact_record_count($sql){
        // ini_set("memory_limit","4096M");
        // $result = $this->exhibitorDB->query($sql,[$this->appConfig['system'],$this->appConfig['sector_code']]);
        $result = $this->exhibitorDB->query($sql,[$this->appConfig['sector_code']]);
        // return $result->num_rows();
        return $result->row_array();
    }
//===================================================================

    public function getMajorProduct(){
        // ini_set("memory_limit","4096M");
        $q = "SELECT ff_code,GROUP_CONCAT(DISTINCT remarks_major SEPARATOR '|')as majorproduct,fair_code FROM e_genproducts
        WHERE 1
        AND sector=?
        GROUP BY fair_code,ff_code";
        $result = $this->exhibitorDB->query($q,[$this->appConfig['sector_code']]);
        return $result->result_array();
    }

//===================================================================

    public function getMinorProduct(){
        // ini_set("memory_limit","4096M");
        $q = "SELECT ff_code,GROUP_CONCAT(DISTINCT remarks_minor SEPARATOR '|')as minorproduct, fair_code FROM e_genproducts
        WHERE 1
        AND sector=?
        GROUP BY fair_code,ff_code";
        // $result = $this->exhibitorDB->query($q,[$this->appConfig['current_fair_code']]);
        $result = $this->exhibitorDB->query($q,[$this->appConfig['sector_code']]);
        return $result->result_array();
    }

//===================================================================

    public function getTradeExperience(){
        // ini_set("memory_limit","4096M");
        $q = "SELECT ff_code,GROUP_CONCAT(DISTINCT remarks SEPARATOR '|')as tradeExperience FROM e_trade_experience
        WHERE 1
        AND fair_code=?
        GROUP BY ff_code";
        $result = $this->exhibitorDB->query($q,[$this->appConfig['current_fair_code']]);
        return $result->result_array();
    }

//===================================================================

    public function getExportCountries(){
        // ini_set("memory_limit","4096M");
        $q = "SELECT ff_code,GROUP_CONCAT(DISTINCT remarks SEPARATOR '|')as exportCountries FROM e_export_countries
        WHERE 1
        AND fair_code=?
        GROUP BY ff_code";
        $result = $this->exhibitorDB->query($q,[$this->appConfig['current_fair_code']]);
        return $result->result_array();
    }

//===================================================================

    public function getIndustryRepresentation(){
        // ini_set("memory_limit","4096M");
        $q = "SELECT ff_code,GROUP_CONCAT(CONCAT(remarks)SEPARATOR '|') as industryRepresentation 
        FROM e_industry_representation
        WHERE 1
        AND fair_code=?
        GROUP BY ff_code";
        $result = $this->exhibitorDB->query($q,[$this->appConfig['current_fair_code']]);
        return $result->result_array();
    }
    
//===================================================================
    public function getMarketSegment(){
        // ini_set("memory_limit","4096M");
        $q = "SELECT ff_code,GROUP_CONCAT(remarks SEPARATOR '|')as marketSegment FROM e_mn_marketsegment
        WHERE 1
        AND fair_code=?
        GROUP BY ff_code";
        $result = $this->exhibitorDB->query($q,[$this->appConfig['current_fair_code']]);
        return $result->result_array();
    }

//===================================================================
    public function getTargetBuyers(){
        // ini_set("memory_limit","4096M");
        $q = "SELECT ff_code,GROUP_CONCAT(remarks SEPARATOR '|')as targetBuyers FROM e_target_buyers
        WHERE 1
        AND fair_code=?
        GROUP BY ff_code";
        $result = $this->exhibitorDB->query($q,[$this->appConfig['current_fair_code']]);
        return $result->result_array();
    }

//===================================================================

    public function get_ctm_exhibitor_by($identity,$email=null){
        // ini_set("memory_limit","4096M");
        $q = "SELECT
        *
        FROM e_contact_profile
        WHERE TRUE
        AND deleted=0 ";
        $q = ($identity=='email')? $q."AND co_email=?" : $q."AND id=?";
        $result = $this->exhibitorDB->query($q,[$email]);
        return $result->first_row('array');
    }
//===================================================================




//===================================================================
//===================================================================
//===================================================================
//get exhibitor by email
    public function get_exhibitor_by_email($email=null){
        // ini_set("memory_limit","4096M");
        $q = "SELECT
        ff_code,fameplus_id,co_email,cont_per_fn,cont_per_ln,country,continent,
                    a.co_name,title,webpage,add_st,tel_off,b.fair_code
        FROM e_contact_profile a INNER JOIN e_attendance b USING(ff_code)
        WHERE TRUE
        AND deleted=0 
        AND co_email=?";
        $result = $this->exhibitorDB->query($q,[$email]);
        return $result->first_row('array');
    }

//get exhibitor by email
    public function get_exhibitor_by_email2($email=null,$endpoint=null){
        // ini_set("memory_limit","4096M");
        $q = "SELECT
        ff_code,fameplus_id,co_email,cont_per_fn,cont_per_ln,country,continent,
                    a.co_name,title,webpage,add_st,tel_off,b.fair_code
        FROM e_contact_profile a INNER JOIN e_attendance b USING(ff_code)
        WHERE TRUE
        AND co_email=?";
        $result = $this->exhibitorDB->query($q,[$email]);
        return $result->first_row('array');
    }

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

    private function _determineContinent($data){
        $getContinent = function($x){return ($this->masterDB->get_where('v_reference',array('c_profile'=>$x,'switch'=>'R1'))->num_rows()==1) ? $this->masterDB->get_where('v_reference',array('c_profile'=>$x,'switch'=>'R1'))->row()->c_code : '';};
        if(isset($data['continent']) && $data['continent'] !== ''){
            return $data['continent'];
        }
        elseif (isset($data['country']) && $data['country'] !== ''){
            return $getContinent($data['country']);
        }
        return '';
    }

//===================================================================
}

/* End of file v1_model.php */
/* Location: ./application/models/v1_model.php */