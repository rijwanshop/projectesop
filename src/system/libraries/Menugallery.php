<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*

This is one of the free scripts from www.dhtmlgoodies.com
You are free to use this script as long as this copyright message is kept intact

(c) Alf Magne Kalleland, http://www.dhtmlgoodies.com - 2005

*/

class CI_Menugallery {
	
	var $elementArray = array();
	
	function addToArray($id,$name,$parentID,$url="",$target=""){
		if(empty($parentID))$parentID=0;	
		$this->elementArray[$parentID][] = array($id,$name,$url,$target);
	}
	
	
	function drawTree(){
		echo "<ul class=\"slimmenu\">";
		for($no=0;$no<count($this->elementArray[0]);$no++){
			$urlAdd = "";
			if($this->elementArray[0][$no][2]){
				$urlAdd = " href=\"".$this->elementArray[0][$no][2]."\"";
				if($this->elementArray[0][$no][3])$urlAdd.=" target=\"".$this->elementArray[0][$no][3]."\"";	
			}
			echo "<li><a $urlAdd>".$this->elementArray[0][$no][1]."</a>";		
			$this->drawSubNode($this->elementArray[0][$no][0]);
			echo "</li>";	
		}	
		echo "</ul>";	
	}
	
	private function drawSubNode($parentID){
		if(isset($this->elementArray[$parentID])){			
			echo "<ul>";
			for($no=0;$no<count($this->elementArray[$parentID]);$no++){
				$urlAdd = "";
				if($this->elementArray[$parentID][$no][2]){
					$urlAdd = ' href="'.$this->elementArray[$parentID][$no][2].'"';
					if($this->elementArray[$parentID][$no][3])$urlAdd.=" target=\"".$this->elementArray[$parentID][$no][3]."\"";	
				}
				echo "<li><a class=\"tree_link\"$urlAdd>".$this->elementArray[$parentID][$no][1]."</a>";	
				$this->drawSubNode($this->elementArray[$parentID][$no][0]);
				echo "</li>";
			}			
			echo "</ul>";			
		}		
	}
	
}//end class


?>