<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 13/9/17
 * Time: 1:20 AM
 */
    require_once ('db.php');
    session_start();

    if(isset($_SESSION['id']))
    {
        $user_id=$_SESSION['id'];
    }
    else
    {
        header('location:index.php');
    }
?>
<html>
<head>
    <title>This is the messaging area</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <center>
        <strong>Welcome <?php echo $_SESSION['username'] ?>   <a href="logout.php">logout</a></strong>
    </center>
    <div class="message-body">
        <div class="message-left">
            <ul>
                <?php
                //show all the users except me
                $q="SELECT * FROM user WHERE id!=$user_id";
                $data=db::get_data($q);
                //display all the results
                while($row=$data->fetch_assoc())
                {
                    echo "<a href='message.php?id={$row['id']}'><li><img src='{$row['img']}'> {$row['username']}</li></a>";
                }
                ?>
            </ul>
        </div>
        <div class="message-right">
<!--            display messages-->
            <div class="display-message">
                <?php
                    //check if $_GET['id'] is set
                    if(isset($_GET['id']))
                    {
                        $user_two=trim(mysqli_real_escape_string(db::connect(),$_GET['id']));
                        //check if user_two id is valid
                        $q="SELECT `id` FROM `user` WHERE id=$user_two AND id!=$user_id";
                        $result=db::get_data($q);
                        //valid user_two
                        if($result != 0)
                        {
                            $conver = "SELECT * FROM `conversation` WHERE (user_one=$user_id AND user_two=$user_two) OR (user_one=$user_two AND user_two=$user_id)";

                            $res=db::get_data($conver);
                            if($res != 0)
                            {
                                $fetch=$res->fetch_assoc();
                                $conversation_id = $fetch['id'];
//                                var_dump($conversation_id);
                            }
                            else
                            {
                                $qrry="INSERT INTO `conversation` VALUES ('','$user_id',$user_two)";
                                $insert=db::insert_data($qrry);

                                $last_id='SELECT MAX(id) FROM user';
                                $con_id=db::get_data($last_id);
                                $conversation_id=$con_id->fetch_assoc();
//                                $conversation_id = db::connect()->insert_id();//getting last insert id of the conversation
                            }
                        }
                        else
                        {
                            die('Invalid $_GET ID.');
                        }
                    }else {
                        die("Click On the Person to start Chating.");
                    }
                ?>
            </div>
<!--            /display message-->
<!--                send message-->
            <div class="send-message">
<!--                    store conversation id ,user_from,user_two so that we can send this to post_message_ajax.php-->
                <input type="hidden" id="conversation_id" value="<?php echo base64_encode($conversation_id); ?>">
                <input type="hidden" id="user_form" value="<?php echo base64_encode($user_id); ?>">
                <input type="hidden" id="user_to" value="<?php echo base64_encode($user_two); ?>">
                <div class="form-group">
                    <textarea class="form-control" id="message" placeholder="Enter Your Message"></textarea>
                </div>
                <button class="btn btn-primary" id="reply">Reply</button>
                <span id="error"></span>
            </div>
<!--            /send message-->
        </div>
    </div>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
</body>
</html>

