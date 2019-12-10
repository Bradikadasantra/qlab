
Forum Diskusi Komunitas Teknologi Indonesia, Forum IT, Forum Komputer

Discussions Activity 

Home › Diskusi Pemrograman & IT
Howdy, Stranger!

It looks like you're new here. If you want to get involved, click one of these buttons!

Sign In Register

Categories
Recent Discussions
Activity

Categories

40.3K All Categories
35.5K Diskusi Pemrograman & IT
204 Artikel & Tutorial Komputer
111 Share Berita, Info Seputar IT & Pemrograman
2.2K Gaul
1.5K Lowongan IT
629 Seputar DiskusiWeb.com

Tolong pilih kategori sesuai, jenis posting (diskusi atau bukan) dan sertakan tag/topik yang sesuai seperti komputer, java, php, mysql, dll. Promosi atau posting tidak pada tempatnya akan kami hapus!
- Bagi Anda yang ingin mendaftar, baca link berikut:
http://diskusiweb.com/discussion/50491/how-to-registrasi-diskusiweb-com-baca-ini-terlebih-dahulu
- Cara menyisipkan kode program supaya tampil rapi dan terformat dengan baik di diskusiweb.com: http://www.diskusiweb.com/discussion/50415/cara-menyisipkan-kode-program-di-diskusiweb-com
- Cara posting gambar/image di post Anda: http://www.diskusiweb.com/discussion/47345/cara-menyisipkan-menyertakan-image-pada-posting/p1
tabel sementara sebelum di simpan ke database?
erica
erica
January 2014 edited January 2014 in Diskusi Pemrograman & IT
mau tanya mas, bagaimana caranya menyimpan inputan data ke tabel sementara, setelah itu dari tabel sementara di simpan ke database berdasarkan data dari combobox?
jadi, alurnya gini:
1. input combobox : nama barang
2. input textbox : volume barang
3. input textbox : keterangan barang
4. inputan dimasukkan ke tabel sementara
5. tabel sementara bisa menampung banyak inputan data
6. dari tabel sementara, data yang ada di simpan ke database "barang" berdasarkan input combobox : nama supplier

contoh codingnya seperti ini:
// hasil dari codingan saya yaitu bisa menginput data dari inputan ke tabel sementara hanya sebatas 10 data saja,
bagaimana cara menghapus data di tabel sementara dan menyimpan data dari tabel sementara ke database mas?

<pre lang="php">
<?php 
//jika tombol proses diklik
if(isset($_POST['btnProses']))
{
//pengecekan untuk error
$message = array();
if (trim($_POST['cmbBarang'])=="BLANK") 
{
$message[] = "Nama barang belum dipilih";		
}
if (trim($_POST['txtVolume'])=="" or !is_numeric(trim($_POST['txtVolume']))) 
{
$message[] = "Jumlah barang tidak boleh kosong dan harus diisi angka";		
}
if (trim($_POST['txtKeterangan'])=="")
{
$message[] = "Keterangan barang tidak boleh kosong";
}

//membaca variabel di form
$cmbBarang = $_POST['cmbBarang'];
$txtVolume = $_POST['txtVolume'];
$txtKeterangan = $_POST['txtKeterangan'];

if (!count($message)==0 )
{
    //menampilkan pesan error 
}

//tidak ada pesan error
if (count($message)==0 )
{
     $no = 0;
     //inputan ke tabel sementara hanya 10 data saja, bagaimana agar data tidak dibatasi?
 for ($i=0;$i<10;$i++) 
 { 
    if ($_SESSION ['a'][$i][0]=="") 
    {
        $_SESSION['a'][$i][0]=$cmbBarang;
        $_SESSION['a'][$i][1]=$txtVolume;
        $_SESSION['a'][$i][2]=$txtKeterangan;									
        break; 
    }
}
   echo "<meta http-equiv='refresh' content='0; url=?page=pengadaan'>";
   exit; 
}
                    
}


//jika tombol simpan diklik, data dari tabel sementara di simpan
ke database barang berdasarkan nama supplier yang dipilih
if(isset($_POST['btnSimpan']))
{

$message = array();
if (trim($_POST['cmbSupplier'])=="BLANK") 
{
$message[] = "Nama supplier belum dipilih";		
} 

if (!count($message)==0 )
{
    //menampilkan pesan error 
}


if (count($message)==0 )
{ 
     //tidak tahu codingnya mas
 }

}


?>

<!--inputan data-->
<form action="?page=pengadaan" method="post" name="frmTambahPengadaan">
<label class="control-label">Nama Barang :</label>
 <select name="cmbBarang">
   <option value="BLANK">-- Pilih Barang --</option>
        <?php
           //mengambil data barang dari database barang
        ?>
</select>
<label class="control-label">Jumlah Barang :</label>
  <input type="text" name="txtVolume" value="" />
<label class="control-label">Keterangan Barang :</label>
   <input type="text" name="txtKeterangan" value="" />

<input type="submit" class="btn btn-primary" name="btnProses" value="Proses" />
<input type="submit" class="btn btn-primary" name="btnSimpan" value="Simpan" />

</form>


<!--menampilkan inputan data di tabel bawah ini-->
<!--tabel sementara sebelum di simpan ke database-->
<table>
<thead>
<tr>
<th>No</th>
<th>Nama Barang</th>
<th>Volume</th>
<th>Keterangan</th>
<th>Hapus</th>
</tr>
<thead>

<tbody>
  <?php
for ($i=0;$i<count($_SESSION['a']);$i++) 
{
    $no++;
    ?>
             <tr class="success">
        <td style="text-align:center"><?php echo $no; ?></td>
        <td><?php echo $_SESSION['a'][$i][0]; ?></td>
        <td><?php echo $_SESSION['a'][$i][1]; ?></td>
        <td><?php echo $_SESSION['a'][$i][2]; ?></td>
        <td><?php //cara hapusnya gmn?        ?></td>
    </tr>
   <?php } ?>
</tbody>
</table>

< /pre>

Tagged:

php 

«123»
Comments

kurakura
kurakura
January 2014 edited January 2014
table sementara apa to mas ?
lha wong elo cuma mainan session doang ...

kagak salah
tapi itu bukan table ... cuma session



masalah data masuk ke table barang ...
tinggal bikin koding buat menjalankan query INSERT

gw kagak tau table barang elo kaya apa
gw anggap field nya (`barang`,`volume`,`keterangan`)

susun dulu query INSERT nya, pake loop
sejumlah count($_SESSION['a'])

$values=array();
for(...) {
  $values[]='("'.implode('","',$_SESSION['a'][...]).'")';
}

$sql='INSERT INTO `barang` (`barang`,`volume`,`keterangan`) VALUES '.implode(',',$values);

itu string query yg di dapat kira-kira bentuknya :
INSERT INTO `barang` (`barang`,`volume`,`keterangan`) VALUES ("a","1","abc"),("d","2","def"),("g","3","ghi"), ...
tinggal di eksekusi



masalah hapus session, pan tinggal : unset($_SESSION['a']);
erica
erica
January 2014
iya saya pake session mas, untuk kasus saya seperti itu enaknya pake session atau tabel sementara (CREATE TEMPORARY TABLE......) ya mas?

untuk hapus session pake unset($_SESSION['a']); yang mas berikan belum bisa, model tabel session saya seperti ini:

ini tabel hasil inputan pake session, ketika saya klik simbol hapus semua data malah hilang..
----------------------------------------------------------------------------------------------
No | Nama Barang | Volume | Keterangan Barang |       Hapus     |
----------------------------------------------------------------------------------------------
 1  |      Barang a   |      9     |  Barang ok             | simbol hapus  |
 2  |      Barang b   |      4     |  Barng ready          | simbol hapus   |

coding menampilkan tabel di atas seperti ini mas:     

      <pre lang="php">
              <?php  

                                for ($i=0;$i<count($_SESSION['a']);$i++)
                                {
                                    $no++;
                                    ?>
                                     <tr class="success">
                                        <td style="text-align:center"><?php echo $no; ?></td>  <!-- No -->
                                        <td><?php echo $_SESSION['a'][$i][0]; ?></td>            <!-- Nama Barang -->
                                        <td><?php echo $_SESSION['a'][$i][1]; ?></td>           <!-- Volume -->
                                        <td><?php echo $_SESSION['a'][$i][2]; ?></td>           <!- Keterangan Barang-->
                                        <td style="text-align:center"><a href="?page=hapus-pengadaan&amp;id=<?php echo $no; ?>" target="_self" alt="Hapus Data Pengadaan" onClick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="icon-trash"></i></a></td>
                                    </tr>
                           <?php } ?>        

      < /pre>
ketika simbol hapus diklik, diarahkan ke "hapus_pengadaan.php", berikut coding saya
di "hapus_pengadaan.php"
      <pre lang="php">
      <?php
        session_start();
        include_once "connect/cek_session.php";
        if($_GET) 
        {
      if(empty($_GET['id']))
      {
        echo "<b>Data yang dihapus tidak ada</b>";
      }
      else
      {
        unset($_SESSION['a']);
        echo "<meta http-equiv='refresh' type='reset' content='0; url=?page=pengadaan'>";
       }	
    }
      ?>

erica
erica
January 2014
database saya seperti ini mas,

tabel barang:
id_barang INT(11);
nama_barang VARCHAR(50);
volume INT(11);
keterangan VARCHAR(50);
supplier_id_supplier VARCHAR (5);  // di dapat dari tabel supplier

tabel supplier:
id_supplier VARCHAR(5);
nama_supplier VARCHAR(20);
alamat VARCHAR(100);
email VARCHAR(45);
telepon VARCHAR(20);

maksudnya dibawah ini gmn mas?
$values=array();
for(...) {
  $values[]='("'.implode('","',$_SESSION['a'][...]).'")';
}

$sql='INSERT INTO `barang` (`barang`,`volume`,`keterangan`) VALUES '.implode(',',$values);
kurakura
kurakura
January 2014 edited January 2014
session ya session mas, kagak ada kaitannya dengan table
atau yg elo maksud <table> nya html ?



kalo nanya mau pake table temporary beneran atau session ...
lha kalo session saja sudah bisa, kenapa mesti pake temporary table ?



elo mau hapus itu per baris ? bukan seluruh ?
ya tambah aja index nya
unset($_SESSION['a'][$_GET['id']]);

kalo cuma unset($_SESSION['a']); ya bener semua baris nya hilang

lha elo juga kagak bilang, maunya hapus per baris ...
yg ada cuma kalimat : "bagaimana cara menghapus data di tabel sementara ..."



masalah INSERT ...

pan gw sudah tulis :
"...
susun dulu query INSERT nya, pake loop
sejumlah count($_SESSION['a'])
..."

itu pan for() nya sudah gw beri '...',
ubah sesuai butuh elo



masalah field table barang ...

$sql='INSERT INTO `barang` (`barang`,`volume`,`keterangan`) VALUES ...

ubah aja definisi field nya sesuai definisi field table elo

kalo butuh penambahan value utk field `supplier_id_supplier`
tambahkan di sini :

$values[]='("'.implode('","',$_SESSION['a'][...]).'","'.$id_suplier.'")';

jangan lupa, definisi field juga harus ditambah :

$sql='INSERT INTO `barang` (`barang`,`volume`,`keterangan`,`...`) VALUES ...
erica
erica
January 2014
iya maksud saya <table>nya html,
kalau pake session bisa ya gpp mas, saya pake session saja untuk kasus ini..

hapusnya berjalan mas, tapi yang kehapus tidak sesuai dengan baris. misalnya: saya mau hapus baris ke dua, tp yang ke hapus baris ke tiga, jadi intinya kehapus dari baris terkhir dulu... apa yang salah ya?
kurakura
kurakura
January 2014 edited January 2014
hapus bermasalah karena rujukan "id" elo ini :

id=<?php echo $no; ?>

sementara rujukan "id" yg tersimpan di session ini :

<td><?php echo $_SESSION['a'][$i][0]; ?></td>
<td><?php echo $_SESSION['a'][$i][1]; ?></td>
<td><?php echo $_SESSION['a'][$i][2]; ?></td>

tebakan gw, counter $no elo pasti mulai dari 1
sementara $i yg tersimpan di session pasti mulai dari 0
erica
erica
January 2014
iya mas,
lengkapnya kayak gini:
$no = 0;
  for ($i=0;$i<10;$i++)
   {
                 if ($_SESSION ['a'][$i][0]=="")
                 {
                         $_SESSION['a'][$i][0]=$cmbBarang;
                         $_SESSION['a'][$i][1]=$txtVolume;
                         $_SESSION['a'][$i][2]=$txtKeterangan;                               
                         break;
                  }
   }       
kurakura
kurakura
January 2014
ya sudah, elo ubah aja rujukan id nya yg bener
erica
erica
January 2014
rujukan id sudah saya ganti tetap ndak isa mas :(
erica
erica
January 2014
rujukan id apa pakai session juga ta mas?
kurakura
kurakura
January 2014
elo ganti kaya apa ?

kalo elo merubah script, biar yg dibahas jelas
elo posting ulang koding terakhir elo

soalnya kalo kagak, pasti nungul pertanyaan :
"elo ganti kaya apa ?"
erica
erica
January 2014 edited January 2014

seperti ini mas, code hapus sama simpan(btnSimpan) session ke database barang

<pre lang="php">
<?php 
//jika tombol proses diklik
if(isset($_POST['btnProses']))
{

    //membaca variabel di form
    $cmbBarang = $_POST['cmbBarang'];
    $txtVolume = $_POST['txtVolume'];
    $txtKeterangan = $_POST['txtKeterangan'];

    if (!count($message)==0 )
    {
        //menampilkan pesan error 
    }
    
    //tidak ada pesan error
    if (count($message)==0 )
    {
         $no = 0;     
     for ($i=0;$i<10;$i++) 
     { 
        if ($_SESSION ['a'][$i][0]=="") 
        {
            $_SESSION['a'][$i][0]=$cmbBarang;
            $_SESSION['a'][$i][1]=$txtVolume;
            $_SESSION['a'][$i][2]=$txtKeterangan;									
            break; 
        }
    }
       echo "<meta http-equiv='refresh' content='0; url=?page=pengadaan'>";
       exit; 
    }
                        
}


//jika tombol simpan diklik, data session di simpan
ke database barang berdasarkan nama supplier yang dipilih
if(isset($_POST['btnSimpan']))
{
   
    $message = array();
    if (trim($_POST['cmbSupplier'])=="BLANK") 
    {
    $message[] = "Nama supplier belum dipilih";		
    } 

    $cmbSupplier = $_POST['cmbSupplier'];

    if (!count($message)==0 )
    {
        //menampilkan pesan error 
    }

    
    if (count($message)==0 )
    { 
         for ($i=0;$i<count($_SESSION['a']);$i++)
         {
        $tmpBarang = $_SESSION['a'][$i][0];
        $tmpVolume = $_SESSION['a'][$i][1];
        $tmpKeterangan = $_SESSION['a'][$i][2];
        $simpanQuery=mysql_query("UPDATE barang SET 
                            volume=volume+'".$tmpVolume."', keterangan_barang='".$tmpKeterangan."', 
                            supplier_id_supplier='".$cmbSupplier."' WHERE id_barang ='".$tmpBarang."'") 
                            or die ("Gagal Query".mysql_error());
                                            
    }
    unset($_SESSION['a']); //menghapus session apabila data sudah masuk ke database barang
    echo "<meta http-equiv='refresh' content='0; url=?page=pengadaan'>";
    exit;
                                                                        
     }	

}


?>

<!--inputan data-->
<form action="?page=pengadaan" method="post" name="frmTambahPengadaan">
<label class="control-label">Nama Barang :</label>
     <select name="cmbBarang">
       <option value="BLANK">-- Pilih Barang --</option>
            <?php
               //mengambil data barang dari database barang
            ?>
    </select>
<label class="control-label">Nama Supplier :</label>
     <select name="cmbSupplier">
       <option value="BLANK">-- Pilih Supplier --</option>
            <?php
               //mengambil data supplier dari database supplier
            ?>
    </select>
<label class="control-label">Jumlah Barang :</label>
      <input type="text" name="txtVolume" value="" />
<label class="control-label">Keterangan Barang :</label>
       <input type="text" name="txtKeterangan" value="" />

<input type="submit" class="btn btn-primary" name="btnProses" value="Proses" />
<input type="submit" class="btn btn-primary" name="btnSimpan" value="Simpan" />

</form>


<!--menampilkan inputan data di tabel bawah ini-->
<!--tabel sementara sebelum di simpan ke database-->
<table>
 <thead>
  <tr>
   <th>No</th>
   <th>Nama Barang</th>
   <th>Volume</th>
   <th>Keterangan</th>
   <th>Hapus</th>
   </tr>
  <thead>

  <tbody>
      <?php
    for ($i=0;$i<count($_SESSION['a']);$i++) 
    {
        $no++;
        ?>
                 <tr class="success">
            <td style="text-align:center"><?php echo $no; ?></td>
            <td><?php echo $_SESSION['a'][$i][0]; ?></td>
            <td><?php echo $_SESSION['a'][$i][1]; ?></td>
            <td><?php echo $_SESSION['a'][$i][2]; ?></td>
            <td style="text-align:center"><a href="?page=hapus-pengadaan&amp;id=<?php echo $_SESSION['a'][$i][0]; ?>" target="_self" alt="Hapus Data Pengadaan" onClick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="icon-trash"></i></a></td>
        </tr>
       <?php } ?>
    </tbody>
</table>

< /pre>

kurakura
kurakura
January 2014 edited January 2014
hoalah ...

ini dulu :
id=<?php echo $_SESSION['a'][$i][0]; ?>

kok jadi kaya gitu ?
pan sudah gw tunjukin, sudah gw bold
cuma masalah $no atau $i

id=<?php echo $i; ?>

gitu pan sudah beres mas ...
"id" yg dipake buat rujukan jadi sama dengan "id" yg dipake di session



masalah INSERT ...

ini elo mau INSERT atau mau UPDATE ?
erica
erica
January 2014
rujukan dengan :
id=<?php echo $no; ?>
id=<?php echo $_SESSION['a'][$i][0]; ?>
id=<?php echo $i; ?>
belum berhasil mas..

kasusnya ini kayak gini mas, menginput banyak barang dari supplier.
sudah ada database barang, nah kalau ada banyak barang dari supplier tinggal dimasukkan ke database barang (volume barang bertambah)..
sepertinya menggunakan UPDATE mas..

erica
erica
January 2014
atau deklarasi dan pemanggilan session punya saya yang salah ya mas?
deklarasi session:

for ($i=0;$i<10;$i++) 
     { 
        if ($_SESSION ['a'][$i][0]=="") 
        {
            $_SESSION['a'][$i][0]=$cmbBarang;
            $_SESSION['a'][$i][1]=$txtVolume;
            $_SESSION['a'][$i][2]=$txtKeterangan;									
            break; 
        }
    }

menampilkan session:
<?php
    for ($i=0;$i<count($_SESSION['a']);$i++) 
    {
        $no++;
        ?>
                 <tr class="success">
            <td style="text-align:center"><?php echo $no; ?></td>
            <td><?php echo $_SESSION['a'][$i][0]; ?></td>
            <td><?php echo $_SESSION['a'][$i][1]; ?></td>
            <td><?php echo $_SESSION['a'][$i][2]; ?></td>
            <td style="text-align:center"><a href="?page=hapus-pengadaan&amp;id=<?php echo $_SESSION['a'][$i][0]; ?>" 
                        target="_self" alt="Hapus Data Pengadaan" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
                        <i class="icon-trash"></i></a></td>
        </tr>
       <?php } ?>

kurakura
kurakura
January 2014
yg elo ubah pake :
id=<?php echo $i; ?>
mana ?

unset nya kaya apa ?
erica
erica
January 2014
pengadaan.php
<?php
                                
        for ($i=0;$i<count($_SESSION['a']);$i++)
           {
                 $no++;
                   ?>
                   <tr class="success">
                    <td style="text-align:center"><?php echo $no; ?></td>
                    <td><?php echo $_SESSION['a'][$i][0]; ?></td>
                    <td><?php echo $_SESSION['a'][$i][1]; ?></td>
                    <td><?php echo $_SESSION['a'][$i][2]; ?></td>
                    <td style="text-align:center"><a href="?page=hapus-pengadaan&amp;id=<?php echo $i; ?>" target="_self" alt="Hapus Data Pengadaan" onClick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="icon-trash"></i></a></td>
                      </tr>
<?php } ?>

hapus_pengadaan.php
<?php
session_start();
if($_GET)
{
    if(empty($_GET['id']))
    {
        echo "<b>Data yang dihapus tidak ada</b>";
    }
    else
    {
        unset($_SESSION['a'][$_GET['id']]);
        echo "<meta http-equiv='refresh' type='reset' content='0; url=?page=pengadaan'>";   

    }
}
?>
kurakura
kurakura
January 2014
coba elo remark dulu baris ini :
echo "<meta http-equiv='refresh' type='reset' content='0; url=?page=pengadaan'>";

jadi :
//echo "<meta http-equiv='refresh' type='reset' content='0; url=?page=pengadaan'>";

saat elo hapus, url nya berubah jadi apa ?
erica
erica
January 2014
redirect ke halaman kosong, layar putih..
kurakura
kurakura
January 2014
url nya mas yg diperhatikan ...
bukan isi halamannya

url nya jadi apa ?
erica
erica
January 2014 edited January 2014
url : localhost/projek/proses.php?page=hapus-pengadaan&id=1
pakai id=<?php echo $i; ?> dengan //echo "<meta http-equiv='refresh' type='reset' content='0; url=?page=pengadaan'>";
-------------------------------------------------------------------------------------------------

ini tabel hasil inputan pake session, ketika saya klik simbol hapus2, data yang kehapus adalah Barang c, jd hapusnya dari bawah tabel, kalau sisa satu data di tabel tidak isa dihapus

itu kalau saya pake id=<?php echo $no; ?>
----------------------------------------------------------------------------------------------
No | Nama Barang | Volume | Keterangan Barang |       Hapus     |
----------------------------------------------------------------------------------------------
 1  |      Barang a   |      9     |  Barang ok             | simbol hapus1  |
 2  |      Barang b   |      4     |  Barng ready          | simbol hapus2  |
 3  |      Barang c   |      4     |  Barng bagus         | simbol hapus3  |
kurakura
kurakura
January 2014
coba elo tambah :

echo '<pre>';print_r($_SESSION['a']);echo '</pre>';
unset($_SESSION['a'][$_GET['id']]);
echo '<pre>';print_r($_SESSION['a']);echo '</pre>';
//echo "<meta http-equiv='refresh' type='reset' content='0; url=?page=pengadaan'>";   

url yg nungul posting kemari
tampilan yg nungul di layar posting kemari
erica
erica
January 2014
url : url : localhost/projek/proses.php?page=hapus-pengadaan&id=1

hasil :

Array
(
    [0] => Array
        (
            [0] => a
            [1] => 1
            [2] => a
        )

    [1] => Array
        (
            [0] => b
            [1] => 2
            [2] => b
        )

    [2] => Array
        (
            [0] => g
            [1] => 9
            [2] => g
        )

)

Array
(
    [0] => Array
        (
            [0] => a
            [1] => 1
            [2] => a
        )

    [2] => Array
        (
            [0] => g
            [1] => 9
            [2] => g
        )

)

kurakura
kurakura
January 2014
bener, id 1 nya kehapus kok ...
data di session elo cuma tinggal 2
erica
erica
January 2014
iy benar,
trus masalahnya apa mas?

aku coba kyk gini:
misal ada 4 baris dalam tabel, aku hapus tabel ke 3 atau  [2] => Array,
tapi kok data baris tabel ke 3, 4 juga ikutan hilang ya, yang tampil cuma No baris 3
kurakura
kurakura
January 2014
soalnya elo nampilin nya pake for()
for() itu bisa dipake kalo id nya urut

coba elo liat dari contoh hasil penghapusan yg elo posting ...
id nya urut atau kagak ?

php pan punya loop lain selain for()
ada while(), foreach()

kalo kasus elo, yg paling pas ya foreach()

coba elo buka php manual
baca ttg foreach()

erica
erica
January 2014
iya jalan mas,
code saya ubah seperti ini:
                        <?php
                               
                            //    for ($i=0;$i<count($_SESSION['a']);$i++)
                                $no=0;
                                foreach ($_SESSION['a'] as $i=>$tampil)
                                {
                                    $no++;
                                    ?>
                                     <tr class="success">
                                        <td style="text-align:center"><?php echo $no; ?></td>
                                        <td><?php echo $_SESSION['a'][$i][0]; ?></td>
                                        <td><?php echo $_SESSION['a'][$i][1]; ?></td>
                                        <td><?php echo $_SESSION['a'][$i][2]; ?></td>
                                        <td style="text-align:center"><a href="?page=hapus-pengadaan&amp;id=<?php echo $i; ?>" target="_self" alt="Hapus Data Pengadaan" onClick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="icon-trash"></i></a></td>
                                    </tr>
                           <?php } ?>

hapus_pengadaan.php
<?php
session_start();
if($_GET)
{
    if($_GET['id']>=0)
    {
        echo '<pre>';print_r($_SESSION['a']);echo '</pre>';
        unset($_SESSION['a'][$_GET['id']]);
        echo '<pre>';print_r($_SESSION['a']);echo '</pre>';
    //    unset($_SESSION['a'][$_GET['id']]);
    //    echo "<meta http-equiv='refresh' content='0; url=?page=pengadaan'>";   
    }
    else
    {
        echo "<b>Data yang dihapus tidak ada</b>";
    }
}
?>

data bisa di inputkan, tapi sebelum itu ada tampilan "Warning: Invalid argument supplied for foreach()" << ini mas, knp y?

erica
erica
January 2014
mas, misalnya array session[a] saya mulai dari indeks ke-1 gpp ta? ap harus dimulai indeks ke-0?
contoh hasil keluaran dari indeks ke 1:

Array
(
    [1] => Array    //ini maksud saya mas
        (
            [0] => a
            [1] => 1
            [2] => a
        )

    [2] => Array
        (
            [0] => b
            [1] => 2
            [2] => b
        )

    [3] => Array
        (
            [0] => 5
            [1] => 1
            [2] => 5
        )

)

kurakura
kurakura
January 2014
pesan warning lengkapnya apa mas ?
erica
erica
January 2014
pesan warning:

Warning: Invalid argument supplied for foreach() in C:\AppServ\www\projek\pengadaan.php on line 509
kurakura
kurakura
January 2014
baris 509 di file pengadaan.php itu yg mana ?
erica
erica
January 2014
509 yang ini >> foreach ($_SESSION['a'] as $i=>$tampil)
kurakura
kurakura
January 2014 edited January 2014
hoalah ...

mas, bisa lihat apa gw dari koding cuma sebaris itu ?
mbok ya, paling tidak elo posting 5 baris sebelum dan 5 baris sesudah
dan yg baris 509 elo tandai

jadi gw pan bisa ngeliat urutan alur koding elo
erica
erica
January 2014
di atas sdh saya post mas code nya, seperti ini :
<?php
                               
                                $no=0;
                                foreach ($_SESSION['a'] as $i=>$tampil)
                                {
                                    $no++;
                                    ?>
                                     <tr class="success">
                                        <td style="text-align:center"><?php echo $no; ?></td>
                                        <td><?php echo $_SESSION['a'][$i][0]; ?></td>
                                        <td><?php echo $_SESSION['a'][$i][1]; ?></td>
                                        <td><?php echo $_SESSION['a'][$i][2]; ?></td>
   
                                    <td
style="text-align:center"><a
href="?page=hapus-pengadaan&amp;id=<?php echo $i; ?>"
target="_self" alt="Hapus Data Pengadaan" onClick="return confirm('Anda
yakin ingin menghapus data ini?')"><i
class="icon-trash"></i></a></td>
                                    </tr>
                           <?php } ?>
kurakura
kurakura
January 2014
* menghela napas *
gw pan kagak tau baris 509 itu yg mana mas ...

coba aja elo itung dari post elo,
foreach() itu baris ke-4 ... lalu darimana gw bisa tau kalo itu sebenernya baris 509 ?



warning kemungkinan muncul saat $_SESSION['a'] kosong kagak ada isinya
tambah aja if()

if(is_array($_SESSION['a'])&&count($_SESSION['a']>=1)) {
  foreach(...) {
    ...
    ...
  }
}
else {
  // tampilkan table default kalo session kosong
}
erica
erica
January 2014
baris 507                   <?php                               
baris 508                   $no=0;
baris 509                   foreach ($_SESSION['a'] as $i=>$tampil)
baris 510                   {
baris 511                   $no++;
                                    ?>
                                     <tr class="success">
                                        <td style="text-align:center"><?php echo $no; ?></td>
                                        <td><?php echo $_SESSION['a'][$i][0]; ?></td>
                                        <td><?php echo $_SESSION['a'][$i][1]; ?></td>
                                        <td><?php echo $_SESSION['a'][$i][2]; ?></td>
   
                                    <td
style="text-align:center"><a
href="?page=hapus-pengadaan&amp;id=<?php echo $i; ?>"
target="_self" alt="Hapus Data Pengadaan" onClick="return confirm('Anda
yakin ingin menghapus data ini?')"><i
class="icon-trash"></i></a></td>
                                    </tr>
                           <?php } ?>

seperti diatas itu mas..
kurakura
kurakura
January 2014
sudah dicoba ditambah if() atau belum ?
erica
erica
January 2014 edited January 2014
sudah, memang sudah gk muncul warning, mengikuti code mas dibawah ini
if(is_array($_SESSION['a'])&&count($_SESSION['a']>=1)) {
  foreach(...) {
    ...
    ... //sukses
    ...
  }
}
else {
  // echo "hasil tabel tambah barang";
}

tapi, tulisan warning digantikan oleh tulisan "hasil tabel tambah barang" yang didapat dari else{} di atas..
hal tersebut tidak masalah kan mas??
erica
erica
January 2014
mas, tanya code >> foreach ($_SESSION['a'] as $i=>$tampil) , untuk variabel $tampil apa fungsinya cuma gitu aja, maksudnya $tampil tidak terpakai lagi di code di bawah ini ?

                                        <td><?php echo $_SESSION['a'][$i][0]; ?></td>
                                        <td><?php echo $_SESSION['a'][$i][1]; ?></td>
                                        <td><?php echo $_SESSION['a'][$i][2]; ?></td>
 
kurakura
kurakura
January 2014
yg masalah pesan : hasil tabel tambah barang
terserah elo ...

tapi sebenernya yg gw maksud, bikin aja <table> kosong yg kagak ada value nya

else { ?>
                                     <tr class="success">
                                        <td style="text-align:center"></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td style="text-align:center"></td>
                                    </tr>
<?php }

jadi tetep imbang dengan layout yg ada isinya



yg masalah $tampil ...

isi $tampil itu persis sama dengan $_SESSION['a'][$i] pada saat foreach jalan

jadi elo <?php echo $_SESSION['a'][$i][0]; ?>
hasilnya persis sama kalo elo pake $tampil : <?php echo $tampil[0]; ?>

terserah elo pake yg mana
cuma secara penulisan lebih singkat yg $tampil
erica
erica
January 2014 edited January 2014
iya mas, sudah bisa..

cara untuk menyimpan hasil session yang ada ditabel (hasil inputan) ke dalam database barang berdasarkan supplier yang dipilih gmn mas?
ini code simpan saya

<?php

if(isset($_POST['btnSimpan']))
{
if(count($message)==0)
                                    {
                                        for ($i=1;$i<count($_SESSION['a']);$i++)
                                        {
                                            $tmpBarang = $_SESSION['a'][$i][0];
                                            $tmpVolume = $_SESSION['a'][$i][1];
                                            $tmpKeterangan = $_SESSION['a'][$i][2];
                                            $simpanQuery=mysql_query("UPDATE barang SET volume=volume+'".$tmpVolume."', keterangan_barang='".$tmpKeterangan."', supplier_id_supplier='".$cmbSupplier."' WHERE id_barang ='".$tmpBarang."'") or die ("Gagal Query".mysql_error());
                                           
                                        }
                                        unset($_SESSION['a']);
                                        echo "<meta http-equiv='refresh' content='0; url=?page=pengadaan'>";
                                        exit;
                                                                       
                                    }   
}

?>
melakukan simpan ke database "barang" berdasarkan combobox $cmbSupplier.., setelah data session d tabel tersimpan, tabel dikosongkan dengan unset($_SESSION['a']);
kurakura
kurakura
January 2014 edited January 2014
kalo liat query elo, ada yg kagak cocok disini ...

$tmpBarang = $_SESSION['a'][$i][0];
$tmpVolume = $_SESSION['a'][$i][1];
$tmpKeterangan = $_SESSION['a'][$i][2];

$simpanQuery=mysql_query(
"UPDATE
  barang
SET
  volume=volume+'".$tmpVolume."',
  keterangan_barang='".$tmpKeterangan."',
  supplier_id_supplier='".$cmbSupplier."'
WHERE
  id_barang ='".$tmpBarang."'"
)



[1]
$tmpBarang isinya apa mas ?
$_SESSION['a'][$i][0] itu apa ?

    <td><?php echo $_SESSION['a'][$i][0]; ?></td>            <!-- Nama Barang -->

kok bisa elo masukin query jadi : WHERE id_barang ='".$tmpBarang."'" ?

[2]

    database saya seperti ini mas,

    tabel barang:
    id_barang INT(11);
    nama_barang VARCHAR(50);
    volume INT(11);
    keterangan VARCHAR(50);
    supplier_id_supplier VARCHAR (5);  // di dapat dari tabel supplier

kok bisa elo masukin query jadi : keterangan_barang='".$tmpKeterangan."', ?
erica
erica
January 2014
>> maksud saya itu nilai <?php echo $_SESSION['a'][$i][0]; ?> kan nilai dari data session, saya tampung dng nama variabel $tmpBarang sebelum di simpan ke database..
atau harusnya tidak perlu ditampung ya mas, jd modelnya seperti ini:
       $cmbSupplier = $_POST['cmbSupplier'];
       $cmbBarang = $_SESSION['a'][$i][0];
       $txtVolume = $_SESSION['a'][$i][1];
       $txtKeterangan = $_SESSION['a'][$i][2];
      
      //$cmbSupplier, $cmbBarang,. $txtVolume, $txtKeterangan adalah nama input variabel form


>> keterangan_barang sama kayak keterangan, kemarin saya ubah "database barang" dari keterangan VARCHAR(50) menjadi keterangan_barang VARCHAR(50)

>> untuk WHERE id_barang ='".$tmpBarang."'" itu yang saya ambil itu id_barang nya, di inputan form saya pakai combobox yang menampilkan nama_barang, tp yang di simpan adalah id_barang, input form seperti ini:

<label class="control-label">Nama Barang :</label>
       <div class="controls">
             <select name="cmbBarang">
                   <option value="BLANK">-- Pilih Barang --</option>
                        <?php
                                 $barangSql = "SELECT * FROM barang ORDER BY id_barang";
                                  $barangQuery = mysql_query($barangSql,$connectDb) or die("Gagal Query : ".mysql_error());
                                  while($barangRow = mysql_fetch_array($barangQuery))
                                   {
                                            if($barangRow['id_barang']==$_POST['cmbBarang'])
                                             {
                                                   echo "<option value='$barangRow[nama_barang]' selected>$barangRow[nama_barang]</option>";
                                              }
                                              else
                                               {
                                                      echo "<option value='$barangRow[nama_barang]'>$barangRow[nama_barang]</option>";
                                               }
                                  }
                        ?>
              </select>
             </div>
kurakura
kurakura
January 2014 edited January 2014

    >> untuk WHERE id_barang ='".$tmpBarang."'" itu yang saya ambil itu id_barang nya, di inputan form saya pakai combobox yang menampilkan nama_barang, tp yang di simpan adalah id_barang, input form seperti ini:

    <label class="control-label">Nama Barang :</label>
           <div class="controls">
                 <select name="cmbBarang">
                       <option value="BLANK">-- Pilih Barang --</option>
                            <?php
                                     $barangSql = "SELECT * FROM barang ORDER BY id_barang";
                                      $barangQuery = mysql_query($barangSql,$connectDb) or die("Gagal Query : ".mysql_error());
                                      while($barangRow = mysql_fetch_array($barangQuery))
                                       {
                                                if($barangRow['id_barang']==$_POST['cmbBarang'])
                                                 {
                                                       echo "<option value='$barangRow[nama_barang]' selected>$barangRow[nama_barang]</option>";
                                                  }
                                                  else
                                                   {
                                                          echo "<option value='$barangRow[nama_barang]'>$barangRow[nama_barang]</option>";
                                                   }
                                      }
                            ?>
                  </select>
                 </div>

mana ada id_barang di combo nya mas ...
erica
erica
January 2014
maaf mas, saya salah ketik, harusnya memang <option value='$barangRow[id_barang]' selected>$barangRow[nama_barang]</option>
erica
erica
January 2014
jadinya kyk gini ta mas utk simpannya?
$cmbSupplier = $_POST['cmbSupplier'];
if(isset($_POST['btnSimpan']))
{
   if(count($message)==0)
   {
         for ($i=1;$i<count($_SESSION['a']);$i++)
         {
               $cmbBarang = $_SESSION['a'][$i][0];
               $txtVolume = $_SESSION['a'][$i][1];
               $txtKeterangan = $_SESSION['a'][$i][2];
  
            $simpanQuery=mysql_query("UPDATE barang SET
volume=volume+'".$txtVolume."', keterangan='".$txtKeterangan."',
supplier_id_supplier='".$cmbSupplier."' WHERE id_barang
='".$cmbBarang."'") or die ("Gagal Query".mysql_error());
          }
          unset($_SESSION['a']);
          echo "<meta http-equiv='refresh' content='0; url=?page=pengadaan'>";
          exit;
                                                                 
     }   
}
kurakura
kurakura
January 2014 edited January 2014
kalo penamaan field dan value nya sudah bener,
tinggal elo maunya kaya apa ...

semisal, jika data di table :
1, barang A, 100, supplier X
2, barang B, 100, supplier Y
3, barang A, 50, supplier Z

koding elo itu bermaksud, kalo ada input : 1, 10, supplier Z

apa kode supplier bisa berubah ?
yg hasilnya table berubah jadi :
1, barang A, 110, supplier Z
2, barang B, 100, supplier Y
3, barang A, 50, supplier Z

atau, sebenernya yg elo maksud, harusnya yg berubah :
1, barang A, 100, supplier X
2, barang B, 100, supplier Y
3, barang A, 60, supplier Z

erica
erica
January 2014
>> saat ini saya hanya menggunakan 2 tabel di database, yaitu tabel barang dan tabel supplier dengan hubungan relasi 1 : N antara supplier dan barang

untuk contoh dari mas dibawah ini :
"apa kode supplier bisa berubah ?
yg hasilnya table berubah jadi :
1, barang A, 110, supplier Z
2, barang B, 100, supplier Y
3, barang A, 50, supplier Z"
>> saya sudah berhasil melakukannya

untuk contoh dari mas dibawah ini :
atau, sebenernya yg elo maksud, harusnya yg berubah :
1, barang A, 100, supplier X
2, barang B, 100, supplier Y
3, barang A, 60, supplier Z
>> saya tahu maksudnya mas, tapi..

yang saya inginkan nanti adalah "laporan barang berdasarkan supplier", misal : supplier A mengirim barang A berjumlah 1, barang B berjumlah 2, barang C berjumlah 3. Sedangkan supplier B mengirim barang A berjumlah 1, barang B berjumlah 2, barang C berjumlah 3....dalam database tabel barang ada "field" nama_barang, volume yang isinya:
nama_barang     |      volume
barang A           |          2    (dr supplier A dan B)
barang B           |          4    (dr supplier A dan B)
barang C           |          6    (dr supplier A dan B)

saat, mau melihat laporan barang berdasarkan supplier, misal saya pilih supplier A maka akan menampilakn barang2 yang dikirim oleh supplier A..

apa di sini saya kurang menambahkan database dengan tabel baru?

 
kurakura
kurakura
January 2014 edited January 2014
nah itu yg jadi masalah mas ... :D

karena pola yg seharusnya itu bukan pola yg pertama
pola yg kedua itu pun juga salah,
tapi yg kedua masih mendingan dibanding yg pertama,
soalnya sudah membedakan supplier meskipun barang nya sama

kompleks atau kagak itu tergantung butuh

semestinya table elo bentuknya paling tidak :

table master_barang (minimal)
id | nama_barang

table master_supplier (minimal)
id | nama_supplier

table stok (minimal)
id | id_barang | id_supplier | tanggal | jumlah

table stok kagak ada proses UPDATE dan DELETE
isinya cuma INSERT

beda dgn pola elo
table barang di elo itu adalah table stok, cuma isinya masih elo campur dengan table master_barang
stok bisa di update, bahkan sampai merubah nama supplier

itu kalo ngomong masalah audit data sudah salah mas
hal yg seharusnya tidak boleh berubah tapi bisa diubah

kalo ngomong butuh elo, pola elo juga kagak bisa dipake



masalah field "keterangan", gw kagak tau butuh elo utk apa
apakah melekat ke transaksi atau ke barang, jadi gw abaikan
tapi sudah gw tulis di atas, itu bentuk minimal, terserah kalo mau ditambah field nya
erica
erica
January 2014
saya ubah databasenya mas, jd ada 4 tabel :

tabel supplier
id_supplier | nama_supplier

tabel barang
id_barang | nama_barang | volume

tabel pengadaan
id_pengadaan | tanggal | id_supplier

tabel pengadaan_item (hasil relasi M : N antara tabel barang dng tabel pengadaan)
id_pengadaan | id_barang | jumlah

saya berhasil menggunakan data session (*pembahasan posting sebelumnya) yang di tampung di tabel terlebih dahulu kemudian di simpan ke database..

semua berjalan dengan satu data session, tapi ketika ada data session yang sama pada tabel, tidak bisa di simpan ke database..misal :
tabel data session
nama barang    |       jumlah
barang a          |           1
barang a          |           1
>> hasil tidak bisa di simpan ke database

ini knp ya mas?
**barang a di dapat dari form inputan nama barang (combobox)

atau bagaimana kalau form inputan nama barang dilakukan pengecekan saja, jadi misalnya "jika barang a telah ada di tabel data session maka ada validasi inputan??

«123»
Sign In or Register to comment.
Forum Software Powered by Vanilla
