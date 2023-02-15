<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*

This is one of the free scripts from www.dhtmlgoodies.com
You are free to use this script as long as this copyright message is kept intact

(c) Alf Magne Kalleland, http://www.dhtmlgoodies.com - 2005

*/

class CI_Listmenubackend {
	
	var $elementArray = array();
	
	
	
	function addToArray($id,$name,$parentID,$level,$order,$up,$down){
		if(empty($parentID))$parentID=0;	
		$this->elementArray[$parentID][] = array($id,$name,$parentID,$level,$order,$up,$down);
	}
	
	
	function drawTree(){
		for($no=0;$no<count($this->elementArray[0]);$no++){
			$order1 = $this->elementArray[0][$no][4] + 1;
			$level = $this->elementArray[0][$no][3] + 1;
			echo "<tr><td>".$this->elementArray[0][$no][1]."";	
			echo "</td><td align='center' class='Parent'>
					<a href='".base_url()."act_settings/order_parent_backend/".$this->elementArray[0][$no][0]."/".$this->elementArray[0][$no][4]."/".$this->elementArray[0][$no][5]."' class='Up'><i style='color:red' class='icon icon-arrow-up'></i></a>	
					<a href='".base_url()."act_settings/order_parent_backend/".$this->elementArray[0][$no][0]."/".$this->elementArray[0][$no][4]."/".$this->elementArray[0][$no][6]."' class='Down'><i style='color:red' class='fa fa-arrow-down'></i></a>
					<script>
					$(document).ready(function() {
						$('.Parent .Up:first').hide();
						$('.Parent .Down:last').hide();
					})
					</script>";	
			echo "</td><td align='right'>
					<a href='".base_url()."settings/menu_manager/add/".$this->elementArray[0][$no][0]."/".$order1."/".$level."' class='btn btn-success btn-xs NewLink'><i class='fa fa-plus'></i></a> &nbsp;
					<a href='".base_url()."settings/menu_manager/edit/".$this->elementArray[0][$no][0]."' class='btn btn-warning btn-xs NewLink'><i class='fa fa-pencil'></i></a> &nbsp;
					<a href='".base_url()."act_settings/delete_menu/".$this->elementArray[0][$no][0]."' class='confirmation btn btn-danger btn-xs'><i class='fa fa-times'></i></a>";	
			echo "</td></tr>";		
			$this->drawSubNode($this->elementArray[0][$no][0]);
		}		
	}
	
	private function drawSubNode($parentID){
		if(isset($this->elementArray[$parentID])){
			$tab = '';
			for($no=0;$no<count($this->elementArray[$parentID]);$no++){
				$order1 = $this->elementArray[$parentID][$no][4] + 1;
				$level = $this->elementArray[$parentID][$no][3] + 1;
			
				if($this->elementArray[$parentID][$no][3] == 2){
					$tab = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				}else{
					$tab = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				}
				echo "<tr><td>".$tab.$this->elementArray[$parentID][$no][1]."";	
				echo "</td><td align='center' class='Child".$this->elementArray[$parentID][$no][2]."'>
					<a href='".base_url()."act_settings/order_child_backend/".$this->elementArray[$parentID][$no][0]."/".$this->elementArray[$parentID][$no][4]."/".$this->elementArray[$parentID][$no][5]."/".$this->elementArray[$parentID][$no][2]."' class='Up'><i style='color:blue' class='fa fa-arrow-up'></i></a>	
					<a href='".base_url()."act_settings/order_child_backend/".$this->elementArray[$parentID][$no][0]."/".$this->elementArray[$parentID][$no][4]."/".$this->elementArray[$parentID][$no][6]."/".$this->elementArray[$parentID][$no][2]."' class='Down'><i style='color:blue' class='fa fa-arrow-down'></i></a>
					<script>
					$(document).ready(function() {
						$('.Child".$this->elementArray[$parentID][$no][2]." .Up:first').hide();
						$('.Child".$this->elementArray[$parentID][$no][2]." .Down:last').hide();
					})
					</script>";
				echo "</td><td align='right'>
					<a href='".base_url()."settings/menu_manager/add/".$this->elementArray[$parentID][$no][0]."/".$order1."/".$level."' class='btn btn-success btn-xs NewLink'><i class='fa fa-plus'></i></a> &nbsp;
					<a href='".base_url()."settings/menu_manager/edit/".$this->elementArray[$parentID][$no][0]."' class='btn btn-warning btn-xs NewLink'><i class='fa fa-pencil'></i></a> &nbsp;
					<a href='".base_url()."act_settings/delete_menu/".$this->elementArray[$parentID][$no][0]."' class='confirmation btn btn-danger btn-xs'><i class='fa fa-times'></i></a>";	
				echo "</td></tr>";	
				
				$this->drawSubNode($this->elementArray[$parentID][$no][0]);
			}						
		}		
	}
	
}//end class


?>