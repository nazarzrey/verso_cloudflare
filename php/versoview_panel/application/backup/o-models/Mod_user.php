<?php
	class Mod_user extends CI_Model {
/*
       	function getWalikelas() {
	        $query = $this->db->query('select * from tkelas a,tuser b where a.wali_kelas=b.username order by kelas asc');
	        return $query;
     	}
*/		
		/*function __construct(argument)
		{
			# code...
		}*/

    #header category
    function userownmagazine($uid){
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
	  
      $sintak = "
      SELECT b.magz_id,IFNULL(b.magz_fk_issue,0) AS magz_fk_issue,
      b.magz_url,b.magz_cat,b.magz_name,REPLACE(CONCAT(c.gallery_path,'/',c.gallery_image1),'//','/') AS gambar,'0'  as ttl_issu      
      FROM magazine_data_hdr b LEFT JOIN magazine_data_dtl a
      ON b.magz_id=a.magz_fk_id 
      LEFT JOIN magazine_gallery c ON b.magz_cover=c.gallery_id
      WHERE magz_user_id=1
      GROUP BY b.magz_id
      ORDER BY magz_name";
      return result_query($this->db->query($sintak));

    }
		function getCategory(){
			$this->db->select("cat_url,cat_name");
			return result_query($this->db->get("magazine_category"));
    }
    #home list category
    function getDataCategory(){
  		$sintak = "SELECT cat_id,cat_name,assets_path,assets_image1 FROM magazine_category a LEFT JOIN magazine_assets b ON a.cat_id=b.assets_fk_id ORDER BY cat_order_number";
  		
        return result_query($this->db->query($sintak));	      
  	}
    #home list cover
  	function getDataCover(){
      /*$sintak = "SELECT b.magz_id,b.magz_fk_issue,b.magz_url,b.magz_cat,b.magz_name,CONCAT(c.gallery_path,c.gallery_image1) as gambar,b.magz_price 
        FROM magazine_cover a LEFT JOIN magazine_data_hdr b ON a.cover_magz_id=b.magz_id
        LEFT JOIN magazine_gallery c ON b.magz_cover=c.gallery_fk_id
        WHERE c.gallery_description='cover' ORDER BY a.cover_order";
      */  

  		$sintak = "
      SELECT b.magz_id,b.magz_fk_issue,b.magz_url,b.magz_cat,b.magz_name,
      IF(IFNULL(b.magz_fk_issue,0)>0,
        (SELECT REPLACE(CONCAT(gallery_path,'/',gallery_image1),'//','/') FROM magazine_gallery WHERE gallery_description='magazine' AND gallery_id = (SELECT issue_cover FROM magazine_data_dtl WHERE magz_dtl_id=b.magz_fk_issue)),
        REPLACE(CONCAT(c.gallery_path,'/',c.gallery_image1),'//','/')
      ) AS gambar,REPLACE(CONCAT(c.gallery_path,'/',c.gallery_image1),'//','/') AS cover, b.magz_price 
      FROM magazine_cover a LEFT JOIN magazine_data_hdr b ON a.cover_magz_id=b.magz_id
      LEFT JOIN magazine_gallery c ON b.magz_cover=c.gallery_fk_id
      WHERE c.gallery_description='cover' ORDER BY a.cover_order";
  		  
        return result_query($this->db->query($sintak));
  	}

    /*open magazine*/
    #get last cover
  	function getDataMagazine($url){
  	$sintak = "
  		SELECT magz_id,magz_fk_issue,magz_name,magz_desc,magz_price,REPLACE(CONCAT(b.gallery_path,'/',b.gallery_image1),'//','/') AS gambar,c.issue_title,
      c.issue_flipbook AS flipbook
			FROM magazine_gallery b RIGHT JOIN magazine_data_hdr a ON a.magz_cover=b.gallery_fk_id 
			LEFT JOIN magazine_data_dtl c ON a.magz_fk_issue=c.magz_dtl_id
			WHERE LOWER(magz_url='$url')  AND gallery_description='cover'";
  		
      return result_query($this->db->query($sintak));
  	}
    #get new cover
    function issueMagazine($id_issue) {
      $sintak = "SELECT a.magz_dtl_id,magz_url AS base_url,issue_url,issue_title,REPLACE(CONCAT(b.gallery_path,'/',b.gallery_image1),'//','/')
      AS gambar,issue_desc,issue_flipbook AS flipbook
      FROM magazine_data_dtl a 
      LEFT JOIN magazine_gallery b ON a.issue_cover=b.gallery_id
      LEFT JOIN magazine_data_hdr c ON b.gallery_fk_id=c.magz_id
      WHERE magz_dtl_id='$id_issue' AND gallery_description='magazine'";
      #AND magz_fk_id=(SELECT magz_id FROM magazine_data_hdr WHERE LOWER(magz_url='colours'))

      return result_query($this->db->query($sintak));
    }
    #get detail open magazine
  	function showDataMagazine($url){
      $sintak = "
      SELECT '$url' AS base_url,issue_url,issue_title,REPLACE(CONCAT(b.gallery_path,'/',b.gallery_image1),'//','/') AS gambar
      FROM magazine_data_dtl a LEFT JOIN magazine_gallery b ON a.issue_cover=b.gallery_id
      WHERE magz_fk_id=(SELECT magz_id FROM magazine_data_hdr WHERE LOWER(magz_url='$url')) AND gallery_description='magazine'
      ORDER BY magz_dtl_id DESC limit 15";
      
      return result_query($this->db->query($sintak));
  	}

    /**/
    function subMagazine($base,$url){
     $sintak = "        
      SELECT '$base' as base_url,issue_url,issue_title,REPLACE(CONCAT(b.gallery_path,'/',b.gallery_image1),'//','/') AS gambar,issue_desc,issue_flipbook as flipbook
      FROM magazine_data_dtl a LEFT JOIN magazine_gallery b ON a.issue_cover=b.gallery_id
      WHERE issue_url='$url' AND magz_fk_id=(SELECT magz_id FROM magazine_data_hdr WHERE LOWER(magz_url='$base')) AND gallery_description='magazine'";

      return single_query($this->db->query($sintak));
    }

    function listCategory($url){
     $sintak = "SELECT b.magz_id,b.magz_url,b.magz_cat,b.magz_name,REPLACE(CONCAT(c.gallery_path,'/',c.gallery_image1),'//','/') AS gambar,b.magz_price 
        FROM magazine_cover a LEFT JOIN magazine_data_hdr b ON a.cover_magz_id=b.magz_id
        LEFT JOIN magazine_gallery c ON b.magz_cover=c.gallery_fk_id
        WHERE magz_cat=(SELECT cat_id FROM magazine_category WHERE cat_url='$url')
        AND c.gallery_description='cover' ORDER BY a.cover_order";
        
        return each_query($this->db->query($sintak));
    }
	}
?>