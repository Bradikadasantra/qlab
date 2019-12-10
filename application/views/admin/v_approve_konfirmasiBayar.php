<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        <?php
            if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
                echo '<div class="pesan">'.$_SESSION['pesan'].'</div>';
            }
                    // mengatur session pesan menjadi kosong
                    $_SESSION['pesan'] = '';
            ?>
            <div class="card">
                <div class="card-body">
                <small><i class="fas fa-list fa-fw"></i> Approve Konfirmasi Pembayaran</small><br>
                    <div class="row mt-4">
                        <div class="col-md">
                            <table class="table" id="table">
                                <thead class="thead-light text-center">
                                    <th width="14%">No Invoice</th>
                                    <th width="15%">Pemilik Rekening</th>
                                    <th width="15%">Jumlah</th>
                                    <th width="5%">Bukti</th>
                                    <th width="11%">Tanggal</th>
                                    <th width="7%">Aksi</th>
                                </thead>
                                <tbody class="text-center">
                                    <?php foreach ($data as $baris): ?>
                                    <tr>
                                        <td><?php echo $baris->no_tagihan; ?></td>
                                        <td><?php echo $baris->pemilik_rekening;  ?></td>
                                        <td><?php echo rupiah($baris->jumlah)  ?></td>
                                        <td><a href="<?php echo base_url('bukti_bayar/'.$baris->bukti_byr);?>" data-fancybox><i class="fas fa-receipt"></i></a></td>
                                        <td><?php echo StatusTagihan($baris->status_tagihan) ?></td>
                                        <td>
                                            <div class="dropup">
                                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Aksi
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <?php if ($baris->status_tagihan != 2){ ?>
                                                    <a class="dropdown-item text-success" href="<?php echo base_url('c_permintaan_uji/konfirmasiBayar/'.$baris->no_tagihan)?>"><span class="fas fa-check fa-fw"></i> Konfirmasi</a>
                                                    <?php } else {?>
                                                        <a class="dropdown-item text-secondary disabled" href="#"><span class="fas fa-check fa-fw"></i> Konfirmasi</a>
                                                    <?php  } ?>
                                                    <a class="dropdown-item text-primary"  href="#myModal" data-toggle="modal" data-id="<?php echo $baris->no_tagihan; ?>"><span class="fas fa-eye fa-fw"></i> Detail</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg"  id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Detail Invoice</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="fetched-data"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
    $(document).ready(function(){
		$('#table').DataTable();
    });

    $(document).ready(function(){
        $('#myModal').on('show.bs.modal', function (e) {
			var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
				url : "<?php echo base_url('c_permintaan_uji/detail_konfirmBayar')?>",
				 data :  'rowid='+ rowid,
				 
                success : function(data){
					    $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
</script>