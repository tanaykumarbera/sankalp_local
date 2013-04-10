<?php
require_once 'dbconnection.php';


if(!(isset($_SESSION['op_id']))||(($_SESSION['event_id']!=1)&&($_SESSION['event_id']!=0)))
      {
          header('Location:index.php');
      }


?>



<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="_css/style.css" type="text/css">
        <title></title>
    </head>
    <body style="background: url('_img/reg_bck.gif') repeat fixed;">
         <a href="logout.php"><div class="logout" title="Click to logout"></div></a> <a href="search.php"><div class="serch" title="Search Student or Team Details"></div></a> <div style="position: fixed; background: url('_img/black.png') repeat; bottom:5px; left: 69px;height: 20px; padding-top: 2px; color: white; font-family: Monospace; border-radius: 5px;">&nbsp;&nbsp;Logged in as <?php echo $_SESSION['op_name'];?>&nbsp;-© Tanay Kumar Bera, Tech-niché, Sankalp-2k13&nbsp;&nbsp;</div>
        
        <div style="width: 1000px; margin-top: 10px; margin-bottom: 10px; margin-left: auto; margin-right: auto; height: 700px;">
            <div style="width: 230px; height: 700px; float: left; background: url('_img/reg_left.jpg'); border-radius: 10px;">
                <form onsubmit="javascript:srch();return false;">
                    <input type="text" id="regid" style="margin-left: 20px; margin-top: 100px; border-radius: 5px;" onkeypress="ckckk(event)" onclick="def()"/>&nbsp;&nbsp;&nbsp;
                <input type="submit" class="button blue" value="GO" style="padding: 0 5px; margin: 0; border-radius: 50px;" onclick="srch()"/>
                </form>
                <a href="search.php"><input type="button" class="button blue" value="SEARCH A STUDENT OR TEAM" style="border-radius: 5px; alignment-adjust: central; position: absolute; top: 50px;"/></a>
                
            </div>
            <div id="isearch" style="width: 760px; height: 700px; float: left; margin-left: 10px; background: url('_img/reg_right.jpg'); border-radius: 10px;" >
                
            
            </div>
        
        </div>
    </body>
    
    <script type="text/javascript">
        function srch()
        {
            var a=document.getElementById("regid").value;
            if((a>2000)&&(a<9999))
                 document.getElementById("regid").style["background-color"]="#99ff00";   
             else
                 document.getElementById("regid").style["background-color"]="#ff6666";   
             
            document.getElementById("isearch").innerHTML='<iframe src="update.php?uid='+a+'" style="position: relative; border-width: 0px; width: 100%; height: 100%;  border-radius: 10px; background-color: transparent;"></iframe>';
            
        }
        
        function def()
        {
            document.getElementById("regid").value="";
            document.getElementById("regid").style["background-color"]="white";   
        }
        
    </script>
    
</html>
