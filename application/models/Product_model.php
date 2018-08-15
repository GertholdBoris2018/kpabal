<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_model extends CI_Model {
    var $tbl_name = "products";

    public function get_item($id) {
        $query = $this->db->get_where($this->tbl_name, array("id" => $id));
        $result = $query->result();
        if($result) return $result[0];
        return false;
    }

    public function save_data($row) {
        $product_info = [];
        foreach ($row as $key => $value) {
            if($key != "id") {
                $product_info[$key] = $value;
            }
        }
        $product_info['posted_date'] = date("Y-m-d H:i:s");
        if($row['id']) {
            $this->db->update($this->tbl_name, $product_info, array("id" => $row["id"]));
        } else {
            $this->db->insert($this->tbl_name, $product_info);
            $row['id'] = $this->db->insert_id();
        }

        if(file_exists(FCPATH.PROJECT_PRODUCT_DIR."/product_".$row['id']."_1.jpg")) {
            rename(FCPATH.PROJECT_PRODUCT_DIR."/product_".$row['id']."_1.jpg", FCPATH.PROJECT_PRODUCT_DIR."/product_".$row['id'].".jpg");
        }

        return 0;
    }

    public function get_category_name($arr_categories, $categoryIdx) {
        foreach ($arr_categories as $key => $category) {
            if($category->categoryIdx == $categoryIdx)
                return $category->categoryName;
        }
        return false;
    }

    public function get_items($arr_categories, $category = "", $keyword="" ) {
        
        $strsql = "select * from tbl_".($this->tbl_name)." where category LIKE '".$category."%' and (product_name like '%".$keyword."%' or descriptions like '%".$keyword."%' or title like '%".$keyword."%')";
        $result = $this->db->query($strsql)->result();

        for($i=0; $i<count($result); $i++) {
            $result[$i]->categoryName = $this->get_category_name($arr_categories, $result[$i]->category);
        }

        return $result;
    }

    public function get_recent_items($arr_categories, $limit = 8) {

        $strsql = "select * from tbl_".($this->tbl_name)." order by posted_date desc limit ".$limit;
        $result = $this->db->query($strsql)->result();

        for($i=0; $i<count($result); $i++) {
            $result[$i]->categoryName = $this->get_category_name($arr_categories, $result[$i]->category);
        }

        return $result;
    }
}
