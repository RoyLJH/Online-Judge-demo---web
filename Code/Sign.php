<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign</title>
    <link rel="stylesheet" type="text/css" href="MyCSS.css"/>
    <script>
        function SignInChosen(){
            document.getElementById("1").setAttribute("class","chosen");
            document.getElementById("2").setAttribute("class","unchosen");
            document.getElementById("signIN").setAttribute("style","display:block;");
            document.getElementById("signUP").setAttribute("style","display:none;");
        }

        function SignUpChosen(){
            document.getElementById("1").setAttribute("class","unchosen");
            document.getElementById("2").setAttribute("class","chosen");
            document.getElementById("signIN").setAttribute("style","display:none;");
            document.getElementById("signUP").setAttribute("style","display:block;");
        }
    </script>
    <script type="text/javascript" src="Script/msgbox.js"></script>
    <style>
        .unchosen{
            height:40px;
            border-radius: 5px;
            background-color: #abcdef;
            font-weight:bold;
            font-size:26px;
            color:white;
            margin-top:10px;
            margin-bottom: 0px;
            margin-left:auto;
            margin-right:auto;
        }
        .chosen{
            height:40px;
            border-radius: 5px;
            background-color: #d1c5b7;
            align-content: center;
            font-weight:bold;
            font-size:26px;
            color:white;
            margin-top:10px;
            margin-bottom: 0px;
            margin-left:auto;
            margin-right:auto;
        }
    </style>
</head>
<body bgcolor="#f6f6f6">
<div>
    <table border="0" width="40%" align="center" style="margin-top:70px">
        <tr >
            <td colspan="1"><div class="chosen" id="1" align="center" onclick="SignInChosen()" style="cursor: pointer">Sign in</div></td>
            <td colspan="1"><div class="unchosen" id="2" align="center" onclick="SignUpChosen()" style="cursor: pointer">Sign up</div></td>
        </tr>
        <tr><td colspan="2" width="100%">
                <div id="signIN"  style="display: block;">
                    <form id="i" method="post" class="signBoard" action="Script/SignIn.php" align = "center" onsubmit="return toValidIn()">
                        <span >Username </span>
                        <input type="text" name="userName" id="username" class="inputer" >
                        <br><br>
                        <span >Password </span>
                        <input type="password" name="passWord" id="password"  class="inputer" >
                        <br><br>
                        <input type="submit" name="submit" value="Sign In" align="center"
                               style="background-color:white;font-size:20px;padding:3px; width:180px;">
                    </form>
                </div>
                <div id="signUP" style="display: none;">
                    <form method="post" class="signBoard" action="Script/SignUp.php" align="center" onsubmit="return toValidUp()">
                        <span style="white-space: pre">     Username     </span>
                        <input type="text" name="Newusername" id="Newusername"  class="inputer" placeholder="Pick up an username">
                        <br><br>
                        <span style="white-space: pre" >     E-mail      </span>
                        <input type="text" id="Newemail" name="Newemail" class="inputer" placeholder="Your e-mail address to contact with">
                        <br><br>
                        <span style="white-space: pre">    Password     </span>
                        <input type="password" id="Newpassword" name="Newpassword" class="inputer" placeholder="Please enter your password">
                        <br><br>
                        <span style="white-space: pre">Confirm Password </span>
                        <input type="password" id="Newconfirm"  name="Newconfirm" class="inputer" placeholder="Please confirm your password">
                        <br><br>
                        <input type="submit" name="submit" value="Sign Up" align="center"
                               style="background-color:#E7512d;font-size:20px;padding:3px; width: 180px">
                    </form>
                </div>
            </td></tr>
    </table>
</div>

<script>
    var url = location.search;
    if(url=="?c=1") SignInChosen();
    else SignUpChosen();

    function validate_empty(inputname,alertText){
        var value = eval(document.getElementById(inputname)).value;
        if (value==null||value==""){
            ZENG.msgbox.show(alertText,1,2000);
            return false;
        }
        return true;
    }

    function toValidIn(){
        if(validate_empty("username","Username must be filled!")===false){ document.getElementById("username").focus(); return false;}
        if(validate_empty("password","Password must be filled!")===false){ document.getElementById("password").focus(); return false;}
        return true;
    }

    function toValidUp(){
        if(validate_empty("Newusername","Username must be filled!")===false){ document.getElementById("Newusername").focus(); return false;}
        if(validate_empty("Newemail","email must be filled!")===false){ document.getElementById("Newemail").focus(); return false;}
        if(validate_empty("Newpassword","password must be filled!")===false){ document.getElementById("Newpassword").focus(); return false;}
        //验证邮箱是否有效
        var mail = eval(document.getElementById("Newemail")).value;
        var atpos= mail.indexOf("@");
        var dotpos= mail.lastIndexOf(".");
        if (atpos<1 || dotpos<atpos+2 || dotpos+2>=mail.length){
            ZENG.msgbox.show("Your e-mail address is invalid!",1,2000);
            return false;
        }
        //验证用户名是否有效
        var pass1 = eval(document.getElementById("Newpassword")).value;
        var pass2 = eval(document.getElementById("Newconfirm")).value;
        if(pass1 !== pass2){
            ZENG.msgbox.show("Your passwords are inconsistent!",1,2000);
            return false;
        }
        //用户名：2-20个字符
        var name = eval(document.getElementById("Newusername")).value;
//        alert("The length of "+name+" is "+name.length);
        if(name.length<=2||name.length>20){
            ZENG.msgbox.show("Please set the username to 2-20 characters",1,2000);
            return false;
        }
        //密码：6-20个字符
        if(pass1.length<6 || pass1.length>20){
            ZENG.msgbox.show("Please set the password to 6-20 characters",1,2000);
            return false;
        }
        return true;
    }
</script>


</body>
</html>