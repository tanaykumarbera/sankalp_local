<?php
 require_once 'dbconnection.php';
 
  if(!(isset($_SESSION['op_id']))||(($_SESSION['event_id']==1)||($_SESSION['event_id']==-1)))
      {
          header('Location:index.php');
      }
 
    if((isset($_REQUEST['eve']))&&(isset($_REQUEST['tm']))&&(isset($_REQUEST['evrnd'])))
    {
        
        $team_id=$_REQUEST['tm'];
        $sq2="SELECT * FROM team_registration WHERE team_id='$team_id'";
        $t=mysql_fetch_array(mysql_query($sq2));
        $b=TRUE;
               
    }
     else 
    {
        $b=FALSE;
    }
    

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link rel="stylesheet" href="_css/style.css" type="text/css">
    </head>
     <body style="background: url('_img/team_back.jpeg') fixed no-repeat center;">
        <?php
            if($b)
            {
        ?>
                <br/>
                <font face="Monospace"><b>
                    <h4><center ><p style="background: url('_img/white.png') repeat; width: 300px; height: 30px; padding-top: 10px; border-radius: 10px; position: absolute; top: 10px; right: 10px;">TEAM : &nbsp; <?php echo $t['team_name'].'&nbsp;['.$t['team_id'].']';?>&nbsp;&nbsp;</p></center></h4>
                    
                    <div style="background: url('_img/white.png') repeat; height: 180px; width: auto; border-radius: 10px; margin-top: 60px; padding-bottom: 20px; padding-left: 20px;">
                        <br/><br/>&nbsp; &nbsp; &nbsp;<u>TEAM MEMBERS:</u><br/>
                    <?php
                          if($t['member1']>10000000)
                          {
                              $sq="SELECT users_name FROM registration WHERE registeration_id='".$t['member1']."'";
                              $n=mysql_fetch_array(mysql_query($sq));
                              echo '<br/>&nbsp; &nbsp;&nbsp; &nbsp;NAME:&nbsp;<font face="Century Gothic" size="3px" color="green">'.$n['users_name'].'&nbsp;&nbsp;&nbsp;&nbsp;</font> ID:&nbsp;[&nbsp;<font face="Calibri" color="green">'.$t['member1'].'</font>&nbsp;]';
                          }
                          if($t['member2']>10000000)
                          {
                              $sq="SELECT users_name FROM registration WHERE registeration_id='".$t['member2']."'";
                              $n=mysql_fetch_array(mysql_query($sq));
                              echo '<br/>&nbsp; &nbsp;&nbsp; &nbsp;NAME:&nbsp;<font face="Century Gothic" size="3px" color="green">'.$n['users_name'].'&nbsp;&nbsp;&nbsp;&nbsp;</font> ID:&nbsp;[&nbsp;<font face="Century Gothic" size="3px" color="green">'.$t['member2'].'</font>&nbsp;]';
                          }
                          if($t['member3']>10000000)
                          {
                              $sq="SELECT users_name FROM registration WHERE registeration_id='".$t['member3']."'";
                              $n=mysql_fetch_array(mysql_query($sq));
                              echo '<br/>&nbsp; &nbsp;&nbsp; &nbsp;NAME:&nbsp;<font face="Century Gothic" size="3px" color="green">'.$n['users_name'].'&nbsp;&nbsp;&nbsp;&nbsp;</font> ID:&nbsp;[&nbsp;<font face="Century Gothic" size="3px" color="green">'.$t['member3'].'</font>&nbsp;]';
                          }
                          if($t['member4']>10000000)
                          {
                              $sq="SELECT users_name FROM registration WHERE registeration_id='".$t['member4']."'";
                              $n=mysql_fetch_array(mysql_query($sq));
                              echo '<br/>&nbsp; &nbsp;&nbsp; &nbsp;NAME:&nbsp;<font face="Century Gothic" size="3px" color="green">'.$n['users_name'].'&nbsp;&nbsp;&nbsp;&nbsp;</font> ID:&nbsp;[&nbsp;<font face="Century Gothic" size="3px" color="green">'.$t['member4'].'</font>&nbsp;]';
                          }
                          if($t['member5']>10000000)
                          {
                              $sq="SELECT users_name FROM registration WHERE registeration_id='".$t['member5']."'";
                              $n=mysql_fetch_array(mysql_query($sq));
                              echo '<br/>&nbsp; &nbsp;&nbsp; &nbsp;NAME:&nbsp;<font face="Century Gothic" size="3px" color="green">'.$n['users_name'].'&nbsp;&nbsp;&nbsp;&nbsp;</font> ID:&nbsp;[&nbsp;<font face="Century Gothic" size="3px" color="green">'.$t['member5'].'</font>&nbsp;]';
                          }
                    
                    ?>
                        
                 </div>
                    
                    <div style="position: absolute; bottom: 10px; right: 5px;">
                        <form name="su" id="scr_fm" action="team_detail_up.php" method="POST" onsubmit="javascript:sub();return false;">
                        <input type="text" name="score" id="scr" class="box"/>
                        <input type="submit" name="tsbtn" value="update" class="button blue"/>
                        <input type="hidden" name="tm_id" value="<?php echo $team_id;?>"/>
                        <input type="hidden" name="tm_eve" value="<?php echo $t['event_performed'];?>"/>
                        <input type="hidden" name="ed" value="<?php echo $_REQUEST['eve'];?>"/>
                        <input type="hidden" name="evrnd" value="<?php echo $_REQUEST['evrnd'];?>"/>
                        </form>
                    </div>
                    
        <?php
            }
            else
                {
                echo '<center><font color="red">SOMETHING WENT WRONG...:D :D.. just keep on finding!:D ;)</font><center>';
                }
        ?>
                   </b> </font>
                   
                   
                   <script>
                       
                       function sub()
                       {
                           var a=document.getElementById("scr").value;
                           if(isNaN(a)||(a=='')||(a=="")||(a==" ")||(a==' ')||(a==null))
                               {
                                   alert('NO SCORE OR INVALID VALUE ENTERED. PLEASE BE ALERTED');
                               }
                           else
                               {
                                   if(confirm("YOU ARE ABOUT TO UPDATE TEAM <?php echo $t['team_name'].' [ '.$t['team_id'].' ] '; ?> with score "+a+" for Round <?php echo $_REQUEST['evrnd'];?>\n\nARE YOU SURE??")==1)
                                   document.forms["scr_fm"].submit();
                               }
                       }
                   </script>
                   
    </body>
</html>
