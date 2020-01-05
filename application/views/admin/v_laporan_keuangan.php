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
                <small><i class="fas fa-clipboard fa-fw"></i> Laporan Keuangan</small><br>
                    <div class="row mt-4 mb-2">
                        <div class="col-md-11">
                            <p> Pilih tanggal</p>    
                            <form action="" method="post" class="form-inline">
                                 <div class="form-group mb-2">
                                    <label for="dari_tgl" class="p-2"> Dari tgl:</label>
                                    <input type="text" name="tgl1" class="form-control datepicker-here" data-position="bottom left" data-date-format="dd-mm-yyyy" data-language="en" id="dari_tgl" placeholder="Dari Tgl">
                                </div>
                                <div class="form-group mb-2">
                                <label for="sampai_tgl" class="p-2 mx-2"> Sampai tgl:</label>
                                    <input type="text" name="tgl2" class="form-control datepicker-here"  data-position="bottom right" data-date-format="dd-mm-yyyy" data-language="en"  id="sampai_tgl" placeholder="Sampai Tgl" >
                                </div>
                                <input type="submit" class="btn btn-outline-secondary btn-sm mb-2 mx-3" name="submit" value="Submit">
                            </form>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md">
                            <a href="<?php echo base_url('c_laporan/keuangan') ?>" class="btn btn-primary btn-sm"><i class="fas fa-redo fa-fw text-cen"></i> Refresh</a>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-11">
                            <table class="table table-sm mt-5" id="dtable">
                                <thead class="thead-light text-center">
                                    <th> No</th>
                                    <th> No Order</th>
                                    <th> No tagihan</th>
                                    <th> Jumlah tagihan</th>
                                    <th> Status Bayar</th>
                                </thead>
                                <tbody class="text-center">
                                    <?php
                                    $no = 1; 
                                    $subtotal = 0; 
                                        foreach ($data as $baris):
                                          
                                            $subtotal += $baris->jumlah_tagihan; 
                                    ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $baris->no_order;  ?></td>
                                            <td><?php echo $baris->no_tagihan ?></td>
                                            <td><?php echo angka($baris->jumlah_tagihan) ?></td>
                                            <td><?php echo StatusTagihan($baris->status_tagihan) ?></td>
                                        </tr>
                                        <?php endforeach;  ?>
                                </tbody>
                                     <tr>
                                        <td></td>
                                        <td></td>
                                        <td class="text-dark">TOTAL</td>
                                        <td></td>
                                        <td class="text-dark"><?php echo angka($subtotal);  ?></td>
                                    </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md">
                    <div class="card mt-4">
                        <div class="card-header">
                            <h6 class="text-primary">Chart</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mt-4">
                                <div class="col-md-9">
                                <h6 class="text-dark text-center mt-4 mb-2">Pemasukan QLab Tahun <?php echo $tahun;  ?></h6>
                                    <div style="width: 100%; height: 430px">
                                        <canvas id="myChart"></canvas>
                                    </div>
                                                   
                                    <script>
                                        var ctx = document.getElementById("myChart").getContext('2d');
                                        var myChart = new Chart(ctx, {
                                            type: 'bar',
                                            data: {
                                                labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni","Juli", "Agustus", "September", "Oktober", "November", "Desember"],
                                                datasets: [{
                                                    label: 'Pemasukan Qlab',
                                                    data: [
                                                        <?php echo GrandTotal(array('month(tgl_order)'=> 1), array('year(tgl_order)'=> $tahun)) ?>,
                                                        <?php echo GrandTotal(array('month(tgl_order)'=> 2), array('year(tgl_order)'=> $tahun)) ?>,
                                                        <?php echo GrandTotal(array('month(tgl_order)'=> 3), array('year(tgl_order)'=> $tahun)) ?>,
                                                        <?php echo GrandTotal(array('month(tgl_order)'=> 4), array('year(tgl_order)'=> $tahun)) ?>,
                                                        <?php echo GrandTotal(array('month(tgl_order)'=> 5), array('year(tgl_order)'=> $tahun)) ?>,
                                                        <?php echo GrandTotal(array('month(tgl_order)'=> 6), array('year(tgl_order)'=> $tahun)) ?>,
                                                        <?php echo GrandTotal(array('month(tgl_order)'=> 7), array('year(tgl_order)'=> $tahun)) ?>,
                                                        <?php echo GrandTotal(array('month(tgl_order)'=> 8), array('year(tgl_order)'=> $tahun)) ?>,
                                                        <?php echo GrandTotal(array('month(tgl_order)'=> 9), array('year(tgl_order)'=> $tahun)) ?>,
                                                        <?php echo GrandTotal(array('month(tgl_order)'=> 10), array('year(tgl_order)'=> $tahun)) ?>,
                                                        <?php echo GrandTotal(array('month(tgl_order)'=> 11), array('year(tgl_order)'=> $tahun)) ?>,
                                                        <?php echo GrandTotal(array('month(tgl_order)'=> 12), array('year(tgl_order)'=> $tahun)) ?>
                                                    ],
                                                    backgroundColor: [
                                                    'rgba(255, 99, 132, 0.2)',
                                                    'rgba(54, 162, 235, 0.2)',
                                                    'rgba(255, 206, 86, 0.2)',
                                                    'rgba(75, 192, 192, 0.2)',
                                                    'rgba(153, 102, 255, 0.2)',
                                                    'rgba(255, 159, 64, 0.2)',
                                                    'rgba(128, 4, 0, 0.2)',
                                                    'rgba(102, 205, 170, 0.2)',
                                                    'rgba(0, 0, 205, 0.2)',
                                                    'rgba(60, 179, 113, 0.2)',
                                                    'rgba(123, 103, 238, 0.2)',
                                                    'rgba(62, 250, 153, 0.2)',
                                                    ],
                                                    borderColor: [
                                                    'rgba(255,99,132,1)',
                                                    'rgba(54, 162, 235, 1)',
                                                    'rgba(255, 206, 86, 1)',
                                                    'rgba(75, 192, 192, 1)',
                                                    'rgba(153, 102, 255, 1)',
                                                    'rgba(255, 159, 64, 1)',
                                                    'rgba(128, 4, 0, 1)',
                                                    'rgba(102, 205, 170, 1)',
                                                    'rgba(0, 0, 205, 1)',
                                                    'rgba(60, 179, 113, 1)',
                                                    'rgba(123, 103, 238, 1)',
                                                    'rgba(62, 250, 153, 1)'
                                                    ],
                                                    borderWidth: 1
                                                }]
                                            },
                                            options: {
                                                scales: {
                                                    yAxes: [{
                                                        ticks: {
                                                            beginAtZero:true
                                                        }
                                                    }]
                                                }
                                            }
                                        });
                                    </script>   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
		$('#dtable').DataTable();
    });
</script>