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
    //------------------------- teams-------------------------
    $sq1="SELECT team_id,event_performed FROM team_registration WHERE event_performed <> -1";
    $r1=  mysql_query($sq1) or die(mysql_error());
    $eve=array();
    while($a=  mysql_fetch_array($r1))
    {
        $t=  str_getcsv($a['event_performed'],'_');
        foreach ($t as $j)
        {
            
            $w1=  str_getcsv($j,'#');
            if($w1[0]==$even_id)
            {
                    $eve[$tm_count]=array();
                    
                    $eve[$tm_count][0]=$w1[1];
                    $eve[$tm_count][1]=$a['team_id'];
                    $tm_count++;
            }
        }
        
        
        
        
    }
    
    for($i=0;$i<$tm_count;$i++)
    {
        for($j=0;$j<$tm_count-$i-1; $j++)
        if($eve[$j+1][0]>$eve[$j][0])
        {
            $temp=$eve[$j+1];
            $eve[$j+1]=$eve[$j];
            $eve[$j]=$temp;
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
        
        <div style="position: fixed; background: url('_img/black.png') repeat; top: 5%; height: auto; padding: 2%; color: white; font-family: Monospace; border-radius: 5px;">
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
                        echo '<div  style="'."background: url('_img/black.png')".' repeat; width: 60%; border-radius: 5px;  margin-top: 10px;  padding-bottom: 10px; padding-top: 10px;" >&nbsp;&nbsp;<font color="red" face="Monospace">&nbsp;&nbsp;&nbsp;&nbsp;No teams Performed yet!</font>&nbsp;&nbsp;</div>';
        else
                        echo '<div  style="'."background: url('_img/black.png')".' repeat; width: 60%; border-radius: 5px; margin-top: 10px;  padding-bottom: 10px;  padding-top: 10px;">&nbsp;&nbsp;<font color="white" face="Monospace">&nbsp;&nbsp;&nbsp;&nbsp;Max Scorers for '.$e['event_name'].'. &nbsp;'.$tm_count.' team(s) performed till now.</font>&nbsp;&nbsp;</div>';
     $cnt=1;
     foreach ($eve as $tm)
     {
        
        if(isset($e['event_name']))
        {
     ?>
     <div style="background: url('_img/black.png') repeat; border-radius: 5px; margin-top: 10px; width: 60%; height: auto;  padding-left: 2%; padding-bottom: 20px; color: white; font-family: monospace; font-weight: bold; font-size: 15px;" >
         <br/>
         SCORED:&nbsp<?php echo $tm[0]; if(isset($sct)){ if($sct==$tm[0]) echo '<font color="red">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tied with previous</font>'; else { $sct=$tm[0]; $cnt=$cnt+1;} } else { $sct=$tm[0]; } ?>
         <p style="float: right;">POSITION: <?php echo $cnt;?>&nbsp;&nbsp;</p>
         
         <br/>
         TEAM NAME: &nbsp;<?php $s_t="SELECT * FROM team_registration WHERE team_id='$tm[1]'"; $t=  mysql_fetch_array(mysql_query($s_t)); echo $t['team_name'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TEAM ID:&nbsp;<?php echo $t['team_id'];?>
         
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
         
     </div>
    <?php
     }
     }
           }
     ?>
       
     
   
     
    </body>
</html>
