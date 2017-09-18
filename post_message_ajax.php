<?php
/**
 * in this page we will
 * decrypt the $conversation_id, $user_from, $user_to
 * and then store the message into `message` table
 */
require_once("db.php");
//post message
if(isset($_POST['message'])){
    $message = mysqli_real_escape_string(db::connect(), $_POST['message']);
    $conversation_id = mysqli_real_escape_string(db::connect(), $_POST['conversation_id']);
    $user_form = mysqli_real_escape_string(db::connect(), $_POST['user_form']);
    $user_to = mysqli_real_escape_string(db::connect(), $_POST['user_to']);

                    //decrypt the conversation_id,user_from,user_to
                    $conversation_id = base64_decode($conversation_id);
                    $user_form = base64_decode($user_form);
                    $user_to = base64_decode($user_to);

//insert into `messages`
$q = "INSERT INTO `messages` VALUES ('',$conversation_id,'$user_form','$user_to','$message')";
$result=db::insert_data($q);
if($result != 0){
    echo "Posted";
}else{
    echo "Error";
}
}
?>