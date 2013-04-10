<?php
    require_once 'dbconnection.php';
   // $bf=TRUE;
    if($_SESSION['event_id']>1)
    {
        $even_id=$_SESSION['event_id'];
    }
    else
    {
        if(isset($_REQUEST['eeid']))
        {
            $admin=FALSE;
            $even_id=$_REQUEST['eeid'];
        }
        else
        {
            $admin=TRUE;
        }
    }
   
    
    $tm_count=0;
    //-------------------------1st position-------------------------
    $sq1="SELECT team_id,event_performed FROM team_registration WHERE event_performed <> -1";
    $r1=  mysql_query($sq1) or die(mysql_error());
    $eve1=array();
    while($a=  mysql_fetch_array($r1))
    {
        $t=  str_getcsv($a['event_performed'],'_');
        foreach ($t as $j)
        {
            
            $w1=  str_getcsv($j,'#');
            if($w1[0]==$even_id)
            {
            $tm_count++;
            if(isset($eve1[$w1[0]]))
            {
                if($eve1[$w1[0]][1]<$w1[1])
                {
                    $eve1[$w1[0]][0]=$a['team_id'];
                    $eve1[$w1[0]][1]=$w1[1];
                    $eve1[$w1[0]][2]=$w1[0];
                }
            }
            else
            {
                $eve1[$w1[0]]=array();
                $eve1[$w1[0]][0]=$a['team_id'];
                $eve1[$w1[0]][1]=$w1[1];
                $eve1[$w1[0]][2]=$w1[0];
            }
            }
        }
        
        
        
        
    }
    
    //----------------2nd position----------------------
    $sq2="SELECT team_id,event_performed FROM team_registration WHERE event_performed <> -1";
    $r2=  mysql_query($sq2) or die(mysql_error());
    $eve2=array();
    while($a=  mysql_fetch_array($r2))
    {
        $t=  str_getcsv($a['event_performed'],'_');
        foreach ($t as $j)
        {
            
            $w1=  str_getcsv($j,'#');
            if($w1[0]==$even_id)
            {
            if($eve1[$w1[0]][0]!=$a['team_id'])
            {
            if(isset($eve2[$w1[0]]))
            {
                if($eve2[$w1[0]][1]<$w1[1])
                {
                    $eve2[$w1[0]][0]=$a['team_id'];
                    $eve2[$w1[0]][1]=$w1[1];
                    $eve2[$w1[0]][2]=$w1[0];
                }
            }
            else
            {
                $eve2[$w1[0]]=array();
                $eve2[$w1[0]][0]=$a['team_id'];
                $eve2[$w1[0]][1]=$w1[1];
                $eve2[$w1[0]][2]=$w1[0];
            }
            }
            }
        }
        
        
        
        
    }
    
    //---------------------3rd position--------------------------
    $sq3="SELECT team_id,event_performed FROM team_registration WHERE event_performed <> -1";
    $r3=  mysql_query($sq3) or die(mysql_error());
    $eve3=array();
    while($a=  mysql_fetch_array($r3))
    {
        $t=  str_getcsv($a['event_performed'],'_');
        foreach ($t as $j)
        {
            
            $w1=  str_getcsv($j,'#');
            if($w1[0]==$even_id)
            {
            if(($eve1[$w1[0]][0]!=$a['team_id'])&&($eve2[$w1[0]][0]!=$a['team_id']))
            {
            if(isset($eve3[$w1[0]]))
            {
                if($eve3[$w1[0]][1]<$w1[1])
                {
                    $eve3[$w1[0]][0]=$a['team_id'];
                    $eve3[$w1[0]][1]=$w1[1];
                    $eve3[$w1[0]][2]=$w1[0];
                }
            }
            else
            {
                $eve3[$w1[0]]=array();
                $eve3[$w1[0]][0]=$a['team_id'];
                $eve3[$w1[0]][1]=$w1[1];
                $eve3[$w1[0]][2]=$w1[0];
            }
            }
            }
        }
        
        
        
        
    }

    

    
    
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="_css/style.css" type="text/css">
        <title>Winner</title>
    </head>
    <body style="background: url('_img/win_back.jpg') center no-repeat fixed;">
       
        <?php
            if($admin)
            {
                $sq_admn="SELECT * FROM event_mapping";
                $r=  mysql_query($sq_admn);
        ?>
        
        <div style="position: absolute; background: url('_img/black.png') repeat; top: 5%; height: auto; padding: 2%; color: white; font-family: Monospace; border-radius: 5px;">
            choose the events below:<br/><br/>
            <form id="noid" action="" method="POST">
            <?php
                       while ($a=  mysql_fetch_array($r))
                       {
                           echo '<input type="radio" name="eeid" value="'.$a['event_id'].'" onclick="'."document.forms['noid'].submit()".'"/>'.$a['event_name'].'<br/>';
                       }
            
            ?>
               
            </form>
        </div>
            <?php
            
            
           }
           else 
           {
        ?>
        
        
        
        
        <?php
        $s_e="SELECT event_name FROM event_mapping WHERE event_id='$even_id'"; $e=  mysql_fetch_array(mysql_query($s_e));         
        if($tm_count==0)
                        echo '<div  class="notification" style="position: absolute; top: 10px; left: 10px;" >&nbsp;&nbsp;<font color="red" face="Monospace">No teams Performed yet!</font>&nbsp;&nbsp;</div>';
        else
                        echo '<div  class="notification" style="position: absolute; top: 10px; left: 10px;">&nbsp;&nbsp;<font color="white" face="Monospace">Max Scorers for '.$e['event_name'].'. &nbsp;'.$tm_count.' team(s) performed till now.</font>&nbsp;&nbsp;</div>';
     
     foreach ($eve1 as $tm)
     {
        
        if(isset($e['event_name']))
        {
     ?>
     <div style="background: url('_img/black.png') repeat; border-radius: 5px; margin-top: 50px; width: 60%; height: auto;  padding-left: 2%; padding-bottom: 20px; color: white; font-family: monospace; font-weight: bold; font-size: 15px;" >
         <br/>
         WINNER 1:
         EVENT: &nbsp;<?php echo $e['event_name'];?>
         <br/>
         TEAM NAME: &nbsp;<?php $s_t="SELECT * FROM team_registration WHERE team_id='$tm[0]'"; $t=  mysql_fetch_array(mysql_query($s_t)); echo $t['team_name'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TEAM ID:&nbsp;<?php echo $t['team_id'];?>
         
         <br/>
         TEAM MEMBERS:
         <?php
            
         
         if($t['member1']>10000000)             {   $s_m="SELECT users_name FROM registration WHERE registeration_id='".$t['member1']."'";  $u=  mysql_fetch_array(mysql_query($s_m)); echo '<br/>||'.$t['member1'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$u['users_name']; }
         if($t['member2']>10000000)             {   $s_m="SELECT users_name FROM registration WHERE registeration_id='".$t['member2']."'";  $u=  mysql_fetch_array(mysql_query($s_m)); echo '<br/>||'.$t['member2'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$u['users_name']; }
         if($t['member3']>10000000)             {   $s_m="SELECT users_name FROM registration WHERE registeration_id='".$t['member3']."'";  $u=  mysql_fetch_array(mysql_query($s_m)); echo '<br/>||'.$t['member3'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$u['users_name']; }
         if($t['member4']>10000000)             {   $s_m="SELECT users_name FROM registration WHERE registeration_id='".$t['member4']."'";  $u=  mysql_fetch_array(mysql_query($s_m)); echo '<br/>||'.$t['member4'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$u['users_name']; }
         if($t['member5']>10000000)             {   $s_m="SELECT users_name FROM registration WHERE registeration_id='".$t['member5']."'";  $u=  mysql_fetch_array(mysql_query($s_m)); echo '<br/>||'.$t['member5'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$u['users_name']; }
         ?>
         
         <br/>
         SCORED:&nbsp<?php echo $tm[1]; $sc1=$tm[1];?>
     </div>
    <?php
     }
     }
     ?>
     <!----------------------------------------------------------------------------------------->  
     
        <?php
            
     foreach ($eve2 as $tm)
     {
       // $s_e="SELECT event_name FROM event_mapping WHERE event_id='$tm[2]'"; $e=  mysql_fetch_array(mysql_query($s_e));  
        if(isset($e['event_name']))
        {
     ?>
     <div style="background: url('_img/black.png') repeat; border-radius: 5px; margin-top: 10px; width: 60%; height: auto;  padding-left: 2%; padding-bottom: 20px; color: white; font-family: monospace; font-weight: bold; font-size: 15px;" >
         <br/>
         WINNER 2:
         EVENT: &nbsp;<?php echo $e['event_name'];?>
         <br/>
         TEAM NAME: &nbsp;<?php $s_t="SELECT * FROM team_registration WHERE team_id='$tm[0]'"; $t=  mysql_fetch_array(mysql_query($s_t)); echo $t['team_name'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TEAM ID:&nbsp;<?php echo $t['team_id'];?>
         
         <br/>
         TEAM MEMBERS:
         <?php
            
         
         if($t['member1']>10000000)             {   $s_m="SELECT users_name FROM registration WHERE registeration_id='".$t['member1']."'";  $u=  mysql_fetch_array(mysql_query($s_m)); echo '<br/>||'.$t['member1'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$u['users_name']; }
         if($t['member2']>10000000)             {   $s_m="SELECT users_name FROM registration WHERE registeration_id='".$t['member2']."'";  $u=  mysql_fetch_array(mysql_query($s_m)); echo '<br/>||'.$t['member2'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$u['users_name']; }
         if($t['member3']>10000000)             {   $s_m="SELECT users_name FROM registration WHERE registeration_id='".$t['member3']."'";  $u=  mysql_fetch_array(mysql_query($s_m)); echo '<br/>||'.$t['member3'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$u['users_name']; }
         if($t['member4']>10000000)             {   $s_m="SELECT users_name FROM registration WHERE registeration_id='".$t['member4']."'";  $u=  mysql_fetch_array(mysql_query($s_m)); echo '<br/>||'.$t['member4'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$u['users_name']; }
         if($t['member5']>10000000)             {   $s_m="SELECT users_name FROM registration WHERE registeration_id='".$t['member5']."'";  $u=  mysql_fetch_array(mysql_query($s_m)); echo '<br/>||'.$t['member5'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$u['users_name']; }
         ?>
         
         <br/>
         SCORED:&nbsp<?php echo $tm[1]; $sc2=$tm[1]; if($sc1==$sc2) echo '&nbsp&nbsp;<font color="RED">Tied with winner 1.</font>';?>
     </div>
    <?php
     }
     }
     ?>
     
     <!----------------------------------------------------------------------->
     
        <?php
            
     foreach ($eve3 as $tm)
     {
    //    $s_e="SELECT event_name FROM event_mapping WHERE event_id='$tm[2]'"; $e=  mysql_fetch_array(mysql_query($s_e));  
        if(isset($e['event_name']))
        {
     ?>
     <div style="background: url('_img/black.png') repeat; border-radius: 5px; margin-top: 10px; width: 60%; height: auto;  padding-left: 2%; padding-bottom: 20px; color: white; font-family: monospace; font-weight: bold; font-size: 15px;" >
         <br/>
         WINNER 3:
         EVENT: &nbsp;<?php echo $e['event_name'];?>
         <br/>
         TEAM NAME: &nbsp;<?php $s_t="SELECT * FROM team_registration WHERE team_id='$tm[0]'"; $t=  mysql_fetch_array(mysql_query($s_t)); echo $t['team_name'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TEAM ID:&nbsp;<?php echo $t['team_id'];?>
         
         <br/>
         TEAM MEMBERS:
         <?php
            
         
         if($t['member1']>10000000)             {   $s_m="SELECT users_name FROM registration WHERE registeration_id='".$t['member1']."'";  $u=  mysql_fetch_array(mysql_query($s_m)); echo '<br/>||'.$t['member1'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$u['users_name']; }
         if($t['member2']>10000000)             {   $s_m="SELECT users_name FROM registration WHERE registeration_id='".$t['member2']."'";  $u=  mysql_fetch_array(mysql_query($s_m)); echo '<br/>||'.$t['member2'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$u['users_name']; }
         if($t['member3']>10000000)             {   $s_m="SELECT users_name FROM registration WHERE registeration_id='".$t['member3']."'";  $u=  mysql_fetch_array(mysql_query($s_m)); echo '<br/>||'.$t['member3'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$u['users_name']; }
         if($t['member4']>10000000)             {   $s_m="SELECT users_name FROM registration WHERE registeration_id='".$t['member4']."'";  $u=  mysql_fetch_array(mysql_query($s_m)); echo '<br/>||'.$t['member4'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$u['users_name']; }
         if($t['member5']>10000000)             {   $s_m="SELECT users_name FROM registration WHERE registeration_id='".$t['member5']."'";  $u=  mysql_fetch_array(mysql_query($s_m)); echo '<br/>||'.$t['member5'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$u['users_name']; }
         ?>
         
         <br/>
         SCORED:&nbsp<?php echo $tm[1]; $tie=$tm[1]; if($tie==$sc2) echo '&nbsp&nbsp;<font color="RED">Tied with winner 2.</font>';?>
         
     </div>
    <?php
     }
     }
     
     //tie contition----------------------------
         //-----------------------------tie condition----------------------
    $sq4="SELECT * FROM team_registration WHERE event_performed <> -1";
    $r4=  mysql_query($sq4) or die(mysql_error());
    
    while($a=  mysql_fetch_array($r4))
    {
        $t=  str_getcsv($a['event_performed'],'_');
        foreach ($t as $j)
        {
             
            $w1=  str_getcsv($j,'#');
            if(($w1[0]==$even_id)&&($tie==$w1[1]))
            {
            if(($eve1[$w1[0]][0]!=$a['team_id'])&&($eve2[$w1[0]][0]!=$a['team_id'])&&($eve3[$w1[0]][0]!=$a['team_id']))
            {
              //  $bf=TRUE;
            ?>
     
     <div style="background: url('_img/black.png') repeat; border-radius: 5px; margin-top: 10px; width: 60%; height: auto;  padding-left: 2%; padding-bottom: 20px; color: white; font-family: monospace; font-weight: bold; font-size: 15px;" >
         <br/>
         TIER TEAM :
         EVENT: &nbsp;<?php echo $e['event_name'];?>
         <br/>
         TEAM NAME: &nbsp;<?php echo $a['team_name'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TEAM ID:&nbsp;<?php echo $a['team_id'];?>
         
         <br/>
         TEAM MEMBERS:
         <?php
            
         
         if($a['member1']>10000000)             {   $s_m="SELECT users_name FROM registration WHERE registeration_id='".$a['member1']."'";  $u=  mysql_fetch_array(mysql_query($s_m)); echo '<br/>||'.$a['member1'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$u['users_name']; }
         if($a['member2']>10000000)             {   $s_m="SELECT users_name FROM registration WHERE registeration_id='".$a['member2']."'";  $u=  mysql_fetch_array(mysql_query($s_m)); echo '<br/>||'.$a['member2'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$u['users_name']; }
         if($a['member3']>10000000)             {   $s_m="SELECT users_name FROM registration WHERE registeration_id='".$a['member3']."'";  $u=  mysql_fetch_array(mysql_query($s_m)); echo '<br/>||'.$a['member3'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$u['users_name']; }
         if($a['member4']>10000000)             {   $s_m="SELECT users_name FROM registration WHERE registeration_id='".$a['member4']."'";  $u=  mysql_fetch_array(mysql_query($s_m)); echo '<br/>||'.$a['member4'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$u['users_name']; }
         if($a['member5']>10000000)             {   $s_m="SELECT users_name FROM registration WHERE registeration_id='".$a['member5']."'";  $u=  mysql_fetch_array(mysql_query($s_m)); echo '<br/>||'.$a['member5'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$u['users_name']; }
         ?>
         
         <br/>
         SCORED:&nbsp<?php echo $tie; echo '&nbsp&nbsp;<font color="RED">Tied with winner 3.</font>';?>
       
         
     </div>
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     <?php
            }
        }
        
    }
    } 
     
    
           } 
     
     ?>
     
     
    </body>
</html>
