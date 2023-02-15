<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*

This is one of the free scripts from www.dhtmlgoodies.com
You are free to use this script as long as this copyright message is kept intact

(c) Alf Magne Kalleland, http://www.dhtmlgoodies.com - 2005

*/

class CI_Combotree {
	
	var $elementArray = array();
	
	
	
	function addToArray($id,$name,$parentID,$level,$sel){
		if(empty($parentID))$parentID=0;	
		$this->elementArray[$parentID][] = array($id,$name,$level,$sel);
	}
	
	
	function drawTree(){
		echo '<b>Jenis SOP : </b><select name="kat_sop">';
		echo '<option value="">Pilih Kategori SOP</option>';
			for($no=0;$no<count($this->elementArray[0]);$no++){
				echo "<option value='".$this->elementArray[0][$no][0]."'"; if($this->elementArray[0][$no][0] == $this->elementArray[0][$no][3]){echo' selected';} echo">".$this->elementArray[0][$no][1]."</option>";	
				
				$this->drawSubNode($this->elementArray[0][$no][0]);
			}	
		echo'</select><br><br>';
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
				
				echo "<option value='".$this->elementArray[$parentID][$no][0]."'"; if($this->elementArray[$parentID][$no][0] == $this->elementArray[$parentID][$no][3]){echo' selected';} echo">".$tab.$this->elementArray[$parentID][$no][1]."</option>";
				
				$this->drawSubNode($this->elementArray[$parentID][$no][0]);
			}						
		}		
	}
	
}//end class


?>