<?php
/**
we will decrypt the conversation_id and then fetch all the relevant messages
 */
    require_once("db.php");
    if(isset($_GET['c_id'])){
        //get the conversation id and
        $conversation_id = base64_decode($_GET['c_id']);

            //fetch all the messages of $user_id(loggedin user) and $user_two from their conversation
            $q = "SELECT * FROM `messages` WHERE conversation_id=$conversation_id";
            $data=db::get_data($q);
            if($data !=0)
            {
                while($m=$data->fetch_assoc())
                {
                    //format the message and display it to the user
                    $user_form = $m['user_from'];
                    $user_to = $m['user_to'];
                    $message = $m['message'];
                    //get name and image of $user_form from `user` table
                    $user = "SELECT username,img FROM `user` WHERE id='$user_form'";
                    $user_data=db::get_data($user);
                    $user_fetch=$user_data->fetch_assoc();
                    $user_form_username = $user_fetch['username'];
                    $user_form_img = $user_fetch['img'];

                    //display the message
                    echo "
                            <div class='message'>
                                <div class='img-con'>
                                    <img src='{$user_form_img}'>
                                </div>
                                <div class='text-con'>
                                    <a href='#''>{$user_form_username}</a>
                                    <p>{$message}</p>
                                </div>
                            </div>
                            <hr>";
                }
            }
            else
            {
                echo "No Messages";
            }
    }

?>