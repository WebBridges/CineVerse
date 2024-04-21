<?php
    use User\DBUtente;
    use User\UserUtility;
    require_once("../Database/AccessDB.php");
    require_once("../Utils/user.php");
    require_once("../Utils/Images_utils.php");

    $description = isset($_POST['description']) ? $_POST['description'] : "";
    $profilePic = isset($_FILES['profilePic']) ? $_FILES['profilePic']['name'] : "";
    $backgroundPic = isset($_FILES['backgroundPic']) ? $_FILES['backgroundPic']['name'] : "";
    $newProfilePicName = "";
    $newBackgroundPicName = "";
    if(strlen($description)> 100){
        http_response_code(400); // Bad Request
        echo "Invalid input";
        exit();
    } else {
        try{
            $user = new DBUtente();
            $userUtility = new UserUtility();
            $oldProfilePic = $userUtility::retrieve_profile_photo($_SESSION['username']);
            $oldBackgroundPic = $userUtility::retrieve_background($_SESSION['username']);

            if($profilePic!=null && $profilePic != ""){
                $oldProfilePicRes=delete_image($oldProfilePic);
                $profilePicExtension = pathinfo($profilePic, PATHINFO_EXTENSION);
                $newProfilePicName = $_SESSION['username'] . "_profile_" . time() . "." . $profilePicExtension;
            }
            if($backgroundPic!=null && $backgroundPic != ""){
                $oldBackgroundPic=delete_image($oldBackgroundPic);
                $backgroundPicExtension = pathinfo($backgroundPic, PATHINFO_EXTENSION);
                $newBackgroundPicName = $_SESSION['username'] . "_background_" . time() . "." . $backgroundPicExtension;
            }
            
            
            $user->update_infos_profile($description, $newProfilePicName, $newBackgroundPicName);
            $user->update_topics_account($_POST['topic']);

            if($profilePic!=null && $profilePic != ""){
                upload_image($_FILES['profilePic'], $newProfilePicName);
            }
            if($backgroundPic!=null && $backgroundPic != ""){
                upload_image($_FILES['backgroundPic'], $newBackgroundPicName);
            }

            header("Location: ../../HTML/Profile/userpage.php");
        }catch(Exception $e){
            http_response_code(400); // Bad Request
            echo $e->getMessage();
        }
    }

?>