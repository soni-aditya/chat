<?php
/**
 * in this page we will
 * decrypt the $conversation_id, $user_from, $user_to
 * and then store the message into `message` table
 */
require_once("connect.php");
//post message
if(isset($_POST['message'])){
    $message = mysqli_real_escape_string($con, $_POST['message']);
    $conversation_id = mysqli_real_escape_string($con, $_POST['conversation_id']);
    $user_form = mysqli_real_escape_string($con, $_POST['user_form']);
    $user_to = mysqli_real_escape_string($con, $_POST['user_to']);

                    //decrypt the conversation_id,user_from,user_to
                    $conversation_id = base64_decode($conversation_id);
                    $user_form = base64_decode($user_form);
                    $user_to = base64_decode($user_to);

//insert into `messages`
$q = mysqli_query($con, "INSERT INTO `messages` VALUES ('','$conversation_id','$user_form','$user_to','$message')");
if($q){
    echo "Posted";
}else{
    echo "Error";
}
}
?>