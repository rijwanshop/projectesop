<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function autono_sop($no) {
		if ($no == '') {
			$no_urut = '00001';
		
		} else {
			$jum = $no;
			$jum++;
			if($jum <= 9) {
				$no_urut = '0000' . $jum;
			} elseif ($jum <= 99) {
				$no_urut = '000' . $jum;
			} elseif ($jum <= 999) {
				$no_urut = '00' . $jum;
			} elseif ($jum <= 9999) {
				$no_urut = '0' . $jum;
			} elseif ($jum <= 99999) {
				$no_urut = $jum; 	
			} else {
				die("Nomor urut melebih batas");		
			}
		}
		return $no_urut;
}
