<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Problems</title>
    <link rel="stylesheet" type="text/css" href="MyCSS.css"/>
    <script type="text/javascript" src="Script/CookieFunc.js"></script>
    <style>
        a:link ,a:visited{
            text-decoration: none;
            color:#0088cc;
        }
        a:hover{
            text-decoration: underline;
        }
        div.Easy{
            border-radius: 10px;
            background-color: #5cb85c;
            display: inline;
            padding: 2px 10px 2px 10px;
            color:whitesmoke;
            font-size: 0.9em;
            font-weight: bold;
            font-family:Helvetica;
        }
        div.Medium{
            border-radius: 10px;
            background-color: #f0ad4e;
            display: inline;
            padding: 2px 10px 2px 10px;
            color:whitesmoke;
            font-size: 0.9em;
            font-weight: bold;
            font-family:Helvetica;
        }
        div.Hard{
            border-radius: 10px;
            background-color: #d9534f;
            display: inline;
            padding: 2px 10px 2px 10px;
            color:whitesmoke;
            font-size: 0.9em;
            font-weight: bold;
            font-family:Helvetica;
        }
    </style>
</head>
<body bgcolor="#f6f6f6">
<ul width="100%">
    <li><a id="logo" class="nav">Stark  OJ</a></li>
    <li><a href="MainPage.html" class="nav">Home</a></li>
    <li><a href="Problems.php"class="nav">Problems</a></li>
    <li><a href="Contest.html"class="nav">Contest</a></li>
    <li><a href="Contact.html" class="nav">Contact</a></li>
    <li><a href="" style="opacity:0;width:10%;cursor:default"></a></li>
    <li><a href="" id="userMod" style="display: block;">
            You haven't <u onclick="GoSign(1)" style="cursor: pointer" >sign in</u> or <u onclick="GoSign(2)" style="cursor: pointer">sign up</u> yet!
        </a>
    </li>
    <div id="userEntry" style="display: none">
        <span style="padding-right: 10px ; cursor: pointer;text-decoration: underline;" onclick="goHonor()">RoyMustung</span>
        <img src="Image/Theo.jpg" width="60px" height="60px" onclick="goHonor()"
             style="float: right;position:relative;top:-20px;padding-left:20px;cursor: pointer">
    </div>
</ul>
<script>
    function GoSign(num){
        if(num == 1)
            window.location.href = "Sign.php?c=1";
        else window.location.href = "Sign.php?c=2";
    }
    function goHonor(){
        window.location.href = "PersonInfo.html";
    }
    function CheckCookie() {
//        alert(document.cookie);
        var user = getCookie("user");
        if(user !== ""){
            document.getElementById("userMod").setAttribute("style","display:none");
            document.getElementById("userEntry").setAttribute("style","display:block");
        }
    }
    CheckCookie();
</script>

<br/>
<br/>
<br/>
<br/>

<?php
    function generateRow($id,$title,$solved,$acceptance,$difficultyLevel){
        $difficulty = "";
        if($difficultyLevel==1) $difficulty="Easy";
        elseif ($difficultyLevel==2) $difficulty="Medium";
        else $difficulty="Hard";
        echo "<tr ";
        if($id%2 == 0) echo "class = 'alt'";
        echo ">";
        echo "<td colspan='1'>$id</td>";
        echo "<td colspan='20'><a href='QuestionBank/Question_$id.php' id='problemsViewed'>$title</a></td>";
        echo "<td colspan='2'>";
        if($solved==1 && isset($_COOKIE["user"])) echo "<img src='Image/ok.png'>";
        echo "</td>";
        echo "<td colspan='4'>$acceptance%</td>";
        echo "<td colspan='6'><div class='$difficulty'>$difficulty</div></td>";
    }
?>

<div id="problemDiv">
    <table id="bank">
        <tr>
            <th colspan="1">Id</th>
            <th colspan="20">Title</th>
            <th colspan="2">Solved</th>
            <th colspan="4">Acceptance</th>
            <th colspan="6">Difficulty</th>
        </tr>


        <?php
            $con = mysqli_connect("localhost","root","PassSQL970929","probleminfo");
            $result = mysqli_query($con,"Select * from problems");
            while($row = mysqli_fetch_array($result)){
                $id = $row["id"];
                $title = $row["title"];
                $solved = $row["solved"];
                $acceptance = $row["acceptance"];
                $difficultyLevel = $row["difficulty"];
                generateRow($id,$title,$solved,$acceptance,$difficultyLevel);
            }
        ?>
    </table>

</div>
<br />
<br />
<br />
</body>
</html>