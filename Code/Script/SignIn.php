<html>
<head>
    <link rel="stylesheet" type="text/css" href="../MyCSS.css"/>
    <script type="text/javascript" src="msgbox.js"></script>
    <script type="text/javascript" src="CookieFunc.js"></script>

</head>
<body bgcolor="#f6f6f6">


<?php
    $username = $_POST["userName"];
    $password = $_POST["passWord"];
    $con = mysqli_connect("localhost","root","PassSQL970929","userinfo");
    $userTotal = mysqli_num_rows(mysqli_query($con,"Select * from users where username='".$username."'"));
    if($userTotal==0){
        $url = "../Sign.php?c=1";
        echo "<script> ZENG.msgbox.show('No User Of $username !',5,2000) </script>";
        echo "<meta http-equiv='refresh' content='2  url=$url'>";
        die();
    }
    $passCorrect = mysqli_num_rows(mysqli_query($con,"Select * from users where username='".$username."'AND password ='".$password."'"));
    if($passCorrect==0){
        $url = "../Sign.php?c=1";
        echo "<script> ZENG.msgbox.show('Your password is incorrect!',5,2000) </script>";
        echo "<meta http-equiv='refresh' content='2  url=$url'>";
        die();
    }
    $url = "../MainPage.html";
    echo "<script> addCookie('user','RoyMustung',0.1); </script>";
    echo "<script> alert(document.cookie); </script>";
    echo "<script> ZENG.msgbox.show('Sign in successfully!',4,2000); </script>";
    echo "<meta http-equiv='refresh' content='2;url=$url'>";
?>



</body>
</html>