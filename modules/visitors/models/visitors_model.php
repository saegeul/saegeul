<?php 
class Visitors_model extends CI_Model
{
	//function __construct()
	//{
	//	parent::__construct();

//	}
	
	
	function visit()
	{
		$sql = " SELECT * FROM GUESTBOOK ";
		$query = $this->db->query($sql);

		return $query->result_array();
		
	}
	
	function write($name, $comment, $passwd){
		//# $REMOTE_ADDR은 PHP에서 미리 정의한 변수입니다. #//
		$query = " INSERT INTO GUESTBOOK VALUES (null,'$name','$comment','$passwd','',now()) ";
		$this->db->query($query);
	}
	
	function modify_view($idx){
		$sql = " SELECT * FROM GUESTBOOK WHERE IDX = '$idx' ";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function modify($passwd, $name, $comment, $idx){
		$query = " UPDATE GUESTBOOK SET NAME = '$name' , PW = '$passwd' , COMMENT = '$comment' , REG_DATE = now() WHERE IDX = '$idx' ";
		$this->db->query($query);
	}
	
	function delete($idx){
		$query = " DELETE FROM GUESTBOOK WHERE IDX = '$idx' ";
		$this->db->query($query);
	}
}
?>