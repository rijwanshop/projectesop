<?php
	defined('BASEPATH') OR exit('No direct script access allowed'); 
?>
<tr>
	<td>
		<input type='checkbox' class='caseKeg H<?= $no; ?>' style='display:none'/>
	</td>
	<td>
		<input type='hidden' name='d[]' class='deci<?= $no; ?>'/>
		<input type='hidden' name='a[]' class='trpel<?= $no; ?>'/>
		<span id='snum"+count+"'><?= $count ?></span>
	</td>
	<td height='135' valign=bottom>
		<textarea type='text' class='form-control' name='kegiatan[]' style='resize:none; height:135px;' maxlength='400'/></textarea>
	</td>
	<td bgcolor='#fff' align='center' class='check1_<?= $no; ?>'>
		<label style='width:100%'>
			<input type='checkbox' onclick='color(1,"<?= $no ?>")' class='pel<?= $count ?> pelaksana1_<?= $no; ?>' name='check_pelaksana1_<?= $no; ?>' value='1-Y'/>
		</label>
		<br><br>
		<div>
			<label class='dc"+no+"' style='display:none'>
				<div style='padding-top:6px;'>Decision</div> 
				<input type='checkbox' class='deci1-"+no+"' name='deci1_"+no+"' value='1-Y' style='width:10px;' onclick='deci(1,"+no+")'/>
			</label>
		</div>
	</td>
	<td bgcolor='#fff' align='center' class='check2_"+no+"'>
		<label style='width:100%'>
			<input type='checkbox' onclick='color(2,"+no+")' class='pel"+count+" pelaksana2_"+no+"' name='check_pelaksana2_"+no+"' value='2-Y'/>
		</label>
		<br><br>
		<div>
			<label class='dc"+no+"' style='display:none'>
				<div style='padding-top:6px;'>Decision</div> 
				<input type='checkbox' class='deci2-"+no+"' name='deci2_"+no+"' value='2-Y' style='width:10px;' onclick='deci(2,"+no+")'/>
			</div>
		</label>
	</td>
	<td bgcolor='#fff' align='center' class='check3_"+no+"'>
		<label style='width:100%'>
			<input type='checkbox' onclick='color(3,"+no+")' class='pel"+count+" pelaksana3_"+no+"' name='check_pelaksana3_"+no+"' value='3-Y'/>
		</label>
		<br><br>
		<div>
			<label class='dc"+no+"' style='display:none'>
				<div style='padding-top:6px;'>Decision</div> 
				<input type='checkbox' class='deci3-"+no+"' name='deci3_"+no+"' value='3-Y' style='width:10px;' onclick='deci(3,"+no+")'/>
			</div>
		</label>
	</td>
	<td bgcolor='#fff' align='center' class='check4_"+no+"'>
		<label style='width:100%'>
			<input type='checkbox' onclick='color(4,"+no+")' class='pel"+count+" pelaksana4_"+no+"' name='check_pelaksana4_"+no+"' value='4-Y'/>
		</label>
		<br><br>
		<div>
			<label class='dc"+no+"' style='display:none'>
				<div style='padding-top:6px;'>Decision</div> 
				<input type='checkbox' class='deci4-"+no+"' name='deci4_"+no+"' value='4-Y' style='width:10px;' onclick='deci(4,"+no+")'/>
			</div>
		</label>
	</td>
	<td bgcolor='#fff' align='center' class='check5_"+no+"'>
		<label style='width:100%'>
			<input type='checkbox' onclick='color(5,"+no+")' class='pel"+count+" pelaksana5_"+no+"' name='check_pelaksana5_"+no+"' value='5-Y'/>
		</label>
		<br><br>
		<div>
			<label class='dc"+no+"' style='display:none'>
				<div style='padding-top:6px;'>Decision</div> 
				<input type='checkbox' class='deci5-"+no+"' name='deci5_"+no+"' value='5-Y' style='width:10px;' onclick='deci(5,"+no+")'/>
			</div>
		</label>
	</td>
	<td bgcolor='#fff' align='center' class='check6_"+no+"'>
		<label style='width:100%'>
			<input type='checkbox' onclick='color(6,"+no+")' class='pel"+count+" pelaksana6_"+no+"' name='check_pelaksana6_"+no+"' value='6-Y'/>
		</label>
		<br><br>
		<div>
			<label class='dc"+no+"' style='display:none'>
				<div style='padding-top:6px;'>Decision</div> 
				<input type='checkbox' class='deci6-"+no+"' name='deci6_"+no+"' value='6-Y' style='width:10px;' onclick='deci(6,"+no+")'/>
			</div>
		</label>
	</td>
	<td bgcolor='#fff' align='center' class='check7_"+no+"'>
		<label style='width:100%'>
			<input type='checkbox' onclick='color(7,"+no+")' class='pel"+count+" pelaksana7_"+no+"' name='check_pelaksana7_"+no+"' value='7-Y'/>
		</label>
		<br><br>
		<div>
			<label class='dc"+no+"' style='display:none'>
				<div style='padding-top:6px;'>Decision</div> 
				<input type='checkbox' class='deci7-"+no+"' name='deci7_"+no+"' value='7-Y' style='width:10px;' onclick='deci(7,"+no+")'/>
			</div>
		</label>
	</td>
	<td bgcolor='#fff' align='center' class='check8_"+no+"'>
		<label style='width:100%'>
			<input type='checkbox' onclick='color(8,"+no+")' class='pel"+count+" pelaksana8_"+no+"' name='check_pelaksana8_"+no+"' value='8-Y'/>
		</label>
		<br><br>
		<div>
			<label class='dc"+no+"' style='display:none'>
				<div style='padding-top:6px;'>Decision</div> 
				<input type='checkbox' class='deci8-"+no+"' name='deci8_"+no+"' value='8-Y' style='width:10px;' onclick='deci(8,"+no+")'/>
			</div>
		</label>
	</td>
	<td bgcolor='#fff' align='center' class='check9_"+no+"'>
		<label style='width:100%'>
			<input type='checkbox' onclick='color(9,"+no+")' class='pel"+count+" pelaksana9_"+no+"' name='check_pelaksana9_"+no+"' value='9-Y'/>
		</label>
		<br><br>
		<div>
			<label class='dc"+no+"' style='display:none'>
				<div style='padding-top:6px;'>Decision</div> 
				<input type='checkbox' class='deci9-"+no+"' name='deci9_"+no+"' value='9-Y' style='width:10px;' onclick='deci(9,"+no+")'/>
			</div>
		</label>
	</td>
	<td bgcolor='#fff' align='center' class='check10_"+no+"'>
		<label style='width:100%'>
			<input type='checkbox' onclick='color(10,"+no+")' class='pel"+count+" pelaksana10_"+no+"' name='check_pelaksana10_"+no+"' value='10-Y'/>
		</label>
		<br><br>
		<div>
			<label class='dc"+no+"' style='display:none'>
				<div style='padding-top:6px;'>Decision</div> 
				<input type='checkbox' class='deci10-"+no+"' name='deci10_"+no+"' value='10-Y' style='width:10px;' onclick='deci(10,"+no+")'/>
			</div>
		</label>
	</td>
	<td bgcolor='#fff' align='center' class='check11_"+no+"'>
		<label style='width:100%'>
			<input type='checkbox' onclick='color(11,"+no+")' class='pel"+count+" pelaksana11_"+no+"' name='check_pelaksana11_"+no+"' value='11-Y'/>
		</label>
		<br><br>
		<div>
			<label class='dc"+no+"' style='display:none'>
				<div style='padding-top:6px;'>Decision</div> 
				<input type='checkbox' class='deci11-"+no+"' name='deci11_"+no+"' value='11-Y' style='width:10px;' onclick='deci(11,"+no+")'/>
			</div>
		</label>
	</td>
	<td bgcolor='#fff' align='center' class='check12_"+no+"'>
		<label style='width:100%'>
			<input type='checkbox' onclick='color(12,"+no+")' class='pel"+count+" pelaksana12_"+no+"' name='check_pelaksana12_"+no+"' value='12-Y'/>
		</label>
		<br><br>
		<div>
			<label class='dc"+no+"' style='display:none'>
				<div style='padding-top:6px;'>Decision</div> 
				<input type='checkbox' class='deci12-"+no+"' name='deci12_"+no+"' value='12-Y' style='width:10px;' onclick='deci(12,"+no+")'/>
			</div>
		</label>
	</td>
	<td bgcolor='#fff' align='center' class='check13_"+no+"'>
		<label style='width:100%'>
			<input type='checkbox' onclick='color(13,"+no+")' class='pel"+count+" pelaksana13_"+no+"' name='check_pelaksana13_"+no+"' value='13-Y'/>
		</label>
		<br><br>
		<div>
			<label class='dc"+no+"' style='display:none'>
				<div style='padding-top:6px;'>Decision</div> 
				<input type='checkbox' class='deci13-"+no+"' name='deci13_"+no+"' value='13-Y' style='width:10px;' onclick='deci(13,"+no+")'/>
			</div>
		</label>
	</td>
	<td bgcolor='#fff' align='center' class='check14_"+no+"'>
		<label style='width:100%'>
			<input type='checkbox' onclick='color(14,"+no+")' class='pel"+count+" pelaksana14_"+no+"' name='check_pelaksana14_"+no+"' value='14-Y'/>
		</label>
		<br><br>
		<div>
			<label class='dc"+no+"' style='display:none'>
				<div style='padding-top:6px;'>Decision</div> 
				<input type='checkbox' class='deci14-"+no+"' name='deci14_"+no+"' value='14-Y' style='width:10px;' onclick='deci(14,"+no+")'/>
			</div>
		</label>
	</td>
	<td bgcolor='#fff' align='center' class='check15_"+no+"'>
		<label style='width:100%'>
			<input type='checkbox' onclick='color(15,"+no+")' class='pel"+count+" pelaksana15_"+no+"' name='check_pelaksana15_"+no+"' value='15-Y'/>
		</label>
		<br><br>
		<div>
			<label class='dc"+no+"' style='display:none'>
				<div style='padding-top:6px;'>Decision</div> 
				<input type='checkbox' class='deci15-"+no+"' name='deci15_"+no+"' value='15-Y' style='width:10px;' onclick='deci(15,"+no+")'/>
			</div>
		</label>
	</td>
							<td valign=bottom><textarea type='text' class='form-control' name='kelengkapan[]' maxlength='110' style='resize:none; height:135px;'/></textarea></td>
							<td valign=bottom><textarea type='text' class='form-control' name='waktu[]' maxlength='40' style='resize:none; height:135px;'/></textarea></td>
							<td valign=bottom><textarea type='text' class='form-control' name='hasil[]' maxlength='110' style='resize:none; height:135px;'/></textarea></td>
							<td valign=bottom><textarea type='text' class='form-control' name='keterangan[]' maxlength='150' style='resize:none; height:135px;'/></textarea></td>
							</tr>