<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*

This is one of the free scripts from www.dhtmlgoodies.com
You are free to use this script as long as this copyright message is kept intact

(c) Alf Magne Kalleland, http://www.dhtmlgoodies.com - 2005

*/

class CI_Menuchecklistview {
	
	var $elementArray = array();
	
	
	
	function addToArray($id,$name,$parentID,$level,$check,$add,$edit,$delete){
		if(empty($parentID))$parentID=0;	
		$this->elementArray[$parentID][] = array($id,$name,$level,$check,$add,$edit,$delete);
	}
	
	
	function drawTree(){
		for($no=0;$no<count($this->elementArray[0]);$no++){
			echo "<tr><td>".$this->elementArray[0][$no][1]."";	
			echo "</td><td align='center'>";if($this->elementArray[0][$no][0] == $this->elementArray[0][$no][3]){echo' Y';} echo"";	
			echo "</td></tr>";		
			$this->drawSubNode($this->elementArray[0][$no][0]);
		}		
	}
	
	private function drawSubNode($parentID){
		if(isset($this->elementArray[$parentID])){
			$tab = '';
			for($no=0;$no<count($this->elementArray[$parentID]);$no++){
				if($this->elementArray[$parentID][$no][2] == 2){
					$tab = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				}else{
					$tab = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				}
					
					
				echo "<tr><td>".$tab." ".$this->elementArray[$parentID][$no][1]."";	
				echo "</td><td align='center'>"; if($this->elementArray[$parentID][$no][0] == $this->elementArray[$parentID][$no][3]){echo' Y';} echo"";
				echo "</td><td align='center'>"; if($this->elementArray[$parentID][$no][4] == '1'){echo' Y';} echo"";
				echo "</td><td align='center'>"; if($this->elementArray[$parentID][$no][5] == '1'){echo' Y';} echo"";
				echo "</td><td align='center'>"; if($this->elementArray[$parentID][$no][6] == '1'){echo' Y';} echo"";
				echo "</td></tr>";	
				
				$this->drawSubNode($this->elementArray[$parentID][$no][0]);
			}						
		}		
	}
	
}//end class


?>