<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Settings Name
|--------------------------------------------------------------------------
|
*/
// $config['setting']['sector_code']       = '02';
// $config['setting']['system1']           = 'FAME+';
// $config['setting']['system']            = 'FAME+ Registration';
// $config['setting']['current_fair_code'] = 'FPLUS2021';
// $config['setting']['sector_fair_code']  = 'HOME';
// $config['setting']['fameplus']          = '31d051aa-7c55-4dad-91f8-e631c0f4af3a';

$config['home']['sector_code']       = '02';
$config['home']['system1']           = 'FAME+';
$config['home']['system']            = 'FAME+ Registration';
$config['home']['current_fair_code'] = 'FPLUS'.date('Y');
$config['home']['sector_fair_code']  = 'HOME';
$config['home']['fameplus']          = '31d051aa-7c55-4dad-91f8-e631c0f4af3a';
$config['home']['productfaircode'] = 'DTCP2020';

$config['ifex']['sector_code']       = '01';
$config['ifex']['system1']           = 'IFEX DTCP';
$config['ifex']['system']            = 'IFEX Registration';
$config['ifex']['current_fair_code'] = 'IFEX'.date('Y');
$config['ifex']['sector_fair_code']  = 'FOOD';
$config['ifex']['productfaircode'] = 'IFEXNEXT2021';


$config['create_dtcp']['sector_code']       = '20';
$config['create_dtcp']['system1']           = 'CREATE DTCP';
$config['create_dtcp']['system']            = 'CREATE SUBSCRIPTION';
$config['create_dtcp']['current_fair_code'] = 'CREATEDTCP'.date('Y');
$config['create_dtcp']['sector_fair_code']  = 'CREATE';
$config['create_dtcp']['productfaircode'] = 'CREATE2021';



$config['create_reg']['sector_code']       = '20';
$config['create_reg']['system1']           = 'CREATE DTCP';
$config['create_reg']['system']            = 'CREATE REGISTRATION';
$config['create_reg']['current_fair_code'] = 'CREATEDTCP'.date('Y');
$config['create_reg']['web']               = 'CREATEDTCP';
$config['create_reg']['sector_fair_code']  = 'CREATE';
$config['create_reg']['productfaircode']   = 'CREATE2024';
$config['create_reg']['event_active']        = TRUE;
$config['create_reg']['regstat_fair_code']       = 'CREATE2024';


/*
|--------------------------------------------------------------------------
| Database Name
|--------------------------------------------------------------------------
|
*/
$config['dbase']['buyer']      = 'default';
$config['dbase']['exhibitor']  = 'exhibitor';
$config['dbase']['master'] = 'masterfile';
$config['dbase']['config'] = 'default'; //for the api table
$config['dbase']['subscription'] = 'subscription';

/*
|--------------------------------------------------------------------------
| Database Reference Switch Code
|--------------------------------------------------------------------------
|
|
*/
$config['switch']['jobfunction']      = 'JOB_F';
$config['switch']['business_ownership']   = '2'; // nature of business, business ownership
$config['switch']['annualsales']      = 'MN2';
$config['switch']['marketsegment']    = 'MN3';
$config['switch']['technique']        = 'MN10';
// $config['switch']['reason']        = 'MN10';
$config['switch']['informthru']       = 'B1';
$config['switch']['trade_experience'] = 'B2I';
$config['switch']['target_buyers'] = 'C1';
$config['switch']['industry_representation'] = 'B2'; //business category,

$config['switch']['natureofbusiness'] = '4'; //ifex
$config['switch']['certification'] = 'B12'; //ifex

/*
|--------------------------------------------------------------------------
| Others
|--------------------------------------------------------------------------
|
*/
$config['project_list']    = array('home','food','create','ssx');
$config['max_page']        = 100;
$config['record_limit']    = true;
$config['validation_stat'] = array('0'=>'PENDING TRADE','1'=>'APPROVED TRADE','2'=>'INCOMPLETE TRADE','3'=>'DISAPPROVED TRADE',);

/*
|--------------------------------------------------------------------------
| Database Allowed Fields
|--------------------------------------------------------------------------
|
|
*/
$config['allowed_field']['v_contact_profile']= array('rep_code','barcode','co_name','description','cont_per_fn','cont_per_ln','mi','position','authority_title','salutation','gender','age_group','birthdate','nationality','accompanying_person','date_apply','date_input','country','continent','states','region','area','province','add_st','add_city','zipcode','tel_off','tel_fact','tel_show','fax','email','email2','work_email','webpage','first_time_asia','attend_mfi','pref_day',
	// 'pre_reg',
	'venue','deleted',
	// 'reg_status',
	'mobile',
	// 'visitor_type','buyer_type','buyerclass',
	'exhi_conf_gov',
	// 'trade_code',
	'added','add_value','add_count','unsubscribed','marked','tag','gcclaimed','gcdate','editdatestamp','markdatestamp','merge_status','pid','cutoff','remarks',
	// 'sector',
	'specific_request','number_retail_stores','list_of_clients','facebook','linkedin','blogsite','twitter','instagram','pinterest','weibo','social_others','y_estab','duplicate','rep_codeOld','rfid','org_name','org_website','quickEmail_status','password',
);
$config['allowed_field']['v_attendance'] = array('refno','rep_code','barcode','fair_code','sector','remarks','pre_reg','reg_status','visitor_privilege','visitor_type','previous_visitor_type','visitor_status','visitor_status_remarks','buyerclass','buyerclass_remarks','valid_email','validated','date_validated','validated_by','emailed','date_emailed','date_apply','date_input','date_arrive','url_form',
	// 'vip',
	'supplier_info','app_system','user_agreement','validation_status','user_agreement','subscription',
);
$config['allowed_field']['v_job_function'] = array(
	'rep_code','barcode','item_code','fair_code','remarks',
);

$config['allowed_field']['v_representation'] = array(
	'rep_code','barcode','item_code','remarks','fair_code',
	'remarks','fair_code','sector','refno','rep_codeOld',
);

$config['allowed_field']['v_mn_marketsegment'] = array(
	'rep_code','barcode','item_code','remarks','sector','refno',
	'remarks','fair_code','sector','refno','rep_codeOld',
);

$config['allowed_field']['v_mn_annualsales'] = array(
	'rep_code','barcode','item_code','fair_code','remarks','sector','refno','rep_codeOld',
);

$config['allowed_field']['v_genproducts'] = array(
	'rep_code','barcode','prod_cat','prod_code','remarks_major','remarks_minor',
	'fair_code','sector','refno','rep_codeOld',
);

$config['allowed_field']['v_product_technique'] = array(
	'rep_code','barcode','item_code','remarks','sector','refno',
	'remarks','fair_code','sector','refno','rep_codeOld',
);

$config['allowed_field']['v_showreason'] = array(
	'rep_code','barcode','item_code','remarks','sector','refno',
	'remarks','fair_code','sector','refno','rep_codeOld',
);

$config['allowed_field']['v_informthru'] = array(
	'rep_code','barcode','item_code','remarks','sector','refno',
	'remarks','fair_code','sector','refno','rep_codeOld',
);



$config['allowed_field']['e_contact_profile']= array(
	// 'ff_code',
	'acct_no','co_name',
	// 'brand_name',
	'description','registration_no','y_estab','y_export','cont_per_ln',
	'cont_per_fn','mi','title','salutation','gender','age_group','date_apply','date_input','country',
	'continent',
	'states',
	'region',
	'area',
	'province','add_st','add_city','zipcode','tel_off','fax','co_mobile','owner_mobile','owner_email','co_email','webpage','remarks','remarks_date','deleted','remarks1','edited','fair_code','stand_name','tin','facebook','twitter','instagram','portfolio','username','userdesc','logo','sector','membership_assoc','password','rights','forgotten_password_code','forgotten_password_time','last_login','active','slug','image','youtube_id','details','linkedin','social_others','level','foldername','messaging_app','fameplus_id','youtube','tiktok','behance',
	// 'ffCode_Old',
	// 'coEmail_orig',
	'quickEmail_status',
);

$config['allowed_field']['e_attendance'] = array(
	'refno','ff_code','co_name','brand_name','portfolio','membership_assoc','application_no','date_apply','proj','fair_code','fair_class','acti','fair_type','fair_stat','fair_part','fair_date','fair_stat_app','fair_stat_app_date','fair_stat_part','foreignlocal','foreignlocalremarks','coordinator','manager','participation_type','company_type','backup','finished','sector_code','username','userdesc','datetimestamp','filename','emailStatus','emailApprovedStat','product_dev','includeInBoothDIrectory','product_dev_consultant','exhibit_participation','trading_agreement','trading_agreement_remarks','bizmatch','bizmatch_remarks','direct_workers','indirect_workers','company_size','business_ownership','user_agreement','app_system'
);


$config['allowed_field']['e_addresses'] = array(
	'ff_code','fact_st','fact_city','fact_zipcode','fact_area','fact_province','fact_region','fact_state','fact_country','fact_continent','fact_tel_off','fact_fax','addr_type','fair_code'
);