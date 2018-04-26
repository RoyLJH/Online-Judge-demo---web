<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Question - 23. Merge k Sorted Lists</title>
    <link rel="stylesheet" type="text/css" href="../MyCSS.css"/>
    <script src="../Script/CookieFunc.js"></script>
    <style>
        .brick{
            width: 10px;
            height: 10px;
            margin: 1px 0 0 1px;
            float: left;
            background: #eee;
            display: inline-block;
        }
        p{
            white-space: pre-wrap;
            word-spacing: 1px;
            line-height: 1.5em;
        }
        .example{
            font-family: Consolas;
        }
        select{
            width:150px;
            height : 35px;
            border-radius: 10px;
            font-family: Arial;
            font-size: 16px;
            padding: 3px 3px 3px 3px;
        }
        textarea{
            border-radius: 15px;
            font-size:18px;
            font-family: Consolas;
        }
        button{
            background-color: #c0c0c0;
            color:white;
            font-size: 18px;
            font-weight: 300;
            font-family: Consolas;
            border-radius: 10px;
            width: 200px;
            height:45px;
        }
    </style>
</head>
<body bgcolor="white">
<ul width="100%">
    <li><a id="logo" class="nav">Stark  OJ</a></li>
    <li><a href="../MainPage.html" class="nav">Home</a></li>
    <li><a href="../Problems.php"class="nav">Problems</a></li>
    <li><a href="../Contest.html"class="nav">Contest</a></li>
    <li><a href="../Contact.html" class="nav">Contact</a></li>
    <li><a href="" style="opacity:0;width:10%;cursor:default"></a></li>
    <li><a href="" id="userMod" style="display: block;">
            You haven't <u onclick="GoSign(1)" style="cursor: pointer" >sign in</u> or <u onclick="GoSign(2)" style="cursor: pointer">sign up</u> yet!
        </a>
    </li>
    <div id="userEntry" style="display: none">
        <span style="padding-right: 10px ; cursor: pointer;text-decoration: underline;" onclick="goHonor()" >RoyMustung</span>
        <img src="../Image/Theo.jpg" width="60px" height="60px" onclick="goHonor()"
             style="float: right;position:relative;top:-20px;padding-left:20px;cursor: pointer;"/>
    </div>
</ul>
<script>
    function GoSign(num){
        if(num == 1)
            window.location.href = "../Sign.php?c=1";
        else window.location.href = "../Sign.php?c=2";
    }
    function goHonor(){
        window.location.href = "../PersonInfo.html";
    }
</script>

<br/>
<br/>
<br/>
<br/>
<br/>
<div class="questionDiv">
    <h3>23. Merge k Sorted Lists</h3>
    <hr />
    <p >
        Merge k sorted linked lists and return it as one sorted list. Analyze and describe its complexity.
    </p>

    <hr/>
    <br/>
    <form style="position: relative;left:40px">
        <select name="language">
            <!--            java python python3 C C# javascript swift ruby go scala kotlin-->
            <option value="C++">C++</option>
            <option value="Java" selected="selected">Java</option>
            <option value="Python">Python</option>
            <option value="Python3">Python3</option>
            <option value="C">C</option>
            <option value="C#">C#</option>
            <option value="Javascript">Javascript</option>
            <option value="Swift">Swift</option>
            <option value="Ruby">Ruby</option>
            <option value="Go">Go</option>
            <option value="Scala">Scala</option>
            <option value="Kotlin">Kotlin</option>
        </select>
        <input type="image" src="../Image/circular143.png" width="25px" height="25px" name="refresh" onclick="resetJava()"
               style="position: relative; top:8px; left:30px; border: solid 2px black; border-radius: 5px;" />
        <br/>
        <br/>
        <textarea id="CodeArea" rows="20" cols="120">
import java.util.*;
public class Main{
    public static void main(String[] args){

    }
}
        </textarea>
        <br />
        <br />
        <br />
        <button id="upload" disabled="true">Submit Solution</button>
    </form>
</div>

<script>
    function resetJava(){
        var textArea = document.getElementById("CodeArea");
        var defaultText = textArea.defaultValue;
        textArea.value = defaultText;
    }
    function CheckCookie() {
//        alert(document.cookie);
        var user = getCookie("user");
        if(user !== ""){
            document.getElementById("userMod").setAttribute("style","display:none");
            document.getElementById("userEntry").setAttribute("style","display:block");
            document.getElementById("upload").removeAttribute("disabled");
            document.getElementById("upload").setAttribute("style","background-color:#336699;cursor:pointer;");
        }
    }
    CheckCookie();
</script>

</body>
</html>