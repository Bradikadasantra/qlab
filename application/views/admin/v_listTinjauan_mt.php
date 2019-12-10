<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <form action="#" method="POST">
                <table class="table">
                    <thead>
                        <th> No </th>
                        <th> Nama sampel </th>
                        <th> Status sampel </th>
                        <th> Tinjauan </th>
                    </thead>
                    <tbody>
                        <?php
                            $query = $this->db->query("SELECT * FROM order_detail JOIN (sampel JOIN tinjauan_mt ON 
                            sampel.id_sampel = tinjauan_mt.id_sampel) ON order_detail.id_order_detail = sampel.id_order_detail WHERE no_order = '$no_order' and status_sampel = 4")->result();
                            $no = 1; 
                            foreach ($query as $baris): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $baris->nama_sampel; ?></td>
                            <td><?php echo StatusSampel($baris->status_sampel); ?></td>
                            <td><a href="#" data-id="" class="btn btn-danger btn-sm"> Konfirmasi sekarang !</a></td>
                        </tr>
                            <?php endforeach; ?>
                    </tbody>
                </table>
            </form>   
        </div>
    </div>
</div>