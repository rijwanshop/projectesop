<?php
	$Arr = array();
	$t = 0;
	foreach($sop->result_array() as $row){
		$Arr['kegiatan'][$t] = $row['sop_kegiatan'];
		$Arr['kelengkapan'][$t] = $row['sop_kelengkapan'];
		$Arr['waktu'][$t] = $row['sop_waktu'];
		$Arr['hasil'][$t] = $row['sop_hasil'];
		$Arr['keterangan'][$t] = $row['sop_keterangan'];
		$Arr['pelaksana1'][$t] = $row['sop_pelaksana1'];
		$Arr['pelaksana2'][$t] = $row['sop_pelaksana2'];
		$Arr['pelaksana3'][$t] = $row['sop_pelaksana3'];
		$Arr['pelaksana4'][$t] = $row['sop_pelaksana4'];
		$Arr['pelaksana5'][$t] = $row['sop_pelaksana5'];
		$Arr['pelaksana6'][$t] = $row['sop_pelaksana6'];
		$Arr['pelaksana7'][$t] = $row['sop_pelaksana7'];
		$Arr['pelaksana8'][$t] = $row['sop_pelaksana8'];
		$Arr['pelaksana9'][$t] = $row['sop_pelaksana9'];
		$Arr['pelaksana10'][$t] = $row['sop_pelaksana10'];
		$Arr['pelaksana11'][$t] = $row['sop_pelaksana11'];
		$Arr['pelaksana12'][$t] = $row['sop_pelaksana12'];
		$Arr['pelaksana13'][$t] = $row['sop_pelaksana13'];
		$Arr['pelaksana14'][$t] = $row['sop_pelaksana14'];
		$Arr['pelaksana15'][$t] = $row['sop_pelaksana15'];
		$Arr['pel1'][$t] = $row['sop_nm_pel1'];
		$Arr['pel2'][$t] = $row['sop_nm_pel2'];
		$Arr['pel3'][$t] = $row['sop_nm_pel3'];
		$Arr['pel4'][$t] = $row['sop_nm_pel4'];
		$Arr['pel5'][$t] = $row['sop_nm_pel5'];
		$Arr['pel6'][$t] = $row['sop_nm_pel6'];
		$Arr['pel7'][$t] = $row['sop_nm_pel7'];
		$Arr['pel8'][$t] = $row['sop_nm_pel8'];
		$Arr['pel9'][$t] = $row['sop_nm_pel9'];
		$Arr['pel10'][$t] = $row['sop_nm_pel10'];
		$Arr['pel11'][$t] = $row['sop_nm_pel11'];
		$Arr['pel12'][$t] = $row['sop_nm_pel12'];
		$Arr['pel13'][$t] = $row['sop_nm_pel13'];
		$Arr['pel14'][$t] = $row['sop_nm_pel14'];
		$Arr['pel15'][$t] = $row['sop_nm_pel15'];
		$Arr['decision'][$t] = $row['sop_decision_perbaris'];
		$Arr['pelaksana_perbaris'][$t] = $row['sop_pelaksana_perbaris'];
		
		$t++;
	}
?>

<style>
	#TableKeg th{text-align:center}
	.resize{resize:none; width:35px; height:30px}
	.form-control{font-size:9px; font-family:arial;}
</style>
<form id="FrmKegiatan" method="post" enctype="multipart/form-data">	

		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
		<table cellpadding="3" cellspacing="0" border="1" align="center" id="TableKeg" style='width:32cm; font-size:9px; font-family:arial; color:#000; margin-left:-20px'>
			<tr bgcolor="#ddd">
				<th rowspan="2" width="20" align="left">&nbsp;</th>
				<th rowspan="2" width="20">No.</th>
				<th rowspan="2">Kegiatan</th>
				<th colspan="10">Pelaksana</th>
				<th rowspan="2" width="35" valign="bottom"><textarea name="pelaksana[10]" maxlength="25" class="resize"><?=$Arr['pel11'][0]?></textarea></th>
				<th rowspan="2" width="35" valign="bottom"><textarea name="pelaksana[11]" maxlength="25" class="resize"><?=$Arr['pel12'][0]?></textarea></th>
				<th rowspan="2" width="35" valign="bottom"><textarea name="pelaksana[12]" maxlength="25" class="resize"><?=$Arr['pel13'][0]?></textarea></th>
				<th rowspan="2" width="35" valign="bottom"><textarea name="pelaksana[13]" maxlength="25" class="resize"><?=$Arr['pel14'][0]?></textarea></th>
				<th rowspan="2" width="35" valign="bottom"><textarea name="pelaksana[14]" maxlength="25" class="resize"><?=$Arr['pel15'][0]?></textarea></th>
				<th colspan="3">Mutu Baku</th>
				<th rowspan="2" width="100">Keterangan</th>
			</tr>
			<tr bgcolor="#ddd">
				<th width="35"><textarea name="pelaksana[0]" maxlength="25" class="resize"><?=$Arr['pel1'][0]?></textarea></th>
				<th width="35"><textarea name="pelaksana[1]" maxlength="25" class="resize"><?=$Arr['pel2'][0]?></textarea></th>
				<th width="35"><textarea name="pelaksana[2]" maxlength="25" class="resize"><?=$Arr['pel3'][0]?></textarea></th>
				<th width="35"><textarea name="pelaksana[3]" maxlength="25" class="resize"><?=$Arr['pel4'][0]?></textarea></th>
				<th width="35"><textarea name="pelaksana[4]" maxlength="25" class="resize"><?=$Arr['pel5'][0]?></textarea></th>
				<th width="35"><textarea name="pelaksana[5]" maxlength="25" class="resize"><?=$Arr['pel6'][0]?></textarea></th>
				<th width="35"><textarea name="pelaksana[6]" maxlength="25" class="resize"><?=$Arr['pel7'][0]?></textarea></th>
				<th width="35"><textarea name="pelaksana[7]" maxlength="25" class="resize"><?=$Arr['pel8'][0]?></textarea></th>
				<th width="35"><textarea name="pelaksana[8]" maxlength="25" class="resize"><?=$Arr['pel9'][0]?></textarea></th>
				<th width="35"><textarea name="pelaksana[9]" maxlength="25" class="resize"><?=$Arr['pel10'][0]?></textarea></th>
				<th width="50">Kelengkapan</th>
				<th width="30">Waktu</th>
				<th width="50">Output</th>
			</tr>
			<?php 
				$dc='';
				$no=0;
				for($i=0;$i<$t;$i++){ 
				$no++;
				
				// decision y/t
				if($i == 0 or $no == $t){ $dc='style="display:none"';}
				else{ $dc='style="display:block"';}
			?>
			<tr>
				<td><input type='checkbox' class='caseKeg H<?=$i?>'/></td>
				<td><input type='hidden' name='d[]' class='deci<?=$i?>' value="<?=$Arr['decision'][$i]?>"/><input type='hidden' name='a[]' class='trpel<?=$i?>' value="<?=$Arr['pelaksana_perbaris'][$i]?>"/><span id='snum<?=$no?>'><?=$no?></span></td>
				<td height='135' valign=bottom><textarea type='text' class='form-control' name='kegiatan[]' style='resize:none; height:135px' maxlength='400'/><?=$Arr['kegiatan'][$i]?></textarea></td>
				<td bgcolor='<?php if($Arr['pelaksana1'][$i] == '1-Y'){ if($Arr['decision'][$i] == '1-Y'){echo'#f00';} else {echo'#28de7b';}}else{echo'#fff';}?>' align='center' class='check1_<?=$i?>'><label style='width:100%'><input type='checkbox' onclick='color(1,<?=$i?>)' class='pel<?=$no?> pelaksana1_<?=$i?>' name='check_pelaksana1_<?=$i?>' value='1-Y' <?php if($Arr['pelaksana1'][$i] == '1-Y'){echo' checked';}?>/></label><br><br><div><label class='dc<?=$i?>' <?=$dc?>><div style='padding-top:6px'>Decision</div> <input type='checkbox' class='deci1-<?=$i?>' name='deci1_<?=$i?>' value='1-Y' style='width:10px' onclick='deci(1,<?=$i?>)' <?php if($Arr['decision'][$i] == '1-Y'){echo' checked';}?>/></div></label></td>
				<td bgcolor='<?php if($Arr['pelaksana2'][$i] == '2-Y'){ if($Arr['decision'][$i] == '2-Y'){echo'#f00';} else {echo'#28de7b';}}else{echo'#fff';}?>' align='center' class='check2_<?=$i?>'><label style='width:100%'><input type='checkbox' onclick='color(2,<?=$i?>)' class='pel<?=$no?> pelaksana2_<?=$i?>' name='check_pelaksana2_<?=$i?>' value='2-Y' <?php if($Arr['pelaksana2'][$i] == '2-Y'){echo' checked';}?>/></label><br><br><div><label class='dc<?=$i?>' <?=$dc?>><div style='padding-top:6px'>Decision</div> <input type='checkbox' class='deci2-<?=$i?>' name='deci2_<?=$i?>' value='2-Y' style='width:10px' onclick='deci(2,<?=$i?>)' <?php if($Arr['decision'][$i] == '2-Y'){echo' checked';}?>/></div></label></td>
				<td bgcolor='<?php if($Arr['pelaksana3'][$i] == '3-Y'){ if($Arr['decision'][$i] == '3-Y'){echo'#f00';} else {echo'#28de7b';}}else{echo'#fff';}?>' align='center' class='check3_<?=$i?>'><label style='width:100%'><input type='checkbox' onclick='color(3,<?=$i?>)' class='pel<?=$no?> pelaksana3_<?=$i?>' name='check_pelaksana3_<?=$i?>' value='3-Y' <?php if($Arr['pelaksana3'][$i] == '3-Y'){echo' checked';}?>/></label><br><br><div><label class='dc<?=$i?>' <?=$dc?>><div style='padding-top:6px'>Decision</div> <input type='checkbox' class='deci3-<?=$i?>' name='deci3_<?=$i?>' value='3-Y' style='width:10px' onclick='deci(3,<?=$i?>)' <?php if($Arr['decision'][$i] == '3-Y'){echo' checked';}?>/></div></label></td>
				<td bgcolor='<?php if($Arr['pelaksana4'][$i] == '4-Y'){ if($Arr['decision'][$i] == '4-Y'){echo'#f00';} else {echo'#28de7b';}}else{echo'#fff';}?>' align='center' class='check4_<?=$i?>'><label style='width:100%'><input type='checkbox' onclick='color(4,<?=$i?>)' class='pel<?=$no?> pelaksana4_<?=$i?>' name='check_pelaksana4_<?=$i?>' value='4-Y' <?php if($Arr['pelaksana4'][$i] == '4-Y'){echo' checked';}?>/></label><br><br><div><label class='dc<?=$i?>' <?=$dc?>><div style='padding-top:6px'>Decision</div> <input type='checkbox' class='deci4-<?=$i?>' name='deci4_<?=$i?>' value='4-Y' style='width:10px' onclick='deci(4,<?=$i?>)' <?php if($Arr['decision'][$i] == '4-Y'){echo' checked';}?>/></div></label></td>
				<td bgcolor='<?php if($Arr['pelaksana5'][$i] == '5-Y'){ if($Arr['decision'][$i] == '5-Y'){echo'#f00';} else {echo'#28de7b';}}else{echo'#fff';}?>' align='center' class='check5_<?=$i?>'><label style='width:100%'><input type='checkbox' onclick='color(5,<?=$i?>)' class='pel<?=$no?> pelaksana5_<?=$i?>' name='check_pelaksana5_<?=$i?>' value='5-Y' <?php if($Arr['pelaksana5'][$i] == '5-Y'){echo' checked';}?>/></label><br><br><div><label class='dc<?=$i?>' <?=$dc?>><div style='padding-top:6px'>Decision</div> <input type='checkbox' class='deci5-<?=$i?>' name='deci5_<?=$i?>' value='5-Y' style='width:10px' onclick='deci(5,<?=$i?>)' <?php if($Arr['decision'][$i] == '5-Y'){echo' checked';}?>/></div></label></td>
				<td bgcolor='<?php if($Arr['pelaksana6'][$i] == '6-Y'){ if($Arr['decision'][$i] == '6-Y'){echo'#f00';} else {echo'#28de7b';}}else{echo'#fff';}?>' align='center' class='check6_<?=$i?>'><label style='width:100%'><input type='checkbox' onclick='color(6,<?=$i?>)' class='pel<?=$no?> pelaksana6_<?=$i?>' name='check_pelaksana6_<?=$i?>' value='6-Y' <?php if($Arr['pelaksana6'][$i] == '6-Y'){echo' checked';}?>/></label><br><br><div><label class='dc<?=$i?>' <?=$dc?>><div style='padding-top:6px'>Decision</div> <input type='checkbox' class='deci6-<?=$i?>' name='deci6_<?=$i?>' value='6-Y' style='width:10px' onclick='deci(6,<?=$i?>)' <?php if($Arr['decision'][$i] == '6-Y'){echo' checked';}?>/></div></label></td>
				<td bgcolor='<?php if($Arr['pelaksana7'][$i] == '7-Y'){ if($Arr['decision'][$i] == '7-Y'){echo'#f00';} else {echo'#28de7b';}}else{echo'#fff';}?>' align='center' class='check7_<?=$i?>'><label style='width:100%'><input type='checkbox' onclick='color(7,<?=$i?>)' class='pel<?=$no?> pelaksana7_<?=$i?>' name='check_pelaksana7_<?=$i?>' value='7-Y' <?php if($Arr['pelaksana7'][$i] == '7-Y'){echo' checked';}?>/></label><br><br><div><label class='dc<?=$i?>' <?=$dc?>><div style='padding-top:6px'>Decision</div> <input type='checkbox' class='deci7-<?=$i?>' name='deci7_<?=$i?>' value='7-Y' style='width:10px' onclick='deci(7,<?=$i?>)' <?php if($Arr['decision'][$i] == '7-Y'){echo' checked';}?>/></div></label></td>
				<td bgcolor='<?php if($Arr['pelaksana8'][$i] == '8-Y'){ if($Arr['decision'][$i] == '8-Y'){echo'#f00';} else {echo'#28de7b';}}else{echo'#fff';}?>' align='center' class='check8_<?=$i?>'><label style='width:100%'><input type='checkbox' onclick='color(8,<?=$i?>)' class='pel<?=$no?> pelaksana8_<?=$i?>' name='check_pelaksana8_<?=$i?>' value='8-Y' <?php if($Arr['pelaksana8'][$i] == '8-Y'){echo' checked';}?>/></label><br><br><div><label class='dc<?=$i?>' <?=$dc?>><div style='padding-top:6px'>Decision</div> <input type='checkbox' class='deci8-<?=$i?>' name='deci8_<?=$i?>' value='8-Y' style='width:10px' onclick='deci(8,<?=$i?>)' <?php if($Arr['decision'][$i] == '8-Y'){echo' checked';}?>/></div></label></td>
				<td bgcolor='<?php if($Arr['pelaksana9'][$i] == '9-Y'){ if($Arr['decision'][$i] == '9-Y'){echo'#f00';} else {echo'#28de7b';}}else{echo'#fff';}?>' align='center' class='check9_<?=$i?>'><label style='width:100%'><input type='checkbox' onclick='color(9,<?=$i?>)' class='pel<?=$no?> pelaksana9_<?=$i?>' name='check_pelaksana9_<?=$i?>' value='9-Y' <?php if($Arr['pelaksana9'][$i] == '9-Y'){echo' checked';}?>/></label><br><br><div><label class='dc<?=$i?>' <?=$dc?>><div style='padding-top:6px'>Decision</div> <input type='checkbox' class='deci9-<?=$i?>' name='deci9_<?=$i?>' value='9-Y' style='width:10px' onclick='deci(9,<?=$i?>)' <?php if($Arr['decision'][$i] == '9-Y'){echo' checked';}?>/></div></label></td>
				<td bgcolor='<?php if($Arr['pelaksana10'][$i] == '10-Y'){ if($Arr['decision'][$i] == '10-Y'){echo'#f00';} else {echo'#28de7b';}}else{echo'#fff';}?>' align='center' class='check10_<?=$i?>'><label style='width:100%'><input type='checkbox' onclick='color(10,<?=$i?>)' class='pel<?=$no?> pelaksana10_<?=$i?>' name='check_pelaksana10_<?=$i?>' value='10-Y' <?php if($Arr['pelaksana10'][$i] == '10-Y'){echo' checked';}?>/></label><br><br><div><label class='dc<?=$i?>' <?=$dc?>><div style='padding-top:6px'>Decision</div> <input type='checkbox' class='deci10-<?=$i?>' name='deci10_<?=$i?>' value='10-Y' style='width:10px' onclick='deci(10,<?=$i?>)' <?php if($Arr['decision'][$i] == '10-Y'){echo' checked';}?>/></div></label></td>
				<td bgcolor='<?php if($Arr['pelaksana11'][$i] == '11-Y'){ if($Arr['decision'][$i] == '11-Y'){echo'#f00';} else {echo'#28de7b';}}else{echo'#fff';}?>' align='center' class='check11_<?=$i?>'><label style='width:100%'><input type='checkbox' onclick='color(11,<?=$i?>)' class='pel<?=$no?> pelaksana11_<?=$i?>' name='check_pelaksana11_<?=$i?>' value='11-Y' <?php if($Arr['pelaksana11'][$i] == '11-Y'){echo' checked';}?>/></label><br><br><div><label class='dc<?=$i?>' <?=$dc?>><div style='padding-top:6px'>Decision</div> <input type='checkbox' class='deci11-<?=$i?>' name='deci11_<?=$i?>' value='11-Y' style='width:10px' onclick='deci(11,<?=$i?>)' <?php if($Arr['decision'][$i] == '11-Y'){echo' checked';}?>/></div></label></td>
				<td bgcolor='<?php if($Arr['pelaksana12'][$i] == '12-Y'){ if($Arr['decision'][$i] == '12-Y'){echo'#f00';} else {echo'#28de7b';}}else{echo'#fff';}?>' align='center' class='check12_<?=$i?>'><label style='width:100%'><input type='checkbox' onclick='color(12,<?=$i?>)' class='pel<?=$no?> pelaksana12_<?=$i?>' name='check_pelaksana12_<?=$i?>' value='12-Y' <?php if($Arr['pelaksana12'][$i] == '12-Y'){echo' checked';}?>/></label><br><br><div><label class='dc<?=$i?>' <?=$dc?>><div style='padding-top:6px'>Decision</div> <input type='checkbox' class='deci12-<?=$i?>' name='deci12_<?=$i?>' value='12-Y' style='width:10px' onclick='deci(12,<?=$i?>)' <?php if($Arr['decision'][$i] == '12-Y'){echo' checked';}?>/></div></label></td>
				<td bgcolor='<?php if($Arr['pelaksana13'][$i] == '13-Y'){ if($Arr['decision'][$i] == '13-Y'){echo'#f00';} else {echo'#28de7b';}}else{echo'#fff';}?>' align='center' class='check13_<?=$i?>'><label style='width:100%'><input type='checkbox' onclick='color(13,<?=$i?>)' class='pel<?=$no?> pelaksana13_<?=$i?>' name='check_pelaksana13_<?=$i?>' value='13-Y' <?php if($Arr['pelaksana13'][$i] == '13-Y'){echo' checked';}?>/></label><br><br><div><label class='dc<?=$i?>' <?=$dc?>><div style='padding-top:6px'>Decision</div> <input type='checkbox' class='deci13-<?=$i?>' name='deci13_<?=$i?>' value='13-Y' style='width:10px' onclick='deci(13,<?=$i?>)' <?php if($Arr['decision'][$i] == '13-Y'){echo' checked';}?>/></div></label></td>
				<td bgcolor='<?php if($Arr['pelaksana14'][$i] == '14-Y'){ if($Arr['decision'][$i] == '14-Y'){echo'#f00';} else {echo'#28de7b';}}else{echo'#fff';}?>' align='center' class='check14_<?=$i?>'><label style='width:100%'><input type='checkbox' onclick='color(14,<?=$i?>)' class='pel<?=$no?> pelaksana14_<?=$i?>' name='check_pelaksana14_<?=$i?>' value='14-Y' <?php if($Arr['pelaksana14'][$i] == '14-Y'){echo' checked';}?>/></label><br><br><div><label class='dc<?=$i?>' <?=$dc?>><div style='padding-top:6px'>Decision</div> <input type='checkbox' class='deci14-<?=$i?>' name='deci14_<?=$i?>' value='14-Y' style='width:10px' onclick='deci(14,<?=$i?>)' <?php if($Arr['decision'][$i] == '14-Y'){echo' checked';}?>/></div></label></td>
				<td bgcolor='<?php if($Arr['pelaksana15'][$i] == '15-Y'){ if($Arr['decision'][$i] == '15-Y'){echo'#f00';} else {echo'#28de7b';}}else{echo'#fff';}?>' align='center' class='check15_<?=$i?>'><label style='width:100%'><input type='checkbox' onclick='color(15,<?=$i?>)' class='pel<?=$no?> pelaksana15_<?=$i?>' name='check_pelaksana15_<?=$i?>' value='15-Y' <?php if($Arr['pelaksana15'][$i] == '15-Y'){echo' checked';}?>/></label><br><br><div><label class='dc<?=$i?>' <?=$dc?>><div style='padding-top:6px'>Decision</div> <input type='checkbox' class='deci15-<?=$i?>' name='deci15_<?=$i?>' value='15-Y' style='width:10px' onclick='deci(15,<?=$i?>)' <?php if($Arr['decision'][$i] == '15-Y'){echo' checked';}?>/></div></label></td>
				<td valign=bottom><textarea type='text' class='form-control' name='kelengkapan[]' maxlength='110'/><?=$Arr['kelengkapan'][$i]?></textarea></td>
				<td valign=bottom><input type='text' class='form-control' name='waktu[]' maxlength='40' value="<?=$Arr['waktu'][$i]?>"/></td>
				<td valign=bottom><textarea type='text' class='form-control' name='hasil[]' maxlength='110'/><?=$Arr['hasil'][$i]?></textarea></td>
				<td valign=bottom><textarea type='text' class='form-control' name='keterangan[]' maxlength='150'/><?=$Arr['keterangan'][$i]?></textarea></td>
			</tr>
			<?php } ?>	
		</table>
		<br>
		<button type="button" class='btn btn-xs btn-danger deleteKeg'>- Hapus</button>
		<button type="button" class='btn btn-xs btn-success addmoreKeg'>+ Tambah Kegiatan</button>
		<button type="submit" class="btn btn-success" style="float:right; margin:5px 0 20px 0; width:120px; height:40px">Lanjut</button>
</form>
			
			
			
			<script>
			$( document ).ready(function() {
				$('.caseKeg').css('display','none');
				$('.caseKeg:last').css('display','block');
			});

			$(".deleteKeg").on('click', function() {
				$('.caseKeg:checkbox:checked').parents("tr").remove();
				$('.check_allKeg').prop("checked", false); 
				 
				$('.caseKeg:last').css('display','block');
			
			});
			$(".addmoreKeg").on('click',function(){
				count=$('#TableKeg tr').length - 1;
				no=$('#TableKeg tr').length - 2;
				var prev = no -1;
					var data="<tr><td><input type='checkbox' class='caseKeg H"+no+"' style='display:none'/></td>";
						data +="<td><input type='hidden' name='d[]' class='deci"+no+"'/><input type='hidden' name='a[]' class='trpel"+no+"'/><span id='snum"+count+"'>"+count+".</span></td>";
							data +="<td height='135' valign=bottom><textarea type='text' class='form-control' name='kegiatan[]' style='resize:none; height:135px' maxlength='400'/></textarea></td>";
							data +="<td bgcolor='#fff' align='center' class='check1_"+no+"'><label style='width:100%'><input type='checkbox' onclick='color(1,"+no+")' class='pel"+count+" pelaksana1_"+no+"' name='check_pelaksana1_"+no+"' value='1-Y'/></label><br><br><div><label class='dc"+no+"' style='display:none'><div style='padding-top:6px'>Decision</div> <input type='checkbox' class='deci1-"+no+"' name='deci1_"+no+"' value='1-Y' style='width:10px' onclick='deci(1,"+no+")'/></div></label></td>";
							data +="<td bgcolor='#fff' align='center' class='check2_"+no+"'><label style='width:100%'><input type='checkbox' onclick='color(2,"+no+")' class='pel"+count+" pelaksana2_"+no+"' name='check_pelaksana2_"+no+"' value='2-Y'/></label><br><br><div><label class='dc"+no+"' style='display:none'><div style='padding-top:6px'>Decision</div> <input type='checkbox' class='deci2-"+no+"' name='deci2_"+no+"' value='2-Y' style='width:10px' onclick='deci(2,"+no+")'/></div></label></td>";
							data +="<td bgcolor='#fff' align='center' class='check3_"+no+"'><label style='width:100%'><input type='checkbox' onclick='color(3,"+no+")' class='pel"+count+" pelaksana3_"+no+"' name='check_pelaksana3_"+no+"' value='3-Y'/></label><br><br><div><label class='dc"+no+"' style='display:none'><div style='padding-top:6px'>Decision</div> <input type='checkbox' class='deci3-"+no+"' name='deci3_"+no+"' value='3-Y' style='width:10px' onclick='deci(3,"+no+")'/></div></label></td>";
							data +="<td bgcolor='#fff' align='center' class='check4_"+no+"'><label style='width:100%'><input type='checkbox' onclick='color(4,"+no+")' class='pel"+count+" pelaksana4_"+no+"' name='check_pelaksana4_"+no+"' value='4-Y'/></label><br><br><div><label class='dc"+no+"' style='display:none'><div style='padding-top:6px'>Decision</div> <input type='checkbox' class='deci4-"+no+"' name='deci4_"+no+"' value='4-Y' style='width:10px' onclick='deci(4,"+no+")'/></div></label></td>";
							data +="<td bgcolor='#fff' align='center' class='check5_"+no+"'><label style='width:100%'><input type='checkbox' onclick='color(5,"+no+")' class='pel"+count+" pelaksana5_"+no+"' name='check_pelaksana5_"+no+"' value='5-Y'/></label><br><br><div><label class='dc"+no+"' style='display:none'><div style='padding-top:6px'>Decision</div> <input type='checkbox' class='deci5-"+no+"' name='deci5_"+no+"' value='5-Y' style='width:10px' onclick='deci(5,"+no+")'/></div></label></td>";
							data +="<td bgcolor='#fff' align='center' class='check6_"+no+"'><label style='width:100%'><input type='checkbox' onclick='color(6,"+no+")' class='pel"+count+" pelaksana6_"+no+"' name='check_pelaksana6_"+no+"' value='6-Y'/></label><br><br><div><label class='dc"+no+"' style='display:none'><div style='padding-top:6px'>Decision</div> <input type='checkbox' class='deci6-"+no+"' name='deci6_"+no+"' value='6-Y' style='width:10px' onclick='deci(6,"+no+")'/></div></label></td>";
							data +="<td bgcolor='#fff' align='center' class='check7_"+no+"'><label style='width:100%'><input type='checkbox' onclick='color(7,"+no+")' class='pel"+count+" pelaksana7_"+no+"' name='check_pelaksana7_"+no+"' value='7-Y'/></label><br><br><div><label class='dc"+no+"' style='display:none'><div style='padding-top:6px'>Decision</div> <input type='checkbox' class='deci7-"+no+"' name='deci7_"+no+"' value='7-Y' style='width:10px' onclick='deci(7,"+no+")'/></div></label></td>";
							data +="<td bgcolor='#fff' align='center' class='check8_"+no+"'><label style='width:100%'><input type='checkbox' onclick='color(8,"+no+")' class='pel"+count+" pelaksana8_"+no+"' name='check_pelaksana8_"+no+"' value='8-Y'/></label><br><br><div><label class='dc"+no+"' style='display:none'><div style='padding-top:6px'>Decision</div> <input type='checkbox' class='deci8-"+no+"' name='deci8_"+no+"' value='8-Y' style='width:10px' onclick='deci(8,"+no+")'/></div></label></td>";
							data +="<td bgcolor='#fff' align='center' class='check9_"+no+"'><label style='width:100%'><input type='checkbox' onclick='color(9,"+no+")' class='pel"+count+" pelaksana9_"+no+"' name='check_pelaksana9_"+no+"' value='9-Y'/></label><br><br><div><label class='dc"+no+"' style='display:none'><div style='padding-top:6px'>Decision</div> <input type='checkbox' class='deci9-"+no+"' name='deci9_"+no+"' value='9-Y' style='width:10px' onclick='deci(9,"+no+")'/></div></label></td>";
							data +="<td bgcolor='#fff' align='center' class='check10_"+no+"'><label style='width:100%'><input type='checkbox' onclick='color(10,"+no+")' class='pel"+count+" pelaksana10_"+no+"' name='check_pelaksana10_"+no+"' value='10-Y'/></label><br><br><div><label class='dc"+no+"' style='display:none'><div style='padding-top:6px'>Decision</div> <input type='checkbox' class='deci10-"+no+"' name='deci10_"+no+"' value='10-Y' style='width:10px' onclick='deci(10,"+no+")'/></div></label></td>";
							data +="<td bgcolor='#fff' align='center' class='check11_"+no+"'><label style='width:100%'><input type='checkbox' onclick='color(11,"+no+")' class='pel"+count+" pelaksana11_"+no+"' name='check_pelaksana11_"+no+"' value='11-Y'/></label><br><br><div><label class='dc"+no+"' style='display:none'><div style='padding-top:6px'>Decision</div> <input type='checkbox' class='deci11-"+no+"' name='deci11_"+no+"' value='11-Y' style='width:10px' onclick='deci(11,"+no+")'/></div></label></td>";
							data +="<td bgcolor='#fff' align='center' class='check12_"+no+"'><label style='width:100%'><input type='checkbox' onclick='color(12,"+no+")' class='pel"+count+" pelaksana12_"+no+"' name='check_pelaksana12_"+no+"' value='12-Y'/></label><br><br><div><label class='dc"+no+"' style='display:none'><div style='padding-top:6px'>Decision</div> <input type='checkbox' class='deci12-"+no+"' name='deci12_"+no+"' value='12-Y' style='width:10px' onclick='deci(12,"+no+")'/></div></label></td>";
							data +="<td bgcolor='#fff' align='center' class='check13_"+no+"'><label style='width:100%'><input type='checkbox' onclick='color(13,"+no+")' class='pel"+count+" pelaksana13_"+no+"' name='check_pelaksana13_"+no+"' value='13-Y'/></label><br><br><div><label class='dc"+no+"' style='display:none'><div style='padding-top:6px'>Decision</div> <input type='checkbox' class='deci13-"+no+"' name='deci13_"+no+"' value='13-Y' style='width:10px' onclick='deci(13,"+no+")'/></div></label></td>";
							data +="<td bgcolor='#fff' align='center' class='check14_"+no+"'><label style='width:100%'><input type='checkbox' onclick='color(14,"+no+")' class='pel"+count+" pelaksana14_"+no+"' name='check_pelaksana14_"+no+"' value='14-Y'/></label><br><br><div><label class='dc"+no+"' style='display:none'><div style='padding-top:6px'>Decision</div> <input type='checkbox' class='deci14-"+no+"' name='deci14_"+no+"' value='14-Y' style='width:10px' onclick='deci(14,"+no+")'/></div></label></td>";
							data +="<td bgcolor='#fff' align='center' class='check15_"+no+"'><label style='width:100%'><input type='checkbox' onclick='color(15,"+no+")' class='pel"+count+" pelaksana15_"+no+"' name='check_pelaksana15_"+no+"' value='15-Y'/></label><br><br><div><label class='dc"+no+"' style='display:none'><div style='padding-top:6px'>Decision</div> <input type='checkbox' class='deci15-"+no+"' name='deci15_"+no+"' value='15-Y' style='width:10px' onclick='deci(15,"+no+")'/></div></label></td>";
							data +="<td valign=bottom><textarea type='text' class='form-control' name='kelengkapan[]' maxlength='110' style='resize:none; height:135px;'/></textarea></td>";
							data +="<td valign=bottom><textarea type='text' class='form-control' name='waktu[]' maxlength='40' style='resize:none; height:135px;'/></textarea></td>";
							data +="<td valign=bottom><textarea type='text' class='form-control' name='hasil[]' maxlength='110' style='resize:none; height:135px;'/></textarea></td>";
							data +="<td valign=bottom><textarea type='text' class='form-control' name='keterangan[]' maxlength='150' style='resize:none; height:135px;'/></textarea></td>";
							data +="</tr>";
							

				$('#TableKeg').append(data);
				 
				$('.caseKeg').css('display','none');
				$('.H'+no+'').css('display','block');
				
				if(no > 1){
					$(".dc"+prev).show();
				}
			});
			function select_allKeg() {
				$('input[class=caseKeg]:checkbox').each(function(){ 
					if($('input[class=check_allKeg]:checkbox:checked').length == 0){ 
						$(this).prop("checked", false); 
					} else {
						$(this).prop("checked", true); 
					} 
				});
			}
			function color(pel,no) {
				var vala = [];
				var count = no+1;
				if($('.pelaksana'+pel+'_'+no+':checkbox:checked').length == 0){ 
					$('.check'+pel+'_'+no+'').css({
						'background-color': '#fff'
					});
					$('.deci'+pel+'-'+no+'').prop('checked', false);
					$('.deci'+no+'').val('');
				}else{
					$('.check'+pel+'_'+no+'').css({
						'background-color': '#28de7b'
					});
				}
				
				
				$('.pel'+count+':checkbox:checked').each(function (i) {
					var ex = $(this).val().split('-');
					vala.push(ex[0]);
				});

				$('.trpel'+no+'').val(vala.join());
			}
			function deci(pel,no) {
				if($('.deci'+pel+'-'+no+':checkbox:checked').length == 0){ 
					$('.deci'+no+'').val('');
					$('.check'+pel+'_'+no+'').css({
						'background-color': '#28de7b'
					});
				}else{
					$('.deci'+no+'').val(''+pel+'-Y');
					$('.check'+pel+'_'+no+'').css({
						'background-color': '#f00'
					});
					$('.pelaksana'+pel+'_'+no+'').prop('checked', true);
					$('.trpel'+no+'').val(pel);
				}
			}
			</script>