<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*

This is one of the free scripts from www.dhtmlgoodies.com
You are free to use this script as long as this copyright message is kept intact

(c) Alf Magne Kalleland, http://www.dhtmlgoodies.com - 2005

*/

class CI_Listmenufrontend {
	
	var $elementArray = array();
	
	
	
	function addToArray($id,$name,$parentID,$position,$status,$type,$order,$up,$down,$domain){
		if(empty($parentID))$parentID=0;	
		$this->elementArray[$parentID][] = array($id,$name,$parentID,$position,$status,$type,$order,$up,$down,$domain);
	}
	
	
	function drawTree(){
		for($no=0;$no<count($this->elementArray[0]);$no++){
			echo "<tr><td>".$this->elementArray[0][$no][1]."";	
			echo "</td><td><a target='_blank' href='http://".$this->elementArray[0][$no][9]."' style='color:#0475ba; font-weight:bold'>".$this->elementArray[0][$no][9]."</a>";	
			echo "</td><td align='center' class='Parent'>
					<a href='".base_url()."ADMmenu/order_parent_frontend/".$this->elementArray[0][$no][0]."/".$this->elementArray[0][$no][6]."/".$this->elementArray[0][$no][7]."' class='Up'><i style='color:red' class='icon-arrow-up'></i></a>	
					<a href='".base_url()."ADMmenu/order_parent_frontend/".$this->elementArray[0][$no][0]."/".$this->elementArray[0][$no][6]."/".$this->elementArray[0][$no][8]."' class='Down'><i style='color:red' class='icon-arrow-down'></i></a>";	
			echo "</td><td>".($this->elementArray[0][$no][5] == 'F' ? '<label class=\'label label-info\'>File</label>' : '<label class=\'label label-warning\'>Content</label>')."";	
			echo "</td><td>".($this->elementArray[0][$no][3] == 'T' ? '<label class=\'label label-info\'>TOP</label>' : '<label class=\'label label-warning\'>BOTTOM</label>')."";	
			echo "</td><td>".($this->elementArray[0][$no][4] == 'Y' ? '<label class=\'label label-success\'>Active</label>' : '<label class=\'label label-danger\'>Non Active</label>')."";	
			echo "</td><td align='right'>
					<a href='".base_url()."KAPd/menu/menu_frontend/add/".$this->elementArray[0][$no][0]."' class='btn btn-success btn-xs NewLink'><i class='icon-plus'></i></a> &nbsp;&nbsp;
					<a href='".base_url()."KAPd/menu/menu_frontend/edit/".$this->elementArray[0][$no][0]."' class='btn btn-warning btn-xs NewLink'><i class='icon-pencil'></i></a> &nbsp;&nbsp;
					<a href='".base_url()."ADMmenu/delete_menu_frontend/".$this->elementArray[0][$no][0]."' class='btn btn-danger btn-xs'><i class='icon-trash'></i></a>";	
			echo "</td></tr>";		
			$this->drawSubNode($this->elementArray[0][$no][0]);
		}		
	}
	
	private function drawSubNode($parentID){
		if(isset($this->elementArray[$parentID])){
			$tab = '';
			for($no=0;$no<count($this->elementArray[$parentID]);$no++){
				$tab = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<tr><td>".$tab.$this->elementArray[$parentID][$no][1]."";	
			echo "</td><td><a target='_blank' href='http://".$this->elementArray[$parentID][$no][9]."' style='color:#0475ba; font-weight:bold'>".$this->elementArray[$parentID][$no][9]."</a>";	
				echo "</td><td align='center' class='Child".$this->elementArray[$parentID][$no][2]."'>
					<a href='".base_url()."ADMmenu/order_child_frontend/".$this->elementArray[$parentID][$no][0]."/".$this->elementArray[$parentID][$no][6]."/".$this->elementArray[$parentID][$no][7]."/".$this->elementArray[$parentID][$no][2]."' class='Up'><i style='color:blue' class='icon-arrow-up'></i></a>	
					<a href='".base_url()."ADMmenu/order_child_frontend/".$this->elementArray[$parentID][$no][0]."/".$this->elementArray[$parentID][$no][6]."/".$this->elementArray[$parentID][$no][8]."/".$this->elementArray[$parentID][$no][2]."' class='Down'><i style='color:blue' class='icon-arrow-down'></i></a>
					<script>
					$(document).ready(function() {
						$('.Child".$this->elementArray[$parentID][$no][2]." .Up:first').hide();
						$('.Child".$this->elementArray[$parentID][$no][2]." .Down:last').hide();
					})
					</script>";
				echo "</td><td>".($this->elementArray[$parentID][$no][5] == 'F' ? '<label class=\'label label-info\'>File</label>' : '<label class=\'label label-warning\'>Content</label>')."";	
				echo "</td><td>".($this->elementArray[$parentID][$no][3] == 'T' ? '<label class=\'label label-info\'>TOP</label>' : '<label class=\'label label-warning\'>BOTTOM</label>')."";	
				echo "</td><td>".($this->elementArray[$parentID][$no][4] == 'Y' ? '<label class=\'label label-success\'>Active</label>' : '<label class=\'label label-danger\'>Non Active</label>')."";	
				echo "</td><td align='right'>
					<a href='".base_url()."KAPd/menu/menu_frontend/edit/".$this->elementArray[$parentID][$no][0]."' class='btn btn-warning btn-xs NewLink'><i class='icon-pencil'></i></a> &nbsp;&nbsp;
					<a href='".base_url()."ADMmenu/delete_menu_frontend/".$this->elementArray[$parentID][$no][0]."' class='btn btn-danger btn-xs'><i class='icon-trash'></i></a>";	
				echo "</td></tr>";	
			}						
		}		
	}
	
}//end class


?>