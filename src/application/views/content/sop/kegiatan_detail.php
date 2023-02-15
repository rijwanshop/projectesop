<?php
	defined('BASEPATH') OR exit('No direct script access allowed'); 
?>
<table cellpadding="2" cellspacing="0"  border="1" align="center" class="TableKeg" style="margin-top:20px; width:32cm; font-size:9px;; font-family:arial; color:#000">
							<tr bgcolor="#ddd" align="center">
								<th rowspan="2" width="20">No.</th>
								<th rowspan="2">Kegiatan</th>
								<th colspan="<?= $jmlpel ?>">Pelaksana</th>
								<?= print_pelaksana_bawah($sop->row()->sop_alias); ?>
								<th colspan="3">Mutu Baku</th>
								<th rowspan="2" width="100">Keterangan</th>
							</tr>
							<tr bgcolor="#ddd" align="center">
								<?= print_pelaksana_atas($sop->row()->sop_alias); ?>
								<th width="70">Kelengkapan</th>
								<th width="50">Waktu</th>
								<th width="70">Output</th>
							</tr>
							<?php foreach ($sop->result_array() as $row): ?>
								<tr>
									<td><?= $no++; ?></td>
									<td height="135">
										<div style="height:135px; overflow:hidden;">
											<div style="height:135px; word-wrap: break-word; align-self: center; display: table-cell; vertical-align: middle">
												<?= nl2br($row['sop_kegiatan']) ?>
											</div>
										</div>
									</td>
									<?php for($j=0; $j<$sop->row()->sop_jml_pelaksana; $j++): ?>
										<td align="center"><?= $img_chart[$no-2][$j] ?></td>
									<?php endfor; ?>
									<td>
										<div style="height:135px; overflow:hidden;">
											<div style="height:135px; word-wrap: break-word; display: table-cell; vertical-align: middle">
												<?= nl2br($row['sop_kelengkapan']) ?>
											</div>
										</div>
									</td>
									<td>
										<div style="height:135px; overflow:hidden;">
											<div style="height:135px; word-wrap: break-word; display: table-cell; vertical-align: middle">
												<?=nl2br($row['sop_waktu'])?>
											</div>
										</div>
									</td>
									<td>
										<div style="height:135px; overflow:hidden;">
											<div style="height:135px; word-wrap: break-word; display: table-cell; vertical-align: middle">
												<?=nl2br($row['sop_hasil'])?>
											</div>
										</div>
									</td>
									<td>
										<div style="height:135px; overflow:hidden;">
											<div style="height:135px; word-wrap: break-word; display: table-cell; vertical-align: middle">
												<?=nl2br($row['sop_keterangan'])?>
											</div>
										</div>
									</td>
								</tr>
							<?php endforeach; ?>
						</table>