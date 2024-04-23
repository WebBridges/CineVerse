<?php

    function upload_image($image, $new_name) {
        $target_dir = "../../img/";
        if($image != null && $image != ""){
            $imageFileType = pathinfo($image["name"], PATHINFO_EXTENSION);
            $new_file_name = $new_name;
            $target_file = $target_dir . $new_file_name;
            move_uploaded_file($image["tmp_name"], $target_file);
            return true;
        } else {
            return false;
        }
    }

    function delete_image($image_name) {
        if($image_name != null && $image_name != ""){
            $file_path = '../../img/' . $image_name;
            if (file_exists($file_path)) {
                unlink($file_path);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
?>