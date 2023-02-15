<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=sop_".date('d-m-Y').".xls");
?>

<style> 
    .str{ 
        mso-number-format:\@; 
    } 
    .border{
        border: 0.5px solid #000;
    }
</style>

<center><h3>Laporan SOP<br>Kementerian Sekretariat Negara</h3></center>
<table class="border">
	<tr>
        <th width="30" class="border">No</th>
        <th width="100" class="border">No SOP</th>
        <th width="500" class="border">Judul SOP</th>
        <th width="200" class="border">Unit Kerja</th>
        <th width="150" class="border">Tgl Pembuatan</th>
	</tr>        
<?php
	$no=1;
	foreach($data->result_array() as $r){
	?>
    <tr>
        <td align="left" class="border"><?php echo $no;?></td>
        <td align="left" class="str" class="border"><?php echo "'".$r['sop_no'];?></td>
        <td align="left" class="border"><?php echo $r['sop_nama'];?></td>
        <td align="center" class="border"><?php echo $r['nama_unit'];?></td>
        <td align="center" class="border"><?php echo $r['sop_tgl_pembuatan'];?></td>
    </tr>
    <?php
	$no++;
	}
	echo "</table>";
?>
