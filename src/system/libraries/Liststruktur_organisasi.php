<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*

This is one of the free scripts from www.dhtmlgoodies.com
You are free to use this script as long as this copyright message is kept intact

(c) Alf Magne Kalleland, http://www.dhtmlgoodies.com - 2005

*/

class CI_Liststruktur_organisasi {
	
	var $elementArray = array();
	
	
	
	function addToArray($id,$name,$parentID,$lvl,$child){
		if(empty($parentID))$parentID=0;	
		$this->elementArray[$parentID][] = array($id,$name,$parentID,$lvl,$child);
	}
	
	
	function drawTree(){
		for($no=0;$no<count($this->elementArray[0]);$no++){
			echo "<tr><td>".$this->elementArray[0][$no][1]."";	
			echo "</td><td align='right'>
					<a href='".base_url()."settings/struktur_organisasi/add/".$this->elementArray[0][$no][0]."/".$this->elementArray[0][$no][3]."/".$this->elementArray[0][$no][4]."' class='btn btn-success btn-xs NewLink'><i class='icon wb-plus'></i></a> &nbsp;
					<a href='".base_url()."settings/struktur_organisasi/edit/".$this->elementArray[0][$no][0]."' class='btn btn-warning btn-xs NewLink'><i class='icon wb-pencil'></i></a> &nbsp;
					<a href='".base_url()."act_settings/delete_struktur_organisasi/".$this->elementArray[0][$no][0]."' class='confirmation btn btn-danger btn-xs'><i class='icon wb-trash'></i></a>";	
			echo "</td></tr>";		
			$this->drawSubNode($this->elementArray[0][$no][0]);
		}		
	}
	
	private function drawSubNode($parentID){
		if(isset($this->elementArray[$parentID])){
			for($no=0;$no<count($this->elementArray[$parentID]);$no++){
				$tab = '';
				$ulg = $this->elementArray[$parentID][$no][3] - 1;
				for($i=0;$i<=$ulg;$i++){
					$tab .= "&nbsp;&nbsp;&nbsp;&nbsp;";
				}
				
				echo "<tr><td>".$tab.$this->elementArray[$parentID][$no][1]."";	
				echo "</td><td align='right'>
					<a href='".base_url()."settings/struktur_organisasi/add/".$this->elementArray[$parentID][$no][0]."/".$this->elementArray[$parentID][$no][3]."/".$this->elementArray[$parentID][$no][4]."' class='btn btn-success btn-xs NewLink'><i class='icon wb-plus'></i></a> &nbsp;
					<a href='".base_url()."settings/struktur_organisasi/edit/".$this->elementArray[$parentID][$no][0]."' class='btn btn-warning btn-xs NewLink'><i class='icon wb-pencil'></i></a> &nbsp;
					<a href='".base_url()."act_settings/delete_struktur_organisasi/".$this->elementArray[$parentID][$no][0]."' class='confirmation btn btn-danger btn-xs'><i class='icon wb-trash'></i></a>";	
				echo "</td></tr>";	
				
				$this->drawSubNode($this->elementArray[$parentID][$no][0]);
			}						
		}		
	}
	
	
}//end class


?>