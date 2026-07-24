<?php
	class Mod_backend_magazine extends CI_Model {
    function magazine_gallery($desc,$id){
      $sql = "select REPLACE(CONCAT(gallery_path,'/',gallery_image1),'//','/') AS gambar from magazine_gallery where gallery_description='$desc'";
      if($desc=="cover"){
        $sintak = $sql." and gallery_fk_id='$id'";
      }else{
        $sintak = $sql." and gallery_id='$id'";
      }
      //die($sintak);
      return single_query($this->db->query($sintak));
    }

    function userownmagazine($uid){
      $sintak = "
      SELECT magz_user_id, 
      IF(IFNULL(magz_fk_issue,0)!=0,
        CONCAT('magazine,',magz_fk_issue,''),IF(IFNULL(magz_cover,0)!=0,
          CONCAT('cover,',magz_cover,''),CONCAT('magazine,',magz_cover,'')
          )
      )
      AS gallery,magz_id,magz_url,magz_cat,magz_name,COUNT(DISTINCT(b.magz_dtl_id)) AS ttl_issue      
      FROM magazine_data_hdr a LEFT JOIN magazine_data_dtl b ON a.magz_id=b.magz_fk_id
      WHERE magz_user_id IS NOT NULL 
      AND magz_user_id=$uid GROUP BY magz_id
      ORDER BY magz_updrec_date DESC";
      /* $sintak = "
      SELECT b.magz_id,b.magz_fk_issue,b.magz_url,b.magz_cat,b.magz_name,
      IF(IFNULL(b.magz_fk_issue,0)>0,
        (SELECT REPLACE(CONCAT(gallery_path,'/',gallery_image1),'//','/') FROM magazine_gallery WHERE gallery_description='magazine' AND gallery_id = (SELECT issue_cover FROM magazine_data_dtl WHERE magz_dtl_id=b.magz_fk_issue)),
        REPLACE(CONCAT(c.gallery_path,'/',c.gallery_image1),'//','/')
      ) AS gambar,REPLACE(CONCAT(c.gallery_path,'/',c.gallery_image1),'//','/') AS cover, b.magz_price
      ,COUNT(magz_id) as ttl_issu
      FROM magazine_cover a right JOIN magazine_data_hdr b ON a.cover_magz_id=b.magz_id
      LEFT JOIN magazine_gallery c ON b.magz_cover=c.gallery_fk_id
      LEFT JOIN magazine_data_dtl d ON b.magz_id = d.magz_fk_id
      WHERE c.gallery_description='cover' 
      AND magz_user_id=$uid
      GROUP BY magz_id
      ORDER BY a.cover_order"; */
     /* $sintak = "
      SELECT b.magz_id,IFNULL(b.magz_fk_issue,0) AS magz_fk_issue,
      b.magz_url,b.magz_cat,b.magz_name,
        IF(IFNULL(b.magz_fk_issue,0)>0,
        (SELECT REPLACE(CONCAT(gallery_path,'/',gallery_image1),'//','/') FROM magazine_gallery WHERE gallery_description='magazine' AND gallery_id = (SELECT issue_cover FROM magazine_data_dtl WHERE magz_dtl_id=b.magz_fk_issue)),
        REPLACE(CONCAT(c.gallery_path,'/',c.gallery_image1),'//','/')
      ) AS gambar,
      '0'  as ttl_issu      
      FROM magazine_data_hdr b LEFT JOIN magazine_data_dtl a
      ON b.magz_id=a.magz_fk_id 
      LEFT JOIN magazine_gallery c ON b.magz_cover=c.gallery_fk_id
      WHERE magz_user_id=$uid 
      GROUP BY b.magz_id
      ORDER BY magz_name";*/	  
      /*$sintak = "
      SELECT b.magz_id,IFNULL(b.magz_fk_issue,0) AS magz_fk_issue,
      b.magz_url,b.magz_cat,b.magz_name,REPLACE(CONCAT(c.gallery_path,'/',c.gallery_image1),'//','/') AS gambar,'0'  as ttl_issu      
      FROM magazine_data_hdr b LEFT JOIN magazine_data_dtl a
      ON b.magz_id=a.magz_fk_id 
      LEFT JOIN magazine_gallery c ON b.magz_cover=c.gallery_id
      WHERE magz_user_id=1
      GROUP BY b.magz_id
      ORDER BY magz_name";*/

      return result_query($this->db->query($sintak));
    }

    function adm_DataMagazine($url){
    $sintak = "
      SELECT magz_url,magz_id,magz_fk_issue,magz_name,magz_desc,magz_price,REPLACE(CONCAT(b.gallery_path,'/',b.gallery_image1),'//','/') AS gambar,c.issue_title,
      c.issue_flipbook AS flipbook,
      magz_pdf_file,magz_process_c2flip
      FROM magazine_gallery b RIGHT JOIN magazine_data_hdr a ON a.magz_cover=b.gallery_fk_id 
      LEFT JOIN magazine_data_dtl c ON a.magz_fk_issue=c.magz_dtl_id
      WHERE LOWER(magz_url='$url')  AND gallery_description='cover'";
      
      return result_query($this->db->query($sintak));
    }

    function adm_issueMagazine($id_issue) {
      $sintak = "SELECT c.magz_id,a.magz_dtl_id,magz_url AS base_url,issue_url,issue_title,REPLACE(CONCAT(b.gallery_path,'/',b.gallery_image1),'//','/')
      AS gambar,issue_desc,issue_flipbook AS flipbook
      FROM magazine_data_dtl a 
      LEFT JOIN magazine_gallery b ON a.issue_cover=b.gallery_id
      LEFT JOIN magazine_data_hdr c ON b.gallery_fk_id=c.magz_id
      WHERE magz_dtl_id='$id_issue' AND gallery_description='magazine'";
      #AND magz_fk_id=(SELECT magz_id FROM magazine_data_hdr WHERE LOWER(magz_url='colours'))

      return result_query($this->db->query($sintak));
    }
    #get detail open magazine
    function adm_showDataMagazine($url){
      $sintak = "
      SELECT '$url' AS base_url,issue_url,issue_title,REPLACE(CONCAT(b.gallery_path,'/',b.gallery_image1),'//','/') AS gambar,
      issue_pdf_file
      FROM magazine_data_dtl a LEFT JOIN magazine_gallery b ON a.issue_cover=b.gallery_id
      WHERE magz_fk_id=(SELECT magz_id FROM magazine_data_hdr WHERE LOWER(magz_url='$url')) AND gallery_description='magazine'
      ORDER BY magz_dtl_id DESC limit 15";
      
      return result_query($this->db->query($sintak));
    }

    /**/
    function adm_subMagazine($base,$url){
     $sintak = "        
      SELECT (SELECT magz_id FROM magazine_data_hdr c WHERE LOWER(magz_url='colours')) AS magz_id,'$base' as base_url,issue_url,issue_title,REPLACE(CONCAT(b.gallery_path,'/',b.gallery_image1),'//','/') AS gambar,issue_desc,issue_flipbook as flipbook
      FROM magazine_data_dtl a LEFT JOIN magazine_gallery b ON a.issue_cover=b.gallery_id
      WHERE issue_url='$url' AND magz_fk_id=(SELECT magz_id FROM magazine_data_hdr WHERE LOWER(magz_url='$base')) AND gallery_description='magazine'";

      return single_query($this->db->query($sintak));
    }
	}
?>