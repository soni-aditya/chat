<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 13/9/17
 * Time: 1:20 AM
 */
    require_once ('connect.php');
    if(isset($_SESSION['id']))
    {
        $user_id=$_SESSION['id'];
    }
    else
    {
        header('Location:index.php');
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
                $q=mysqli_query("SELECT * FROM user WHERE id!=$user_id");
                //display all the results
                while($row=mysqli_fetch_assoc($q))
                {
                    echo "<a href='message.php?id={$row[id]}'><li><img src='$row[img]'> {$row['username']}</li></a>";
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
                        $user_two=trim(mysqli_real_escape_string($con,$_GET['id']));
                        //check if user_two id is valid
                        $q=mysqli_query($con,"SELECT `id` FROM `user` WHERE id='$user_two' AND id!='$user_id'");
                        //valid user_two
                        if(mysqli_num_rows($q)==1)
                        {
                            //check if there exist some previous conversations btw user1 and user2
                            //check $user_id and $user_two has conversation or not if no start one
                            $conver = mysqli_query($con, "SELECT * FROM `conversation` WHERE (user_one='$user_id' AND user_two='$user_two') OR (user_one='$user_two' AND user_two='$user_id')");

                            //they have a conversation
                            if(mysqli_num_rows($conver) == 1){
                                //fetch the converstaion id
                                $fetch = mysqli_fetch_assoc($conver);
                                $conversation_id = $fetch['id'];;
                            }
                            else{
                                //they do not have a conversation
                                //start a new converstaion and fetch its id
                                $q = mysqli_query($con, "INSERT INTO `conversation` VALUES ('','$user_id',$user_two)");
                                ///return the id inserted through auto-increment in last query
                                $conversation_id = mysqli_insert_id($con);
                            }
                        }else{
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

