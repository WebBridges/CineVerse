<?php

    function upload_file($file, $new_name) {
        $target_dir = "../../img/";
        $allowed_types = ['image/jpeg','image/jpg', 'image/png', 'image/gif', 'video/mp4', 'video/mpeg', 'video/quicktime'];
        if($file != null && $file != "" && in_array($file['type'], $allowed_types)){
            $new_file_name = $new_name;
            $target_file = $target_dir . $new_file_name;
            move_uploaded_file($file["tmp_name"], $target_file);
            return true;
        } else {
            return false;
        }
    }

    function delete_file($image_name) {
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