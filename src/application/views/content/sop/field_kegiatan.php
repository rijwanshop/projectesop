 <?php
	defined('BASEPATH') OR exit('No direct script access allowed'); 
?>
<tr>
	<td>
		<input type="checkbox" class="caseKeg H<?= $no; ?>" style="display:none;"/>
	</td>
	<td>
		<input type="hidden" name="d[]" class="deci<?= $no; ?>"/>
		<input type="hidden" name="a[]" class="trpel<?= $no; ?>"/>
		<span id="snum<?= $count ?>"><?= $count ?></span>
	</td>
	<td height="135" valign="bottom">
		<textarea type="text" class="form-control text-kegiatan" name="kegiatan[]" style="resize:none; height:135px;" maxlength="400"></textarea>
		<div id="charNum">karakter tersisa: 400</div>
	</td>

	<?php for($i=1; $i<16; $i++): ?>

		<td bgcolor="#fff" align="center" class="check<?= $i ?>_<?= $no ?>">
			<label style="width:100%;">
				<input type="checkbox" onclick="color(<?= $i ?>,<?= $no ?>)" class="pel<?= $count ?> pelaksana<?= $i ?>_<?= $no ?>" name="check_pelaksana<?= $i ?>_<?= $no ?>" value="<?= $i ?>-Y"/>
			</label>
			<br><br>
			<div>
				<label class="dc<?= $no ?>" style="display:none;">
					<div style="padding-top:6px;">Decision</div> 
					<input type="checkbox" class="deci<?= $i ?>-<?= $no ?>" name="deci<?= $i ?>-<?= $no ?>" value="<?= $i ?>-Y" style="width:10px;" onclick="deci(<?= $i ?>,<?= $no ?>)" />
				</label>
			</div>
		</td>

	<?php endfor; ?>

	<td valign=bottom>
		<textarea type="text" class="form-control text-kegiatan" name="kelengkapan[]" maxlength="110" style="resize:none; height:135px;"/></textarea>
		<div id="charNum">karakter tersisa: 110</div>
	</td>
	<td valign=bottom>
		<textarea type="text" class="form-control text-kegiatan" name="waktu[]" maxlength="40" style="resize:none; height:135px;"/></textarea>
		<div id="charNum">karakter tersisa: 40</div>
	</td>
	<td valign=bottom>
		<textarea type="text" class="form-control text-kegiatan" name="hasil[]" maxlength="110" style="resize:none; height:135px;"/></textarea>
		<div id="charNum">karakter tersisa: 110</div>
	</td>
	<td valign=bottom>
		<textarea type="text" class="form-control text-kegiatan" name="keterangan[]" maxlength="150" style="resize:none; height:135px;"/></textarea>
		<div id="charNum">karakter tersisa: 150</div>
	</td>
</tr>
<script>

	$('textarea.text-kegiatan').on('keyup', function(){
		var len = $(this).val().length;
		var maxlength = $(this).attr('maxlength');
		if (len >= maxlength){
            $(this).val($(this).val().substring(0, maxlength));
     	}
		var sisa = maxlength-len;
		$(this).closest('td').find('div#charNum').text('karakter tersisa: '+sisa);
	});

</script>