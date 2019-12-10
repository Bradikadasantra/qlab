<?php
// ------------------------------------------------------------------------
	/**
	 * Formats a numbers as bytes, based on size, and adds the appropriate suffix
	 *
	 * @param	mixed	will be cast as int
	 * @param	int
	 * @return	string
	 */
	  function getJumlah($no_order){
		$ci = get_instance();
		$qri = "SELECT SUM(biaya_pemeriksaan) as jml FROM order_detail JOIN (sampel JOIN pemeriksaan ON 
		sampel.id_sampel = pemeriksaan.id_sampel) ON order_detail.id_order_detail = sampel.id_order_detail where no_order = '$no_order'";
		$hsl = $ci->db->query($qri);
		$row = $hsl->row();
		return $row->jml;
	 }
function getNota($table, $param, $kode) {
@$today = date("Ymd");

$ci = get_instance();
	$qri = "SELECT MAX($param) AS last FROM $table where $param like '%$today%'";
	$hsl = $ci->db->query($qri);
	$row = $hsl->row();
	$lastNo = $row->last;
	$custom_code =$kode;
	$code=$kode.$today;
	// baca nomor urut Pengajuan dari id Pengajuan terakhir
	//002201602050001
	$lastNoUrut = substr($lastNo, 11, 4); 

	// nomor urut ditambah 1
	$nextNoUrut = $lastNoUrut + 1;

	// membuat format nomor Pengajuan berikutnya
	$no_nota = $code.sprintf('%04s', $nextNoUrut);
			return $no_nota;
	}

function getRomawi($bln){
                switch ($bln){
                    case 1: 
                        return "I";
                        break;
                    case 2:
                        return "II";
                        break;
                    case 3:
                        return "III";
                        break;
                    case 4:
                        return "IV";
                        break;
                    case 5:
                        return "V";
                        break;
                    case 6:
                        return "VI";
                        break;
                    case 7:
                        return "VII";
                        break;
                    case 8:
                        return "VIII";
                        break;
                    case 9:
                        return "IX";
                        break;
                    case 10:
                        return "X";
                        break;
                    case 11:
                        return "XI";
                        break;
                    case 12:
                        return "XII";
                        break;
                }
}

function setNoSampel($kode, $tgl_order) {
	$thn = substr($tgl_order,0,4);
	$bln = substr($tgl_order,5,2);
	$tgl = substr($tgl_order,8,2);
	return $kode.'/Qlab/'.getRomawi($bln).'/'.$thn;
}

	function getNoSampel($kode) {

	$ci = get_instance();
	$qri = "SELECT MAX(no_sampel) AS last FROM sampel where id_bidang='$kode' and year(tanggal) = year(now())";
	$hsl = $ci->db->query($qri);
	$row = $hsl->row();	
	$lastNo = $row->last;
	$code=$kode;
	$lastNoUrut = substr($lastNo, 1, 3); 

	$nextNoUrut = $lastNoUrut + 1;

	$no_sampel = $code.sprintf('%03s', $nextNoUrut);
			return $no_sampel;
		}
	
	
	function SetInvoice($kode){ 

		$tahun = substr(date('Y'), 2, 2);
		$ci = get_instance();
		$qri = "SELECT MAX(no_tagihan) AS last FROM tagihan";
		$row = $ci->db->query($qri)->row();
	
		$lastNo = substr($row->last,0);
		$urut = $lastNo+1;
		if ($urut < 10){
		$lastNoUrut = $kode.$tahun.".0000".$urut;
		}else if ($urut < 100){
			$lastNoUrut = $kode.$tahun.".000".$urut;
		}else if ($urut < 1000){
			$lastNoUrut = $kode.$tahun.".00".$urut;
		}else if ($urut < 10000){
			$lastNoUrut = $kode.$tahun.".0".$urut;
		}
		return $lastNoUrut; 
	}
	

function rupiah($angka){
	$hasil_rupiah = number_format($angka,2,',','.');
	return $hasil_rupiah;
}
	

function koma($angka) {
	$rupiah="";
	$rp=strlen($angka);
	while ($rp>3) {
		$rupiah = ",". substr($angka,-3). $rupiah;
		$s		= strlen($angka) - 3;
		$angka	= substr($angka,0,$s);
		$rp		= strlen($angka);
	}
	$rupiah = $angka . $rupiah ;
	return $rupiah;
}

function hapuskoma($kata){
 return str_replace(',','',$kata);	
}
	 function hapustitik($kata){
 return str_replace('.','',$kata);	
}
	function angka($angka)
	{
		$rupiah="";
		$rp=strlen($angka);
		while ($rp>3) {
			$rupiah = ".". substr($angka,-3). $rupiah;
			$s		= strlen($angka) - 3;
			$angka	= substr($angka,0,$s);
			$rp		= strlen($angka);
		}
		$rupiah = "Rp." .$angka . $rupiah;
		return $rupiah;	
	}
	function status_pesan($x){
		switch($x){
			case 0:return 'Pesan';
			break;
			case 1:return 'Konfirmasi';
			break;
		}
		
	}
	
	function WKT($sekarang){
		$tanggal = substr($sekarang,8,2)+0;
		$bulan = substr($sekarang,5,2);
		$tahun = substr($sekarang,0,4);

		$judul_bln=array(1=> "Januari", "Februari", "Maret", "April", "Mei","Juni", "Juli", "Agustus", "September","Oktober", "November", "Desember");
		$wk=$tanggal." ".$judul_bln[(int)$bulan]." ".$tahun;
		return $wk;
	}
function getName($tb,$primary,$parameter,$field) {
	$ci = get_instance();
	 $ci->db->where($primary, $parameter);
       $data=$ci->db->get($tb)->row();
	
		return $data->$field;
		////getName('tb_anggota','id_anggota',$hasil[id_anggota],'nama')//penggunaaanya
	
}


// FUNCTION STATUS ORDER
function status($s){	
	$ci = get_instance();
	$hak_akses = $ci->session->userdata('hak_akses');
	
	$query = "SELECT * FROM `order` WHERE no_order = '$s'";
	$cari = $ci->db->query($query)->row();
	$status = $cari->status; 
	
	if ($hak_akses == 'Super Admin'){
		switch ($status){
			case 0 :return '<span class="badge badge-danger"><i class="fas fa-minus fa-sm"></i></span> Belum dikerjakan';break;
			case 1 :return '<span class="badge badge-success"><i class="fas fa-minus fa-sm"></i></span> sudah dikerjakan';break;
			case 2 :return '<span class="badge badge-success"><i class="fas fa-minus fa-sm"></i></span> sudah dikerjakan';break;
			case 3 :return '<span class="badge badge-success"><i class="fas fa-minus fa-sm"></i></span> sudah dikerjakan';break;
			case 4 :return '<span class="badge badge-success"><i class="fas fa-minus fa-sm"></i></span> sudah dikerjakan';break;
			case 5 :return '<span class="badge badge-success"><i class="fas fa-minus fa-sm"></i></span> sudah dikerjakan';break;
			case 6 :return '<span class="badge badge-success"><i class="fas fa-minus fa-sm"></i></span> sudah dikerjakan';break;
			case 7 :return '<span class="badge badge-success"><i class="fas fa-minus fa-sm"></i></span> sudah dikerjakan';break;
			case 8 :return '<span class="badge badge-success"><i class="fas fa-minus fa-sm"></i></span> sudah dikerjakan';break;
			case 9 :return '<span class="badge badge-success"><i class="fas fa-minus fa-sm"></i></span> sudah dikerjakan';break;
			case 10 :return '<span class="badge badge-success"><i class="fas fa-minus fa-sm"></i></span> sudah dikerjakan';break;
			
		}
	}	
	else if ($hak_akses == 'manajer_teknik'){
		switch ($status){
			case 1 :return '<span class="badge badge-danger"><i class="fas fa-minus fa-sm"></i></span> Belum dikerjakan';break;
			case 2 :return '<span class="badge badge-success"><i class="fas fa-check fa-sm"></i></span> Sudah dikerjakan';break;
			case 3 :return '<span class="badge badge-success"><i class="fas fa-check fa-sm"></i></span> Sudah dikerjakan';break;
			case 4 :return '<span class="badge badge-success"><i class="fas fa-check fa-sm"></i></span> Sudah dikerjakan';break;
			case 5 :return '<span class="badge badge-success"><i class="fas fa-check fa-sm"></i></span> Sudah dikerjakan';break;
			case 6 :return '<span class="badge badge-success"><i class="fas fa-check fa-sm"></i></span> Sudah dikerjakan';break;
			case 7 :return '<span class="badge badge-success"><i class="fas fa-check fa-sm"></i></span> Sudah dikerjakan';break;
			case 10 :return '<span class="badge badge-success"><i class="fas fa-check fa-sm"></i></span> Sudah dikerjakan';break;
			
		}
	}
	
	else if ($hak_akses == 'analis'){
		switch($status){
			case 7 :return '<span class="badge badge-danger"><i class="fas fa-minus fa-sm"></i></span> Belum dikerjakan';break;
		}
	}
}

		//status sampel 
		function StatusSampel($s){
			$ci = get_instance();
			$hak_akses = $ci->session->userdata('hak_akses');
			
			if ($hak_akses == 'Super Admin'){
			switch ($s){
				case 0 :return '<span class="badge badge-danger"> Belum Diterima</span>';break;
				case 1 :return '<span class="badge badge-success"> Diterima</span>';break;
				case 2 :return '<span class="badge badge-success"> Disetujui MT</span>';break;
				case 3 :return '<span class="badge badge-danger"> Ditolak MT</span>';break;
				case 4 :return '<span class="badge badge-info"> Disetujui MT dengan catatan *</span>';break;
				case 5 :return '<span class="badge badge-warning"> Dikonfirmasi pelanggan*</span>';break;
			
				}
			}
			else if ($hak_akses == 'manajer_teknik'){
				switch ($s){
				case 1 :return '<span class="badge badge-warning"> Menunggu Approval</span>';break;
				case 2 :return '<span class="badge badge-success"> Disetujui</span>';break;
				case 3 :return '<span class="badge badge-danger"> Ditolak</span> ';break;
				case 4 :return '<span class="badge badge-info"> Disetujui dengan catatan</span> ';break;
				case 5 :return '<span class="badge badge-info"> Disetujui dengan catatan</span> ';break;
				}
			}
			else if ($hak_akses == 'analis'){
				switch ($s){
				case 2 :return '<span class="badge badge-success"> Disetujui</span>';break;
				case 3 :return '<span class="badge badge-danger"> Ditolak</span>';break;
				case 4 :return '<span class="badge badge-info"> Disetujui dengan catatan</span> ';break;
				case 5 :return '<span class="badge badge-info"> Disetujui dengan catatan</span> ';break;
				}
			}
			
			else if ($hak_akses == 'pelanggan'){
				switch ($s){
				case 0 :return '<span class="badge badge-danger"> Serahkan sampel</span>';break;
				case 1 :return '<span class="badge badge-info"> Sampel diterima</span> ';break;
				case 2 :return '<span class="badge badge-success"> Disetujui</span> ';break;
				case 3 :return '<span class="badge badge-danger"> Ditolak</span> ';break;
				case 4 :return '<span class="badge badge-info"> Disetujui dengan catatan </span>';break;
				case 5 :return '<span class="badge badge-info"> Disetujui dengan catatan</span> ';break;
				}
			}
		}
				
	function StatusTinjauan($s, $id_bidang, $status){
		$ci = get_instance();
		$hak_akses  = $ci->session->userdata('hak_akses');
	
		if ($hak_akses == 'manajer_teknik'){
			$cari = $ci->m_registrasi_sampel->all_data_perbidang2(array('order.no_order' => $s), $id_bidang, $status);
				if ($cari->num_rows() > 0 ){
					echo '<span class="badge badge-success"><i class="fas fa-minus fa-sm"></i></span> Sudah dikerjakan';
					}
				else{
					echo '<span class="badge badge-danger"><i class="fas fa-minus fa-sm"></i></span> Belum dikerjakan';
				}
		}
		else if ($hak_akses == 'analis'){
			$cari2 = $ci->m_registrasi_sampel->all_data_perbidang2(array('order.no_order' => $s),$id_bidang, $status);
				if ($cari2->num_rows() > 0 ){
					echo '<span class="badge badge-success"><i class="fas fa-minus fa-sm"></i></span> Sudah dikerjakan'; 
				}else{
					echo '<span class="badge badge-danger"><i class="fas fa-minus fa-sm"></i></span> Belum dikerjakan';
				}
		}
	}
	
	function notif_navbar($id_bidang, $status, $tinjauan){
		$ci  = get_instance();
		$result = $ci->m_registrasi_sampel->notif_navbar($id_bidang, $status, $tinjauan)->result();
		return count($result);
	}

	function status_tinjauan($no_order, $id_bidang, $status){
		$ci  = get_instance();
		$hasil = $ci->m_registrasi_sampel->notif_navbar($no_order, $id_bidang, $status)->num_rows();
			if ($hasil > 0){
				echo '<span class="badge badge-danger"><i class="fas fa-minus fa-sm"></i></span> Belum dikerjakan';
			}else{
				echo '<span class="badge badge-success"><i class="fas fa-minus fa-sm"></i></span> Sudah dikerjakan'; 
			}
	}
	
	function status_sertifikat2($no_order, $id_bidang){
		$ci = get_instance();
		$hak_akses  = $ci->session->userdata('hak_akses');
		$default = $ci->m_registrasi_sampel->all_data_perbidang($no_order, $id_bidang)->result();
		$cek_0 = $ci->m_registrasi_sampel->all_data_perbidang3($no_order, $id_bidang,array('status_sertifikat'=> 0),array('status_tinjauan_mt'=> 4))->result();
		$cek_1 = $ci->m_registrasi_sampel->all_data_perbidang3($no_order, $id_bidang,array('status_sertifikat'=> 1),array('status_tinjauan_mt'=> 2))->result();
		$cek_2 = $ci->m_registrasi_sampel->all_data_perbidang3($no_order, $id_bidang,array('status_sertifikat'=> 2),array('status_tinjauan_mt'=> 4))->result();		
		
		if ($hak_akses == 'manajer_teknik'){
			if (count($default) == count($cek_1)){
			echo '<span class="badge badge-danger"> Butuh persetujuan</span>';
			}else if (count($default) == count($cek_2)){
				echo '<span class="badge badge-success"> Disetujui</span>';
			}else{
				echo '-';
			}
			
		}else if ($hak_akses == 'analis'){
			if (count($default) == count($cek_1)){
			echo '<span class="badge badge-primary"> Diajukan</span>';
			}else if (count($default) == count($cek_2)){
				echo '<span class="badge badge-success"> Disetujui</span>';
			}else if (count($default) == count($cek_3)){
				echo '<span class="badge badge-warning"> Diuji ulang</span>';
			}else{
				echo '-';
			}
		}
	}
	
	function StatusTagihan($status){
		switch ($status){
			case 0 : return '<button type="button" class="btn btn-outline-danger btn-sm disabled"> Belum Bayar</button>';  break;
			case 1 : return '<button type="button" class="btn btn-outline-info btn-sm disabled"> Sudah Konfirmasi</button>';  break;
			case 2 : return '<button type="button" class="btn btn-outline-success btn-sm disabled"> Sudah Bayar</button>';  break;
		}
	}


function StatusSertifikat($s){
	switch ($s){
		case 0 :return '-';break;
		case 1 :return '<span class="badge badge-info">Diajukan</span>';break;
		case 2 :return '<span class="badge badge-success"> Disetujui</span>';break;
		case 3 :return '<span class="badge badge-danger"> Ditolak</span>';break;
		case 4 :return '<span class="badge badge-info"> Diajukan ulang</span>';break;
	}
}
function aktif($s){
	switch ($s){
		case 0 :return 'Tidak Aktif';break;
		case 1 :return 'Aktif';break;
	}
}

function terbilang($x){
  $abil = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
  if ($x < 12)
    return " " . $abil[$x];
  elseif ($x < 20)
    return Terbilang($x - 10) . " Belas";
  elseif ($x < 100)
    return Terbilang($x / 10) . " Puluh" . Terbilang($x % 10);
  elseif ($x < 200)
    return " Seratus" . Terbilang($x - 100);
  elseif ($x < 1000)
    return Terbilang($x / 100) . " Ratus" . Terbilang($x % 100);
  elseif ($x < 2000)
    return " Seribu" . Terbilang($x - 1000);
  elseif ($x < 1000000)
    return Terbilang($x / 1000) . " Ribu" . Terbilang($x % 1000);
  elseif ($x < 1000000000)
    return Terbilang($x / 1000000) . " Juta" . Terbilang($x % 1000000);
	elseif ($x < 1000000000000)
    return Terbilang($x / 1000000000) . " Milyar" . Terbilang($x % 1000000000);
}


function GetStatus_Sampel($no_order){
	$query = "SELECT status_pemeriksaan FROM `order` JOIN (order_detail JOIN(sampel JOIN pemeriksaan ON sampel.id_sampel = pemeriksaan.id_sampel) 
	ON order_detail.id_order_detail = sampel.id_order_detail) ON `order`.no_order = order_detail.no_order WHERE `order`.no_order = '$no_order' AND status_pemeriksaan = 2";
	
	$ci = get_instance();
	$run = $ci->db->query($query)->num_rows();
	if ($run >= 1){
		echo StatusPemeriksaan(1);
	}
	else{
		echo StatusPemeriksaan(0);
	}
}

function GetStatus_SampelDiterima($no_order){
	$query = "SELECT status_sampel FROM `order` JOIN (order_detail JOIN sampel ON order_detail.id_order_detail = sampel.id_order_detail) ON
	`order`.no_order = order_detail.no_order WHERE `order`.no_order = '$no_order' AND (status_sampel = 1 OR status_sampel = 2 OR status_sampel = 3)";
	
	$ci = get_instance();
	$hasil = $ci->db->query($query)->num_rows();
	
	if ($hasil >= 1){
		echo StatusSampel(1);
	}else{
		echo StatusSampel(0);
	}	
}

function GetStatus_SampelDikerjakan($no_order){
	$query = "SELECT status_sampel FROM `order` JOIN (order_detail JOIN sampel ON order_detail.id_order_detail = sampel.id_order_detail) ON
	`order`.no_order = order_detail.no_order WHERE `order`.no_order = '$no_order' AND status_sampel = 3";
	
	$ci = get_instance();
	$hasil = $ci->db->query($query)->num_rows();
	
	if ($hasil >= 1){
		echo StatusSampel(3);
	}else{
		echo StatusSampel(2);
	}	
	
}

function GetStatus_Sertifikat($no_order){
	$q1  = "SELECT status_sertifikat FROM `order` JOIN (order_detail JOIN sampel ON order_detail.id_order_detail = sampel.id_order_detail) ON 
	`order`.no_order = order_detail.no_order WHERE  `order`.no_order = '$no_order'";
	
	$q2	 = "SELECT status_sertifikat FROM `order` JOIN (order_detail JOIN sampel ON order_detail.id_order_detail = sampel.id_order_detail) ON 
	`order`.no_order = order_detail.no_order WHERE `order`.no_order = '$no_order' AND status_sertifikat = 1";
	
	$q3  = "SELECT status_sertifikat FROM `order` JOIN (order_detail JOIN sampel ON order_detail.id_order_detail = sampel.id_order_detail) ON 
	`order`.no_order = order_detail.no_order WHERE  `order`.no_order = '$no_order' AND status_sertifikat = 2";
	
	$ci = get_instance();
	$run1 = $ci->db->query($q1)->result();
	$hitung1 = count($run1);
	
	$run2 = $ci->db->query($q2)->result();
	$hitung2 = count($run2);
	
	$run3 = $ci->db->query($q3)->result();
	$hitung3 = count($run3);
	
	if ($hitung3 == $hitung1){
		echo StatusSertifikat(2);
	}else if ($hitung2 >= $hitung3 or $hitung3 >= $hitung2){
		echo StatusSertifikat(1);
	}else{
		echo StatusSertifikat(3);
	}
	
}
	

