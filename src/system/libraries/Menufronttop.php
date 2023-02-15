<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*

This is one of the free scripts from www.dhtmlgoodies.com
You are free to use this script as long as this copyright message is kept intact

(c) Alf Magne Kalleland, http://www.dhtmlgoodies.com - 2005

*/

class CI_Menufronttop {
	
	var $elementArray = array();
	
	
	
	function addToArray($id,$name,$parentID,$link,$child,$url1){
		if(empty($parentID))$parentID=0;	
		$this->elementArray[$parentID][] = array($id,$name,$link,$child,$url1);
	}
	
	
	function drawTree(){
		for($no=0;$no<count($this->elementArray[0]);$no++){
			$active = ($this->elementArray[0][$no][2] == $this->elementArray[0][$no][4] ? 'active' : '');
			
			if($this->elementArray[0][$no][3] == 'Y'){
				echo '<li class="dropdown '.$active.'"> 
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						'.$this->elementArray[0][$no][1].' 
						<span class="caret"></span></a>';
			}else{
				echo '<li class="'.$active.'"><a href="'.base_url().$this->elementArray[0][$no][2].'">'.$this->elementArray[0][$no][1].'</a></li>';
			}
					
				$this->drawSubNode($this->elementArray[0][$no][0]);
					
			echo '</li>';
		}		
	}
	
	private function drawSubNode($parentID){
		if(isset($this->elementArray[$parentID])){
			$active = ($this->elementArray[$parentID][$no][2] == $this->elementArray[$parentID][$no][4] ? 'active' : '');
			
			echo '<ul class="dropdown-menu">';
			
				for($no=0;$no<count($this->elementArray[$parentID]);$no++){
					
					echo '<li class="'.$active.'"><a href="'.base_url().$this->elementArray[$parentID][$no][2].'">'.$this->elementArray[$parentID][$no][1].'</a></li>';
					
				}	
			
			echo '</ul>';
		}		
	}
	
}//end class


?>