<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*

This is one of the free scripts from www.dhtmlgoodies.com
You are free to use this script as long as this copyright message is kept intact

(c) Alf Magne Kalleland, http://www.dhtmlgoodies.com - 2005

*/

class CI_Menuchecklistedit {
	
	var $elementArray = array();
	
	
	
	function addToArray($id,$name,$parentID,$level,$check,$add,$edit,$delete){
		if(empty($parentID))$parentID=0;	
		$this->elementArray[$parentID][] = array($id,$name,$level,$check,$add,$edit,$delete);
	}
	
	
	function drawTree(){
		for($no=0;$no<count($this->elementArray[0]);$no++){
			echo "<tr><td>".$this->elementArray[0][$no][1]."";	
			echo "</td><td><input type='checkbox' name='check[]' class='check_all_menu".$this->elementArray[0][$no][0]."' onclick='select_all_menu".$this->elementArray[0][$no][0]."()'  value='".$this->elementArray[0][$no][0]."'"; if($this->elementArray[0][$no][0] == $this->elementArray[0][$no][3]){echo' checked';} echo">";	
			echo "</td><td colspan='3'>
				<!--<script>
						function select_all_menu".$this->elementArray[0][$no][0]."() {
							$('input[class=submenu".$no."]:checkbox').each(function(){ 
								if($('input[class=check_all_menu".$this->elementArray[0][$no][0]."]:checkbox:checked').length == 0){ 
									$(this).prop('checked', false); 
								alert('a')
								} else {
									$(this).prop('checked', true); 
								alert('b')
								} 
							});
						}
					</script>-->
			</td></tr>";		
			$this->drawSubNode($this->elementArray[0][$no][0],$no);
		}		
	}
	
	private function drawSubNode($parentID,$n){
		if(isset($this->elementArray[$parentID])){
			$tab = '';
			for($no=0;$no<count($this->elementArray[$parentID]);$no++){
				if($this->elementArray[$parentID][$no][2] == 2){
					$tab = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				}else{
					$tab = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				}
					
					
				echo "<tr><td>".$tab." ".$this->elementArray[$parentID][$no][1]."";	
				echo "</td><td><input type='checkbox' name='check[]' class='check_all".$this->elementArray[$parentID][$no][0]."' onclick='select_all".$this->elementArray[$parentID][$no][0]."()' value='".$this->elementArray[$parentID][$no][0]."'"; if($this->elementArray[$parentID][$no][0] == $this->elementArray[$parentID][$no][3]){echo' checked';} echo">";
				echo "</td><td><input type='checkbox' class='case".$this->elementArray[$parentID][$no][0]."' name='add_".$this->elementArray[$parentID][$no][0]."' value='1'"; if($this->elementArray[$parentID][$no][4] == '1'){echo' checked';} echo">";
				echo "</td><td><input type='checkbox' class='case".$this->elementArray[$parentID][$no][0]."' name='edit_".$this->elementArray[$parentID][$no][0]."' value='1'"; if($this->elementArray[$parentID][$no][5] == '1'){echo' checked';} echo">";
				echo "</td><td><input type='checkbox' class='case".$this->elementArray[$parentID][$no][0]."' name='delete_".$this->elementArray[$parentID][$no][0]."' value='1'"; if($this->elementArray[$parentID][$no][6] == '1'){echo' checked';} echo">";
				echo "<script>
							function select_all".$this->elementArray[$parentID][$no][0]."() {
								$('input[class=case".$this->elementArray[$parentID][$no][0]."]:checkbox').each(function(){ 
									if($('input[class=check_all".$this->elementArray[$parentID][$no][0]."]:checkbox:checked').length == 0){ 
										$(this).prop('checked', false); 
									} else {
										$(this).prop('checked', true); 
									} 
								});
							}
						</script>
					</td></tr>";	
				
				$this->drawSubNode($this->elementArray[$parentID][$no][0],$n);
			}						
		}		
	}
	
}//end class


?>