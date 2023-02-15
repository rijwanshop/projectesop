<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*

This is one of the free scripts from www.dhtmlgoodies.com
You are free to use this script as long as this copyright message is kept intact

(c) Alf Magne Kalleland, http://www.dhtmlgoodies.com - 2005

*/

class CI_Menufrontbot {
	
	var $elementArray = array();
	
	
	
	function addToArray($id,$name,$parentID,$link){
		if(empty($parentID))$parentID=0;	
		$this->elementArray[$parentID][] = array($id,$name,$link);
	}
	
	
	function drawTree(){
		for($no=0;$no<count($this->elementArray[0]);$no++){
			echo '<div class="col-md-2 col-sm-3">
                    <div class="widget">
                        <h2>'.$this->elementArray[0][$no][1].'</h2>
                        <ul>';
						
                            $this->drawSubNode($this->elementArray[0][$no][0]);
							
                        echo '</ul>
                    </div>    
                </div>';	
		}		
	}
	
	private function drawSubNode($parentID){
		if(isset($this->elementArray[$parentID])){
			$tab = '';
			for($no=0;$no<count($this->elementArray[$parentID]);$no++){
				
				echo '<li><a href="'.base_url().'post/detail/'.$this->elementArray[$parentID][$no][1].'">'.$this->elementArray[$parentID][$no][1].'</a></li>';
				
			}						
		}		
	}
	
}//end class


?>