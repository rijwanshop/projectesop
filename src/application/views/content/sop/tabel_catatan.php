<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php if($catatan->num_rows() != 0 && $status == ''): ?>
<table class="table table-sm">
   <thead>
      <tr>
         <th scope="col">No</th>
         <th scope="col">Nama</th>
         <th scope="col">Status</th>
         <th scope="col">Catatan</th>
         <th scope="col">Tanggal</th>
      </tr>
   </thead>
   <tbody>
      <?php foreach($catatan->result() as $row): ?>
         <tr>
            <th scope="row"><?= $no++; ?></th>
            <td><?= $row->nama_pereview; ?></td>
            <td><?= $row->status_pengajuan; ?></td>
            <td><?= $row->catatan_review; ?></td>
            <td><?= date('d-m-Y H:i:s', strtotime($row->tanggal_catatan)); ?></td>
         </tr>
      <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>