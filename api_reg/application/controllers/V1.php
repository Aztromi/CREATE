<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require (APPPATH.'/libraries/RestController.php');
require (APPPATH.'/libraries/Format.php');
use Restserver\Libraries\RestController;


class V1 extends RestController {
// class V1 extends CI_Controller {

    public function __construct(){
        parent::__construct();
        // $this->config->load('rest', TRUE);get_buyer
        $this->config->load('my_rest', TRUE);
        $this->load->library('my_rest_lib');
        $this->load->model('buyerv1_model');
        $this->load->model('exhibitorv1_model');
        $this->load->model('apiv1_model');
        $this->load->model('subscriptionv1_model');
        $this->allowedData = $this->config->item('allowed_field', 'my_rest');
        $this->appConfig = $this->apiv1_model->_load_appConfig();
        $this->dbase  = $this->config->item('dbase', 'my_rest');
        $this->buyerDB     = $this->load->database($this->dbase['buyer'],TRUE);
        $this->exhibitorDB = $this->load->database($this->dbase['exhibitor'],TRUE);
        $this->masterDB    = $this->load->database($this->dbase['master'],TRUE);
        $this->configDB    = $this->load->database($this->dbase['config'],TRUE);
        $this->subscriptionDB    = $this->load->database($this->dbase['subscription'],TRUE);
    }
//===============================================
      
    public function index(){
        header("Location: https://citem.com.ph");
        // $this->response('CITEM TEST API');
    }

//=======================================================================================

//================================TRADE BUYER REGISTRATION===============================

//=======================================================================================

    public function buyers_post(){
        $user = $this->_hasAccess('BYR',2);
        $endpoint = 'v1/buyers';
        $emailExist = function($x){
            return ($this->buyerDB->get_where('v_contact_profile',['email'=>$x])->num_rows()==1 ) ? true:false;
        };
        $fair_code = $data['fair_code']?? $this->appConfig['productfaircode'];
        if(!$emailExist($this->post('email'))){
            //remove unknwon fields
            $data = $this->post();
            $allowed_data = remove_unallowed_fields($this->post(),$this->form_validation->get_field_names('buyers_post'));
            //validation
            $this->form_validation->set_data($allowed_data);
            if($this->form_validation->run('buyers_post')!=false){
                //ADD TO CONTACT PROFILE
                $prep_data = $this->buyerv1_model->prep_v_contact_profile_data($allowed_data);
                $buyer_id = $this->buyerv1_model->add_v_contact_profile($prep_data);
                // echo $buyer_id;
                // $buyer_id='345';
                if(!$buyer_id){
                    $this->response([
                        'status'=>'failure',
                        'message'=>'An unexpected error occured while trying to create buyer contact record',
                    ],RestController::HTTP_INTERNAL_ERROR);
                }
                else{
                    //ADD TO ATTENDANCE
                    // print_r($attendance_data);exit();
                    
                    if(isset($data['arranged_meetings']) AND $data['arranged_meetings']!='' AND !empty($data['arranged_meetings'])){
                        if(strtolower($data['arranged_meetings']) == 'yes'){
                            $allowed_data['specific_request'] = 'pre-arranged meetings';
                        }
                    }


                    // FOR CREATE REFERENCE ID - e_dtcp_id
                    if(!$this->buyerv1_model->add_buyer_reference_id($allowed_data,$buyer_id)){
                        $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while . ',
                        ],RestController::HTTP_INTERNAL_ERROR,false);
                    }

                    if(!$this->buyerv1_model->add_v_attendance($allowed_data,$buyer_id)){
                        $this->response([
                        'status'=>'failure',
                        'message'=>'An unexpected error occured while trying to create buyer participation record',
                        ],RestController::HTTP_INTERNAL_ERROR);
                    }

                    //check for nature of business - IFEX - v_representation
                    if(isset($allowed_data['representation']) AND $allowed_data['representation']!='' AND !empty($allowed_data['representation'])){
                        if(!$this->buyerv1_model->update_buyer_natureofbusiness($allowed_data['representation'],$buyer_id,$fair_code)){
                            $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while updating the buyers nature of business',
                        ],RestController::HTTP_INTERNAL_ERROR);
                        }
                    }
                    //check for annual sales data - single or multi value
                    if(isset($allowed_data['annual_sales']) AND $allowed_data['annual_sales']!='' AND !empty($allowed_data['annual_sales'])){
                        if(!$this->buyerv1_model->update_buyer_annual_sales($allowed_data['annual_sales'],$buyer_id,$fair_code)){
                            $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while updating the buyer annual sales. ',
                        ],RestController::HTTP_INTERNAL_ERROR,false);
                        }
                    }
                    //check for job function data/company role - single value
                    if(isset($allowed_data['job_function']) AND $allowed_data['job_function']!=''){
                        if(!$this->buyerv1_model->update_buyer_job_function($allowed_data['job_function'],$buyer_id,$fair_code)){
                            $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while updating the buyer company role ',
                        ],RestController::HTTP_INTERNAL_ERROR,false);
                        }
                    }

                    //check for job function data/company role - single value
                    if(isset($data['interpreter']) AND $data['interpreter']!=''){
                        if(!$this->buyerv1_model->update_buyer_arrangement($data['interpreter'],$buyer_id,$fair_code)){
                            $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while updating the buyer company role ',
                        ],RestController::HTTP_INTERNAL_ERROR,false);
                        }
                    }
                    //check for Products data - multi
                    if(isset($allowed_data['prod_sub_category']) AND $allowed_data['prod_sub_category']!=''){
                        if(!$this->buyerv1_model->update_buyer_products($allowed_data['prod_sub_category'],$buyer_id,$fair_code)){
                            $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while updating the buyer products. ',
                        ],RestController::HTTP_INTERNAL_ERROR,false);
                        }
                    }
                    //CREATE check for major product data - multi
                    if(isset($allowed_data['products_services']) AND $allowed_data['products_services']!=''){
                        print_r($allowed_data['products_services']);
                        if(!$this->exhibitorv1_model->add_exh_major_product($allowed_data['product_services'],$buyer['rep_code'])){
                            $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while updating the buyer products and services. ',
                            ],RestController::HTTP_INTERNAL_ERROR,false);
                        }
                    }
                    $this->set_response([
                        'status'=>'success',
                        'id'=>$buyer_id,
                        'message'=>'record created'
                    ],RestController::HTTP_CREATED); 
                    
                }
            }
            else{
                //validation error
                $this->response([
                    'status'=>'failure',
                    'timestamp'=>date('Y-m-d H:i:s'),
                    'method'=>'POST',
                    'endpoint'=>base_url().$endpoint,
                    'errors'=>[
                        'code'=>RestController::HTTP_BAD_REQUEST,
                        'text'=>$this->form_validation->get_errors_as_array(),
                    ],
                ]);
            }
        }
        else{
            //email aready exist in db, wil do an update
            $data = $this->post();
            $this->buyers_patch($data,$data['email']);
        }
    }//BUYER_POST END

//===============================================

    public function buyers_patch($data=null,$identity=null){
        $user = $this->_hasAccess('BYR',3);
        if($this->get('id')){
            $this->set_response([
                'status'=>'success',
                'message'=>'Sorry, this service is not yet available'
            ],RestController::HTTP_OK);
        }
        elseif($this->get('email')){
            $data = $this->patch();
            $this->updateBuyerByEmail($data,urldecode($this->get( 'email' )));
        }elseif(isset($data) AND isset($identity)) {
            $this->updateBuyerByEmail($data,urldecode($identity));
        }
        else{
            $this->response([
                'status'=>'failure',
                'timestamp'=>date('Y-m-d H:i:s'),
                'method'=>'PATCH',
                // 'endpoint'=>base_url().$endpoint,
                'errors'=>[
                        'code'=>RestController::HTTP_CONFLICT,
                        'message'=>'Invalid request',
                        ],
                    ],RestController::HTTP_BAD_REQUEST);
        }
    }

//===============================================

    public function updateBuyerByEmail($data,$email){
        $endpoint='v1/buyer/email/{email}';
        $buyer = $this->buyerv1_model->get_buyer_contact_by_email($email);
        $fair_code = $data['fair_code']?? $this->appConfig['productfaircode'];
        if(isset($buyer['rep_code'])){
            $buyer_id = $buyer['rep_code'];
            $allowed_data = remove_unallowed_fields($data,$this->form_validation->get_field_names('buyers_patch'));
            $additional_data=array();
            $prep_data = (count($additional_data)>0 ? array_merge($allowed_data,$additional_data) : $allowed_data);
            $this->form_validation->set_data($prep_data);
            if($this->form_validation->run('exhibitors_patch')!=false){
                //SETUP DATA ARRAY FOR UPDATING contact profile, attendance, and other tables
                
                //ADD OR TO UPDATE THE ATTENDANCE
                if(!$this->buyerv1_model->update_v_attendance($prep_data,$buyer_id)){
                        $this->response([
                        'status'=>'failure',
                        'message'=>'An unexpected error occured while trying to create buyer participation record',
                        ],RestController::HTTP_INTERNAL_ERROR);
                    }


                // FOR CREATE REFERENCE ID - e_dtcp_id
                if(!$this->buyerv1_model->add_buyer_reference_id($allowed_data,$buyer_id)){
                    $this->response([
                        'status'=>'failure',
                        'message'=>'An unexpected error occurred while . ',
                    ],RestController::HTTP_INTERNAL_ERROR,false);
                }

                //check for nature of business - IFEX - v_representation
                if(isset($data['arranged_meetings']) AND $data['arranged_meetings']!='' AND !empty($data['arranged_meetings'])){
                    if($data['arranged_meetings']==strtolower('yes')){
                        $allowed_data['specific_request'] = 'pre-arranged meetings';
                    }
                }
                //update the buyer Contact
                $prep_contact_data = $this->buyerv1_model->prep_v_contact_profile_data($allowed_data);
                if(!$this->buyerv1_model->add_v_contact_profile($prep_contact_data,$buyer_id)){
                    $this->response([
                        'status'=>'failure',
                        'message'=>'An unexpected error occurred while updating the buyer contact',
                    ],RestController::HTTP_INTERNAL_ERROR,false); //500 The server encountered an unexpected error
                }                

                //check for nature of business - IFEX - v_representation
                if(isset($allowed_data['representation']) AND $allowed_data['representation']!='' AND !empty($allowed_data['representation'])){
                    if(!$this->buyerv1_model->update_buyer_natureofbusiness($allowed_data['representation'],$buyer['rep_code'],$fair_code)){
                        $this->response([
                        'status'=>'failure',
                        'message'=>'An unexpected error occurred while updating the buyers nature of business',
                    ],RestController::HTTP_INTERNAL_ERROR);
                    }
                }
                //check for annual sales data - single or multi value
                if(isset($allowed_data['annual_sales']) AND $allowed_data['annual_sales']!='' AND !empty($allowed_data['annual_sales'])){
                    if(!$this->buyerv1_model->update_buyer_annual_sales($allowed_data['annual_sales'],$buyer['rep_code'],$fair_code)){
                        $this->response([
                        'status'=>'failure',
                        'message'=>'An unexpected error occurred while updating the buyer annual sales. ',
                    ],RestController::HTTP_INTERNAL_ERROR,false);
                    }
                }
                //check for job function data/company role - single value
                if(isset($allowed_data['job_function']) AND $allowed_data['job_function']!=''){
                    if(!$this->buyerv1_model->update_buyer_job_function($allowed_data['job_function'],$buyer['rep_code'],$fair_code)){
                        $this->response([
                        'status'=>'failure',
                        'message'=>'An unexpected error occurred while updating the buyer company role ',
                    ],RestController::HTTP_INTERNAL_ERROR,false);
                    }
                }

                //check for job function data/company role - single value
                if(isset($data['interpreter']) AND $data['interpreter']!=''){
                    if(!$this->buyerv1_model->update_buyer_arrangement($data['interpreter'],$buyer['rep_code'],$fair_code)){
                        $this->response([
                        'status'=>'failure',
                        'message'=>'An unexpected error occurred while updating the buyer company role ',
                    ],RestController::HTTP_INTERNAL_ERROR,false);
                    }
                }

                //check for Products data - multi
                if(isset($allowed_data['prod_sub_category']) AND $allowed_data['prod_sub_category']!=''){
                    if(!$this->buyerv1_model->update_buyer_products($allowed_data['prod_sub_category'],$buyer_id,$fair_code)){
                        $this->response([
                        'status'=>'failure',
                        'message'=>'An unexpected error occurred while updating the buyer products. ',
                    ],RestController::HTTP_INTERNAL_ERROR,false);
                    }
                }

                //CREATE check for major product data - multi
                if(isset($allowed_data['products_services']) AND $allowed_data['products_services']!=''){
                    if(!$this->buyerv1_model->update_buyer_major_product($allowed_data['products_services'],$buyer['rep_code'])){
                        $this->response([
                        'status'=>'failure',
                        'message'=>'An unexpected error occurred while updating the buyer products and services. ',
                        ],RestController::HTTP_INTERNAL_ERROR,false);
                    }
                }

                $this->response([
                    'status'=>'success',
                    'message'=>'Buyer Record Update Successful',
                ],RestController::HTTP_OK); // 200 The request has succeeded
            }
            else{
                //Form validation error notif
                $this->response([
                    'status'=>'failure',
                    'timestamp'=>date('Y-m-d H:i:s'),
                    'method'=>'PATCH',
                    'endpoint'=>base_url().$endpoint,
                    // 'message'=> 'User could not be found',
                    'errors'=>[
                        'code'=>RestController::HTTP_BAD_REQUEST,
                        'text'=>$this->form_validation->get_errors_as_array(),
                        // 'text'=>'validation form error',
                        // 'hints'=>'hints to developer for potential issues',
                        // 'info'=>'link to webpage for manual regarding error'
                    ],
                ],RestController::HTTP_BAD_REQUEST,false);
            }
        }
        else{
            $this->response([
                'status' => 'failure',
                'message' => 'Cannot update, record not found',
            ],RestController::HTTP_NOT_FOUND,false);
        }
    }//END UPDATEBYEMAIL

//===============================================


//UPDATE BUYER VALIDATION STATUS
    public function validate_buyer_patch(){
        $user = $this->_hasAccess('BYR',3);
        $fair_code= $this->appConfig['current_fair_code'];
        $sector_fair_code= $this->appConfig['sector_fair_code'];
        $sector=$this->appConfig['sector_code'];
        $endpoint = 'v1/validate_buyer/email/{email}';
        $checkParticipation = function($buyer_id,$fair_code){
            $buyer_db = $this->load->database($this->dbase['buyer'],TRUE);
            return ($buyer_db->get_where('v_attendance',array('rep_code'=>$buyer_id,'fair_code'=>$fair_code))->num_rows()==1) ? true : false;};
        if($this->get('email')){
            $this->form_validation->reset_validation();
            $this->form_validation->set_data($this->patch());
            if($this->form_validation->run('validate_buyer_patch')!=false){
                $buyer = $this->buyerv1_model->get_buyer_by_email(urldecode($this->get( 'email' )));
                if(isset($buyer['rep_code'])){
                    if($checkParticipation($buyer['rep_code'],$fair_code)){
                        $allowed_data = remove_unallowed_fields($this->patch(),$this->form_validation->get_field_names('validate_buyer_patch'));
                        $updated = $this->buyerv1_model->validate_buyer($allowed_data['validation_status'],$buyer['rep_code'],$fair_code);
                        if(!$updated){
                            $this->set_response([
                                'status'=>'failure',
                                'timestamp'=>date('Y-m-d H:i:s'),
                                'method'=>'PATCH',
                                'endpoint'=>base_url().$endpoint,
                                'errors'=>[
                                        'code'=>RestController::HTTP_INTERNAL_ERROR,
                                        'text'=>'An unexpected error occurred while validating the buyer.',
                                        ],
                                ],RestController::HTTP_INTERNAL_ERROR);
                        }else{
                            $this->response([
                                'status'=>'success',
                                'message'=>'Buyer validation status updated',
                            ],RestController::HTTP_OK); // 200 The request has succeeded
                        }
                    }
                    else{
                        //no current event record
                        $this->set_response([
                            'status'=> 'failure',
                            'timestamp'=>date('Y-m-d H:i:s'),
                            'method'=>'PATCH',
                            'endpoint'=>base_url().$endpoint,
                            'errors'=>[
                                    'code'=>RestController::HTTP_NOT_FOUND, //400 The requested resource could not be found
                                    'message'=>'No record of current event found',
                                ],
                            ],RestController::HTTP_NOT_FOUND);
                    }
                }else{
                    $this->set_response([
                    'status'=> 'failure',
                    'timestamp'=>date('Y-m-d H:i:s'),
                    'method'=>'PATCH',
                    'endpoint'=>base_url().$endpoint,
                    'errors'=>[
                            'code'=>RestController::HTTP_NOT_FOUND, //400 The requested resource could not be found
                            'message'=>'No record were found',
                        ],
                    ],RestController::HTTP_NOT_FOUND);
                }
            }else{
                $this->set_response([
                    'status'=>'failure',
                    'timestamp'=>date('Y-m-d H:i:s'),
                    'method'=>'PATCH',
                    'endpoint'=>base_url().$endpoint,
                    'errors'=>[
                            'code'=>RestController::HTTP_BAD_REQUEST,
                            'text'=>'The validated field is required',
                            ],
                        ],RestController::HTTP_BAD_REQUEST);
            }
        }else{
            $this->set_response([
                'status'=>'failure',
                'timestamp'=>date('Y-m-d H:i:s'),
                'method'=>'PATCH',
                'endpoint'=>base_url().$endpoint,
                'errors'=>[
                        'code'=>RestController::HTTP_BAD_REQUEST,
                        'text'=>'Invalid request, check endpoint requirements',
                        ],
                    ],RestController::HTTP_BAD_REQUEST);
        }
    }



//===============================================
//GET BUYERS
    public function buyers_get(){
        // $user = $this->_hasAccess('BYR',1);
        $endpoint = 'v1/buyers/';
        $customSet = array('fields','offset','limit','q');
        //check if retrieve all or single buyer record
        if($this->get('id')){ //buyer by id
            $this->set_response([
                'status'=>'success',
                'message'=>'Sorry, this service is not yet available'
            ],RestController::HTTP_OK);
        }elseif($this->get('email')){   //buyer by email
            $result = $this->_buyerBy('email',$customSet);
            if($result){
                $this->set_response([
                    'status'=>'success','data'=>$result,],RestController::HTTP_OK);
            }else{
                $this->set_response([
                    'status'=>'success','message'=>'no records','data'=>[],],RestController::HTTP_OK);
            }
        }else{//list all buyers
            $buyers_detail = $this->_all_buyers($customSet);
            $response_data = function($newArr,$param,$total){
                if(array_key_exists('limit', $param)){
                    return array('status'=>'success',
                        'paging'=>['limit'=>$_GET['limit'],
                        'offset'=>isset($_GET['offset']) ? $_GET['offset'] : NULL,
                        'total_records' =>$total['count']],
                        'data'=> $newArr,);
                }
                else{
                    return array('status'=>'success','paging'=>['limit'=>0,'offset'=>0,
                        'total_records' =>$total['count']],'data'=> $newArr);
                }
            };
            if($buyers_detail){
                $this->response($response_data($buyers_detail['data'],$buyers_detail['param'],$buyers_detail['total']),RestController::HTTP_OK);
            }else{
               // Set the response and exit
                $this->set_response([
                'status'=> 'success',
                'timestamp'=>date('Y-m-d H:i:s'),
                'method'=>'GET',
                'endpoint'=>base_url().$endpoint,
                'message'=>'No records',
                'errors'=>[
                        // 'code'=>RestController::HTTP_OK,
                        // 'message'=>'No records',
                    //  'description'=>'["Please check that user has provided the non null value for 'name'"]',
                    //  'link'=>'link to webpage for manual regarding error'
                     ],],RestController::HTTP_OK);
            }
        }
    }
//===============================================


//===============================================
//GET CITEM BUYERS
    public function ctm_buyers_get(){
        $user = $this->_hasAccess('BYR',1);
        $endpoint = 'v1/buyers/';
        $customSet = array('fields','offset','limit','q');

        //check if retrieve all or single buyer record
        if($this->get('id')){ //buyer by id
            $this->set_response([
                'status'=>'success',
                'message'=>'Sorry, this service is not yet available'
            ],RestController::HTTP_OK);

        }elseif($this->get('email')){   //buyer by email
            $result = $this->_ctmBuyerBy('email',$customSet);
            if($result){
                $this->set_response([
                    'status'=>'success','data'=>$result,],RestController::HTTP_OK);
            }else{
                $this->set_response([
                    'status'=>'success','message'=>'no record','data'=>[],],RestController::HTTP_OK);
            }

        }else{//list all buyers
            $this->set_response([
                'status'=>'success',
                'message'=>'Sorry, this service is not yet available'
            ],RestController::HTTP_OK);
            exit();
            $buyers_detail = $this->_all_buyers($customSet);
            $response_data = function($newArr,$param,$total){
                if(array_key_exists('limit', $param)){
                    return array('status'=>'success',
                        'paging'=>['limit'=>$_GET['limit'],
                        'offset'=>isset($_GET['offset']) ? $_GET['offset'] : NULL,
                        'total_records' =>$total['count']],
                        'data'=> $newArr,);
                }
                else{
                    return array('status'=>'success','paging'=>['limit'=>0,'offset'=>0,
                        'total_records' =>$total['count']],'data'=> $newArr);
                }
            };
            if($buyers_detail){
                $this->response($response_data($buyers_detail['data'],$buyers_detail['param'],$buyers_detail['total']),RestController::HTTP_OK);
            }else{
               // Set the response and exit
                $this->set_response([
                'status'=> 'success',
                'timestamp'=>date('Y-m-d H:i:s'),
                'method'=>'GET',
                'endpoint'=>base_url().$endpoint,
                'message'=>'No records',
                'errors'=>[
                        // 'code'=>RestController::HTTP_OK,
                        // 'message'=>'No records',
                    //  'description'=>'["Please check that user has provided the non null value for 'name'"]',
                    //  'link'=>'link to webpage for manual regarding error'
                     ],],RestController::HTTP_OK);
            }
        }
    }

//===============================================

//===============================================
// _get all buyers
    private function _all_buyers($customSet=null){
        function getArr($row,$data,$field){
            $key = array_search($row, array_column($data, 'rep_code'));
            return ($key===false)? '':explodeToArr('|',$data[$key][$field]);
                // return explodeToArr('|',$data[$key][$field]);
        }

        function getItem($row,$data,$field){
            $key = array_search($row, array_column($data, 'rep_code'));
            return ($key===false)? '':$data[$key][$field];
        }
        function validation_no($status){
            if($status=='PENDING TRADE'){
                return 'Pending';
            }elseif($status=='APPROVED TRADE'){
                return 'Approved';
            }elseif($status=='INCOMPLETE TRADE'){
                return 'Incomplete';
            }elseif($status=='DISAPPROVED TRADE'){
                return 'Disapproved';
            }
            else{
                return null;
            }
        };
        $param = getUrlParam($customSet);

        $mysqls = $this->my_rest_lib->generate_sql($param);
        // print_r($mysqls);exit();
        $buyers = $this->buyerv1_model->getContact($mysqls['query']);
        $total =  $this->buyerv1_model->total_contact_record_count($mysqls['count_query']);
        // $reason = $this->buyerv1_model->getReason();
        // $informthru = $this->buyerv1_model->getInformthru();
        $jobfunction = $this->buyerv1_model->getJobfunction();
        $nature_of_business = $this->buyerv1_model->getRepresentation();
        // $product_interest = $this->buyerv1_model->getProductInterest();
        // $market = $this->buyerv1_model->getMarketSegment();
        $annualSales = $this->buyerv1_model->getAnnualsales();
        $majorProducts = $this->buyerv1_model->getMajorProduct();
        $minorProducts = $this->buyerv1_model->getMinorProduct();
        // print_r($buyers);exit();
        if($buyers){
            foreach($buyers as $row){
                $newArr[]=array(
                // 'fameplus_id' => $row['fameplus_id'],
                // 'rep_code'    => $row['rep_code'],
                'email'       => $row['email'],
                'cont_per_fn' => $row['cont_per_fn'],
                'cont_per_ln' => $row['cont_per_ln'],
                'mi'          => $row['mi'],
                'title'       => $row['authority_title'],
                'company'     => $row['co_name'],
                'webpage'     => $row['webpage'],
                'country'     => $row['country'],
                'continent'   => $row['continent'],
                'add_st'      => $row['add_st'],
                'add_city'      => $row['add_city'],
                'region'      => $row['region'],
                'zipcode'      => $row['zipcode'],
                'tel_off'     => $row['tel_off'],
                'mobile'      => $row['mobile'],
                'facebook' => $row['facebook'],
                'twitter' => $row['twitter'],
                'instagram' => $row['instagram'],
                // 'social_others' => $row['social_others'],
                // 'validated'   => validation_no($row['validation_status']),
                // 'visitor_type'   => $row['visitor_type'],
                // 'visitor_status'   => $row['visitor_status'],
                // 'visitor_status_remarks'   => $row['visitor_status_remarks'],
                'job_function'=> getItem($row['rep_code'],$jobfunction,'jobfunction'),
                'nature_of_business'=> getItem($row['rep_code'],$nature_of_business,'representation'),
                
                // 'market_segment'=> getArr($row['rep_code'],$market,'marketSegment'),
                // 'annual_sales'=> getItem($row['rep_code'],$annualSales,'annualsales'),
                // 'supplier_info'=> explodeToArr(',',$row['supplier_info']),
                // 'supplier_info'=> $row['supplier_info'],
                'category'=> getArr($row['rep_code'],$majorProducts,'majorproduct'),
                'sub_category'=> getArr($row['rep_code'],$minorProducts,'minorproduct'),
                // 'product_interest'=> getArr($row['rep_code'],$product_interest,'product_interest'),
                // 'reason'=> getArr($row['rep_code'],$reason,'reason'),
                // 'informthru'=> getArr($row['rep_code'],$informthru,'informthru'),
                '_links'=> array(
                    'edit' => ['href'=>base_url().'v1/buyers/email/'.urlencode($row['email']),'methods'=>'patch',],
                    ),
                );
            }
            $buyers_detail = array('data'=>$newArr,'total'=>$total,'param'=>$param);
            return $buyers_detail;
        }else{
            return false;
        }
    }

//===============================================
// _get buyer by
    private function _buyerBy($identity,$customSet=null){
        function getArr($row,$data,$field){
            $key = array_search($row, array_column($data, 'rep_code'));
            return ($key===false)? '':explodeToArr('|',$data[$key][$field]);
                // return explodeToArr('|',$data[$key][$field]);
        }
        function getItem($row,$data,$field){
            $key = array_search($row, array_column($data, 'rep_code'));
            return ($key===false)? '':$data[$key][$field];
        }
        function validation_no($status){
            if($status=='PENDING TRADE'){
                return '0';
            }elseif($status=='APPROVED TRADE'){
                return '1';
            }elseif($status=='INCOMPLETE TRADE'){
                return '2';
            }elseif($status=='DISAPPROVED TRADE'){
                return '3';
            }else{
                return null;
            }
        };
        $param = getUrlParam($customSet);
        $mysqls = $this->my_rest_lib->generate_sql($param);
        if($identity=='email'){
            $buyer = $this->buyerv1_model->get_buyer_by($identity,$this->get('email'));
        }
        if($identity=='id'){
            $buyer = $this->buyerv1_model->get_buyer_by($identity,$this->get('id'));
        }
        if(!$buyer){
            return false;
        }

        $reason = $this->buyerv1_model->getReason();
        $informthru = $this->buyerv1_model->getInformthru();
        $jobfunction = $this->buyerv1_model->getJobfunction();
        $nature_of_business = $this->buyerv1_model->getRepresentation();
        $product_interest = $this->buyerv1_model->getProductInterest();
        $market = $this->buyerv1_model->getMarketSegment();
        $annualSales = $this->buyerv1_model->getAnnualsales();
        $majorProducts = $this->buyerv1_model->getMajorProduct();
        $minorProducts = $this->buyerv1_model->getMinorProduct();

        $newArr[]=array(
            // 'rep_code'    => $row['rep_code'],
            'email'       => $buyer['email'],
            'cont_per_fn' => $buyer['cont_per_fn'],
            'cont_per_ln' => $buyer['cont_per_ln'],
            'mi'           => $buyer['mi'],
            'title'       => $buyer['authority_title'],
            'company'     => $buyer['co_name'],
            'webpage'     => $buyer['webpage'],
            'country'     => $buyer['country'],
            'continent'   => $buyer['continent'],
            'add_st'      => $buyer['add_st'],
            'add_city'      => $buyer['add_city'],
            'region'      => $buyer['region'],
            'zipcode'      => $buyer['zipcode'],
            'mobile'      => $buyer['mobile'],
            'facebook'      => $buyer['facebook'],
            'twitter'      => $buyer['twitter'],
            'instagram'      => $buyer['instagram'],
            'social_others'      => $buyer['social_others'],
            'tel_off'      => $buyer['tel_off'],
            'mobile'      => $buyer['mobile'],
            'validated'   => $buyer['validation_status'],
            'visitor_type'   => $buyer['visitor_type'],
            'job_function'=> getItem($buyer['rep_code'],$jobfunction,'jobfunction'),
            'nature_of_business'=> explodeToArr('|',getItem($buyer['rep_code'],$nature_of_business,'representation')),
            // 'market_segment'=> getArr($buyer['rep_code'],$market,'marketSegment'),
            'annual_sales'=> getItem($buyer['rep_code'],$annualSales,'annualsales'),
            // 'supplier_info'=> explodeToArr(',',$buyer['supplier_info']),
            'supplier_info'=> $buyer['supplier_info'],
            'category'=> getArr($buyer['rep_code'],$majorProducts,'majorproduct'),
            'sub_category'=> getArr($buyer['rep_code'],$minorProducts,'minorproduct'),
            // 'product_interest'=> getArr($buyer['rep_code'],$product_interest,'product_interest'),
            // 'reason'=> getArr($buyer['rep_code'],$reason,'reason'),
            // 'informthru'=> getArr($buyer['rep_code'],$informthru,'informthru'),
        );
        return $newArr;
        }
//===============================================


//===============================================
// _get buyer by
    private function _ctmBuyerBy($identity,$customSet=null){
        function getArr($row,$data,$field){
            $key = array_search($row, array_column($data, 'rep_code'));
            return ($key===false)? '':explodeToArr('|',$data[$key][$field]);
                // return explodeToArr('|',$data[$key][$field]);
        }
        function getItem($row,$data,$field){
            $key = array_search($row, array_column($data, 'rep_code'));
            return ($key===false)? '':$data[$key][$field];
        }
        // $identity = $this->get($identity);
        $param = getUrlParam($customSet);
        $mysqls = $this->my_rest_lib->generate_ctmbuyer_sql($param);
        // print_r($mysqls);exit();
        if($identity=='email'){
            $buyer = $this->buyerv1_model->get_ctm_buyer_by($identity,urldecode($this->get('email')));
        }
        if($identity=='id'){
            $buyer = $this->buyerv1_model->get_ctm_buyer_by_email($identity,$this->get('id'));
        }
        if(!$buyer){
            return false;
        }
        // $reason = $this->buyerv1_model->getReason();
        // $informthru = $this->buyerv1_model->getInformthru();
        // $jobfunction = $this->buyerv1_model->getJobfunction();
        // $nature_of_business = $this->buyerv1_model->getRepresentation();
        // $product_interest = $this->buyerv1_model->getProductInterest();
        // $market = $this->buyerv1_model->getMarketSegment();
        // $annualSales = $this->buyerv1_model->getAnnualsales();
        // $majorProducts = $this->buyerv1_model->getMajorProduct();
        // $minorProducts = $this->buyerv1_model->getMinorProduct();

        $newArr[]=array(
            'rep_code'    => $buyer['rep_code'],
            'email'       => $buyer['email'],
            'cont_per_fn' => $buyer['cont_per_fn'],
            'cont_per_ln' => $buyer['cont_per_ln'],
            'mi'           => $buyer['mi'],
            'title'       => $buyer['authority_title'],
            'company'     => $buyer['co_name'],
            'webpage'     => $buyer['webpage'],
            'country'     => $buyer['country'],
            'continent'   => $buyer['continent'],
            'add_st'      => $buyer['add_st'],
            'add_city'      => $buyer['add_city'],
            'region'      => $buyer['region'],
            'zipcode'      => $buyer['zipcode'],
            'tel_off'      => $buyer['tel_off'],
            'mobile'      => $buyer['mobile'],
            'facebook'      => $buyer['facebook'],
            'twitter'      => $buyer['twitter'],
            'instagram'      => $buyer['instagram'],
            'social_others'      => $buyer['social_others'],
            // 'visitor_type'   => $buyer['visitor_type'],
            // 'job_function'=> getItem($buyer['rep_code'],$jobfunction,'jobfunction'),
            // 'nature_of_business'=> explodeToArr('|',getItem($buyer['rep_code'],$nature_of_business,'representation')),
            // 'market_segment'=> getArr($buyer['rep_code'],$market,'marketSegment'),
            // 'annual_sales'=> getItem($buyer['rep_code'],$annualSales,'annualsales'),
            // 'supplier_info'=> explodeToArr(',',$buyer['supplier_info']),
            // 'category'=> getArr($buyer['rep_code'],$majorProducts,'majorproduct'),
            // 'sub_category'=> getArr($buyer['rep_code'],$minorProducts,'minorproduct'),
            // 'product_interest'=> getArr($buyer['rep_code'],$product_interest,'product_interest'),
            // 'reason'=> getArr($buyer['rep_code'],$reason,'reason'),
            // 'informthru'=> getArr($buyer['rep_code'],$informthru,'informthru'),   
        );
        return $newArr;
        }
//===============================================






//====================================================

//===============EXHIBITORS REGISTRATION==============

//====================================================


//===============================================
//GET EXHIBITORS
    public function exhibitors_get(){
        $sector_code = $this->appConfig['sector_code'];
        $table = 'v_contact_profile';
        $user        = $this->config->item('api_key', 'my_rest')?$this->_hasAccess('EXH',1):'';
        $endpoint    = base_url().$this->router->fetch_class().'/'.$this->router->fetch_method().'/';
        $customSet   = array('fields','offset','limit','q','l','set','raw');
        
        //check if retrieve all or single buyer record
        if($this->get('id')){ //buyer by id
            $this->set_response([
                'status'=>'success',
                'message'=>'Sorry, this service is not yet available'
            ],RestController::HTTP_OK);

        }elseif($this->get('email')){   //buyer by email
            $this->set_response([
                'status'=>'success',
                'message'=>'Sorry, this service is not yet available'
            ],RestController::HTTP_OK);
            // $result = $this->_exhibitorBy('email',$customSet);
            // if($result){
            //     $this->set_response([
            //         'status'=>'success','data'=>$result,],RestController::HTTP_OK);
            // }else{
            //     $this->set_response([
            //         'status'=>'success','message'=>'no records','data'=>[],],RestController::HTTP_OK);
            // }

        }else{//list all exhibitors
            $exhibitors = $this->_all_exhibitors($sector_code,$customSet);
            if($exhibitors){
                $this->response($this->_response_data(
                    $exhibitors['data'],
                    $exhibitors['param'],
                    $exhibitors['total'],
                    $exhibitors['total_filtered'],
                    $exhibitors['query'],
                    $exhibitors['query_total'],
                    $exhibitors['query_filtered']
                ),RestController::HTTP_OK);
            }
            else{
                // Set the response and exit
                $responseArr = [
                    'status'    => 'success',
                    'timestamp' => (new DateTime('Asia/Manila'))->format('Y-m-d H:i:s'),
                    'method'    => 'GET',
                    // 'endpoint'  => base_url().$endpoint,
                    'endpoint' => base_url().$this->router->fetch_class().'/'.$this->router->fetch_method().'/',
                    'message'   => 'No records',
                    'errors'    => [
                     ],];
                $param          = getUrlParam($customSet);
                $param['table'] = $table;
                $mysqls         = $this->my_rest_lib->generate_query($param,$sector_code);
                if(array_key_exists('set', $param) and $param['set'] =='debug'){
                    $debugResponse = [
                        'sql'=>[
                            'query'          => $mysqls['query'],
                            'total'          => $mysqls['query_count'],
                            'total_filtered' => $mysqls['query_filter_count'],
                        ]];
                    $responseArr = array_merge($responseArr, $debugResponse);
                }
                $this->set_response($responseArr, RestController::HTTP_OK);               
            }
        }
    }

//===============================================

    public function exhibitor_get(){
        $user = $this->_hasAccess('EXH',1);
        $endpoint = 'v1/exhibitors/';
        $customSet = array('fields','offset','limit','q');

        //check if retrieve all or single buyer record
        if($this->get('id')){ //buyer by id
            $this->set_response([
                'status'=>'success',
                'message'=>'Sorry, this service is not yet available'
            ],RestController::HTTP_OK);

        }elseif($this->get('email')){   //buyer by email
            $result = $this->_buyerBy('email',$customSet);
            if($result){
                $this->set_response([
                    'status'=>'success','data'=>$result,],RestController::HTTP_OK);
            }else{
                $this->set_response([
                    'status'=>'success','message'=>'no records','data'=>[],],RestController::HTTP_OK);
            }

        }else{//list all buyers
            $buyers_detail = $this->_all_buyers($customSet);
            $response_data = function($newArr,$param,$total){
                if(array_key_exists('limit', $param)){
                    return array('status'=>'success',
                        'paging'=>['limit'=>$_GET['limit'],
                        'offset'=>isset($_GET['offset']) ? $_GET['offset'] : NULL,
                        'total_records' =>$total['count']],
                        'data'=> $newArr,);
                }
                else{
                    return array('status'=>'success','paging'=>['limit'=>0,'offset'=>0,
                        'total_records' =>$total['count']],'data'=> $newArr);
                }
            };
            if($buyers_detail){
                $this->response($response_data($buyers_detail['data'],$buyers_detail['param'],$buyers_detail['total']),RestController::HTTP_OK);
            }else{
               // Set the response and exit
                $this->set_response([
                'status'=> 'success',
                'timestamp'=>date('Y-m-d H:i:s'),
                'method'=>'GET',
                'endpoint'=>base_url().$endpoint,
                'message'=>'No records',
                'errors'=>[
                        // 'code'=>RestController::HTTP_OK,
                        // 'message'=>'No records',
                    //  'description'=>'["Please check that user has provided the non null value for 'name'"]',
                    //  'link'=>'link to webpage for manual regarding error'
                     ],],RestController::HTTP_OK);
            }
        }
    }
//===============================================


//===============================================
//ADD NEW EXHIBITOR
    public function exhibitors_post(){
        
        $user = $this->_hasAccess('EXH',2);
        $endpoint = 'v1/exhibitors';
        $emailExist = function($x){
            $this->exhibitorDB = $this->load->database($this->dbase['exhibitor'],TRUE);
            return ($this->exhibitorDB->get_where('e_contact_profile',array('co_email'=>$x))->num_rows()>=1) ? true : false;
        };
        if(!$emailExist($this->post('co_email'))){
            //remove unknown field and and additional fields
            $allowed_data = remove_unallowed_fields($this->post(),$this->form_validation->get_field_names('exhibitors_post'));

            if(isset($allowed_data['webpage']) AND strpos($allowed_data['webpage'],'|')){
                list($allowed_data['webpage'],$allowed_data['other_webpage']) = $this->_breakMultiValue($allowed_data['webpage']);
            }
            if(isset($allowed_data['title']) AND strpos($allowed_data['title'],'|')){
                list($allowed_data['title'],$allowed_data['other_title']) = $this->_breakMultiValue($allowed_data['title']);
            }

            $this->form_validation->set_data($allowed_data);
            if($this->form_validation->run('exhibitors_post')!=false){
                //FOR IFEX NATURE OF BUSINESS / BUSINESS OWNERSHIP
                if(isset($allowed_data['organization_type']) and $allowed_data['organization_type']!=''){
                    $allowed_data['business_ownership'] = $allowed_data['organization_type'];
                }

                // ADD TO CONTACT PROFILE
                // $contact_profile_data = remove_unallowed_fields($allowed_data,$this->allowedData['e_contact_profile']);
                // $prep_data = $this->exhibitorv1_model->prep_e_contact_profile_data($contact_profile_data);
                $prep_data = $this->exhibitorv1_model->prep_e_contact_profile_data($allowed_data);
                $exhibitor_id = $this->exhibitorv1_model->add_exh_contact_profile($prep_data);

                // $exhibitor_id=1298;
                if(!$exhibitor_id){
                    $this->set_response([
                    'status'=>'failure',
                    'message'=>'An unexpected error occured while trying to create exhibitor contact record',
                ],RestController::HTTP_INTERNAL_ERROR);
                }
                else{
                    // ADD TO E_ATTENDANCE
                    $digital_part = $allowed_data['digital_participation']??'No';
                    $physical_part = $allowed_data['physical_participation']??'No';
                    if(strtolower($digital_part)=='yes' AND strtolower($physical_part)=='yes'){
                        $allowed_data['exhibit_participation'] = 'Physical Trade Show + Digital Platform';
                    }else{
                        if(strtolower($digital_part)=='yes'){
                            $allowed_data['exhibit_participation'] = 'Digital Platform';
                        }elseif(strtolower($physical_part)=='yes'){
                            $allowed_data['exhibit_participation'] = 'Physical Trade Show';
                        }else{
                            $allowed_data['exhibit_participation'] = '';
                        }
                    }

                    $allowed_data['ff_code'] = $exhibitor_id;
                    $allowed_data['fair_code'] = $allowed_data['fair_code'] ?? $this->appConfig['current_fair_code'];
                    $attendance_data = remove_unallowed_fields($allowed_data,$this->allowedData['e_attendance']);
                    $prep_data = $this->exhibitorv1_model->prep_e_attendance_data($attendance_data);
                    if(!$this->exhibitorv1_model->add_exh_attendance($prep_data)){
                            $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while adding exhibitor attendance record',
                        ],RestController::HTTP_INTERNAL_ERROR);
                    }

                    $doc = array();
                    //FOR IFEX DOCS
                    if(isset($allowed_data['sec_dti_doc']) and $allowed_data['sec_dti_doc']!=''){
                        $doc['remarks']='SEC or DTI registration';
                        $doc['url']=$allowed_data['sec_dti_doc'];
                        $this->exhibitorv1_model->add_document_link($doc,$exhibitor_id);
                    }
                    if(isset($allowed_data['permit_doc']) and $allowed_data['permit_doc']!=''){
                        $doc['remarks']='Mayors permit';
                        $doc['url']=$allowed_data['permit_doc'];
                        $this->exhibitorv1_model->add_document_link($doc,$exhibitor_id);
                    }
                    if(isset($allowed_data['license_cert_doc']) and $allowed_data['license_cert_doc']!=''){
                        $doc['remarks']='License or certifications';
                        $doc['url']=$allowed_data['license_cert_doc'];
                        $this->exhibitorv1_model->add_document_link($doc,$exhibitor_id);
                    }
                    if(isset($allowed_data['export_declaration_doc']) and $allowed_data['export_declaration_doc']!=''){
                        $doc['remarks']='Export declarations';
                        $doc['url']=$allowed_data['export_declaration_doc'];
                        $this->exhibitorv1_model->add_document_link($doc,$exhibitor_id);
                    }
                    if(isset($allowed_data['training_cert_doc']) and $allowed_data['training_cert_doc']!=''){
                        $doc['remarks']='Training Certification';
                        $doc['url']=$allowed_data['training_cert_doc'];
                        $this->exhibitorv1_model->add_document_link($doc,$exhibitor_id);
                    }
                    if(isset($allowed_data['endorse_letter_doc']) and $allowed_data['endorse_letter_doc']!=''){
                        $doc['remarks']='Endorsement Letter';
                        $doc['url']=$allowed_data['endorse_letter_doc'];
                        $this->exhibitorv1_model->add_document_link($doc,$exhibitor_id);
                    }
                    //CREATE DOCS
                    if(isset($allowed_data['portfolio_doc']) and $allowed_data['portfolio_doc']!=''){
                        $doc['remarks'] = 'Sample Works';
                        $doc['url'] = $allowed_data['portfolio_doc'];
                        $this->exhibitorv1_model->add_document_link($doc,$exhibitor_id);
                    }
                    if(isset($allowed_data['business_permit_doc']) and $allowed_data['business_permit_doc']!=''){
                        $doc['remarks'] = 'Business Permit / Identification';
                        $doc['url'] = $allowed_data['business_permit_doc'];
                        $this->exhibitorv1_model->add_document_link($doc,$exhibitor_id);
                    }
                    if(isset($allowed_data['gov_id_doc']) and $allowed_data['gov_id_doc']!=''){
                        $doc['remarks'] = 'Any government-issued ID (for individuals) or valid Business Permit (for businesses/companies)';
                        $doc['url'] = $allowed_data['gov_id_doc'];
                        $this->exhibitorv1_model->add_document_link($doc,$exhibitor_id);
                    }
                    if(isset($allowed_data['reg_cert_doc']) and $allowed_data['reg_cert_doc']!=''){
                        $doc['remarks'] = 'Certificate of Registration';
                        $doc['url'] = $allowed_data['reg_cert_doc'];
                        $this->exhibitorv1_model->add_document_link($doc,$exhibitor_id);
                    }

                    // FOR MULTI ADDITIONAL EMAILS - CREATE - e_other_info
                    if(isset($allowed_data['other_emails']) and $allowed_data['other_emails']!=''){
                        if(!$this->exhibitorv1_model->add_exh_other_info($allowed_data['other_emails'],$allowed_data['fair_code'],$exhibitor_id,'email')){
                            $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while updating the exhibitor other emails. ',
                        ],RestController::HTTP_INTERNAL_ERROR,false);
                        }
                    }

                    // FOR MULTI ADDITIONAL mobile - CREATE - e_other_info
                    if(isset($allowed_data['other_mobile']) and $allowed_data['other_mobile']!=''){
                        if(!$this->exhibitorv1_model->add_exh_other_info($allowed_data['other_mobile'],$allowed_data['fair_code'],$exhibitor_id,'other mobile')){
                            $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while updating the exhibitor other mobile. ',
                        ],RestController::HTTP_INTERNAL_ERROR,false);
                        }
                    }

                    // FOR MULTI ADDITIONAL webpage - CREATE - e_other_info
                    if(isset($allowed_data['other_webpage']) and $allowed_data['other_webpage']!=''){
                        if(!$this->exhibitorv1_model->add_exh_other_info($allowed_data['other_webpage'],$allowed_data['fair_code'],$exhibitor_id,'other webpage')){
                            $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while updating the exhibitor other mobile. ',
                        ],RestController::HTTP_INTERNAL_ERROR,false);
                        }
                    }

                    // FOR MULTI ADDITIONAL title(position) - CREATE - e_other_info
                    if(isset($allowed_data['other_title']) and $allowed_data['other_title']!=''){
                        if(!$this->exhibitorv1_model->add_exh_other_info($allowed_data['other_title'],$allowed_data['fair_code'],$exhibitor_id,'other title')){
                            $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while updating the exhibitor other mobile. ',
                        ],RestController::HTTP_INTERNAL_ERROR,false);
                        }
                    }

                    // FOR CREATE REFERENCE ID - e_dtcp_id
                    if(!$this->exhibitorv1_model->add_exh_reference_id($allowed_data,$exhibitor_id)){
                        $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while updating the exhibitor top countries. ',
                        ],RestController::HTTP_INTERNAL_ERROR,false);
                    }


                    // FOR IFEX FACTORY ADDRESS -  F for factory addr_type
                    if(!$this->exhibitorv1_model->add_factory_address($allowed_data,$exhibitor_id,'F')){
                        $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while updating the exhibitor top countries. ',
                        ],RestController::HTTP_INTERNAL_ERROR,false);
                    }

                    // FOR IFEX REPRESENTATIVE
                    if(!$this->exhibitorv1_model->add_exh_representative($allowed_data,$exhibitor_id)){
                        $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while updating the exhibitor top countries. ',
                        ],RestController::HTTP_INTERNAL_ERROR,false);
                    }

                    // FOR IFEX FOOD SAFETY CERTIFICATIONS
                    if(isset($allowed_data['certification']) AND $allowed_data['certification']!=''){
                        if(!$this->exhibitorv1_model->add_exh_certification($allowed_data,$exhibitor_id,)){
                            $this->response([
                                'status'=>'failure',
                                'message'=>'An unexpected error occurred while updating the exhibitor certification. ',
                            ],RestController::HTTP_INTERNAL_ERROR,false);
                        }
                    }

                    // check for top  3 current export market - multi
                    if(isset($allowed_data['top_countries']) AND $allowed_data['top_countries']!=''){
                        $allowed_data['export_market'] = $allowed_data['top_countries'];
                        if(!$this->exhibitorv1_model->add_exh_top_countries($allowed_data,$exhibitor_id)){
                            $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while updating the exhibitor top countries. ',
                        ],RestController::HTTP_INTERNAL_ERROR,false);
                        }
                    }

                    // check for top 3 target countries for export  - multi
                    if(isset($allowed_data['target_countries']) AND $allowed_data['target_countries']!=''){
                        if(!$this->exhibitorv1_model->add_exh_target_countries($allowed_data,$exhibitor_id)){
                            $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while updating the exhibitor top countries. ',
                        ],RestController::HTTP_INTERNAL_ERROR,false);
                        }
                    }

                    // check for Products data - multi
                    if(isset($allowed_data['product_sub_category']) AND $allowed_data['product_sub_category']!=''){
                        if(!$this->exhibitorv1_model->add_exh_products($allowed_data,$exhibitor_id)){
                            $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while updating the exhibitor products. ',
                        ],RestController::HTTP_INTERNAL_ERROR,false);
                        }
                    }

                    //CREATE check for major product data - multi
                    if(isset($allowed_data['products_services']) AND $allowed_data['products_services']!=''){
                        if(!$this->exhibitorv1_model->add_exh_create_services($allowed_data,$exhibitor_id)){
                            $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while updating the buyer products and services. ',
                            ],RestController::HTTP_INTERNAL_ERROR,false);
                        }
                    }

                    // for CREATE major_expertise  - single
                    if(isset($allowed_data['major_expertise']) AND $allowed_data['major_expertise']!=''){
                        if(!$this->exhibitorv1_model->add_exh_expertise($allowed_data,$exhibitor_id)){
                            $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while updating the exhibitor nature of business. ',
                        ],RestController::HTTP_INTERNAL_ERROR,false);
                        }
                    }

                    // for IFEX business nature  - multi
                    if(isset($allowed_data['nature_of_business']) AND $allowed_data['nature_of_business']!=''){
                        
                        if(!$this->exhibitorv1_model->add_exh_business_nature($allowed_data,$exhibitor_id)){
                            $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while updating the exhibitor nature of business. ',
                        ],RestController::HTTP_INTERNAL_ERROR,false);
                        }
                    }

                    // for IFEX annual sales  - single
                    if(isset($allowed_data['annualsales']) AND $allowed_data['annualsales']!=''){
                        if(!$this->exhibitorv1_model->add_exh_annualsales($allowed_data,$exhibitor_id)){
                            $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while updating the exhibitor nature of business. ',
                        ],RestController::HTTP_INTERNAL_ERROR,false);
                        }
                    }

                    // check for target buyers -  multi
                    if(isset($allowed_data['target_buyers']) AND $allowed_data['target_buyers']!=''){
                        if(!$this->exhibitorv1_model->add_exh_target_buyers($allowed_data,$exhibitor_id)){
                            $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while updating the exhibitor target buyers. ',
                        ],RestController::HTTP_INTERNAL_ERROR,false);
                        }

                    }
                    //CREATE//
                    // for CREATE Exhibitor_category / Industry_representation  - multi
                    if(isset($allowed_data['exhibitor_category']) AND $allowed_data['exhibitor_category']!=''){
                        // MULTI
                        // if(!$this->exhibitorv1_model->add_exh_category($allowed_data,$exhibitor_id)){
                        // SINGLE
                        if(!$this->exhibitorv1_model->add_exh_industry_rep($allowed_data,$exhibitor_id)){
                            $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while updating the exhibitor nature of business. ',
                        ],RestController::HTTP_INTERNAL_ERROR,false);
                        }
                    }
                    $this->set_response([
                        'status'=>'success',
                        'id'=>$exhibitor_id,
                        'message'=>'Exhibitor record created'
                    ],RestController::HTTP_CREATED);
                            
                }
            }else{
                // FORM VALIDATION ERROR NOTIF
                $this->set_response([
                    'status'=>'failure',
                    'timestamp'=>date('Y-m-d H:i:s'),
                    'method'=>'POST',
                    'endpoint'=>base_url().$endpoint,
                    // 'message'=> '',
                    'errors'=>[
                            'code'=>RestController::HTTP_BAD_REQUEST,
                            'text'=>$this->form_validation->get_errors_as_array(),
                            ],
                        ],RestController::HTTP_BAD_REQUEST);
            }
        }else{
            $data = $this->post();
            // echo 'duplicate email';exit();
            $this->exhibitors_patch($data,$data['co_email']);
        }


    }//END EXHIBITOR_POST


//===============================================
//EXHIBITOR UPDATE
    public function exhibitors_patch($data=null,$identity=null){
        $user = $this->_hasAccess('EXH',3);
        if($this->get('id')){
            $this->set_response([
                'status'=>'success',
                'message'=>'Sorry, this service is not yet available'
            ],RestController::HTTP_OK);
        }
        elseif($this->get('email')){
            // echo 1;exit();
            $data = $this->patch();
            $this->updateExhByEmail($data,urldecode($this->get( 'email' )));
        }elseif(isset($data) AND isset($identity)){
            // echo 2;exit();
            $this->updateExhByEmail($data,urldecode($identity));
        }
        else{
            $this->response([
                    'status'=>'failure',
                    'timestamp'=>date('Y-m-d H:i:s'),
                    'method'=>'PATCH',
                    // 'endpoint'=>base_url().$endpoint,
                    'errors'=>[
                            'code'=>RestController::HTTP_CONFLICT,
                            'message'=>'Invalid request',
                            // 'hints'=>'hints to developer for potential issues',
                            // 'info'=>'link to webpage for manual regarding error'
                            ],
                        ],RestController::HTTP_BAD_REQUEST);
        }
    }
//===============================================
//===============================================
//Update Exhibitor by email
    public function updateExhByEmail($data,$email){
        $sector_code = $this->appConfig['sector_code'];
        $endpoint = ($this->patch()) ? 'v1/exhibitors/email/{email}' : base_url().$this->router->fetch_class().'/'.$this->router->fetch_method().'/';

        $exhibitor = $this->apiv1_model->get_record($email,'exhibitor');

        $get_dtcp_faircode = function($exhibitor_id){
                        return ($this->exhibitorDB->order_by('refno','DESC')->get_where('e_attendance',array('ff_code'=>$exhibitor_id,'fair_code LIKE'=>'%'.$this->appConfig['web'].'%'))->row()->fair_code)??$this->appConfig['current_fair_code'];};

        if(isset($exhibitor['ff_code'])){
            $exhibitor_id = $exhibitor['ff_code'];
            $prep_data = remove_unallowed_fields($data,$this->form_validation->get_field_names('exhibitors_patch'));
            if(isset($prep_data['webpage']) AND strpos($prep_data['webpage'],'|')){
                list($prep_data['webpage'],$prep_data['other_webpage']) = $this->_breakMultiValue($prep_data['webpage']);
            }
            if(isset($prep_data['title']) AND strpos($prep_data['title'],'|')){
                list($prep_data['title'],$prep_data['other_title']) = $this->_breakMultiValue($prep_data['title']);
            }
            $additional_data=array();
            $allowed_data = (count($additional_data) > 0 ? array_merge($prep_data,$additional_data) : $prep_data);
            // SPECIFY fair_code
            $allowed_data['fair_code'] = (isset($data['fair_code']) AND $data['fair_code'] != '') ? $data['fair_code'] : $get_dtcp_faircode($exhibitor_id);

            $this->form_validation->set_data($allowed_data);
            if($this->form_validation->run('exhibitors_patch')!=false){
                //SETUP DATA ARRAY FOR UPDATING contact profile, attendance, and other tables
                $doc = array();
                //FOR IFEX DOCS
                if(isset($allowed_data['sec_dti_doc']) and $allowed_data['sec_dti_doc']!=''){
                    $doc['remarks']='SEC or DTI registration';
                    $doc['url']=$allowed_data['sec_dti_doc'];
                    $this->exhibitorv1_model->add_document_link($doc,$exhibitor_id);
                }
                if(isset($allowed_data['permit_doc']) and $allowed_data['permit_doc']!=''){
                    $doc['remarks']='Mayors permit';
                    $doc['url']=$allowed_data['permit_doc'];
                    $this->exhibitorv1_model->add_document_link($doc,$exhibitor_id);
                }
                if(isset($allowed_data['license_cert_doc']) and $allowed_data['license_cert_doc']!=''){
                    $doc['remarks']='License or certifications';
                    $doc['url']=$allowed_data['license_cert_doc'];
                    $this->exhibitorv1_model->add_document_link($doc,$exhibitor_id);
                }
                if(isset($allowed_data['export_declaration_doc']) and $allowed_data['export_declaration_doc']!=''){
                    $doc['remarks']='Export declarations';
                    $doc['url']=$allowed_data['export_declaration_doc'];
                    $this->exhibitorv1_model->add_document_link($doc,$exhibitor_id);
                }
                if(isset($allowed_data['training_cert_doc']) and $allowed_data['training_cert_doc']!=''){
                    $doc['remarks']='Training Certification';
                    $doc['url']=$allowed_data['training_cert_doc'];
                    $this->exhibitorv1_model->add_document_link($doc,$exhibitor_id);
                }
                if(isset($allowed_data['endorse_letter_doc']) and $allowed_data['endorse_letter_doc']!=''){
                    $doc['remarks']='Endorsement Letter';
                    $doc['url']=$allowed_data['endorse_letter_doc'];
                    $this->exhibitorv1_model->add_document_link($doc,$exhibitor_id);
                }
                //CREATE DOCS
                if(isset($allowed_data['portfolio_doc']) and $allowed_data['portfolio_doc']!=''){
                    $doc['remarks'] = 'Sample Works';
                    $doc['url'] = $allowed_data['portfolio_doc'];
                    $this->exhibitorv1_model->add_document_link($doc,$exhibitor_id);
                }
                if(isset($allowed_data['business_permit_doc']) and $allowed_data['business_permit_doc']!=''){
                    $doc['remarks'] = 'Business Permit / Identification';
                    $doc['url'] = $allowed_data['business_permit_doc'];
                    $this->exhibitorv1_model->add_document_link($doc,$exhibitor_id);
                }
                if(isset($allowed_data['gov_id_doc']) and $allowed_data['gov_id_doc']!=''){
                    $doc['remarks'] = 'Any government-issued ID (for individuals) or valid Business Permit (for businesses/companies)';
                    $doc['url'] = $allowed_data['gov_id_doc'];
                    $this->exhibitorv1_model->add_document_link($doc,$exhibitor_id);
                }
                if(isset($allowed_data['reg_cert_doc']) and $allowed_data['reg_cert_doc']!=''){
                    $doc['remarks'] = 'Certificate of Registration';
                    $doc['url'] = $allowed_data['reg_cert_doc'];
                    $this->exhibitorv1_model->add_document_link($doc,$exhibitor_id);
                }

                // FOR MULTI ADDITIONAL EMAILS - CREATE - e_other_info
                if(isset($allowed_data['other_emails']) and $allowed_data['other_emails']!=''){
                    if(!$this->exhibitorv1_model->add_exh_other_info($allowed_data['other_emails'],$allowed_data['fair_code'],$exhibitor_id,'email')){
                        $this->response([
                        'status'=>'failure',
                        'message'=>'An unexpected error occurred while updating the exhibitor other emails. ',
                    ],RestController::HTTP_INTERNAL_ERROR,false);
                    }
                }

                // FOR MULTI ADDITIONAL mobile - CREATE - e_other_info
                if(isset($allowed_data['other_mobile']) and $allowed_data['other_mobile']!=''){
                    if(!$this->exhibitorv1_model->add_exh_other_info($allowed_data['other_mobile'],$allowed_data['fair_code'],$exhibitor_id,'other mobile')){
                        $this->response([
                        'status'=>'failure',
                        'message'=>'An unexpected error occurred while updating the exhibitor other mobile. ',
                    ],RestController::HTTP_INTERNAL_ERROR,false);
                    }
                }

                // FOR MULTI ADDITIONAL webpage - CREATE - e_other_info
                if(isset($allowed_data['other_webpage']) and $allowed_data['other_webpage']!=''){
                    if(!$this->exhibitorv1_model->add_exh_other_info($allowed_data['other_webpage'],$allowed_data['fair_code'],$exhibitor_id,'other webpage')){
                        $this->response([
                        'status'=>'failure',
                        'message'=>'An unexpected error occurred while updating the exhibitor other mobile. ',
                    ],RestController::HTTP_INTERNAL_ERROR,false);
                    }
                }

                // FOR MULTI ADDITIONAL title(position) - CREATE - e_other_info
                if(isset($allowed_data['other_title']) and $allowed_data['other_title']!=''){
                    if(!$this->exhibitorv1_model->add_exh_other_info($allowed_data['other_title'],$allowed_data['fair_code'],$exhibitor_id,'other title')){
                        $this->response([
                        'status'=>'failure',
                        'message'=>'An unexpected error occurred while updating the exhibitor other mobile. ',
                    ],RestController::HTTP_INTERNAL_ERROR,false);
                    }
                }

                // for CREATE Exhibitor_category / Industry_representation  - multi
                if(isset($allowed_data['exhibitor_category']) AND $allowed_data['exhibitor_category']!=''){
                    // MULTI
                    // if(!$this->exhibitorv1_model->add_exh_category($allowed_data,$exhibitor_id)){
                    // SINGLE
                    if(!$this->exhibitorv1_model->add_exh_industry_rep($allowed_data,$exhibitor_id)){
                        $this->response([
                        'status'=>'failure',
                        'message'=>'An unexpected error occurred while updating the exhibitor nature of business. ',
                    ],RestController::HTTP_INTERNAL_ERROR,false);
                    }
                }

                // FOR IFEX FACTORY ADDRESS -  F for factory addr_type
                if(!$this->exhibitorv1_model->add_factory_address($allowed_data,$exhibitor_id,'F')){
                    $this->response([
                        'status'=>'failure',
                        'message'=>'An unexpected error occurred while updating the exhibitor top countries. ',
                    ],RestController::HTTP_INTERNAL_ERROR,false);
                }
                
                //FOR IFEX NATURE OF BUSINESS / BUSINESS OWNERSHIP
                if(isset($allowed_data['organization_type']) and $allowed_data['organization_type']!=''){
                    $allowed_data['business_ownership'] = $allowed_data['organization_type'];
                }

                // FOR IFEX REPRESENTATIVE
                if(!$this->exhibitorv1_model->add_exh_representative($allowed_data,$exhibitor_id)){
                    $this->response([
                        'status'=>'failure',
                        'message'=>'An unexpected error occurred while updating the exhibitor top countries. ',
                    ],RestController::HTTP_INTERNAL_ERROR,false);
                }
                // FOR IFEX FOOD SAFETY CERTIFICATIONS
                if(isset($allowed_data['certification']) AND $allowed_data['certification']!=''){
                    if(!$this->exhibitorv1_model->add_exh_certification($allowed_data,$exhibitor_id,)){
                        $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while updating the exhibitor certification. ',
                        ],RestController::HTTP_INTERNAL_ERROR,false);
                    }
                }
                // check for top  3 current export market - multi
                if(isset($allowed_data['export_market']) AND $allowed_data['export_market']!=''){
                    if(!$this->exhibitorv1_model->add_exh_top_countries($allowed_data,$exhibitor_id)){
                        $this->response([
                        'status'=>'failure',
                        'message'=>'An unexpected error occurred while updating the exhibitor top countries. ',
                    ],RestController::HTTP_INTERNAL_ERROR,false);
                    }
                }

                // check for top 3 target countries for export  - multi
                if(isset($allowed_data['target_countries']) AND $allowed_data['target_countries']!=''){
                    if(!$this->exhibitorv1_model->add_exh_target_countries($allowed_data,$exhibitor_id)){
                        $this->response([
                        'status'=>'failure',
                        'message'=>'An unexpected error occurred while updating the exhibitor top countries. ',
                    ],RestController::HTTP_INTERNAL_ERROR,false);
                    }
                }

                // check for Products data - multi
                if(isset($allowed_data['product_sub_category']) AND $allowed_data['product_sub_category']!=''){
                    if(!$this->exhibitorv1_model->add_exh_products($allowed_data,$exhibitor_id)){
                        $this->response([
                        'status'=>'failure',
                        'message'=>'An unexpected error occurred while updating the exhibitor products. ',
                    ],RestController::HTTP_INTERNAL_ERROR,false);
                    }
                }

                // for IFEX business nature  - multi
                if(isset($allowed_data['nature_of_business']) AND $allowed_data['nature_of_business']!=''){
                    if(!$this->exhibitorv1_model->add_exh_business_nature($allowed_data,$exhibitor_id)){
                        $this->response([
                        'status'=>'failure',
                        'message'=>'An unexpected error occurred while updating the exhibitor nature of business. ',
                    ],RestController::HTTP_INTERNAL_ERROR,false);
                    }
                }

                // for IFEX annual sales  - single
                if(isset($allowed_data['annualsales']) AND $allowed_data['annualsales']!=''){
                    if(!$this->exhibitorv1_model->add_exh_annualsales($allowed_data['annualsales'],$exhibitor_id)){
                        $this->response([
                        'status'=>'failure',
                        'message'=>'An unexpected error occurred while updating the exhibitor nature of business. ',
                    ],RestController::HTTP_INTERNAL_ERROR,false);
                    }
                }

                // for CREATE major_expertise  - single
                if(isset($allowed_data['major_expertise']) AND $allowed_data['major_expertise']!=''){
                    if(!$this->exhibitorv1_model->add_exh_expertise($allowed_data,$exhibitor_id)){
                        $this->response([
                        'status'=>'failure',
                        'message'=>'An unexpected error occurred while updating the exhibitor nature of business. ',
                    ],RestController::HTTP_INTERNAL_ERROR,false);
                    }
                }

                //CREATE check for major product data - multi - e_genproducts
                if(isset($allowed_data['products_services']) AND $allowed_data['products_services']!=''){
                    if(!$this->exhibitorv1_model->add_exh_create_services($allowed_data,$exhibitor_id)){
                        $this->response([
                        'status'=>'failure',
                        'message'=>'An unexpected error occurred while updating the buyer products and services. ',
                        ],RestController::HTTP_INTERNAL_ERROR,false);
                    }
                }

                // FOR CREATE REFERENCE ID - e_dtcp_id
                if(isset($allowed_data['reference_id']) AND $allowed_data['reference_id']!=''){
                    if(!$this->exhibitorv1_model->add_exh_reference_id($allowed_data,$exhibitor_id)){
                        $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while updating the exhibitor top countries. ',
                        ],RestController::HTTP_INTERNAL_ERROR,false);
                    }
                }

                // check for target buyers -  multi
                if(isset($allowed_data['target_buyers']) AND $allowed_data['target_buyers']!=''){
                    if(!$this->exhibitorv1_model->add_exh_target_buyers($allowed_data['target_buyers'],$exhibitor_id)){
                        $this->response([
                        'status'=>'failure',
                        'message'=>'An unexpected error occurred while updating the exhibitor target buyers. ',
                    ],RestController::HTTP_INTERNAL_ERROR,false);
                    }
                }
                if(isset($allowed_data['digital_participation']) OR isset($allowed_data['physical_participation'])){
                    $digital_part = $allowed_data['digital_participation']??'No';
                    $physical_part = $allowed_data['physical_participation']??'No';
                    if(strtolower($digital_part)=='yes' AND strtolower($physical_part)=='yes'){
                        $allowed_data['exhibit_participation'] = 'Physical Trade Show + Digital Platform';
                    }else{
                        if(strtolower($digital_part)=='yes'){
                            $allowed_data['exhibit_participation'] = 'Digital Platform';
                        }elseif(strtolower($physical_part)=='yes'){
                            $allowed_data['exhibit_participation'] = 'Physical Trade Show';
                        }else{
                            $allowed_data['exhibit_participation'] = '';
                        }
                    }
                }
                // add to e_attendance
                if(!$this->exhibitorv1_model->check_faircode($email,$allowed_data['fair_code'])){
                    //no current attendance -- add a participation
                    $allowed_data['ff_code']=$exhibitor_id;
                    $attendance_data = remove_unallowed_fields($allowed_data,$this->allowedData['e_attendance']);
                    $prep_data = $this->exhibitorv1_model->prep_e_attendance_data($attendance_data);
                    if(!$this->exhibitorv1_model->add_exh_attendance($prep_data)){
                            $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while adding exhibitor attendance record',
                        ],RestController::HTTP_INTERNAL_ERROR);
                    }    
                }
                else{
                    //update attendance
                    $attendance_data = remove_unallowed_fields($allowed_data,$this->allowedData['e_attendance']);
                    $prep_data = $this->exhibitorv1_model->update_prep_e_attendance_data($attendance_data);
                    if(!$this->exhibitorv1_model->add_exh_attendance($prep_data ,$exhibitor_id)){
                            $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while updating exhibitor attendance record',
                        ],RestController::HTTP_INTERNAL_ERROR);
                    }
                }

                //update the exhibitor Contact
                $contact_profile_data = $this->exhibitorv1_model->prep_e_contact_profile_data($allowed_data);
                // diagnostics($contact_profile_data);exit();
                if(!$this->exhibitorv1_model->add_exh_contact_profile($contact_profile_data,$exhibitor_id)){
                    $this->response([
                        'status'=>'failure',
                        'message'=>'An unexpected error occurred while updating the exhibitor contact',
                    ],RestController::HTTP_INTERNAL_ERROR,false); //500 The server encountered an unexpected error
                }


                //FOR PHYSICAL EVENT===================================
                // if($this->appConfig['event_active']){
                //     if(!isset($data['add_event']) OR $data['add_event']!=FALSE){
                //         $exh_data = $data;
                //         $exh_data['fair_code'] = $this->appConfig['regstat_fair_code'];
                //         $exh_data['add_event'] = FALSE;

                //         $this->updateExhByEmail($exh_data,$email);
                //     }
                // }
                //========================================================


                $this->response([
                    'status'=>'success',
                    'message'=>'Exhibitor Record Update Successful',
                ],RestController::HTTP_OK); // 200 The request has succeeded

            }
            else{
                //Form_validation error notification
                $this->set_response([
                    'status'=>'failure',
                    'timestamp'=>date('Y-m-d H:i:s'),
                    'method'=>'PATCH',
                    'endpoint'=>base_url().$endpoint,
                    // 'message'=> 'User could not be found',
                    'errors'=>[
                            'code'=>RestController::HTTP_BAD_REQUEST,
                            // 'text'=>$this->form_validation->get_errors_as_array(),
                            'text'=>'validation form error',
                            // 'hints'=>'hints to developer for potential issues',
                            // 'info'=>'link to webpage for manual regarding error'
                            ],
                        ],RestController::HTTP_BAD_REQUEST,false);
            }
        }else{
            $this->response([
            'status'=>'failure',
            'message'=>'Cannot update, record not found',
        ],RestController::HTTP_NOT_FOUND,false);

        }   
    }
//===============================================

//===============================================
//===============================================
//UPDATE EXHIBITOR VALIDATION STATUS
    public function validate_exhibitor_patch(){
        $user = $this->_hasAccess('EXH',3);
        $endpoint = 'v1/validate_exhibitor/email/{email}';
        $get_dtcp_faircode = function($exhibitor_id){
            return ($this->exhibitorDB->order_by('refno','DESC')->get_where('e_attendance',array('ff_code'=>$exhibitor_id,'fair_code LIKE'=>'%'.$this->appConfig['web'].'%'))->row()->fair_code)??'';};
        $participationExist = function($exhibitor_id,$fair_code){
            return ($this->exhibitorDB->get_where('e_attendance',array('ff_code'=>$exhibitor_id,'fair_code'=>$fair_code))->num_rows()>0) ? true : false;};

        $data =  $this->patch();
        $data['email'] = $this->get('email');
        // $data['email']='dfsjb6289jdfs@g.com';
        // diagnostics($data);
        // exit();
        if($data['email']){
            $this->form_validation->reset_validation();
            $this->form_validation->set_data($data);
            if($this->form_validation->run('validate_exhibitor_patch')!=false){
                $result = $this->_update_validation($data);

                //FOR PHYSICAL EVENT===================================
                if($result['status']=='success'){
                    if($this->appConfig['event_active']){
                        if(!isset($data['add_event']) OR $data['add_event']!=FALSE){
                            $exh_data = $data;
                            $exh_data['fair_code'] = $this->appConfig['regstat_fair_code'];
                            $exh_data['add_event'] = FALSE;
                            $result = $this->_update_validation($exh_data);
                        }
                    }
                }
                //FOR PHYSICAL EVENT===================================

                if($result['status']=='success'){
                    $this->response([
                        'status'=>'success',
                        'message'=>$result['msg'],
                        // 'message'=>'Exhibitor validation status updated',
                    ],RestController::HTTP_OK); // 200 The request has succeeded
                }
                if($result['status']=='failure'){
                    $this->response([
                        'status' => $result['status'],
                        'timestamp' => date('Y-m-d H:i:s'),
                        'method' => 'PATCH',
                        'endpoint' => base_url().$endpoint,
                        'errors' => [
                                'code' => $result['http_status_code'], //400 The requested resource could not be found
                                'message' => $result['msg'],
                                ],
                            ],$result['http_status_code']);

                }
                // print_r($result);exit();
            }

        }else{
            $this->response([
            'status'=>'failure',
            'timestamp'=>date('Y-m-d H:i:s'),
            'method'=>'PATCH',
            'endpoint'=>base_url().$endpoint,
            'errors'=>[
                    'code'=>RestController::HTTP_BAD_REQUEST,
                    'text'=>'Invalid request, check endpoint requirements',
                    ],
                ],RestController::HTTP_BAD_REQUEST);

        }
    }


//===============================================
//UPDATE EXHIBITOR VALIDATION STATUS
    private function _update_validation($data,$fair_code=NULL){
        $endpoint = 'v1/validate_exhibitor/email/{email}';

        //to get the validation format word equivalent
        $get_validation_status = function($x,$y){
            $x = strtolower($x);
            if(array_key_exists($x,$y)){ return $y[$x]; };};
        $validation_stat_value=array(
            'deleted'=>'Deleted',
            'approved'=>'Approved',
            'pending'=>'Pending',
            'incomplete'=>'Incomplete',
            'disapproved'=>'Disapproved',
            'deactivated'=>'Deactivated',
            'reviewed'=>'Reviewed',
            'waitlisted'=>'Waitlisted',
        );

        $get_dtcp_faircode = function($exhibitor_id){
            return ($this->exhibitorDB->order_by('refno','DESC')->get_where('e_attendance',array('ff_code'=>$exhibitor_id,'fair_code LIKE'=>'%'.$this->appConfig['web'].'%'))->row()->fair_code)??'';};
        $participationExist = function($exhibitor_id,$fair_code){
            return ($this->exhibitorDB->get_where('e_attendance',array('ff_code'=>$exhibitor_id,'fair_code'=>$fair_code))->num_rows()>0) ? true : false;};
        //$dtcpFair = $this->appConfig['web']; //IFEXDTCP
        //$current_fair_code = $this->appConfig['current_fair_code'];//IFEXDTCP{year}

        $exhibitor = $this->exhibitorv1_model->get_exhibitor_by_email2(urldecode($data['email']));

        //CHECK VALIDATION VALUE IF VALID
        $data['validation_status'] = $get_validation_status(strtolower($data['validation_status']),$validation_stat_value)?:'Invalid status';
        if($data['validation_status']=='Invalid status'){
            return ['status'=>'failure','msg'=>'Validation Status is Invalid.','http_status_code'=>RestController::HTTP_BAD_REQUEST,];
        }

        if(isset($exhibitor['ff_code'])){
            $allowed_data = remove_unallowed_fields($data,$this->form_validation->get_field_names('validate_exhibitor_patch'));
            $allowed_data['fair_code'] = $allowed_data['fair_code']?? $get_dtcp_faircode($exhibitor['ff_code']);
            if($participationExist($exhibitor['ff_code'],$allowed_data['fair_code'])){
                $updated = $this->exhibitorv1_model->validate_exhibitor($allowed_data,$exhibitor['ff_code']);
                if($updated){
                    return [
                        'status'=>'success',
                        'msg'=>'Exhibitor validation status updated to '.$data['validation_status'],
                        'http_status_code'=>RestController::HTTP_OK,];
                }else{
                    return ['status'=>'failure','msg'=>'An unexpected error occurred while validating the exhibitor.','http_status_code'=>RestController::HTTP_INTERNAL_ERROR,];
                }
            }else{
                return ['status'=>'failure','msg'=>"No record of ".$fair_code." fair code found",'http_status_code'=>RestController::HTTP_NOT_FOUND,];
            }
        }else{
            return ['status'=>'failure','msg'=>'No record were found','http_status_code'=>RestController::HTTP_NOT_FOUND,];
        }
    }



//==================PRIVATE======================
// _get all buyers
    private function _all_exhibitors($sector_code,$customSet=null){
        function getArr($row,$data,$field,$rawFormat=null){
            $key = array_search($row, array_column($data, 'ff_code'));
            if($key!=false){
                return ($rawFormat==null) ? explodeToArr2('|',$data[$key][$field]) : $data[$key][$field];
            }else{
                return false;
            }
        }
        function getItem($row,$data,$field){
            $key = array_search($row, array_column($data, 'ff_code'));
            return ($key===false)? '':$data[$key][$field];
        }
        function getRecord($value,$data,$field){
            $key = array_search($value,array_column($data,$field));
            return $key ? $data[$key] : '';
        }
        // not yet used
        function getRecords($value,$data,$field){
            $keys = array_keys(array_column($data,$field),$value);
            // return $data[$key];
        }
        function validation_no($status){
            if($status=='PENDING TRADE'){
                return 0;
            }elseif($status=='APPROVED TRADE'){
                return 1;
            }elseif($status=='INCOMPLETE TRADE'){
                return 2;
            }elseif($status=='DISAPPROVED TRADE'){
                return 3;
            }
            else{
                return null;
            }
        };

        $param = getUrlParam($customSet);
        $format = $param['raw']??null;
        $param['table'] = "e_contact_profile a INNER JOIN e_attendance b USING(ff_code) LEFT JOIN e_representative c ON a.ff_code=c.ff_code";
        $param['stakeholder'] = 'exhibitor';
        // $mysqls = $this->my_rest_lib->generate_exhibitor_query($param);
        $mysqls = $this->my_rest_lib->generate_query($sector_code,$param);

        // diagnostics($mysqls);exit();
        // 
        $exhibitors = $this->exhibitorv1_model->runQuery(stripslashes($mysqls['query']));
        $filtered_count = $this->exhibitorv1_model->queryCount($mysqls['query_filter_count']);
        $total = $this->exhibitorv1_model->queryCount($mysqls['query_count']);


        // $exhibitors = $this->exhibitorv1_model->getContact($mysqls['query']);
        // $total =  $this->exhibitorv1_model->total_contact_record_count($mysqls['query_count']);
        $majorProducts = $this->exhibitorv1_model->getMajorProduct();
        $minorProducts = $this->exhibitorv1_model->getMinorProduct();
        $tradeExperience = $this->exhibitorv1_model->getTradeExperience();
        $exportCountries = $this->exhibitorv1_model->getExportCountries();
        $industryRepresentation = $this->exhibitorv1_model->getIndustryRepresentation();
        $market = $this->exhibitorv1_model->getMarketSegment();
        $targetBuyers = $this->exhibitorv1_model->getTargetBuyers();

        if($exhibitors){
            foreach($exhibitors as $row){
                // $filter = array('ff_code' =>$row['ff_code'], 'fair_code' => $row['fair_code']);
                $newArr[]=array(
                'ff_code' => $row['ff_code'],
                'fair_code' =>$row['fair_code'],
                'apply_date' =>$row['date_apply'],
                'co_name' => $row['co_name'],
                'password' =>$row['password'],
                'brand_name' => $row['brand_name'],
                'co_email' => $row['co_email'],
                'telephone' => $row['tel_off'],
                'office_address' => $row['add_st'],
                'participation' => $row['fair_stat_app'],
                'editions' => $row['fair_stat_app_date'],
                'co_registered' => $row['foreignlocal'],
                'webpage'     => $row['webpage'],
                'social_media' => array(
                    'facebook' =>  $row['facebook'],
                    'instagram' => $row['instagram'],
                    'twitter' => $row['twitter'],
                    'linkedin' => $row['linkedin'],
                    'others' => $row['social_others'],
                ),
                'primary_contact'=>[
                    'cont_per_fn' => $row['cont_per_fn'],
                    'mi' => $row['mi'],
                    'cont_per_ln' => $row['cont_per_ln'],
                    'title'       => $row['title'],
                    'owner_mobile' =>$row['owner_mobile'],
                    'messaging_app' => explodeToArr(',',$row['messaging_app']),
                    'email' => $row['owner_email'],
                ],
                'secondary_contact'=>[
                    'cont_per_fn' => $row['rep_fname'],
                    'mi' => $row['rep_mi'],
                    'cont_per_ln' => $row['rep_lname'],
                    'title'       => $row['rep_title'],
                    'owner_mobile' => $row['rep_mobile'],
                    'messaging_app' => explodeToArr(',',$row['rep_messaging_app']),
                    'email' => $row['rep_email'],
                ],
                'year_established' => $row['y_estab'],
                'tin' => $row['tin'],
                'affiliation' => $row['membership_assoc'],
                'country'     => $row['country'],
                'continent'   => $row['continent'],
                'company_size' => $row['company_size'],
                'number_of_workers'=> array(
                    'direct_workers' => $row['direct_workers'],
                    'indirect_workers' => $row['indirect_workers'],
                ),
                'business_ownership' => $row['business_ownership'],
                'trade_experience' => getItem($row['ff_code'],$tradeExperience,'tradeExperience'),
                'top_countries_exporting_to' => getArr($row['ff_code'],$exportCountries,'exportCountries'),
                'business_category'=> getItem($row['ff_code'],$industryRepresentation,'industryRepresentation'),
                'market_segment' => getArr($row['ff_code'],$market,'marketSegment'),

                'category' => searchFromArray(['ff_code' =>$row['ff_code'], 'fair_code' => $row['fair_code']],$majorProducts,'majorproduct'),
                'sub_category' => searchFromArray(['ff_code' =>$row['ff_code'], 'fair_code' => $row['fair_code']],$minorProducts,'minorproduct'),

                'target_buyers' => getArr($row['ff_code'],$targetBuyers,'targetBuyers'),
                'nature_of_participation' => $row['exhibit_participation'],
                'fair_stat_app' =>$row['fair_stat_app'],
                'fair_stat_app_date' => $row['fair_stat_app_date'],
                'fair_stat_part' => $row['fair_stat_part'],
                );
            }
            $exhibitor_detail = array(
                'data'           => $newArr,
                'total'          => $total['count'],
                'total_filtered' => $filtered_count['count'],
                'param'          => $param,
                'query'          => $mysqls['query'],
                'query_total'    => $mysqls['query_count'],
                'query_filtered' => $mysqls['query_filter_count']);
            return $exhibitor_detail;
        }else{
            return false;
        }
    }


//===============================================
// _get exhibitor by
    private function _exhibitorBy($identity,$customSet=null){
        function getArr($row,$data,$field){
            $key = array_search($row, array_column($data, 'rep_code'));
            return ($key===false)? '':explodeToArr('|',$data[$key][$field]);
                // return explodeToArr('|',$data[$key][$field]);
        }
        function getItem($row,$data,$field){
            $key = array_search($row, array_column($data, 'rep_code'));
            return ($key===false)? '':$data[$key][$field];
        }
        function validation_no($status){
            if($status=='PENDING TRADE'){
                return '0';
            }elseif($status=='APPROVED TRADE'){
                return '1';
            }elseif($status=='INCOMPLETE TRADE'){
                return '2';
            }elseif($status=='DISAPPROVED TRADE'){
                return '3';
            }else{
                return null;
            }
        };
        $param = getUrlParam($customSet);
        $mysqls = $this->my_rest_lib->generate_sql($param);
        if($identity=='email'){
            $exhibitor = $this->buyerv1_model->get_exhibitor_by($identity,$this->get('email'));
        }
        if($identity=='id'){
            $exhibitor = $this->buyerv1_model->get_exhibitor_by($identity,$this->get('id'));
        }
        if(!$exhibitor){
            return false;
        }

        $reason = $this->exhibitorv1_model->getReason();
        $informthru = $this->exhibitorv1_model->getInformthru();
        $jobfunction = $this->exhibitorv1_model->getJobfunction();
        $nature_of_business = $this->exhibitorv1_model->getRepresentation();
        $product_interest = $this->exhibitorv1_model->getProductInterest();
        $market = $this->exhibitorv1_model->getMarketSegment();
        $annualSales = $this->exhibitorv1_model->getAnnualsales();
        $majorProducts = $this->exhibitorv1_model->getMajorProduct();
        $minorProducts = $this->exhibitorv1_model->getMinorProduct();

        $newArr[]=array(
            'fameplus_id' => $exhibitor['fameplus_id'],
            // 'rep_code'    => $row['rep_code'],
            'email'       => $exhibitor['email'],
            'cont_per_fn' => $exhibitor['cont_per_fn'],
            'cont_per_ln' => $exhibitor['cont_per_ln'],
            'country'     => $exhibitor['country'],
            'continent'   => $exhibitor['continent'],
            'company'     => $exhibitor['co_name'],
            'title'       => $exhibitor['title'],
            'webpage'     => $exhibitor['webpage'],
            'add_st'      => $exhibitor['add_st'],
            'mobile'      => $exhibitor['mobile'],
            'validated'   => $exhibitor['validation_status'],
            'visitor_type'   => $buyer['visitor_type'],
            'job_function'=> getItem($exhibitor['rep_code'],$jobfunction,'jobfunction'),
            'nature_of_business'=> getItem($exhibitor['rep_code'],$nature_of_business,'representation'),
            'market_segment'=> getArr($exhibitor['rep_code'],$market,'marketSegment'),
            'annual_sales'=> getItem($exhibitor['rep_code'],$annualSales,'annualsales'),
            'supplier_info'=> explodeToArr(',',$exhibitor['supplier_info']),
            'category'=> getArr($exhibitor['rep_code'],$majorProducts,'majorproduct'),
            'sub_category'=> getArr($exhibitor['rep_code'],$minorProducts,'minorproduct'),
            'product_interest'=> getArr($exhibitor['rep_code'],$product_interest,'product_interest'),
            'reason'=> getArr($exhibitor['rep_code'],$reason,'reason'),
            'informthru'=> getArr($exhibitor['rep_code'],$informthru,'informthru'),
        );
        return $newArr;
        }
//===============================================
//GET CITEM Exhibitor
    public function ctm_exhibitors_get(){
        $endpoint = 'v1/buyers/';
        $customSet = array('fields','offset','limit','q');
        //check if retrieve all or single buyer record
        if($this->get('id')){ //buyer by id
            $this->response([
                'status'=>'success',
                'message'=>'Sorry, this service is not yet available'
            ],RestController::HTTP_OK);

        }elseif($this->get('email')){   //buyer by email
            $result = $this->_ctmExhibitorBy('email',$customSet);
            if($result){
                $this->response([
                    'status'=>'success','data'=>$result,],RestController::HTTP_OK);
            }else{
                $this->response([
                    'status'=>'success','message'=>'no record found for '.$this->get('email'),'data'=>[],],RestController::HTTP_OK);
            }
        }else{//list all buyers
            $this->response([
                'status'=>'success',
                'message'=>'Sorry, this service is not yet available'
            ],RestController::HTTP_OK);
            exit();
            $buyers_detail = $this->_all_buyers($customSet);
            $response_data = function($newArr,$param,$total){
                if(array_key_exists('limit', $param)){
                    return array('status'=>'success',
                        'paging'=>['limit'=>$_GET['limit'],
                        'offset'=>isset($_GET['offset']) ? $_GET['offset'] : NULL,
                        'total_records' =>$total['count']],
                        'data'=> $newArr,);
                }
                else{
                    return array('status'=>'success','paging'=>['limit'=>0,'offset'=>0,
                        'total_records' =>$total['count']],'data'=> $newArr);
                }
            };
            if($buyers_detail){
                $this->response($response_data($buyers_detail['data'],$buyers_detail['param'],$buyers_detail['total']),RestController::HTTP_OK);
            }else{
               // Set the response and exit
                $this->set_response([
                'status'=> 'success',
                'timestamp'=>date('Y-m-d H:i:s'),
                'method'=>'GET',
                'endpoint'=>base_url().$endpoint,
                'message'=>'No records',
                'errors'=>[
                        // 'code'=>RestController::HTTP_OK,
                        // 'message'=>'No records',
                    //  'description'=>'["Please check that user has provided the non null value for 'name'"]',
                    //  'link'=>'link to webpage for manual regarding error'
                     ],],RestController::HTTP_OK);
            }
        }
    }

//===============================================
// _get buyer by
    private function _ctmExhibitorBy($identity,$customSet=null){
        function getArr($row,$data,$field){
            $key = array_search($row, array_column($data, 'rep_code'));
            return ($key===false)? '':explodeToArr('|',$data[$key][$field]);
                // return explodeToArr('|',$data[$key][$field]);
        }
        function getItem($row,$data,$field){
            $key = array_search($row, array_column($data, 'rep_code'));
            return ($key===false)? '':$data[$key][$field];
        }
        // $identity = $this->get($identity);
        $param = getUrlParam($customSet);
        $mysqls = $this->my_rest_lib->generate_ctmexhibitor_sql($param);
        if($identity=='email'){
            $exhibitor = $this->exhibitorv1_model->get_ctm_exhibitor_by($identity,urldecode($this->get('email')));
        }
        if($identity=='id'){
            $exhibitor = $this->exhibitorv1_model->get_ctm_exhibitor_by_email($identity,$this->get('id'));
        }
        if(!$exhibitor){
            return false;
        }

        // $reason = $this->buyerv1_model->getReason();
        // $informthru = $this->buyerv1_model->getInformthru();
        // $jobfunction = $this->buyerv1_model->getJobfunction();
        // $nature_of_business = $this->buyerv1_model->getRepresentation();
        // $product_interest = $this->buyerv1_model->getProductInterest();
        // $market = $this->buyerv1_model->getMarketSegment();
        // $annualSales = $this->buyerv1_model->getAnnualsales();
        // $majorProducts = $this->buyerv1_model->getMajorProduct();
        // $minorProducts = $this->buyerv1_model->getMinorProduct();

        $newArr[]=array(
            'fameplus_id' => $exhibitor['fameplus_id'],
            'email'       => $exhibitor['co_email'],
            'company'     => $exhibitor['co_name'],
            'cont_per_fn' => $exhibitor['cont_per_fn'],
            'cont_per_ln' => $exhibitor['cont_per_ln'],
            'designation' => $exhibitor['title'],
            'webpage'     => $exhibitor['webpage'],
            'address'     => ['street'=>$exhibitor['add_st'] , 'city'=>$exhibitor['add_city'],'province'=>$exhibitor['province']],
            'country'     => $exhibitor['country'],
            'continent'   => $exhibitor['continent'],
            'region'    => $exhibitor['region'],
            'address' => ['street'=>$exhibitor['add_st'],'city'=>$exhibitor['add_city'],'province'=>$exhibitor['province']],
            'zipcode'=>$exhibitor['zipcode'],
            'contacts'    => ['mobile'=>$exhibitor['co_mobile'],'office'=>$exhibitor['tel_off'],'fax'=>$exhibitor['fax']],
            'social_media' => ['facebook'=>$exhibitor['facebook'],'twitter'=>$exhibitor['twitter'],'instagram'=>$exhibitor['instagram']],  
        );
        return $newArr;
        }
//===============================================



//==============================================================================

//=======================CREATE PHIL SUBSCRIPTION===============================

//==============================================================================
//GET SUBSCRIBERS
    public function subscriptions_get(){
        $user = $this->_hasAccess('SUBSC',1);
        $endpoint = 'v1/subscriptions/';
        $customSet = array('fields','offset','limit','q');

        //check if retrieve all or single buyer record
        if($this->get('id')){ //buyer by id
            $this->response([
                'status'=>'success',
                'message'=>'Sorry, this service is not yet available'
            ],RestController::HTTP_OK);

        }elseif($this->get('email')){   //buyer by email
            $result = $this->_subscriberBy('email',$customSet);
            if($result){
                $this->response([
                    'status'=>'success','data'=>$result,],RestController::HTTP_OK);
            }else{
                $this->response([
                    'status'=>'success','message'=>'no records','data'=>[],],RestController::HTTP_OK);
            }

        }else{//list all buyers
            $buyers_detail = $this->_all_subscriptions($customSet);
            $response_data = function($newArr,$param,$total){
                if(array_key_exists('limit', $param)){
                    return array('status'=>'success',
                        'paging'=>['limit'=>$_GET['limit'],
                        'offset'=>isset($_GET['offset']) ? $_GET['offset'] : NULL,
                        'total_records' =>$total['count']],
                        'data'=> $newArr,);
                }
                else{
                    return array('status'=>'success','paging'=>['limit'=>0,'offset'=>0,
                        'total_records' =>$total['count']],'data'=> $newArr);
                }
            };
            if($buyers_detail){
                $this->response($response_data($buyers_detail['data'],$buyers_detail['param'],$buyers_detail['total']),RestController::HTTP_OK);
            }else{
               // Set the response and exit
                $this->set_response([
                'status'=> 'success',
                'timestamp'=>date('Y-m-d H:i:s'),
                'method'=>'GET',
                'endpoint'=>base_url().$endpoint,
                'message'=>'No records',
                'errors'=>[
                        // 'code'=>RestController::HTTP_OK,
                        // 'message'=>'No records',
                    //  'description'=>'["Please check that user has provided the non null value for 'name'"]',
                    //  'link'=>'link to webpage for manual regarding error'
                     ],],RestController::HTTP_OK);
            }
        }
    }

//===============================================
//ADD SUBSCRIPTIONS
    public function subscriptions_post(){
        $user = $this->_hasAccess('SUBSC',2);
        $this->appConfig = $this->_load_appConfig($user['app_system']);
        $system = $this->appConfig['system'];
        $generic_fair = $this->appConfig['sector_fair_code'];
        $fair_code    = $this->appConfig['current_fair_code'];
        $sector_code  = $this->appConfig['sector_code'];
        $endpoint = 'v1/subscriptions';
        $emailExist = function($x){
            // $buyerDB = $this->load->database('default',TRUE);
            return ($this->subscriptionDB->get_where('v_contact_profile',array('email'=>$x))->num_rows()==1) ? true : false;
        };
        if(!$emailExist($this->post('email'))){
            //remove unknown field and and additional fields
            $allowed_data = remove_unallowed_fields($this->post(),$this->form_validation->get_field_names('subscriptions_post'));
            //validation
            $this->form_validation->set_data($allowed_data);
            if($this->form_validation->run('subscriptions_post')!=false){
                //add required additional data 
                $prep_data = $this->subscriptionv1_model->prepare_add_subscriptions_data($allowed_data);
                //Add subscription to contacts
                $buyer_id = $this->subscriptionv1_model->add_buyer_contact_profile($prep_data);
                if(!$buyer_id){
                    $this->response([
                    'status'=>'failure',
                    'message'=>'An unexpected error occured while trying to subscription record',
                ],RestController::HTTP_INTERNAL_ERROR);
                }
                else{// update contact with barcode and pid
                    if(!$this->subscriptionv1_model->add_barcode_pid($allowed_data,$buyer_id)){
                        $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occured while trying to create barcode and pid',
                        ],RestController::HTTP_INTERNAL_ERROR);
                    }
                    //add to attendance
                    if(!$this->subscriptionv1_model->add_subscription_attendance($allowed_data,$buyer_id)){
                        $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occured while trying to create participation record',
                        ],RestController::HTTP_INTERNAL_ERROR);
                    }
                    // check for product of interest  - multi
                    if(isset($allowed_data['interest']) AND $allowed_data['interest']!=''){
                        if(!$this->subscriptionv1_model->add_subscription_interest($allowed_data['interest'],$buyer_id)){
                            $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while adding the subscribers interest. ',
                            ],RestController::HTTP_INTERNAL_ERROR,false);
                        }
                        if(!$this->subscriptionv1_model->update_valid_email($buyer_id)){
                            $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while updating email validity.',
                            ],RestController::HTTP_INTERNAL_ERROR,false);
                        }
                        if(!$this->subscriptionv1_model->update_attendance_subscription($buyer_id)){
                            $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while updating subscription.',
                            ],RestController::HTTP_INTERNAL_ERROR,false);
                        }
                    }
                    // check for subscribers representation  - multi
                    if(isset($allowed_data['representation']) AND $allowed_data['representation']!=''){
                        if(!$this->subscriptionv1_model->add_subscription_representation($allowed_data['representation'],$buyer_id)){
                            $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while adding subscribers representation. ',
                        ],RestController::HTTP_INTERNAL_ERROR,false);
                        }
                    }
                    if($buyer_id){
                        $this->response([
                            'status'=>'success',
                            'id'=>$buyer_id,
                            'message'=>'record created'
                        ],RestController::HTTP_CREATED); 
                    }
                }
            }
            else{
                //Validation error notification
                $this->response([
                    'status'=>'failure',
                    'timestamp'=>date('Y-m-d H:i:s'),
                    'method'=>'POST',
                    'endpoint'=>base_url().$endpoint,
                    // 'message'=> 'User could not be found',
                    'errors'=>[
                            'code'=>RestController::HTTP_BAD_REQUEST,
                            'text'=>$this->form_validation->get_errors_as_array(),
                            // 'hints'=>'hints to developer for potential issues',
                            // 'info'=>'link to webpage for manual regarding error'
                            ],
                        ],RestController::HTTP_BAD_REQUEST);
            }
        }
        else{
            //Email already exist in database
            //if exist do an update
            $data = $this->post();
            $this->subscriptions_patch($data,$data['email']);
        }
    }
//===============================================
//SUBSCRIPTION UPDATE
    public function subscriptions_patch($data=null,$email=null){
        $user = $this->_hasAccess('SUBSC',3);
        if($this->get( 'id' )){
            $this->set_response([
                'status'=>'success',
                'message'=>'Sorry, this service is not yet available'
            ],RestController::HTTP_OK);
        }
        elseif($this->get( 'email' )){
            $data = $this->patch();
            $this->subscription_updateByEmail($data,urldecode($this->get( 'email' )));
        }elseif(isset($data) AND isset($email)) {
            $this->subscription_updateByEmail($data,urldecode($email));
        }
        else{
            $this->response([
                    'status'=>'failure',
                    'timestamp'=>date('Y-m-d H:i:s'),
                    'method'=>'PATCH',
                    // 'endpoint'=>base_url().$endpoint,
                    'errors'=>[
                            'code'=>RestController::HTTP_CONFLICT,
                            'message'=>'Invalid request',
                            // 'hints'=>'hints to developer for potential issues',
                            // 'info'=>'link to webpage for manual regarding error'
                            ],
                        ],RestController::HTTP_BAD_REQUEST);
        }
    }

//===============================================
//Update by email
    public function subscription_updateByEmail($data,$email){
        $endpoint ='v1/subscriptions/email/{email}';
        $buyer   = $this->subscriptionv1_model->get_buyer_contact_by_email($email);
        if(isset($buyer['rep_code'])){
            $allowed_data = remove_unallowed_fields($data,$this->form_validation->get_field_names('subscriptions_patch'));
            $this->form_validation->set_data($allowed_data);
            if($this->form_validation->run('subscriptions_patch')!=false){
                //check for Products data - multi
                if(isset($allowed_data['interest']) AND $allowed_data['interest']!=''){
                    if(!$this->subscriptionv1_model->add_subscription_interest($allowed_data['interest'],$buyer['rep_code'])){
                        $this->response([
                        'status'=>'failure',
                        'message'=>'An unexpected error occurred while updating the buyer products. ',
                        ],RestController::HTTP_INTERNAL_ERROR,false);
                    }
                    if(!$this->subscriptionv1_model->update_valid_email($buyer['rep_code'])){
                        $this->response([
                        'status'=>'failure',
                        'message'=>'An unexpected error occurred while updating email validity.',
                        ],RestController::HTTP_INTERNAL_ERROR,false);
                    }
                    if(!$this->subscriptionv1_model->update_attendance_subscription($buyer['rep_code'])){
                        $this->response([
                        'status'=>'failure',
                        'message'=>'An unexpected error occurred while updating subscription.',
                        ],RestController::HTTP_INTERNAL_ERROR,false);
                    }
                }
                // check for representation data / nature of business - multi
                if(isset($allowed_data['representation']) AND $allowed_data['representation']!='' AND !empty($allowed_data['representation'])){
                    if(!$this->subscriptionv1_model->add_subscription_representation($allowed_data['representation'],$buyer['rep_code'])){
                        $this->response([
                        'status'=>'failure',
                        'message'=>'An unexpected error occurred while updating the buyers nature of business',
                    ],RestController::HTTP_INTERNAL_ERROR);
                    }
                }
                //update the buyer participation
                $updated = $this->subscriptionv1_model->update_subscription_attendance($allowed_data,$buyer['rep_code']);
                
                if(!$updated){
                    $this->response([
                        'status'=>'failure',
                        'message'=>'An unexpected error occurred while updating the buyer participation',
                    ],RestController::HTTP_INTERNAL_ERROR,false); //500 The server encountered an unexpected error
                }

                //update the buyer Contact
                $prep_contact_data = $this->subscriptionv1_model->prepare_addbuyer_data($allowed_data);

                $contact_profile_data = remove_unallowed_fields($prep_contact_data,$this->allowedData['v_contact_profile']);
                if($contact_profile_data){
                    $updated = $this->subscriptionv1_model->update_subscription($contact_profile_data,$buyer['rep_code']);
                    if(!$updated){
                        $this->response([
                            'status'=>'failure',
                            'message'=>'An unexpected error occurred while updating the buyer contact',
                        ],RestController::HTTP_INTERNAL_ERROR,false); //500 The server encountered an unexpected error
                    }else{
                        $this->response([
                            'status'=>'success',
                            'message'=>'Record Update Successful',
                        ],RestController::HTTP_OK); // 200 The request has succeeded
                    }
                }else{
                    $this->response([
                            'status'=>'success',
                            'message'=>'Record Update Successful',
                        ],RestController::HTTP_OK); 
                }  
            }
            else{
                //Form_validation error notification
                $this->response([
                    'status'=>'failure',
                    'timestamp'=>date('Y-m-d H:i:s'),
                    'method'=>'PATCH',
                    'endpoint'=>base_url().$endpoint,
                    // 'message'=> 'User could not be found',
                    'errors'=>[
                            'code'=>RestController::HTTP_BAD_REQUEST,
                            // 'text'=>$this->form_validation->get_errors_as_array(),
                            'text'=>'validation form error',
                            'hints'=>'use x-www-form-urlencoded or check required fields',
                            // 'info'=>'link to webpage for manual regarding error'
                            ],
                        ],RestController::HTTP_BAD_REQUEST,false);
            }
        }else{
            $this->response([
            'status'=>'failure',
            'message'=>'Cannot update, record not found',
        ],RestController::HTTP_NOT_FOUND,false);

        }   
    }


//=====================PRIVATE===================
//===============================================
//
    //use for multi value which first value will be assigned to another table field in the db
    private function _breakMultiValue($data){
        $dataArr = explodeToArr('|',$data);
        $firstValue = $dataArr[0];
        $otherValues = implode('|', array_slice($dataArr, 1));
        return array($firstValue, $otherValues);
    }
//===============================================
// _get  by
    private function _subscriberBy($identity,$customSet=null){
        function getArr($row,$data,$field){
            $key = array_search($row, array_column($data, 'rep_code'));
            return ($key===false)? '':explodeToArr('|',$data[$key][$field]);
                // return explodeToArr('|',$data[$key][$field]);
        }
        function getItem($row,$data,$field){
            $key = array_search($row, array_column($data, 'rep_code'));
            return ($key===false)? '':$data[$key][$field];
        }
        function validation_no($status){
            if($status=='PENDING TRADE'){
                return '0';
            }elseif($status=='APPROVED TRADE'){
                return '1';
            }elseif($status=='INCOMPLETE TRADE'){
                return '2';
            }elseif($status=='DISAPPROVED TRADE'){
                return '3';
            }else{
                return null;
            }
        };
        $param = getUrlParam($customSet);
        $mysqls = $this->my_rest_lib->generate_sql($param);
        if($identity=='email'){
            $buyer = $this->subscriptionv1_model->get_buyer_by($identity,$this->get('email'));
        }
        if($identity=='id'){
            $buyer = $this->subscriptionv1_model->get_buyer_by($identity,$this->get('id'));
        }
        if(!$buyer){
            return false;
        }

        $reason = $this->subscriptionv1_model->getReason();
        $informthru = $this->subscriptionv1_model->getInformthru();
        $jobfunction = $this->subscriptionv1_model->getJobfunction();
        $nature_of_business = $this->subscriptionv1_model->getRepresentation();
        $product_interest = $this->subscriptionv1_model->getProductInterest();
        $market = $this->subscriptionv1_model->getMarketSegment();
        $annualSales = $this->subscriptionv1_model->getAnnualsales();
        $majorProducts = $this->subscriptionv1_model->getMajorProduct();
        $minorProducts = $this->subscriptionv1_model->getMinorProduct();

        $newArr[]=array(
            // 'rep_code'    => $row['rep_code'],
            'email'       => $buyer['email'],
            'cont_per_fn' => $buyer['cont_per_fn'],
            'cont_per_ln' => $buyer['cont_per_ln'],
            'mi'           => $buyer['mi'],
            'title'       => $buyer['title'],
            'company'     => $buyer['co_name'],
            'webpage'     => $buyer['webpage'],
            'country'     => $buyer['country'],
            'continent'   => $buyer['continent'],
            'add_st'      => $buyer['add_st'],
            'add_city'      => $buyer['add_city'],
            'region'      => $buyer['region'],
            'zipcode'      => $buyer['zipcode'],
            'mobile'      => $buyer['mobile'],
            'facebook'      => $buyer['facebook'],
            'twitter'      => $buyer['twitter'],
            'instagram'      => $buyer['instagram'],
            'social_others'      => $buyer['social_others'],
            'tel_off'      => $buyer['tel_off'],
            'mobile'      => $buyer['mobile'],
            'validated'   => $buyer['validation_status'],
            'visitor_type'   => $buyer['visitor_type'],
            'job_function'=> getItem($buyer['rep_code'],$jobfunction,'jobfunction'),
            'nature_of_business'=> explodeToArr('|',getItem($buyer['rep_code'],$nature_of_business,'representation')),
            // 'market_segment'=> getArr($buyer['rep_code'],$market,'marketSegment'),
            'annual_sales'=> getItem($buyer['rep_code'],$annualSales,'annualsales'),
            // 'supplier_info'=> explodeToArr(',',$buyer['supplier_info']),
            'supplier_info'=> $buyer['supplier_info'],
            'category'=> getArr($buyer['rep_code'],$majorProducts,'majorproduct'),
            'sub_category'=> getArr($buyer['rep_code'],$minorProducts,'minorproduct'),
            // 'product_interest'=> getArr($buyer['rep_code'],$product_interest,'product_interest'),
            // 'reason'=> getArr($buyer['rep_code'],$reason,'reason'),
            // 'informthru'=> getArr($buyer['rep_code'],$informthru,'informthru'),
        );
        return $newArr;
        }



// _get all subscriptions
    private function _all_subscriptions($customSet=null){
        function getArr($row,$data,$field){
            $key = array_search($row, array_column($data, 'rep_code'));
            return ($key===false)? '':explodeToArr('|',$data[$key][$field]);
                // return explodeToArr('|',$data[$key][$field]);
        }
        function getItem($row,$data,$field){
            $key = array_search($row, array_column($data, 'rep_code'));
            return ($key===false)? '':$data[$key][$field];
        }
        $param = getUrlParam($customSet);
        $mysqls = $this->my_rest_lib->generate_subscriptions_sql($param);
        $buyers = $this->subscriptionv1_model->getContactv2($mysqls['query']);
        $total =  $this->subscriptionv1_model->total_contact_record_count($mysqls['count_query']);
        $interest = $this->subscriptionv1_model->getSubscriptionInterest();
        $representation = $this->subscriptionv1_model->getSubscriptionRepresentation();

        if($buyers){
            foreach($buyers as $row){
                $newArr[]=array(
                // 'fameplus_id' => $row['fameplus_id'],
                'id'    => $row['rep_code'],
                'email'       => $row['email'],
                'country'     => $row['country'],
                'continent'   => $row['continent'],
                'interest' => getArr($row['rep_code'],$interest,'interest'),
                'representation' => getArr($row['rep_code'],$representation,'representation'),
                );
            }
            $buyers_detail = array('data'=>$newArr,'total'=>$total,'param'=>$param);
            return $buyers_detail;
        }else{
            return false;
        }
    }


//===============================================
//===============================================
//for access rights
    private function _hasAccess($module,$id){
        $user = $this->apiv1_model->accessRights($module,$id);
        if(!checkAccess($user,$module,$id)){
            $this->response([
                    'status'=>'failure',
                    'errors'=>[
                            'code'=>RestController::HTTP_UNAUTHORIZED ,
                            'message'=>'Unauthorized Access',
                            ],
                        ],RestController::HTTP_UNAUTHORIZED);
        }
        else{
            return $user;}
    }
//===============================================
//for loading project settings
    private function _load_appConfig($app_system){
        if($app_system){
            switch ($app_system) {
                case 'CREATE_DTCP':
                    return $this->config->item('create_dtcp', 'my_rest');
                    break;
                case 'FAME+ Registration':
                    return $this->config->item('home', 'my_rest');
                    break;
                default:
                    # code...
                    break;
            }
        }
    }
//===============================================

//==============================================================================

    private function _response_data($newArr,$param,$total,$total_filtered,$query,$query_total,$query_filtered){
        if(array_key_exists('limit', $param) OR array_key_exists('l', $param) OR array_key_exists('q', $param)){
            if($this->my_rest_lib->is_debug($param)){
                return array(
                    'sql' => [
                    'query'          => $query??'' ,
                    'total'          => $query_total??'',
                    'total_filtered' => $query_filtered??'',],
                    'status'         => 'success',
                    'paging'         => [
                        'limit'          => $_GET['limit'] ?? 0,
                        'offset'         => $_GET['offset'] ?? 0,
                        'total_records'  => $total,
                        'total_filtered' => $total_filtered ?? 0
                    ],
                    'data' => $newArr,
                );
            }else{
                return array(
                    'status' => 'success',
                    'paging' => [
                        'limit'          => $_GET['limit'] ?? 0,
                        'offset'         => $_GET['offset'] ?? 0,
                        'total_records'  => $total,
                        'total_filtered' => $total_filtered ?? 0
                    ],
                    'data'=> $newArr,
                );
            }
        }
        else{
            if($this->my_rest_lib->is_debug($param)){
                return array(
                    'sql' => [
                        'query'          => $query??'' ,
                        'total'          => $query_total??'',
                        'total_filtered' => $query_filtered??'',
                    ],
                    'status' => 'success',
                    'paging'=> [
                        'limit'          => 0,
                        'offset'         => 0,
                        'total_records'  => $total,
                        'total_filtered' => $total_filtered ?? 0,
                    ],
                    'data' => $newArr
                );
            }else{
                return array(
                    'status' => 'success',
                    'paging' => [
                        'limit'          => 0,
                        'offset'         => 0,
                        'total_records'  => $total,
                        'total_filtered' => $total_filtered ?? 0
                    ],
                        'data' => $newArr,
                    );
            }
        }
    }






//================================END========================================

}

/* End of file api.php */
/* Location: ./application/controllers/api.php */