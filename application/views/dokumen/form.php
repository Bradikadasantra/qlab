
<form action="<?php echo base_url('c_dokumen/tangkap') ?>" method="post">
    <input type="text" name="nama" placeholder="nama">
    <input type="text" name="alamat" placeholder="alamat">
    <input type="checkbox" name="hobi[]" value="berenang">Berenang 
    <input type="checkbox" name="hobi[]" value="bulu tangkias">Bulu tangkis 
    <input type="submit" name="submit" value="submit">
    <a href="<?php echo base_url('c_dokumen/destroy') ?>">Reset</a>
</form>
<table>
<tr>
   <td>Nama</td>
  <td>Alamat</td>
 </tr>
<?php
        if (isset($_SESSION['nama']) and isset($_SESSION['alamat'])) {
            $nama = $_SESSION['nama'];
            $alamat = $_SESSION['alamat'];
            for ($i=0; $i < count($nama); $i++){ ?>
              
            <tr>
                <td><?php echo $nama[$i]?></td><td><?php echo $alamat[$i] ?></td><td><a href="<?php echo base_url('c_dokumen/de)?>">hapus</a></td>
            </tr>
            
            <?php
            } } ?>
