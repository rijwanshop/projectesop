<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*

This is one of the free scripts from www.dhtmlgoodies.com
You are free to use this script as long as this copyright message is kept intact

(c) Alf Magne Kalleland, http://www.dhtmlgoodies.com - 2005

*/

class CI_Menubackend {
	
	var $elementArray = array();
	
	
	function addToArray($id,$name,$parentID,$link,$level,$child,$icon){
		if(empty($parentID))$parentID=0;	
		$this->elementArray[$parentID][] = array($id,$name,$parentID,$link,$level,$child,$icon);
	}
	
	
	function drawTree(){
		$distype='';
		for($no=0;$no<count($this->elementArray[0]);$no++){
			echo '<li class="site-menu-item has-sub">
					 <a href="#" data-dropdown-toggle="false">
						<i class="site-menu-icon '.$this->elementArray[0][$no][6].'" aria-hidden="true"></i>
						<span class="site-menu-title">'.$this->elementArray[0][$no][1].'</span>
						<span class="site-menu-arrow"></span>
					  </a>
					  <ul class="site-menu-sub">';
						$this->drawSubNode($this->elementArray[0][$no][0]);
				echo "</ul>
			</li>";
		}		
	}
	
	private function drawSubNode($parentID){
		$dis = 0;
		if(isset($this->elementArray[$parentID])){
			for($no=0;$no<count($this->elementArray[$parentID]);$no++){
				echo'<li class="site-menu-item">
                  <a class="animsition-link" href="'.base_url().''.$this->elementArray[$parentID][$no][3].'">
                    <span class="site-menu-title">'.$this->elementArray[$parentID][$no][1].'</span>
                  </a>
                </li>';
			}
			
		}		
	}
	
}//end class


?>