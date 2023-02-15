<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*

This is one of the free scripts from www.dhtmlgoodies.com
You are free to use this script as long as this copyright message is kept intact

(c) Alf Magne Kalleland, http://www.dhtmlgoodies.com - 2005

*/

class CI_Listst {
	
	var $elementArray = array();
	
	
	
	function addToArray($id,$name,$parentID){
		if(empty($parentID))$parentID=0;	
		$this->elementArray[$parentID][] = array($id,$name,$parentID);
	}
	echo  $this->elementArray[0];
	
	function drawTree(){
		for($no=0;$no<count($this->elementArray[0]);$no++){
				echo "<tr><td>".$this->elementArray[0][$no][0]."";	
				echo "</td></tr>";		
				$this->drawSubNode($this->elementArray[0][$no][0]);
		}		
	}
	
	private function drawSubNode($parentID){
		if(isset($this->elementArray[$parentID])){
			$tab = '';
			for($no=0;$no<count($this->elementArray[$parentID]);$no++){
				echo "<tr><td>".$this->elementArray[$parentID][$no][1]."";	
				echo "</td></tr>";	
				
				$this->drawSubNode($this->elementArray[$parentID][$no][0]);
			}						
		}		
	}
	
}//end class


?>