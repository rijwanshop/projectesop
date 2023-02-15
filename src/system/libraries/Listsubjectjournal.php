<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*

This is one of the free scripts from www.dhtmlgoodies.com
You are free to use this script as long as this copyright message is kept intact

(c) Alf Magne Kalleland, http://www.dhtmlgoodies.com - 2005

*/

class CI_Listsubjectjournal {
	
	var $elementArray = array();
	
	
	
	function addToArray($id,$name,$parentID,$status){
		if(empty($parentID))$parentID=0;	
		$this->elementArray[$parentID][] = array($id,$name,$status);
	}
	
	
	function drawTree(){
		for($no=0;$no<count($this->elementArray[0]);$no++){
			echo "<tr><td>".$this->elementArray[0][$no][1]."";	
			echo "</td><td>".($this->elementArray[0][$no][2] == 'Y' ? '<label class=\'label label-success\'>Active</label>' : '<label class=\'label label-danger\'>Non Active</label>')."";	
			echo "</td><td align='right'>
					<a href='".base_url()."KAPd/manage_journal/subject/add/".$this->elementArray[0][$no][0]."' class='btn btn-success btn-xs NewLink'><i class='icon-plus'></i></a> &nbsp;
					<a href='".base_url()."KAPd/manage_journal/subject/edit/".$this->elementArray[0][$no][0]."' class='btn btn-warning btn-xs NewLink'><i class='icon-pencil'></i></a> &nbsp;
					<a href='".base_url()."ADMjournal/delete_subject/".$this->elementArray[0][$no][0]."' class='btn btn-danger btn-xs'><i class='icon-trash'></i></a>";	
			echo "</td></tr>";		
			$this->drawSubNode($this->elementArray[0][$no][0]);
		}		
	}
	
	private function drawSubNode($parentID){
		if(isset($this->elementArray[$parentID])){
			$tab = '';
			for($no=0;$no<count($this->elementArray[$parentID]);$no++){
				$tab = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<tr><td>".$tab.$this->elementArray[$parentID][$no][1]."";	
				echo "</td><td>".($this->elementArray[$parentID][$no][2] == 'Y' ? '<label class=\'label label-success\'>Active</label>' : '<label class=\'label label-danger\'>Non Active</label>')."";	
				echo "</td><td align='right'>
					<a href='".base_url()."KAPd/manage_journal/subject/edit/".$this->elementArray[$parentID][$no][0]."' class='btn btn-warning btn-xs NewLink'><i class='icon-pencil'></i></a> &nbsp;
					<a href='".base_url()."ADMjournal/delete_subject/".$this->elementArray[$parentID][$no][0]."' class='btn btn-danger btn-xs'><i class='icon-trash'></i></a>";	
				echo "</td></tr>";	
			}						
		}		
	}
	
}//end class


?>