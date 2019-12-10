<div class="row">
			<div class="col-md-12">
				<table class="table table-hover">
					<thead>
						<tr>
							<th width="4%">No</th>
							<th width="15%">Merk</th>
							<th width="5%">Action</th>
						</tr>
					</thead>
					
					<tbody>
						<?php 
							$no = 1;
							foreach ($merk as $baris) {
						?>
					  <tr>
						<td><?php echo $no++; ?></td>
						<td><?php echo $baris['merk']; ?></td>
						<td style="text-align:center;"><a class="fas fa-trash-alt fa-sm" style="color:red; font-size:16px;"  href="<?php echo base_url('c_admin/hapus_merk/'.$baris['id_merk']) ?>"></a></td>
					  </tr>
					  <?php 
							}
					  ?>
					</tbody>
				</table>
			</div>
		</div>
	