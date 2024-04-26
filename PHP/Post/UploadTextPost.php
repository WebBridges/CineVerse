<?php
    use Post\DBPost;
    use Post\DBTesto;

    require_once("../Utils/bootstrap.php");
    require_once("../Utils/post.php");
    sec_session_start();

    if(!isset($_POST["postTitle"]) || !isset($_POST["postDescription"])){
        http_response_code(400); // Bad Request
        echo "There was an error during validation of post's field. Please try again.";
    } else if (strlen($_POST["postTitle"]) == 0 || strlen($_POST["postDescription"]) == 0 ||
               strlen($_POST["postTitle"]) > 50 || strlen($_POST["postDescription"]) > 50){
                http_response_code(400); // Bad Request
                echo "There was an error during validation of post's field. Please try again.";
               } else {
                    try{
                        $post=new DBPost($_POST["postTitle"],null,0,$_SESSION["username"],null);
                        $post->db_serialize();
                        $text_post= new DBTesto(null,$post->get_IDpost(),$_POST["postDescription"]);
                        $text_post->db_serialize();
                        header('Location: ../../HTML/Profile/userpage.php');
                    } catch(Exception $e){
                        http_response_code(400); // Bad Request
                        echo $e->getMessage();
                    }
                }
?>