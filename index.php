<?php
 require_once 'dbconnection.php';
 $admin=FALSE;

 
 
if(isset($_REQUEST['sbtn']))
{
    if(isset($_REQUEST['uname'])&&isset($_REQUEST['pswd']))
    {
        $sql= "SELECT * FROM operator WHERE op_id='".$_REQUEST['uname']."' AND password='".md5($_REQUEST['pswd'])."'";
        $res=  mysql_query($sql);
        if(mysql_num_rows($res))
        {
            $a=  mysql_fetch_array($res);
            $_SESSION['op_name']=$a['op_name'];
            $_SESSION['op_id']=$a['op_id'];
            $_SESSION['event_id']=$a['event_id'];
            $_SESSION['amnt_clctd']=$a['amnt_clctd'];
        }
        
     else
         {
            header('Location: index.php?f=2');
         }
    }
        
}

                if(isset($_SESSION['op_name']))
                {
                    if($_SESSION['event_id']==1)
                    {
                            header('Location: reg_desk.php');
                    }
                    elseif ($_SESSION['event_id']==-1) 
                    {
                        header('Location: team_reg.php');
                    }  
                    elseif ($_SESSION['event_id']>1) 
                    {
                        header('Location: event_desk.php');
                    }

                    elseif($_SESSION['event_id']==0)
                    {
                        $admin=TRUE;
                    }

                }








?>




<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="_css/style.css" type="text/css">
        <title></title>
    </head>
    <body style="background: url('_img/index_back.jpg') no-repeat fixed; width: 1200px;">
     <div style="background: url('_img/black.png') repeat; padding-top: 0px; padding-bottom: 0px; padding-left: 40px; padding-right: 40px; border-radius: 10px; position: fixed; top: 30px; left: 30px;"> <img src="_img/sankalp_logo.png"/></div> 
        
        <?php if(!$admin){ ?>
                    <?php  if(isset($_REQUEST['f'])) if($_REQUEST['f']==2) echo '<div class="notification" style="color: red; position: fixed; top: 10px; right: 10px;"> <center>&nbsp;&nbsp;Invalid Credinals...&nbsp;&nbsp;</center> </div>';?>
                    
                     <div style="position: fixed; background: url('_img/black.png') repeat; bottom:5px; left: 5px;height: 20px; padding-top: 2px; color: white; font-family: Monospace; border-radius: 5px;">&nbsp;&nbsp;© Tanay Kumar Bera, Tech-niché, Sankalp-2k13&nbsp;&nbsp;</div>
            <div id="login_frame" style="border-radius: 5px; position: fixed; top: 30px; right: 20px;  padding: 10px; ">
                        <table>
                            <tr>
                                <td>
                                    <img src="_img/locked.png" style="float: right;"/>
                                    
                                </td>
                               
                                <td>
                        <form name="user_login" id="log_in" action="" method="POST">
                            <input type="text" title="Enter your id" class="box" value="Operator ID" name="uname" onclick="this.value='';"/><br/>
                        <input type="password" title="Enter your password" class="box" value="Username" name="pswd" onclick="this.value='';"/><br/>
                        <input type="submit" title="Click to Login!" class="btn" style="float: right;" value="Login" name="sbtn" />
                        </td>
                               </tr>  
                                </table>
                    </div>
                     
                     <div style="background: url('_img/black.png') repeat; border-radius: 5px; padding-top: 5%; margin: 20% auto;  width: 98%; position: absolute; height: 200px; top: 20%;   color: white; font-family: monospace; font-weight: bold; font-size: 20px;" >
                        <center><a href="new_registeration.php"><img src="_img/nwreg.png"/></a>&nbsp; &nbsp;<a href="search.php"><img src="_img/srch.png"/></a>&nbsp; &nbsp; <a href="max_score.php"><img src="_img/wnr.png"/></a>&nbsp; &nbsp;</center>
                     </div>
                     
        <?php
       }
       else
       {
       ?>
        <a href="logout.php"><div class="logout" title="Click to logout"></div></a> <a href="search.php"><div class="serch" title="Search Student or Team Details"></div></a> <div style="position: fixed; background: url('_img/black.png') repeat; bottom:5px; left: 69px;height: 20px; padding-top: 2px; color: white; font-family: Monospace; border-radius: 5px;">&nbsp;&nbsp;Logged in as <?php echo $_SESSION['op_name'];?>&nbsp;-© Tanay Kumar Bera, Tech-niché, Sankalp-2k13&nbsp;&nbsp;</div>
        <div style="background: url('_img/black.png') repeat; border-radius: 5px; padding-top: 5%; top: 40%; width: 98%; position: absolute; top: 40%; height: 200px;  color: white; font-family: monospace; font-weight: bold; font-size: 20px;" >
            <center><a href="reg_desk.php"><img src="_img/r&p.png"/></a>&nbsp; &nbsp;<a href="team_reg.php"><img src="_img/tmr.png"/></a>&nbsp; &nbsp; <a href="event_desk.php"><img src="_img/ed.png"/></a>&nbsp; &nbsp; <a href="max_score.php"><img src="_img/wnr.png"/></a>&nbsp; &nbsp;</center>
        </div>
      
        <?php
       }
      
        ?>
    </body>
</html>
