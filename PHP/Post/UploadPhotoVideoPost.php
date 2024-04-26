<?php
    use Post\DBPost;
    use Post\DBFoto_video;

    require_once("../Utils/bootstrap.php");
    require_once("../Utils/post.php");
    require_once("../Utils/Images_utils.php");
    sec_session_start();

    if(!isset($_POST["postTitle"]) || !isset($_POST["postDescription"]) || !isset($_FILES["uploadFile"])){
        ob_start();
        echo "POST data: ";
        print_r($_POST);
        echo "FILES data: ";
        print_r($_FILES);
        $debug_output = ob_get_clean();
        echo "There was an error during validation of post. Please try again. Debug info: $debug_output";
    } else if (strlen($_POST["postTitle"]) == 0 || strlen($_POST["postDescription"]) == 0 || $_FILES["uploadFile"]["size"] == 0 ||
               strlen($_POST["postTitle"]) > 50 || strlen($_POST["postDescription"]) > 50){
                http_response_code(400); // Bad Request
                echo "There was an error during validation of post's field. Please try again.";
               } else {
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $fileType = finfo_file($finfo, $_FILES["uploadFile"]["tmp_name"]);
                finfo_close($finfo);
                if (strpos($fileType, 'image/') !== 0 && strpos($fileType, 'video/') !== 0) {
                    http_response_code(400);
                    echo "Invalid file type. Please upload an image or video.";
                } else {
                    try{
                        $post=new DBPost($_POST["postTitle"],null,0,$_SESSION["username"],null);
                        $post->db_serialize();
                        $post_file_name=$_FILES['uploadFile']['name'];
                        $PostFileExtension = strtolower(pathinfo($post_file_name, PATHINFO_EXTENSION));
                        $newpost_file_name = $_SESSION['username'] . "_photovideopost_" . time() . "." . $PostFileExtension;
                        $photo_video_post= new DBFoto_video(null,$post->get_IDpost(),$newpost_file_name,$_POST["postDescription"]);
                        $photo_video_post->db_serialize();
                        upload_file($_FILES['uploadFile'], $newpost_file_name);
                        header('Location: ../../HTML/Profile/userpage.php');
                    } catch(Exception $e){
                        http_response_code(400); // Bad Request
                        echo $e->getMessage();
                    }
                }
            }
?>