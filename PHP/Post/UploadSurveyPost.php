<?php
    use Post\DBPost;
    use Post\DBOpzione;

    require_once("../Utils/bootstrap.php");
    require_once("../Utils/post.php");
    sec_session_start();

    if(!isset($_POST["postTitle"]) || !isset($_POST["optionType"]) || strlen($_POST["postTitle"]) == 0 || strlen($_POST["postTitle"]) > 50){
        http_response_code(400); // Bad Request
        echo "There was an error during validation of post's field. Please try again.";
    } else {
            try{
                $post=new DBPost($_POST["postTitle"],null,0,$_SESSION["username"],null);
                $post->db_serialize();
                $fields = array();
                for ($i = 1; $i <= 4; $i++) {
                    if (isset($_POST['field' . $i]) && !empty($_POST['field' . $i])) {
                        $fields[] = $_POST['field' . $i];
                    }
                }
                foreach($fields as $field){
                    $option=new DBOpzione($post->get_IDpost(),$field,$_POST["optionType"]);
                    $option->db_serialize();
                }
                header('Location: ../../HTML/Profile/userpage.php');
            } catch(Exception $e){
                http_response_code(400); // Bad Request
                echo $e->getMessage();
            }
        }
?>