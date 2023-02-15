<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('tgl_indo'))
{
	function tgl_indo($tgl)
	{
		$ubah = gmdate($tgl, time()+60*60*8);
		$pecah = explode("-",$ubah);
		$tanggal = $pecah[0];
		$bulan = bulan($pecah[1]);
		$tahun = $pecah[2];
		return $tanggal.' '.$bulan.' '.$tahun;
	}
	
	function tgl_indo2($tgl)
	{
		$ubah = gmdate($tgl, time()+60*60*8);
		$pecah = explode("-",$ubah);
		$tanggal = $pecah[2];
		$bulan = bulan($pecah[1]);
		$tahun = $pecah[0];
		return $tanggal.' '.$bulan.' '.$tahun;
	}
	
	function tgl_strip($tgl)
	{
		if($tgl == '')
			return '';
		$ubah = $tgl;
		$pecah = explode(" ",$ubah);
		$tanggal = $pecah[0];
		$bulan = bulan2($pecah[1]);
		$tahun = $pecah[2];
		return $tanggal.'-'.$bulan.'-'.$tahun;
	}
}

if ( ! function_exists('bulan'))
{
	function bulan($bln)
	{
		switch ($bln)
		{
			case 1:
				return "Januari";
				break;
			case 2:
				return "Februari";
				break;
			case 3:
				return "Maret";
				break;
			case 4:
				return "April";
				break;
			case 5:
				return "Mei";
				break;
			case 6:
				return "Juni";
				break;
			case 7:
				return "Juli";
				break;
			case 8:
				return "Agustus";
				break;
			case 9:
				return "September";
				break;
			case 10:
				return "Oktober";
				break;
			case 11:
				return "November";
				break;
			case 12:
				return "Desember";
				break;
		}
	}
}

if ( ! function_exists('bulan2'))
{
	function bulan2($bln)
	{
		switch ($bln)
		{
			case "Januari":
				return 1;
				break;
			case "Februari":
				return 2;
				break;
			case "Maret":
				return 3;
				break;
			case "April":
				return 4;
				break;
			case "Mei":
				return 5;
				break;
			case "Juni":
				return 6;
				break;
			case "Juli":
				return 7;
				break;
			case "Agustus":
				return 8;
				break;
			case "September":
				return 9;
				break;
			case "Oktober":
				return 10;
				break;
			case "November":
				return 11;
				break;
			case "Desember":
				return 12;
				break;
		}
	}
}

if ( ! function_exists('nama_hari'))
{
	function nama_hari($tanggal)
	{
		$ubah = gmdate($tanggal, time()+60*60*8);
		$pecah = explode("-",$ubah);
		$tgl = $pecah[0];
		$bln = $pecah[1];
		$thn = $pecah[2];

		$nama = date("l", mktime(0,0,0,$bln,$tgl,$thn));
		$nama_hari = "";
		if($nama=="Sunday") {$nama_hari="Minggu";}
		else if($nama=="Monday") {$nama_hari="Senin";}
		else if($nama=="Tuesday") {$nama_hari="Selasa";}
		else if($nama=="Wednesday") {$nama_hari="Rabu";}
		else if($nama=="Thursday") {$nama_hari="Kamis";}
		else if($nama=="Friday") {$nama_hari="Jumat";}
		else if($nama=="Saturday") {$nama_hari="Sabtu";}
		return $nama_hari;
	}
	function nama_hari2($tanggal)
	{
		$ubah = gmdate($tanggal, time()+60*60*8);
		$pecah = explode("-",$ubah);
		$tgl = $pecah[2];
		$bln = $pecah[1];
		$thn = $pecah[0];

		$nama = date("l", mktime(0,0,0,$bln,$tgl,$thn));
		$nama_hari = "";
		if($nama=="Sunday") {$nama_hari="Minggu";}
		else if($nama=="Monday") {$nama_hari="Senin";}
		else if($nama=="Tuesday") {$nama_hari="Selasa";}
		else if($nama=="Wednesday") {$nama_hari="Rabu";}
		else if($nama=="Thursday") {$nama_hari="Kamis";}
		else if($nama=="Friday") {$nama_hari="Jumat";}
		else if($nama=="Saturday") {$nama_hari="Sabtu";}
		return $nama_hari;
	}
}

if ( ! function_exists('hitung_mundur'))
{
	function hitung_mundur($wkt)
	{
		$waktu=array(	365*24*60*60	=> "tahun",
						30*24*60*60		=> "bulan",
						7*24*60*60		=> "minggu",
						24*60*60		=> "hari",
						60*60			=> "jam",
						60				=> "menit",
						1				=> "detik");

		$hitung = strtotime(gmdate ("Y-m-d H:i:s", time () +60 * 60 * 8))-$wkt;
		$hasil = array();
		if($hitung<5)
		{
			$hasil = 'kurang dari 5 detik yang lalu';
		}
		else
		{
			$stop = 0;
			foreach($waktu as $periode => $satuan)
			{
				if($stop>=6 || ($stop>0 && $periode<60)) break;
				$bagi = floor($hitung/$periode);
				if($bagi > 0)
				{
					$hasil[] = $bagi.' '.$satuan;
					$hitung -= $bagi*$periode;
					$stop++;
				}
				else if($stop>0) $stop++;
			}
			$hasil=implode(' ',$hasil).' yang lalu';
		}
		return $hasil;
	}
}


if(!function_exists('time_ago'))
{
    function time_ago($datetime, $full = false)
    {
     $today = time();
        $createdday = strtotime($datetime);
        $datediff = abs($today - $createdday);
        $difftext = "";
        $years = floor($datediff / (365 * 60 * 60 * 24));
        $months = floor(($datediff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($datediff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        $hours = floor($datediff / 3600);
        $minutes = floor($datediff / 60);
        $seconds = floor($datediff);
        //year checker
        if ($difftext == "") {
            if ($years > 1)
                $difftext = $years . " years ";
            elseif ($years == 1)
                $difftext = $years . " year ";
        }
        //month checker
        if ($difftext == "") {
            if ($months > 1)
                $difftext = $months . " months ago";
            elseif ($months == 1)
                $difftext = $months . " month ago";
        }
        //month checker
        if ($difftext == "") {
            if ($days > 1)
                $difftext = $days . " days ago";
            elseif ($days == 1)
                $difftext = $days . " day ago";
        }
        //hour checker
        if ($difftext == "") {
            if ($hours > 1)
                $difftext = $hours . " hours ago";
            elseif ($hours == 1)
                $difftext = $hours . " hour ago";
        }
        //minutes checker
        if ($difftext == "") {
            if ($minutes > 1)
                $difftext = $minutes . " minutes ago";
            elseif ($minutes == 1)
                $difftext = $minutes . " minute ago";
        }
        //seconds checker
        if ($difftext == "") {
            if ($seconds > 1)
                $difftext = $seconds . " seconds ago";
            elseif ($seconds == 1)
                $difftext = $seconds . " second ago";
        }
        return $difftext;
    }
}
