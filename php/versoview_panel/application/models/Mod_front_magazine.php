<?php
class Mod_front_magazine extends CI_Model {

    /*home*/

    function getDataMagazine($url){
    /*$sintak = "
    SELECT 
    magz_url_name,
    magz_id,magz_fk_id,magz_name,magz_desc,magz_price,REPLACE(CONCAT(b.gallery_path,'/',b.gallery_image1),'//','/') AS gambar,c.issue_title,
    -- c.issue_flipbook AS flipbook,
    magz_pdf_file,magz_process_c2flip
    FROM magazine_gallery b 
    RIGHT JOIN magazine_data_hdr a ON a.magz_cover=b.gallery_fk_id 
    LEFT JOIN magazine_data_dtl c ON a.magz_id=c.magz_dtl_id
    WHERE LOWER(magz_url_name='$url')";*/

    $sintak = "
      SELECT 
      magz_url_name,
      magz_id,magz_fk_id,
      magz_dtl_id,
      magz_name,magz_desc,magz_price,
      issue_path,
      IF(
        IFNULL(magz_cover,'')!='',
              (SELECT REPLACE(CONCAT(b.gallery_path,'/',b.gallery_image1),'//','/') FROM magazine_gallery b  WHERE b.gallery_fk_id=magz_cover),
              IF(IFNULL(issue_fk_cover,'')!='',
        (SELECT REPLACE(CONCAT(b.gallery_path,'/',b.gallery_image1),'//','/') FROM magazine_gallery b  WHERE b.gallery_fk_id=issue_fk_cover),NULL
        )
      ) AS gambar,
      (SELECT COUNT(magz_dtl_id) FROM magazine_data_dtl WHERE magz_fk_id=magz_id AND issue_publish=1) AS ttl_issue,
      issue_title,
      issue_fk_cover,
      magz_pdf_file,magz_process_c2flip,
      -- COUNT(magz_fk_id) AS ttl_issue,
      CONCAT('P/',dynamic_url) AS flipbook
      FROM magazine_data_hdr a 
      LEFT JOIN magazine_data_dtl b ON a.magz_id=b.magz_fk_id
      LEFT JOIN magazine_dynamic_url c ON b.magz_dtl_id=c.issue_fk_id
      WHERE LOWER(magz_url_name='$url')      
      AND issue_publish=1
      ORDER BY issue_updrec_date DESC 
      LIMIT 1";
      return single_query($this->db->query($sintak));
    }

    function issueMagazine($id_issue) {
      $sintak = "
      SELECT c.magz_id,a.magz_dtl_id,magz_url AS base_url,issue_id,issue_title,REPLACE(CONCAT(b.gallery_path,'/',b.gallery_image1),'//','/')
      AS gambar,issue_desc,issue_path AS flipbook
      FROM magazine_data_dtl a 
      LEFT JOIN magazine_gallery b ON a.magz_dtl_id=b.gallery_id
      LEFT JOIN magazine_data_hdr c ON b.gallery_fk_id=c.magz_id
      WHERE magz_dtl_id='$id_issue' AND gallery_description='magazine'";
      #AND magz_fk_id=(SELECT magz_id FROM magazine_data_hdr WHERE LOWER(magz_url='colours'))

      return single_query($this->db->query($sintak));
    }
    #get detail open magazine
    function showDataMagazine($url){
      $sintak = "
      SELECT '$url' AS base_url,issue_id,issue_title,REPLACE(CONCAT(b.gallery_path,'/',b.gallery_image1),'//','/') AS gambar,
      issue_pdf_file
      FROM magazine_data_dtl a LEFT JOIN magazine_gallery b ON a.magz_dtl_id=b.gallery_id
      WHERE magz_fk_id=(SELECT magz_id FROM magazine_data_hdr WHERE LOWER(magz_url_name='$url')) AND gallery_description='magazine'
      ORDER BY magz_dtl_id DESC limit 15";
      
      return result_query($this->db->query($sintak));
    }

    /**/
    function subMagazine($base,$url){
     $sintak = "        
      SELECT '$base' as base_url,issue_id,issue_title,REPLACE(CONCAT(b.gallery_path,'/',b.gallery_image1),'//','/') AS gambar,issue_desc,issue_path as flipbook
      FROM magazine_data_dtl a LEFT JOIN magazine_gallery b ON a.magz_dtl_id=b.gallery_id
      WHERE issue_id='$url' AND magz_fk_id=(SELECT magz_id FROM magazine_data_hdr WHERE LOWER(magz_url='$base')) AND gallery_description='magazine'";

      return single_query($this->db->query($sintak));
    }

    /**/
}