<html>
<head>

</head>
<body>
<?php
    $username = $_POST["Newusername"];
    $email = $_POST["Newemail"];
    $password = $_POST["Newpassword"];

    $con = mysqli_connect("localhost","root","PassSQL970929","userinfo");
    if (!$con)
    {
        die('Could not connect: ' . mysqli_error());
    }
    mysqli_query($con,"insert into users(username,password,email) values ( '".$username."','".$password."','".$email."');");

    echo "You have successfully signed up as a new user ".$username;
    echo "<br />";
    echo "<br />";
    echo "<br />";
    echo "<br />";
    $userTotal = mysqli_num_rows(mysqli_query($con,"Select * from users"));
    echo "Now we have ".$userTotal." users as followed:";
    echo "<br />";
    inquiry();


    function inquiry(){
        global $con;
        $result = mysqli_query($con,"SELECT * from users");
        while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
            echo $row['uid']. "   " . $row['username']. "     " . $row['password']."     ".$row['email'];
            echo "<br />";
        }
    }
    mysqli_close($con);
?>


</body>
</html>