<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 13/9/17
 * Time: 12:57 AM
 *
 * Login page
 */
require_once ('connect.php');
?>
<html>
<head>
    <title>A chat application</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body style="background: #eee;">
    <!--Login Container-->
    <div class="login-container">
        <h1 class="text-center">Login</h1>
        <form action="index.php" method="post">
                <div class="form-group">
                    <input required type="text" class="form-control" name="username" placeholder="Enter Your username.">
                </div>
                <div class="form-group">
                    <input required type="password" class="form-control" name="password" placeholder="Enter Your password.">
                </div>
                <input type="submit" value="login"  name="login" class="btn btn-primary btn-block">
        </form>
        <br>
        <span><b>User & pass:</b> husain / test123</span><br>
        <span><b>User & pass:</b> hunk / test123</span><br>
        <span><b>User & pass:</b> hackerkernel / test123</span><br>
        <span><b>User & pass:</b> murtaza / test123</span><br>
        <span><b>User & pass:</b> qut / test123</span><br>
        <span><b>User & pass:</b> sakina / test123</span>
        </form>
    </div>
</body>
</html>
<?php
if (isset($_POST['login']))
{
    $username=trim(mysqli_real_escape_string($con,$_POST['username']));
    $password=trim(mysqli_real_escape_string($con,$_POST['password']));
    $md5password=md5($password);

    ///Check the username and password match from the DB
    $query=mysqli_query($con,"SELECT * FROM user WHERE username='.$username.' AND password='.$md5password.'");
    if(mysqli_num_rows($query) == 1)
    {
        $fetch=mysqli_fetch_assoc($query);
        session_start();
        $_SESSION['id']=$fetch['id'];
        $_SESSION['username']=$fetch['username'];
        header('location:message.php');
    }
    else
    {
        //show error message
        echo "<div class='alert alert-danger'>Invalid username Or password.</div>";
    }
}
?>
