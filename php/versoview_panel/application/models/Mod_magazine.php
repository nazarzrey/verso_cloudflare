<?php
class Mod_magazine extends CI_Model
{
  function HdrMagz($value, $column)
  {
    $sintak = "select * from magz_hdr_issue";
    if (empty($value)) {
      $sql = $sintak;
    } else {
      #if(is_numeric($value)){
      #  $sql = $sintak." where magz_id='$value'";
      #}else{
      $sql = $sintak . " where " . $column . "='" . $value . "'";
      #}
    }
    // debug($sql, "1");
    return each_query($this->db->query($sql));
  }
  function notMagzUsed($magz)
  {
    $sintak = "SELECT magz_fk_id FROM magazine_data_dtl WHERE issue_path LIKE '%$magz%'";
    return single_query($this->db->query($sintak));
  }
  function DtlMagz($value, $column)
  {
    $col = "          
          magz_dtl_id AS dtl_id,
          magz_fk_id AS hdr_id,
          issue_id AS id,
          issue_title AS ititle,
          issue_desc AS idesc,
          issue_category AS icat,
          issue_path AS ipath, 
          issue_style AS istyle,
          issue_pdf_file AS ipdf,
          issue_pdf_page AS ipage,
          issue_publish AS ipublish,
          issue_convert AS iconvert,
          IF(dynamic_url IS NULL,dynamic_url,CONCAT('P/',dynamic_url)) AS dynamic_url,
          target
          ";
    $sintak = "
        SELECT 
        $col
        FROM magazine_data_dtl a LEFT JOIN magazine_dynamic_url b ON a.magz_dtl_id=b.issue_fk_id";
    if (empty($value)) {
      $sql  = $sintak;
    } else {
      $sql  = $sintak . " where " . $column . "='" . $value . "'";
    }
    #echo $sql;
    $result =  single_query($this->db->query($sql));
    if (empty($result->dynamic_url) && $result->ipublish == "1") {
      $target = $result->ipath;
      $this->DynUrl($result->dtl_id, $target);
      $result2 =  single_query($this->db->query($sql));
      return $result2;
    } else {
      return $result;
    }
  }
  function HdrOV($value)
  {
    $sintak = "
      SELECT a.issue_id,b.magz_id,b.`magz_dtl_id`,MIN(b.magz_page) AS min_page,MAX(b.`magz_page`) AS max_page,content FROM magazine_data_dtl a LEFT JOIN api_openview_dtl b ON a.magz_dtl_id=b.`magz_dtl_id`
      WHERE issue_id='$value'
      GROUP BY content";
    #echo $sintak;
    $result =  each_query($this->db->query($sintak));
    return $result;
  }
  function DtlOV($value, $content)
  {
    $sintak = "SELECT a.issue_id,b.* FROM magazine_data_dtl a LEFT JOIN api_openview_dtl b  ON a.magz_dtl_id=b.magz_dtl_id WHERE issue_id='$value' AND content='$content'";
    $result =  each_query($this->db->query($sintak));
    return $result;
  }

  function DynUrl($issue_id, $target)
  {
    $this->db->where("issue_fk_id", $issue_id);
    $query  = $this->db->get("magazine_dynamic_url");
    if ($query->num_rows($query) == 0) {
      $urldtl = $this->dynKey();
      $this->db->insert(
        "magazine_dynamic_url",
        array(
          "issue_fk_id"       => $issue_id,
          "dynamic_url"       => $urldtl,
          "target"            => flip_url($target),
          "updrec_date" => tgl("full")
        )
      );
      if ($this->db->insert_id()) {
        return base_url("P/" . $urldtl);
      } else {
        return "0";
      }
    } else {
      return base_url("P/" . $query->result()[0]->dynamic_url);
    }
  }
  function CatDtl($cat, $book)
  {
    if ($book == "all" || $cat == "") {
      $sintak = "
          SELECT cat_id,cat_name,assets_path,assets_image1 
          FROM magazine_category a 
          LEFT JOIN magazine_assets b ON a.cat_id=b.assets_fk_id
          ORDER BY cat_order_number";
    } else {
      $sintak = "
          SELECT cat_id,cat_name,assets_path,assets_image1,
          IF(cat_id=$cat,1,2) as urut
          FROM magazine_category a 
          LEFT JOIN magazine_assets b ON a.cat_id=b.assets_fk_id
          ORDER BY urut ,cat_order_number";
    }
    return result_query($this->db->query($sintak));
  }
  function ProConv($id, $data)
  {
    if (strpos($id, '/') !== false) {
      $this->db->where('issue_path', $id);
    } else {
      $this->db->where('issue_id', $id);
    }
    $query = $this->db->update('magazine_data_dtl', $data);
  }
  function magazine_gallery($desc, $id)
  {
    $sql = "select REPLACE(CONCAT(gallery_path,'/',gallery_image1),'//','/') AS gambar from magazine_gallery where gallery_description='$desc'";
    if ($desc == "magazine") {
      $sintak = $sql . " and gallery_fk_id='$id'";
    } else {
      $sintak = $sql . " and gallery_id='$id'";
    }
    $syntax = "SELECT IFNULL((" . $sintak . "),'X') AS gambar";
    $hasil  = single_query($this->db->query($syntax));
    if ($hasil) {
      if (count((array)$hasil) != 0) {
        return $hasil->gambar;
      } else {
        return "0";
      }
    } else {
      return "0";
    }
  }

  function openview_gallery($desc, $id)
  {
    $sql = "select REPLACE(CONCAT(gallery_path,'/',gallery_image1),'//','/') AS gambar from magazine_gallery where gallery_description='$desc'";
    if ($desc == "magazine") {
      $sintak = $sql . " and gallery_fk_id='$id'";
    } else {
      $sintak = $sql . " and gallery_id='$id'";
    }
    $syntax = "SELECT IFNULL((" . $sintak . "),'X') AS gambar";
    #echo $sintak;
    $hasil  = single_query($this->db->query($sintak));
    #var_dump($hasil);
    #echo count((array)$hasil);
    if ($hasil) {
      if (count((array)$hasil) != 0) {
        return $hasil->gambar;
      } else {
        return "0";
      }
    } else {
      return "0";
    }
  }

  function userownopenview($uid)
  {
    $find = "AND magz_user_id=$uid";
    if (empty($uid)) {
      $find = "";
    }
    $sintak = "
      SELECT magz_user_id, 
      IFNULL(IF(IFNULL(issue_fk_cover,0)!=0,
        CONCAT('magazine,',issue_fk_cover,''),IF(IFNULL(magz_cover,0)!=0,
          CONCAT('cover,',magz_cover,''),CONCAT('magazine,',magz_cover,'')
          )
      ),'cover,0')
      AS gallery,
      magz_id,
      magz_url,
      magz_cat,
      magz_name,
      a.magz_desc,
      count(DISTINCT(b.magz_dtl_id)) AS ttl_issue,
      IFNULL(c.v_issue_ttl,'0') AS v_issue,
      a.magz_desc,
      IFNULL(magz_basecolor,'ver-clr1') AS basecolor
      FROM magazine_data_hdr a 
      LEFT JOIN magazine_data_dtl b ON a.magz_id=b.magz_fk_id      
      LEFT JOIN view_issue c ON a.magz_id=c.magz_dtl_id
      WHERE magz_user_id IS NOT NULL
      $find
      and issue_openview='1'
      GROUP BY a.magz_id
      ORDER BY magz_updrec_date DESC";
    #h3($sintak);
    return each_query($this->db->query($sintak));
  }
  function userownmagazine($uid)
  {
    $find = "AND magz_user_id=$uid";
    if (empty($uid)) {
      $find = "";
    }
    $sintak = "
      SELECT magz_user_id, 
      IFNULL(IF(IFNULL(issue_fk_cover,0)!=0,
        CONCAT('magazine,',issue_fk_cover,''),IF(IFNULL(magz_cover,0)!=0,
          CONCAT('cover,',magz_cover,''),CONCAT('magazine,',magz_cover,'')
          )
      ),'cover,0')
      AS gallery,
      magz_id,
      magz_url,
      magz_cat,
      magz_name,
      a.magz_desc,
      COUNT(DISTINCT(b.magz_dtl_id)) AS ttl_issue,
      IFNULL(c.v_issue_ttl,'0') AS v_issue,
      a.magz_desc,
      IFNULL(magz_basecolor,'ver-clr1') AS basecolor
      FROM magazine_data_hdr a 
      LEFT JOIN magazine_data_dtl b ON a.magz_id=b.magz_fk_id      
      LEFT JOIN view_issue c ON a.magz_id=c.magz_dtl_id
      WHERE magz_user_id IS NOT NULL
      $find
      GROUP BY a.magz_id
      ORDER BY magz_updrec_date DESC";
    return each_query($this->db->query($sintak));
  }
  function random_key()
  {
    $keys   = ranKey("");
    $this->db->where("magz_url", $keys);
    $query  = $this->db->get("magazine_data_hdr");
    if ($query->num_rows($query) == 0) {
      $url  = $keys;
    } else {
      $url  = tgl("sort");
    }
    return $url;
  }
  function dynKey()
  {
    $keys   = ranKey("4");
    $this->db->where("dynamic_url", $keys);
    $query  = $this->db->get("magazine_dynamic_url");
    if ($query->num_rows($query) == 0) {
      $url  = $keys;
    } else {
      $url  = $this->random_key();
    }
    return $url;
  }
  function UrlDyn($url)
  {
    $this->db->where("dynamic_url", $url);
    $query  = $this->db->get("magazine_dynamic_url");
    if ($query->num_rows($query) == 1) {
      $url  = $query->result()[0]->target;
    } else {
      $url  = "404";
    }
    return $url;
  }

  function new_hdr_magz($jdl, $kat, $uid, $des, $auto)
  {
    #echo $jdl." - ".$kat." - ".$uid." - ".$des." - ".$auto;
    $url    = $this->random_key();
    $newurl = "panel/" . $url;
    $table  = "magazine_data_hdr";
    $this->db->insert(
      $table,
      array(
        "magz_cat" => $kat,
        "magz_url" => $url,
        "magz_name" => strtoupper($jdl),
        "magz_desc" => $des,
        "magz_user_id" => $uid,
        "magz_updrec_date" => tgl("full"),
        "magz_href" => $newurl,
        "cover_auto" => $auto
      )
    );
    if ($this->db->insert_id()) {
      return $newurl;
    } else {
      return "0";
    }
  }

  function new_dtl_magz($category, $magz_id, $title, $desc, $pdf, $numpage, $img)
  {
    $urldtl = $this->random_key();
    $this->db->insert(
      "magazine_data_dtl",
      array(
        "magz_fk_id"        => $magz_id,
        "issue_id"          => $urldtl,
        "issue_title"       => $title,
        "issue_desc"        => $desc,
        // "issue_path"        =>strtolower($urldtl),
        "issue_category"    => $category,
        "issue_pdf_file"    => $pdf,
        "issue_pdf_page"    => $numpage,
        "issue_updrec_date" => tgl("full")
      )
    );
    if ($dtlid = $this->db->insert_id()) {
      $this->db->insert(
        "magazine_gallery",
        array(
          "gallery_fk_id" => $dtlid,
          "gallery_description" => 'magazine',
          "gallery_path" => "magazine/cover-issue/",
          "gallery_image1" => $img,
          "gallery_updrec_date" => tgl("full")
        )
      );
      $this->db->where(array('magz_id' => $magz_id, "cover_auto" => "1"));
      $this->db->update('magazine_data_hdr', array("issue_fk_cover" => $dtlid));
      return "1";
    } else {
      return "0";
    }
    /*$data = array(
        'title' => $title,
        'name' => $name,
        'date' => $date
      );

      $this->db->where('id', $id);
      $this->db->update('mytable', $data);*/
  }

  function title_cat($jdl, $cat)
  {
    #$this->db->where(array("magz_name"=>strtoupper($jdl),"magz_cat"=>$cat));
    $this->db->where("magz_name", strtoupper($jdl));
    $query = $this->db->get("magazine_data_hdr");
    return $query->num_rows($query);
  }
  function magz_pdf($id)
  {
    $this->db->where(array("magz_id" => $id));
    $query = $this->db->get("magazine_data_hdr");
    return $query->result_array()[0]["magz_pdf_file"];
  }
  function magz_update($id, $cover)
  {
    $this->db->query("update magazine_data_hdr set magz_process_c2flip=2 where magz_id=$id");
    $this->db->query("update magazine_gallery set gallery_image1='$cover' where gallery_fk_id=$id and gallery_description='cover'");
  }
  function magz_name($id)
  {
    $this->db->where(array("magz_id" => $id));
    $query = $this->db->get("magazine_data_hdr");
    if ($query->num_rows() == 0) {
      return null;
    } else {
      return strtolower($query->result_array()[0]["magz_name"]);
    }
  }

  function magz_title_cek($title)
  {
    $this->db->where("magz_name='$title'");
    $query = $this->db->get("magazine_data_hdr");
    if ($query->num_rows() == 0) {
      return "0";
    } else {
      return "1";
    }
  }

  function analytics($id)
  {
    $this->db->where("magz_dtl_fk_id", $id);
    $query = $this->db->get("magazine_analytics");
    if ($query->num_rows() == 0) {
      return "0";
    } else {
      return $query->result()[0]->magz_ga_id;
    }
  }

  function dtl_magz($category, $url, $urldtl, $title, $desc, $uid, $pdf)
  {
    $newurl = "magazine/" . strtolower($url);
    $result = "";
    $table = "magazine_data_hdr";
    $this->db->insert(
      $table,
      array(
        "magz_cat" => $category,
        "magz_url" => $url,
        "magz_name" => strtoupper($title),
        "magz_desc" => $desc,
        "magz_user_id" => $uid,
        "magz_pdf_file" => $pdf,
        "magz_updrec_date" => tgl("full"),
        "magz_href" => $newurl
      )
    );
    if ($this->db->insert_id()) {
      $this->db->query("update $table set magz_cover=magz_id where magz_cover is null");
      $this->db->where(array("magz_url" => $url, "magz_user_id" => $uid, "magz_name" => strtoupper($title)));
      $subquery = $this->db->get($table);
      if ($subquery->num_rows() == 1) {
        $result_array = $subquery->result_array();
        $hdr_id       = $result_array[0]["magz_id"];
        $this->db->insert(
          "magazine_data_dtl",
          array(
            "magz_fk_id"        => $hdr_id,
            "issue_id"         => $urldtl,
            "issue_title"       => ucwords(strtolower($title)),
            "issue_desc"        => $desc,
            "issue_category"    => $category,
            "issue_pdf_file"    => $pdf,
            "issue_updrec_date" => tgl("full")
          )
        );
        if ($this->db->insert_id()) {
          $this->db->insert(
            "magazine_gallery",
            array(
              "gallery_fk_id" => $result_array[0]["magz_id"],
              "gallery_description" => 'cover',
              "gallery_path" => "magazine/cover/",
              "gallery_updrec_date" => tgl("full")
            )
          );
          $this->db->insert_id();
        }
      }
      return "1";
    } else {
      return "2";
    }
    #1 = sukses, 2= gagal
  }
  /* function adm_DataMagazine($url){
    echo $sintak = "
      SELECT magz_url,magz_id,magz_fk_issue,magz_name,magz_desc,magz_price,REPLACE(CONCAT(b.gallery_path,'/',b.gallery_image1),'//','/') AS gambar,c.issue_title,
      c.issue_flipbook AS flipbook,
      magz_pdf_file,magz_process_c2flip
      FROM magazine_gallery b RIGHT JOIN magazine_data_hdr a ON a.magz_cover=b.magz_fk_id 
      LEFT JOIN magazine_data_dtl c ON a.magz_fk_issue=c.magz_dtl_id
      WHERE LOWER(magz_url='$url')  AND gallery_description='cover'";
      
      return result_query($this->db->query($sintak));
    }*/
  function issue_cover($id)
  {
    $sintak = "
      SELECT 
      IF(a.issue_fk_cover=b.magz_dtl_id,'yes','') AS use_cover,
      b.magz_dtl_id AS id,b.issue_title AS issue,CONCAT(c.gallery_path,c.gallery_image1) AS cover
      FROM magazine_data_hdr a 
      LEFT JOIN magazine_data_dtl b ON a.magz_id=b.magz_fk_id
      LEFT JOIN magazine_gallery c ON b.magz_dtl_id=c.gallery_fk_id
      WHERE magz_url='$id'";

    return each_query($this->db->query($sintak));
  }
  function adm_issueMagazine($id)
  {
    global $uid;
    if (is_numeric($id)) {
      $where = "WHERE magz_id='$id'";
    } else {
      $where = "WHERE b.magz_url='$id'";
    }
    $sintak = "
      SELECT 
      b.magz_id,a.magz_dtl_id,issue_id,issue_title,
      REPLACE(CONCAT(c.gallery_path,'/',c.gallery_image1),'//','/') AS gambar,
      issue_desc,issue_pdf_page AS pdf_page,issue_convert AS pdf_conv, issue_publish AS pdf_pub,
      issue_path,
      issue_date_process as date_pros,
      issue_pdf_file,
      d.cat_name AS cat,
      a.issue_desc as desk,
      e.record,f.dynamic_url as dyn
      FROM magazine_data_dtl a 
      LEFT JOIN magazine_data_hdr b ON b.magz_id=a.magz_fk_id
      LEFT JOIN magazine_gallery c ON c.gallery_fk_id=a.magz_dtl_id
      LEFT JOIN magazine_category d ON a.issue_category=d.cat_id
      LEFT JOIN issue_record e ON a.magz_dtl_id=e.id      
      LEFT JOIN magazine_dynamic_url f ON a.magz_dtl_id=f.issue_fk_id
      $where
      AND gallery_description='magazine'
      order by a.issue_updrec_date desc
      ";
    #AND magz_fk_id=(SELECT magz_id FROM magazine_data_hdr WHERE LOWER(magz_url='colours'))
    // popup("3",$sintak);
    if ($uid == 47) {
      echo $sintak;
    }
    return result_query($this->db->query($sintak));
  }

  function adm_issueOpenview($id)
  {
    if (is_numeric($id)) {
      $where = "WHERE magz_id='$id'";
    } else {
      $where = "WHERE b.magz_url='$id'";
    }
    $sintak = "
      SELECT 
      b.magz_id,a.magz_dtl_id,issue_id,issue_title,
      REPLACE(CONCAT(c.gallery_path,'/',c.gallery_image1),'//','/') AS gambar,
      issue_desc,issue_pdf_page AS pdf_page,issue_convert AS pdf_conv, issue_publish AS pdf_pub,
      issue_path,
      issue_date_process as date_pros,
      issue_pdf_file,
      d.cat_name AS cat,
      a.issue_desc as desk,
      e.record,f.dynamic_url as dyn
      FROM magazine_data_dtl a 
      LEFT JOIN magazine_data_hdr b ON b.magz_id=a.magz_fk_id
      LEFT JOIN magazine_gallery c ON c.gallery_fk_id=a.magz_dtl_id
      LEFT JOIN magazine_category d ON a.issue_category=d.cat_id
      LEFT JOIN issue_record e ON a.magz_dtl_id=e.id      
      LEFT JOIN magazine_dynamic_url f ON a.magz_dtl_id=f.issue_fk_id
      $where
      AND issue_openview='1'
      AND gallery_description='magazine'
      order by a.issue_updrec_date desc
      ";
    #AND magz_fk_id=(SELECT magz_id FROM magazine_data_hdr WHERE LOWER(magz_url='colours'))
    #echo $sintak;
    return result_query($this->db->query($sintak));
  }
  #get detail open magazine
  function adm_showDataMagazine($id)
  {
    $sintak = "
      SELECT 
      issue_id,
      issue_title,
      REPLACE(CONCAT(b.gallery_path,'/',b.gallery_image1),'//','/') AS gambar,
      issue_pdf_file
      FROM magazine_data_dtl a LEFT JOIN magazine_gallery b ON a.issue_cover=b.gallery_id
      WHERE a.magz_fk_id='$id' AND gallery_description='magazine'
      ORDER BY a.magz_dtl_id DESC limit 15";

    return result_query($this->db->query($sintak));
  }

  /**/
  function adm_subMagazine($idsub)
  {
    $url = "";
    $sintak = "        
      SELECT '$idsub' AS magz_id,issue_id,issue_title,REPLACE(CONCAT(b.gallery_path,'/',b.gallery_image1),'//','/') AS gambar,issue_desc,issue_flipbook as flipbook
      FROM magazine_data_dtl a LEFT JOIN magazine_gallery b ON a.issue_cover=b.gallery_id
      WHERE issue_id='$url' AND b.gallery_fk_id='$idsub' AND gallery_description='magazine'";

    return single_query($this->db->query($sintak));
  }
  /* api danang */

  function adm_issueMagazine_popular()
  {
    $sintak = "SELECT * FROM magazine_popular";
    return result_query($this->db->query($sintak));
  }

  function adm_issueMagazine_sample()
  {
    $sintak = "SELECT title,image as url,href,'styles.slide1' as css FROM magazine_popular";
    return result_query($this->db->query($sintak));
  }

  function adm_issueMagazine_sample2()
  {
    $sintak = "SELECT title,image as url,href,'styles.slide1' as css FROM magazine_popular";
    return result_query($this->db->query($sintak));
  }

  function adm_issueMagazine_featured()
  {
    $sintak = "SELECT * FROM magazine_featured";
    return result_query($this->db->query($sintak));
  }

  function adm_issueMagazine_arrival()
  {
    $sintak = "SELECT * FROM magazine_arrival";
    return result_query($this->db->query($sintak));
  }
  function adm_issueMagazine_app($id = '0')
  {
    $where = '';
    if ($id != '0')
      if (is_numeric($id)) {
        $where = " AND magz_id='$id'";
      } else {
        $where = " AND b.magz_url='$id'";
      }
    $sintak = "
			SELECT 
			b.magz_id,a.magz_dtl_id,issue_id,issue_title,
			REPLACE(CONCAT(c.gallery_path,'/',c.gallery_image1),'//','/') AS gambar,
			issue_desc,issue_pdf_page AS pdf_page,issue_convert AS pdf_conv, issue_publish AS pdf_pub,
			issue_path,
			issue_date_process as date_pros,
			issue_pdf_file,
			d.cat_name AS cat,
			a.issue_desc as desk,
			e.record,f.dynamic_url as dyn,
      a.issue_pdf_page as page
			FROM magazine_data_dtl a 
			LEFT JOIN magazine_data_hdr b ON b.magz_id=a.magz_fk_id
			LEFT JOIN magazine_gallery c ON c.gallery_fk_id=a.magz_dtl_id
			LEFT JOIN magazine_category d ON a.issue_category=d.cat_id
			LEFT JOIN issue_record e ON a.magz_dtl_id=e.id      
			LEFT JOIN magazine_dynamic_url f ON a.magz_dtl_id=f.issue_fk_id
			AND gallery_description='magazine'
			AND issue_path IS NOT NULL
			WHERE a.issue_publish = 1
			$where
			order by a.issue_updrec_date desc
			";
    #AND magz_fk_id=(SELECT magz_id FROM magazine_data_hdr WHERE LOWER(magz_url='colours'))
    return result_query($this->db->query($sintak));
  }

  function adm_issueMagazine_cat($id = '0')
  {
    $sintak = "
    SELECT 
    b.magz_id,a.magz_dtl_id,issue_id,issue_title,
    REPLACE(CONCAT(c.gallery_path,'/',c.gallery_image1),'//','/') AS gambar,
    issue_desc,issue_pdf_page AS pdf_page,issue_convert AS pdf_conv, issue_publish AS pdf_pub,
    issue_path,
    issue_date_process as date_pros,
    issue_pdf_file,
    d.cat_name AS cat,
    a.issue_desc as desk,
    e.record,f.dynamic_url as dyn
    FROM magazine_data_dtl a 
    LEFT JOIN magazine_data_hdr b ON b.magz_id=a.magz_fk_id
    LEFT JOIN magazine_gallery c ON c.gallery_fk_id=a.magz_dtl_id
    LEFT JOIN magazine_category d ON a.issue_category=d.cat_id
    LEFT JOIN issue_record e ON a.magz_dtl_id=e.id      
    LEFT JOIN magazine_dynamic_url f ON a.magz_dtl_id=f.issue_fk_id
    AND gallery_description='magazine'
    AND issue_path IS NOT NULL
    WHERE a.issue_publish = 1
    AND magz_cat='$id'
    order by a.issue_updrec_date desc
    ";
    #AND magz_fk_id=(SELECT magz_id FROM magazine_data_hdr WHERE LOWER(magz_url='colours'))
    return result_query($this->db->query($sintak));
  }

  function userownmagazine_app($uid)
  {
    $find = "AND magz_user_id=$uid";
    if (empty($uid)) {
      $find = "";
    }
    $sintak = "
      SELECT magz_user_id, 
      IFNULL(IF(IFNULL(issue_fk_cover,0)!=0,
        CONCAT('magazine,',issue_fk_cover,''),IF(IFNULL(magz_cover,0)!=0,
          CONCAT('cover,',magz_cover,''),CONCAT('magazine,',magz_cover,'')
          )
      ),'cover,0')
      AS gallery,
      magz_id,
      magz_url,
      magz_cat,
      magz_name,
      a.magz_desc,
      COUNT(DISTINCT(b.magz_dtl_id)) AS ttl_issue,
      IFNULL(c.v_issue_ttl,'0') AS v_issue,
      a.magz_desc,
      IFNULL(magz_basecolor,'ver-clr1') AS basecolor
      FROM magazine_data_hdr a 
      LEFT JOIN magazine_data_dtl b ON a.magz_id=b.magz_fk_id      
      LEFT JOIN view_issue c ON a.magz_id=c.magz_dtl_id
      WHERE magz_user_id IS NOT NULL
      AND b.issue_publish=1
      $find
      GROUP BY a.magz_id
      ORDER BY magz_updrec_date DESC";
    return each_query($this->db->query($sintak));
  }

  function addtoLibrary($user, $magazine)
  {
    $query = $this->db->where('user_email', $user)->get("magazine_users_hdr");
    $user_id = $query->num_rows() > 0 ? $query->row()->user_id : '';
    if ($user_id != '') {
      $data = $this->db->insert(
        "library",
        array(
          "magz_dtl_id" => $magazine,
          "user_id" => $user_id,
        )
      );
      return $data;
    }
  }

  function addtoSuscribe($user, $magazine)
  {
    $query = $this->db->where('user_email', $user)->get("magazine_users_hdr");
    echo $user_id = $query->num_rows() > 0 ? $query->row()->user_id : '';
    if ($user_id != '') {
      $data = $this->db->insert(
        "suscribe",
        array(
          "magz_id" => $magazine,
          "user_id" => $user_id,
        )
      );
      return $data;
    }
  }

  function getlibrary($user)
  {
    $query = $this->db->where('user_email', $user)->get("magazine_users_hdr");
    $user_id = $query->num_rows() > 0 ? $query->row()->user_id : '';
    if ($user_id != '') {
      $query = $this->db
        ->select('magazine_data_dtl.issue_path AS href, CONCAT(\'' . base_url() . '\', magazine_gallery.gallery_path, magazine_gallery.gallery_image1) AS image, magazine_data_dtl.issue_title AS title, magazine_data_dtl.issue_desc AS description')
        ->where('library.user_id', $user_id)
        ->from('library')
        ->join('magazine_data_dtl', 'library.magz_dtl_id = magazine_data_dtl.magz_dtl_id')
        ->join('magazine_data_hdr', 'magazine_data_dtl.magz_fk_id = magazine_data_hdr.magz_id')
        ->join('magazine_gallery', 'magazine_data_dtl.magz_dtl_id = magazine_gallery.gallery_fk_id')
        ->get()
        ->result();
      echo json_encode($query);
    }
  }

  function getsuscribe($user)
  {
    $query = $this->db->where('user_email', $user)->get("magazine_users_hdr");
    $user_id = $query->num_rows() > 0 ? $query->row()->user_id : '';
    if ($user_id != '') {
      $query = $this->db
        ->select('magazine_data_dtl.issue_path AS href, CONCAT(\'' . base_url() . '\', magazine_gallery.gallery_path, magazine_gallery.gallery_image1) AS image')
        ->where('suscribe.user_id', $user_id)
        ->from('suscribe')
        ->join('magazine_data_hdr', 'suscribe.magz_id = magazine_data_hdr.magz_id')
        ->join('magazine_data_dtl', 'magazine_data_hdr.magz_id = magazine_data_dtl.magz_fk_id')
        ->join('magazine_gallery', 'magazine_data_dtl.magz_dtl_id = magazine_gallery.gallery_fk_id')
        ->get()
        ->result();
      echo json_encode($query);
    }
  }

  function getsearch($search)
  {
    $query = $this->db
      ->select('magazine_data_hdr.magz_url AS href, magazine_data_hdr.magz_name, magazine_data_hdr.magz_desc, CONCAT(\'' . base_url() . '\', magazine_gallery.gallery_path, magazine_gallery.gallery_image1) AS image')
      ->like('magazine_data_hdr.magz_name', $search)
      ->from('magazine_data_hdr')
      ->join('magazine_data_dtl', 'magazine_data_hdr.magz_id = magazine_data_dtl.magz_fk_id')
      ->join('magazine_gallery', 'magazine_data_dtl.magz_dtl_id = magazine_gallery.gallery_fk_id')
      ->get()
      ->result();
    echo json_encode($query);
  }

  function setview($user)
  {
    $data = $this->db->insert(
      "magazine_view",
      array(
        "magz_dtl_id" => '1',
        "user_id" => '2',
      )
    );
  }

  function userownmagazine_in($cat)
  {
    $sintak = "
      SELECT magz_user_id, 
      IFNULL(IF(IFNULL(issue_fk_cover,0)!=0,
        CONCAT('magazine,',issue_fk_cover,''),IF(IFNULL(magz_cover,0)!=0,
          CONCAT('cover,',magz_cover,''),CONCAT('magazine,',magz_cover,'')
          )
      ),'cover,0')
      AS gallery,
      magz_id,
      magz_url,
      magz_cat,
      magz_name,
      a.magz_desc,
      COUNT(DISTINCT(b.magz_dtl_id)) AS ttl_issue,
      IFNULL(c.v_issue_ttl,'0') AS v_issue,
      a.magz_desc,
      IFNULL(magz_basecolor,'ver-clr1') AS basecolor
      FROM magazine_data_hdr a 
      LEFT JOIN magazine_data_dtl b ON a.magz_id=b.magz_fk_id      
      LEFT JOIN view_issue c ON a.magz_id=c.magz_dtl_id
      WHERE magz_user_id IS NOT NULL
      AND b.issue_publish=1
      -- AND magz_cat IN ($cat)
      GROUP BY a.magz_id
      ORDER BY magz_updrec_date DESC";
    return each_query($this->db->query($sintak));
  }

  function issueMagazinedetil($id = '0')
  {
    if ($id != '0')
      $sintak = "
          SELECT 
            issue_id, issue_desc, issue_title, issue_pdf_page, issue_path
          FROM magazine_data_dtl
          WHERE issue_id='$id'          
        ";
    #AND magz_fk_id=(SELECT magz_id FROM magazine_data_hdr WHERE LOWER(magz_url='colours'))
    return result_query($this->db->query($sintak));
  }

  function openView()
  {
    $sintak = "
        SELECT magz_page, content FROM openview_data_dtl WHERE magz_dtl_fk_id = '38'
      ";
    return result_query($this->db->query($sintak));
  }

  function baca()
  {
    $sintak = "
          SELECT 
            *
          FROM magazine_baca
        ";
    return result_query($this->db->query($sintak));
  }

  function adm_issueMagazine_anantara($id = '0')
  {
    $sintak = "
      SELECT 
      b.magz_id,a.magz_dtl_id,issue_id,issue_title,
      REPLACE(CONCAT(c.gallery_path,'/',c.gallery_image1),'//','/') AS gambar,
      issue_desc,issue_pdf_page AS pdf_page,issue_convert AS pdf_conv, issue_publish AS pdf_pub,
      issue_path,
      issue_date_process as date_pros,
      issue_pdf_file,
      d.cat_name AS cat,
      a.issue_desc as desk,
      e.record,f.dynamic_url as dyn,
      a.issue_pdf_page as page
      FROM magazine_data_dtl a 
      LEFT JOIN magazine_data_hdr b ON b.magz_id=a.magz_fk_id
      LEFT JOIN magazine_gallery c ON c.gallery_fk_id=a.magz_dtl_id
      LEFT JOIN magazine_category d ON a.issue_category=d.cat_id
      LEFT JOIN issue_record e ON a.magz_dtl_id=e.id      
      LEFT JOIN magazine_dynamic_url f ON a.magz_dtl_id=f.issue_fk_id
      AND gallery_description='magazine'
      AND issue_path IS NOT NULL
      WHERE a.issue_publish = 1
      AND a.magz_fk_id = 41
      order by a.issue_updrec_date desc
      ";
    #AND magz_fk_id=(SELECT magz_id FROM magazine_data_hdr WHERE LOWER(magz_url='colours'))
    return result_query($this->db->query($sintak));
  }
}
