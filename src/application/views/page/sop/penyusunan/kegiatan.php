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
				<th rowspan="2" width="35" valign="bottom"><textarea name="pelaksana[10]" maxlength="25" class="resize"></textarea></th>
				<th rowspan="2" width="35" valign="bottom"><textarea name="pelaksana[11]" maxlength="25" class="resize"></textarea></th>
				<th rowspan="2" width="35" valign="bottom"><textarea name="pelaksana[12]" maxlength="25" class="resize"></textarea></th>
				<th rowspan="2" width="35" valign="bottom"><textarea name="pelaksana[13]" maxlength="25" class="resize"></textarea></th>
				<th rowspan="2" width="35" valign="bottom"><textarea name="pelaksana[14]" maxlength="25" class="resize"></textarea></th>
				<th colspan="3">Mutu Baku</th>
				<th rowspan="2" width="100">Keterangan</th>
			</tr>
			<tr bgcolor="#ddd">
				<th width="35"><textarea name="pelaksana[0]" maxlength="25" class="resize"></textarea></th>
				<th width="35"><textarea name="pelaksana[1]" maxlength="25" class="resize"></textarea></th>
				<th width="35"><textarea name="pelaksana[2]" maxlength="25" class="resize"></textarea></th>
				<th width="35"><textarea name="pelaksana[3]" maxlength="25" class="resize"></textarea></th>
				<th width="35"><textarea name="pelaksana[4]" maxlength="25" class="resize"></textarea></th>
				<th width="35"><textarea name="pelaksana[5]" maxlength="25" class="resize"></textarea></th>
				<th width="35"><textarea name="pelaksana[6]" maxlength="25" class="resize"></textarea></th>
				<th width="35"><textarea name="pelaksana[7]" maxlength="25" class="resize"></textarea></th>
				<th width="35"><textarea name="pelaksana[8]" maxlength="25" class="resize"></textarea></th>
				<th width="35"><textarea name="pelaksana[9]" maxlength="25" class="resize"></textarea></th>
				<th width="50">Kelengkapan</th>
				<th width="30">Waktu</th>
				<th width="50">Output</th>
			</tr>
		</table>
		



		<br>
		<button type="button" class='btn btn-danger btn-xs deleteKeg'>- Hapus</button>
		<button type="button" class='btn btn-success btn-xs addmoreKeg'>+ Tambah Kegiatan</button>
		<button type="submit" class="btn btn-success" style="float:right; margin:0px 0 20px 0; width:120px; height:40px">Lanjut</button>
</form>
			
			
			
			<script>
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
							data +="<td height='135' valign=bottom><textarea type='text' class='form-control' name='kegiatan[]' style='resize:none; height:135px;' maxlength='400'/></textarea></td>";
							data +="<td bgcolor='#fff' align='center' class='check1_"+no+"'><label style='width:100%'><input type='checkbox' onclick='color(1,"+no+")' class='pel"+count+" pelaksana1_"+no+"' name='check_pelaksana1_"+no+"' value='1-Y'/></label><br><br><div><label class='dc"+no+"' style='display:none'><div style='padding-top:6px;'>Decision</div> <input type='checkbox' class='deci1-"+no+"' name='deci1_"+no+"' value='1-Y' style='width:10px;' onclick='deci(1,"+no+")'/></div></label></td>";
							data +="<td bgcolor='#fff' align='center' class='check2_"+no+"'><label style='width:100%'><input type='checkbox' onclick='color(2,"+no+")' class='pel"+count+" pelaksana2_"+no+"' name='check_pelaksana2_"+no+"' value='2-Y'/></label><br><br><div><label class='dc"+no+"' style='display:none'><div style='padding-top:6px;'>Decision</div> <input type='checkbox' class='deci2-"+no+"' name='deci2_"+no+"' value='2-Y' style='width:10px;' onclick='deci(2,"+no+")'/></div></label></td>";
							data +="<td bgcolor='#fff' align='center' class='check3_"+no+"'><label style='width:100%'><input type='checkbox' onclick='color(3,"+no+")' class='pel"+count+" pelaksana3_"+no+"' name='check_pelaksana3_"+no+"' value='3-Y'/></label><br><br><div><label class='dc"+no+"' style='display:none'><div style='padding-top:6px;'>Decision</div> <input type='checkbox' class='deci3-"+no+"' name='deci3_"+no+"' value='3-Y' style='width:10px;' onclick='deci(3,"+no+")'/></div></label></td>";
							data +="<td bgcolor='#fff' align='center' class='check4_"+no+"'><label style='width:100%'><input type='checkbox' onclick='color(4,"+no+")' class='pel"+count+" pelaksana4_"+no+"' name='check_pelaksana4_"+no+"' value='4-Y'/></label><br><br><div><label class='dc"+no+"' style='display:none'><div style='padding-top:6px;'>Decision</div> <input type='checkbox' class='deci4-"+no+"' name='deci4_"+no+"' value='4-Y' style='width:10px;' onclick='deci(4,"+no+")'/></div></label></td>";
							data +="<td bgcolor='#fff' align='center' class='check5_"+no+"'><label style='width:100%'><input type='checkbox' onclick='color(5,"+no+")' class='pel"+count+" pelaksana5_"+no+"' name='check_pelaksana5_"+no+"' value='5-Y'/></label><br><br><div><label class='dc"+no+"' style='display:none'><div style='padding-top:6px;'>Decision</div> <input type='checkbox' class='deci5-"+no+"' name='deci5_"+no+"' value='5-Y' style='width:10px;' onclick='deci(5,"+no+")'/></div></label></td>";
							data +="<td bgcolor='#fff' align='center' class='check6_"+no+"'><label style='width:100%'><input type='checkbox' onclick='color(6,"+no+")' class='pel"+count+" pelaksana6_"+no+"' name='check_pelaksana6_"+no+"' value='6-Y'/></label><br><br><div><label class='dc"+no+"' style='display:none'><div style='padding-top:6px;'>Decision</div> <input type='checkbox' class='deci6-"+no+"' name='deci6_"+no+"' value='6-Y' style='width:10px;' onclick='deci(6,"+no+")'/></div></label></td>";
							data +="<td bgcolor='#fff' align='center' class='check7_"+no+"'><label style='width:100%'><input type='checkbox' onclick='color(7,"+no+")' class='pel"+count+" pelaksana7_"+no+"' name='check_pelaksana7_"+no+"' value='7-Y'/></label><br><br><div><label class='dc"+no+"' style='display:none'><div style='padding-top:6px;'>Decision</div> <input type='checkbox' class='deci7-"+no+"' name='deci7_"+no+"' value='7-Y' style='width:10px;' onclick='deci(7,"+no+")'/></div></label></td>";
							data +="<td bgcolor='#fff' align='center' class='check8_"+no+"'><label style='width:100%'><input type='checkbox' onclick='color(8,"+no+")' class='pel"+count+" pelaksana8_"+no+"' name='check_pelaksana8_"+no+"' value='8-Y'/></label><br><br><div><label class='dc"+no+"' style='display:none'><div style='padding-top:6px;'>Decision</div> <input type='checkbox' class='deci8-"+no+"' name='deci8_"+no+"' value='8-Y' style='width:10px;' onclick='deci(8,"+no+")'/></div></label></td>";
							data +="<td bgcolor='#fff' align='center' class='check9_"+no+"'><label style='width:100%'><input type='checkbox' onclick='color(9,"+no+")' class='pel"+count+" pelaksana9_"+no+"' name='check_pelaksana9_"+no+"' value='9-Y'/></label><br><br><div><label class='dc"+no+"' style='display:none'><div style='padding-top:6px;'>Decision</div> <input type='checkbox' class='deci9-"+no+"' name='deci9_"+no+"' value='9-Y' style='width:10px;' onclick='deci(9,"+no+")'/></div></label></td>";
							data +="<td bgcolor='#fff' align='center' class='check10_"+no+"'><label style='width:100%'><input type='checkbox' onclick='color(10,"+no+")' class='pel"+count+" pelaksana10_"+no+"' name='check_pelaksana10_"+no+"' value='10-Y'/></label><br><br><div><label class='dc"+no+"' style='display:none'><div style='padding-top:6px;'>Decision</div> <input type='checkbox' class='deci10-"+no+"' name='deci10_"+no+"' value='10-Y' style='width:10px;' onclick='deci(10,"+no+")'/></div></label></td>";
							data +="<td bgcolor='#fff' align='center' class='check11_"+no+"'><label style='width:100%'><input type='checkbox' onclick='color(11,"+no+")' class='pel"+count+" pelaksana11_"+no+"' name='check_pelaksana11_"+no+"' value='11-Y'/></label><br><br><div><label class='dc"+no+"' style='display:none'><div style='padding-top:6px;'>Decision</div> <input type='checkbox' class='deci11-"+no+"' name='deci11_"+no+"' value='11-Y' style='width:10px;' onclick='deci(11,"+no+")'/></div></label></td>";
							data +="<td bgcolor='#fff' align='center' class='check12_"+no+"'><label style='width:100%'><input type='checkbox' onclick='color(12,"+no+")' class='pel"+count+" pelaksana12_"+no+"' name='check_pelaksana12_"+no+"' value='12-Y'/></label><br><br><div><label class='dc"+no+"' style='display:none'><div style='padding-top:6px;'>Decision</div> <input type='checkbox' class='deci12-"+no+"' name='deci12_"+no+"' value='12-Y' style='width:10px;' onclick='deci(12,"+no+")'/></div></label></td>";
							data +="<td bgcolor='#fff' align='center' class='check13_"+no+"'><label style='width:100%'><input type='checkbox' onclick='color(13,"+no+")' class='pel"+count+" pelaksana13_"+no+"' name='check_pelaksana13_"+no+"' value='13-Y'/></label><br><br><div><label class='dc"+no+"' style='display:none'><div style='padding-top:6px;'>Decision</div> <input type='checkbox' class='deci13-"+no+"' name='deci13_"+no+"' value='13-Y' style='width:10px;' onclick='deci(13,"+no+")'/></div></label></td>";
							data +="<td bgcolor='#fff' align='center' class='check14_"+no+"'><label style='width:100%'><input type='checkbox' onclick='color(14,"+no+")' class='pel"+count+" pelaksana14_"+no+"' name='check_pelaksana14_"+no+"' value='14-Y'/></label><br><br><div><label class='dc"+no+"' style='display:none'><div style='padding-top:6px;'>Decision</div> <input type='checkbox' class='deci14-"+no+"' name='deci14_"+no+"' value='14-Y' style='width:10px;' onclick='deci(14,"+no+")'/></div></label></td>";
							data +="<td bgcolor='#fff' align='center' class='check15_"+no+"'><label style='width:100%'><input type='checkbox' onclick='color(15,"+no+")' class='pel"+count+" pelaksana15_"+no+"' name='check_pelaksana15_"+no+"' value='15-Y'/></label><br><br><div><label class='dc"+no+"' style='display:none'><div style='padding-top:6px;'>Decision</div> <input type='checkbox' class='deci15-"+no+"' name='deci15_"+no+"' value='15-Y' style='width:10px;' onclick='deci(15,"+no+")'/></div></label></td>";
							data +="<td valign=bottom><textarea type='text' class='form-control' name='kelengkapan[]' maxlength='110' style='resize:none; height:135px;'/></textarea></td>";
							data +="<td valign=bottom><textarea type='text' class='form-control' name='waktu[]' maxlength='40' style='resize:none; height:135px;'/></textarea></td>";
							data +="<td valign=bottom><textarea type='text' class='form-control' name='hasil[]' maxlength='110' style='resize:none; height:135px;'/></textarea></td>";
							data +="<td valign=bottom><textarea type='text' class='form-control' name='keterangan[]' maxlength='150' style='resize:none; height:135px;'/></textarea></td>";
							data +="</tr>";
							
				$('#TableKeg tr').last().after(data);
				 
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