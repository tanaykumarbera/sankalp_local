<?php

 require_once 'dbconnection.php';
 
  if(!(isset($_SESSION['op_id']))||(($_SESSION['event_id']==1)||($_SESSION['event_id']==-1)))
      {
          header('Location:index.php');
      }
 
 
    if(isset($_REQUEST['tsbtn']))
    {
        $ev=stripslashes($_REQUEST['tm_eve']);
        $tm=stripslashes($_REQUEST['tm_id']);
        $ed=stripslashes($_REQUEST['ed']);
        if($ev==-1||$ev==NULL)
        {
            $ev=$ed."#".stripslashes($_REQUEST['score'])."#".stripslashes($_REQUEST['evrnd']);
        }
        else
        {
            $ev=$ev.'_'.$ed."#".stripslashes($_REQUEST['score'])."#".stripslashes($_REQUEST['evrnd']);
        }
        
        $sql="UPDATE team_registration SET event_performed='$ev' WHERE team_id='$tm'";
       
        mysql_query($sql) or die(mysql_error());
        
    }
    
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="_css/style.css" type="text/css">
        <title></title>
    </head>
    
    
    
    <body style="background-color: transparent; padding-top: 20%; color: white">
      
    <center> <b>TEAM &nbsp; <?php echo $tm;?>&nbsp; SCORED <?php echo $_REQUEST['score'];?></b></center>
    <center><input type="button" value="OKAY" class="button blue" onclick="window.top.location.href ='event_desk.php?evrnd=<?php echo stripslashes($_REQUEST['evrnd']);?>'" /></center>
    </body>
   
</html>
