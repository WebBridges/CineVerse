<?php
    require_once("../Utils/emailUtils.php");
    require_once("../Utils/post.php");
    require_once("../Utils/user.php");

    use Post\PostUtility;
    use User\UserUtility;

    $type = $_GET['type'];
    if($type == 'post') {
        $IDPost = $_GET['id'];
        $post = PostUtility::get_post_by_IDpost($IDPost);
        $titoloPost = $post->get_titolo();
        $subject = "Post like";
        $email = UserUtility::get_utente_by_username($post->get_username_utente())->get_email();
        $message=
            '<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">
            <div style="max-width: 600px; margin: 20px auto; padding: 20px; background-color: #fff; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                <h1 style="text-align: center; color: #333;">
                    L\'utente ' . $_SESSION['username'] . ' ha lasciato un like al tuo post dal titolo: "' . $titoloPost . '"
                </h1>
            </div>
            </body>';
    } else if($type == 'comment') {
        $IDCommento = $_GET['id'];
        $commento = PostUtility::get_comment_by_IDcommento($IDCommento);
        $IDPost = $commento->get_IDpost();
        $post = PostUtility::get_post_by_IDpost($IDPost);
        $titoloPost = $post->get_titolo();
        $subject = "Comment like";
        $email = UserUtility::get_utente_by_username($commento->get_username_utente())->get_email();
        $message=
            '<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">
            <div style="max-width: 600px; margin: 20px auto; padding: 20px; background-color: #fff; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                <h1 style="text-align: center; color: #333;">
                    L\'utente ' . $_SESSION['username'] . ' ha lasciato un like al tuo commento: "' . $commento->get_corpo() . '" nel post dal titolo: "' . $titoloPost . '".
                </h1>
            </div>
            </body>';
    } else if($type == 'follow') {
        $username = $_GET['id'];
        $subject = "Follow";
        $email = UserUtility::get_utente_by_username($username)->get_email();
        $message=
            '<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">
            <div style="max-width: 600px; margin: 20px auto; padding: 20px; background-color: #fff; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                <h1 style="text-align: center; color: #333;">
                    L\'utente ' . $_SESSION['username'] . ' ha iniziato a seguirti.
                </h1>
            </div>
            </body>';
    }

    //Send email only if the post or comment owner user is not the same user that left the like
    if($email != $_SESSION['email']){
        sendEmailMessage($subject, $message, $email);
    }
    header('Content-Type: application/json');
    echo json_encode($message, JSON_PRETTY_PRINT);
?>