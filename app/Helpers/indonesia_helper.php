<?php

if (!function_exists('Tgl_Indo')) {
  function Tgl_Indo($date)
  {
    //date_default_timezone_set('Asia/Jakarta');
    // array hari dan bulan
    $Hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
    $Bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

    // pemisahan tahun, bulan, hari, dan waktu
    $tahun = substr($date, 0, 4);
    $bulan = substr($date, 5, 2);
    $tgl = substr($date, 8, 2);
    $waktu = substr($date, 11, 5);
    $hari = date("w", strtotime($date));
    $result = $tgl . " " . $Bulan[(int) $bulan - 1] . " " . $tahun;
    //$result = $Hari[$hari].", ".$tgl." ".$Bulan[(int)$bulan-1]." ".$tahun." ".$waktu;

    return $result;
  }
}

if (!function_exists('TglWkt_Indo')) {
  function TglWkt_Indo($date)
  {
    //date_default_timezone_set('Asia/Jakarta');
    // array hari dan bulan
    $Hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
    $Bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

    // pemisahan tahun, bulan, hari, dan waktu
    $tahun = substr($date, 0, 4);
    $bulan = substr($date, 5, 2);
    $tgl = substr($date, 8, 2);
    $waktu = substr($date, 11, 5);
    $hari = date("w", strtotime($date));
    $result = $tgl . " " . $Bulan[(int) $bulan - 1] . " " . $tahun . " " . $waktu;
    //$result = $Hari[$hari].", ".$tgl." ".$Bulan[(int)$bulan-1]." ".$tahun." ".$waktu;

    return $result;
  }
}

if (!function_exists('Uang_Indo')) {
  function Uang_Indo($x)
  {
    $abil = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
    if ($x < 12)
      return " " . $abil[$x];
    elseif ($x < 20)
      return Uang_Indo($x - 10) . " Belas";
    elseif ($x < 100)
      return Uang_Indo($x / 10) . " Puluh" . Uang_Indo($x % 10);
    elseif ($x < 200)
      return " Seratus" . Uang_Indo($x - 100);
    elseif ($x < 1000)
      return Uang_Indo($x / 100) . " Ratus" . Uang_Indo($x % 100);
    elseif ($x < 2000)
      return " Seribu" . Uang_Indo($x - 1000);
    elseif ($x < 1000000)
      return Uang_Indo($x / 1000) . " Ribu" . Uang_Indo($x % 1000);
    elseif ($x < 1000000000)
      return Uang_Indo($x / 1000000) . " Juta" . Uang_Indo($x % 1000000);
  }
}

?>