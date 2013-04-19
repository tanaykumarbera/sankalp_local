<?php
    require_once 'dbconnection.php';
    
if(!(isset($_SESSION['op_id']))||(($_SESSION['event_id']!=-1)&&($_SESSION['event_id']!=0)))
      {
          header('Location:index.php');
      }
    
    
    if(isset($_REQUEST['team_sbtn']))
    {
        
        $events=$_REQUEST['events'];
        $team_name=mysql_real_escape_string($_REQUEST['team_name']);
        $ptct=0;
        if(isset($_REQUEST['member_1'])) 
        {
            $mem[1]=  mysql_real_escape_string($_REQUEST['member_1']);
            $ptct++;
            $pttk=$mem[1];
        }
        else
        {
            $mem[1]=-1;
        }
        
        if(isset($_REQUEST['member_2'])) 
        {
            $mem[2]=  mysql_real_escape_string($_REQUEST['member_2']);
            $ptct++;
            $pttk=$mem[2];
        }
        else
        {
            $mem[2]=-1;
        }
        
        if(isset($_REQUEST['member_3'])) 
        {
            $mem[4]=  mysql_real_escape_string($_REQUEST['member_4']);
            $ptct++;
            $pttk=$mem[4];
        }
        else
        {
            $mem[4]=-1;
        }
        
        if(isset($_REQUEST['member_5'])) 
        {
            $mem[5]=  mysql_real_escape_string($_REQUEST['member_5']);
            $ptct++;
            $pttk=$mem[5];
        }
        else
        {
            $mem[5]=-1;
        }
        
        if(isset($_REQUEST['member_3'])) 
        {
            $mem[3]=  mysql_real_escape_string($_REQUEST['member_3']);
            $ptct++;
            $pttk=$mem[3];
        }
        else
        {
            $mem[3]=-1;
        }
        
        $r= rand(1000,9999);
        $evnt_ls="";
        foreach ($events as $i)
        {
            $evnt_ls=$evnt_ls."_".$i;
        }
        
        
        if($ptct==1)
        {
            $ptsql="SELECT users_name FROM registration WHERE registeration_id='$pttk' LIMIT 1";
            $ptar= mysql_fetch_array(mysql_query($ptsql));
            $team_name=$ptar['users_name'];
            
        }
        $eve=  mysql_real_escape_string($evnt_ls);
        $sql_ins="INSERT INTO team_registration VALUES('','$r','$team_name','$eve','$mem[1]','$mem[2]','$mem[3]','$mem[4]','$mem[5]','-1')";
        mysql_query($sql_ins) or die(mysql_error());
        
        
    }
    else
    {
        header('Location:team_reg.php');
    }


?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="_css/style.css" type="text/css">
        <title>Team Registration - Sankalp 2k13</title>
    </head>
    <body style="background: url('_img/team_back.jpg') fixed no-repeat;">
       
         <a href="logout.php"><div class="logout" title="Click to logout"></div></a> <a href="search.php"><div class="serch" title="Search Student or Team Details"></div></a> <div style="position: fixed; background: url('_img/black.png') repeat; bottom:5px; left: 69px;height: 20px; padding-top: 2px; color: white; font-family: Monospace; border-radius: 5px;">&nbsp;&nbsp;Logged in as <?php echo $_SESSION['op_name'];?>&nbsp;-© Tanay Kumar Bera, Tech-niché, Sankalp-2k13&nbsp;&nbsp;</div>
        <div style="background: url('_img/black.png') repeat; width: 100%; margin-top: 20%; padding-top:  20px; padding-bottom: 20px; height: auto; color: white; ">
            <font face="Calibri"><b>
                <?php if($_REQUEST['ut']==1)
                {
                ?>
                
                <center>||TEAM NAME: &nbsp;&nbsp;<?php echo $team_name;?>&nbsp;&nbsp;|&nbsp;&nbsp;TEAM ID: &nbsp;&nbsp;<?php echo $r;?>||</center>
                <?php
                }
                else
                {
                    echo '<center>|| REGISTRATION SUCCESSFULL | ID: '.$r.' ||</center>';
                }
                ?>
                
            <br/>
            <?php
            for($i=1;$i<=5;$i++)
            {
                if($mem[$i]!=-1)
                {
                    $s="SELECT users_name, users_team FROM registration WHERE registeration_id='$mem[$i]'";
                    $a=  mysql_fetch_array(mysql_query($s)) or die(mysql_error());
                    echo '<br/><center>MEMBER NAME: '.$a['users_name'].' ['.$mem[$i].']</center>';
                    $t=$a['users_team'];
                    if($t==-1)  $t="_".$r;
                    else $t=$t."_".$r;
                    $tt=mysql_real_escape_string($t);
                    
                    date_default_timezone_set('Asia/Calcutta');
                    $up_date=date("Y-m-d H:i:s");
                    $s="UPDATE registration SET users_team='$tt',last_update='$up_date' WHERE registeration_id='$mem[$i]'";
                    mysql_query($s) or die(mysql_error());
                }
            }
            ?>
            <center><a href="event_reg.php"><input type="button" value="OK" class="button blue"/></a></center>
            </b>
            </font>
        </div>
    </body>
</html>
