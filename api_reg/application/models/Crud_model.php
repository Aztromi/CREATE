<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crud_model extends CI_Model {

	protected $_table=null;
	protected $_primary_key=null;

	public function __construct()
	{
		parent::__construct();
		
	}

	/**
	*	@usage
	*	   All: $this->user_model->retrieve();
	*	Single: $this->user_model->retrieve(2);
	*	Custom: $this->user_model->retrieve(array('any'=>'param'))
	*	$this->user_model->retrieve(array(
							'userid'=>'1',
							'email !='=>'eric'));

		WHERE userid=1 AND 'email'='eric'
	*
	**/


	public function retrieve($id=null, $row=null){
		ini_set("memory_limit","4096M");

		if(is_numeric($id)){
			$this->db->where($this->_primary_key,$id);
			$q = $this->db->get($this->_table);
			return $q->first_row('array');
		}
		if(is_array($id)){
			foreach($id as $key=>$value){
				$q=$this->db->where($key,$value);
			}
			$q = $this->db->get($this->_table);
			if($row){
				return $q->first_row('array');
			}else{
				return $q->result_array();	
			}
			
		}
		if($id==null){
			$q = $this->db->get($this->_table);
			return $q->result_array();	
		}

	}

	

	/**
	*	@usage
	*	   $result=$this->user_model->insert(['login'=>'joe']);
	*
	**/

	public function insert($data){
		$this->db->insert($this->_table,$data);
		return $this->db->insert_id();
	}




	/**
	*	@usage
	*	   $this->user_model->update(['login'=>'Joe'],3);
	*		$this->user_model->update(['login'=>'Joe'],['date_created'=>'0']);
	**/

	public function update($newData, $where){
		if(is_numeric($where)){
			$this->db->where($this->_primary_key,$where);	
		}
		elseif(is_array($where)){
			foreach($where as $key=>$value){
				$this->db->where($key,$value);
			}
		}
		else{
			die("Must pass a second parameter to UPDATE() method");
		}
		$this->db->update($this->_table,$newData);
		return $this->db->affected_rows();
	}


	/**
	*	@usage
	*	   (if  record exist its gonna update,if it doesnt exist it will insert)
	*		save(['name'=>'ted'],12)
	**/

	public function save($data, $id=false){
		if(!$id){
			die("You must pass a second parameter to the insertUpdate() method");
		}
		$this->db->select($this->_primary_key);
		$this->db->where($this->_primary_key,$id);
		$q = $this->db->get($this->_table);
		$result = $q->num_rows();

		if($result==0){
			//INSERT
			return $this->insert($data);
		}
		//UPDATE
			return $this->update($data,$id);
	}



	/**
	*	@usage
	*		$this->user_model->delete(6);
	*		$this->user_model->delete(array('name')=>'Markus'))
	*
	*
	*	note: make sure a parameter be passed to DELETE() of may delete the whole table
	**/

	public function delete($id=null){
		if(is_numeric($id)){
			$this->db->where($this->_primary_key,$id);
		}
		elseif(is_array($id)){
			foreach($id as $key=>$value){
				$this->db->where($key,$value);
			}
		}
		else{
			die("Missing Argument: Must pass a parameter to the DELETE() method.");
		}
		$this->db->delete($this->_table);
		return $this->db->affected_rows(); //returns 1 for success
	}




	/**
	*	@usage
	*	   All: $this->user_model->retrieve();
	*	Single: $this->user_model->retrieve(2);
	*	Custom: $this->user_model->retrieve(array('any'=>'param'))
	*	$this->user_model->retrieve(array(
							'userid'=>'1',
							'email !='=>'eric'));

		WHERE userid=1 AND 'email'='eric'
	*
	**/


	public function retrieveVer2($select='', $id=null, $order_by=null){

		if(is_numeric($id)){
			$this->db->select($select);
			$this->db->where($this->_primary_key,$id);
			$q = $this->db->get($this->_table);
			return $q->first_row('array');
		}
		if(is_array($id)){
			$this->db->select($select);
			foreach($id as $key=>$value){
				$q=$this->db->where($key,$value);
			}
			$q = $this->db->get($this->_table);
			return $q->result_array();	
		}
		if($id==null){
			$this->db->select($select);
			$q = $this->db->get($this->_table);
			return $q->result_array();	
		}

	}


}
/* End of file crud_model.php */
/* Location: ./application/models/crud_model.php */