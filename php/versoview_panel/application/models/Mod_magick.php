<?php
class Mod_magick extends CI_Model
{
  // count
  function convert_iss($DtlMgz, $value, $convert, $page)
  {
    $file       = 'book.zip';
    $imagename  = $DtlMgz->ititle;
    $pdfname    = $DtlMgz->ipdf;
    if ($convert == "convert") {
      $flippath   = date("ymd") . "/" . strtolower($DtlMgz->id);
    } else {
      $flippath   = $DtlMgz->ipath;
    }
    $numpage    = $DtlMgz->ipage;

    $directory  = sys("path");
    #var_dump($directory);
    $foldername = "pageturner/" . $flippath;
    $path       = $directory . $foldername . "/";
    $saveAsPath = $path . "files/";
    $filepdf    = $directory . "pdf_temp/" . $pdfname;
    if (empty($pdfname) || !file_exists($filepdf)) {
      echo "temporary pdf is nolonger exists, please reupload";
      return;
    } else {
      $zip = new ZipArchive;
      $res = $zip->open($file);
      if ($res === TRUE) {
        $zip->extractTo($path);
        $zip->close();
      }
      if (!is_dir($path)) {
        echo "folder not exists";
        return;
      }
      if ($numpage == 0) {
        $num_pages = numPdf($filepdf);
      } else {
        $num_pages = $numpage;
      }
      $a = $num_pages;
      if ($this->ttl_pros_conv()->ttl_process < 3) {
        $b = 2;
      } else {
        if ($convert == "convert") {
          $b = 2;
        } else {
          $b = 1;
        }
      }
      $c = round($a / $b);
      $x = 0;
      if ($page == "") {
        for ($i = 1; $i <= $b; $i++) {
          if ($i == $b) {
            $page =  $x . "," . $a;
          } else {
            $page = $x . "," . $i * $c;
          }
          $x = $i * $c;
          #echo $saveAsPath.".".$filepdf.".".$page;
          #echo $page;
          #$this->magick($saveAsPath,$filepdf,$page);   
          $this->magick($saveAsPath, $filepdf, $page);
          #$magick = "php ".FCPATH."magick.php path=$path pdf=$filepdf page=$page ";
        }
      } else {
        $this->magick($saveAsPath, $filepdf, $page);
      }
      $ga  = $this->Mod_magazine->analytics($value);
      if ($convert == "convert") {
        $this->Mod_magazine->ProConv($value, array("issue_convert" => "1", "issue_path" => $flippath));
      } else {
        $this->Mod_magazine->ProConv($value, array("issue_convert" => "1"));
      }
      if ($convert == "convert") {
        echo "process_" . str_replace("/", "_", $flippath) . "_" . $num_pages;
      }
    }
  }
  function count_img($path = '', $num = '', $dir = '')
  {
    $files = glob($dir . '*.jpg');
    if ($files !== false) {
      $filecount = count($files);
    } else {
      $filecount = 0;
    }
    # echo $filecount.$dir;
    if (is_numeric($num)) {
      $persen = $filecount / $num * 100;
      if ($persen < 5) {
        $percent = 1;
      } else {
        $percent = $persen;
      }
      if ($filecount == $num) {
        $this->Mod_magazine->ProConv($path, array("issue_convert" => "2",));
        $DtlMgz  = $this->Mod_magazine->DtlMagz($path, "issue_path");
        return json_encode(array($percent, $DtlMgz->dynamic_url));
      } else {
        return json_encode(array($percent, "0"));
      }
    } else {
      return $filecount;
    }
  }
  // convert pdf 
  function magick($path, $pdf, $page)
  {
    $magick = "php " . FCPATH . "magick.php path=$path pdf=$pdf page=$page";
    #$magick = "php ".FCPATH."magick.php path=190716/NMiDNOBUdh pdf=190716/19071608262027165.pdf page=0,2";
    if (DIRECTORY_SEPARATOR == '\\') {
      pclose(popen("start /B " . $magick, "r"));
    } else {
      exec($magick . " > /dev/null &");
    }
  }
  function ttl_pros_conv()
  {
    $sintak = "
    SELECT COUNT(1) AS ttl_process FROM magazine_data_dtl 
     WHERE issue_convert = '1'
     AND TIMESTAMPDIFF(MINUTE,issue_date_process,NOW())>120
     AND issue_convert='1'";
    return single_query($this->db->query($sintak));
  }
}
