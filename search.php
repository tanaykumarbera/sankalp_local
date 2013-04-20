<?php
require_once 'dbconnection.php';
    if(isset($_REQUEST['stubtn']))
    {
       if($_REQUEST['op']==1 || $_REQUEST['op']==2)
       {
        if($_REQUEST['op']==1)
        {
            $sql="SELECT * FROM registration WHERE registeration_id='".$_REQUEST['stuid']."'";
        }
        else if($_REQUEST['op']==2)
        {
            $sql="SELECT * FROM registration WHERE users_mail='".$_REQUEST['stuid']."'";
        }
        
        $a=  mysql_query($sql) or die(mysql_error());
        
        if(mysql_num_rows($a)==0)
        {
            $sd=1;
        }
        else 
        {
            $sd=0;
            $b=  mysql_fetch_array($a);
            $evi=  str_getcsv($b['users_events'],'_');
            $ev_ls=array();
            foreach($evi as $e)
            {
                $sqe="SELECT * FROM event_mapping WHERE event_id='$e'";
                $t=  mysql_fetch_array(mysql_query($sqe));
                array_push($ev_ls, $t['event_name']);
            }
            
            $tm_ls= str_getcsv($b['users_team'],'_');
            
            
            
        }
    }
 else if($_REQUEST['op']==4)
 {
     $sql="SELECT * FROM registration WHERE users_name LIKE '%".$_REQUEST['stuid']."%'";
     
     $a=  mysql_query($sql) or die(mysql_error());
        
        if(mysql_num_rows($a)==0)
        {
            $sd=1;
        }
        else 
        {
            $sd=11;
            
            
        }
     
     
     
 }
    else
        {
        
     $s_t="SELECT * FROM team_registration WHERE team_id='".$_REQUEST['stuid']."'";
      $a=  mysql_query($s_t);
      if(mysql_num_rows($a)==0)
        {
            $sd=1;
        }
        else 
        {
            $sd=7;
            $t=  mysql_fetch_array($a);
            $evi=  str_getcsv($t['event_list'],'_');
            $evp=  str_getcsv($t['event_performed'],'_');
            $ev_ls=array();
            $ev_ps=array();
            foreach($evi as $e)
            {
                $sqe="SELECT * FROM event_mapping WHERE event_id='$e'";
                $tmp=  mysql_fetch_array(mysql_query($sqe));
                array_push($ev_ls, $tmp['event_name']);
            }
           
            $evsc=array();
            $i=0;
            foreach($evp as $e)
            {
                $evsc[$i]=array();
                $tt=  str_getcsv($e,'#');
                $sqe="SELECT * FROM event_mapping WHERE event_id='$tt[0]'";
                $tmp=  mysql_fetch_array(mysql_query($sqe));
                $evsc[$i][0]=$tmp['event_name'];
                $evsc[$i][1]=$tt[1];
                array_push($ev_ps,$tmp['event_name']);
                $i++;
            }
          
            $ev_n=array_diff($ev_ls, $ev_ps);
            
            
            
            
        }   
    
        
    }
        
    }
    else
    {
        $sd=3;
    }

    

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="_css/style.css" type="text/css">
        <title></title>
    </head>
    <body style="background: url('_img/search_back.jpg') fixed;">
     <div style="background: url('_img/black.png') repeat; padding-top: 0px; padding-bottom: 0px; padding-left: 40px; padding-right: 40px; border-radius: 10px; position: absolute; top:  10%; left: 10%;"> <img src="_img/sankalp_logo.png"/></div>     
  <div id="src" style="position: absolute;  right: 10%; top: 10%; height: 100px; width: 300px; color: white; font-family: monospace; background: url('_img/black.png') repeat; border-radius: 5px; padding-bottom: 10px; padding-left: 10px; padding-top: 30px;" >      
      <form action="" method="POST">
          <input type="radio" name="op" value="1" checked="checked"/>&nbsp;Registration ID&nbsp;&nbsp;<input type="radio" name="op" value="2"/>&nbsp;User Email&nbsp;&nbsp;<input type="radio" name="op" value="3"/>&nbsp;Team ID&nbsp;&nbsp;<input type="radio" name="op" value="4"/>&nbsp;Name<br/><br/>  
          <input type="text" id="stuid" name="stuid" style="margin-left: 30px; border-radius: 5px;" />&nbsp;&nbsp;&nbsp;
          <input type="submit" name="stubtn" class="button blue" value="GO" style="padding: 0 5px; margin: 0; border-radius: 50px;" /><br/><br/>
                
                
      </form>
  
  </div>
        
<div id="det" style="position: absolute;  right: 10%; top: 45%; height: auto; width: 550px; background: url('_img/black.png') repeat; border-radius: 5px; color: white; font-family: monospace; font-weight: bolder;font-size: 15px; padding: 50px;" >      
<?php
    if($sd==0)
    {
        echo 'Member Registeration ID:&nbsp;'.$b['registeration_id'].'<br/>Registered On '.$b['registered_at'].'<br/>Last Update On '.$b['last_update'].'<br/><br/>Member Name:&nbsp;'.$b['users_name'].'<br/><br/>Institution:<br/>'.$b['users_ins'].'<br/><br/>Contact Info:&nbsp;'.$b['users_mail'].',&nbsp;'.$b['users_no'].'<br/><br/>Payment status: '.$b['users_payment'].'<br/><br/>Participated in:<br/>';    
        foreach ($ev_ls as $s)
        echo $s.',&nbsp;';
        echo '<br/><br/>Registered In Teams:<br/>';
        foreach ($tm_ls as $s)
        echo $s.',&nbsp;';
        //echo '</font>';
    }
    elseif ($sd==7)
    {
         
        echo 'TEAM ID:&nbsp;'.$t['team_id'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TEAM NAME:&nbsp;'.$t['team_name'].'<br/>';
        echo '<br/> TEAM MEMBERS:';
         
         if($t['member1']>1000)             {   $s_m="SELECT users_name FROM registration WHERE registeration_id='".$t['member1']."'";  $u=  mysql_fetch_array(mysql_query($s_m)); echo '<br/>||'.$t['member1'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$u['users_name']; }
         if($t['member2']>1000)             {   $s_m="SELECT users_name FROM registration WHERE registeration_id='".$t['member2']."'";  $u=  mysql_fetch_array(mysql_query($s_m)); echo '<br/>||'.$t['member2'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$u['users_name']; }
         if($t['member3']>1000)             {   $s_m="SELECT users_name FROM registration WHERE registeration_id='".$t['member3']."'";  $u=  mysql_fetch_array(mysql_query($s_m)); echo '<br/>||'.$t['member3'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$u['users_name']; }
         if($t['member4']>1000)             {   $s_m="SELECT users_name FROM registration WHERE registeration_id='".$t['member4']."'";  $u=  mysql_fetch_array(mysql_query($s_m)); echo '<br/>||'.$t['member4'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$u['users_name']; }
         if($t['member5']>1000)             {   $s_m="SELECT users_name FROM registration WHERE registeration_id='".$t['member5']."'";  $u=  mysql_fetch_array(mysql_query($s_m)); echo '<br/>||'.$t['member5'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$u['users_name']; }
         
         
        echo '<br/><br/>TEAM EVENTS:';
        foreach ($ev_n as $evnts)
        {
            echo '<br/>'.$evnts.'&nbsp;[Not Attended]';
        }
       
        foreach ($evsc as $rr)
        {
            if(isset($rr[1]))
            echo '<br/>'.$rr[0].'&nbsp;['.$rr[1].']';
        }
        
    }
    elseif ($sd==11)
    {
        echo '<br/>Following Matches found..<br/>';
        
        while($users=mysql_fetch_array($a))
        {
            echo '<br/><a style="text-decoration: none" href="search.php?stubtn=true&op=1&stuid='.$users['registeration_id'].'">&nbsp;'.$users['users_name'].', SN'.$users['registeration_id'].'&nbsp;('.$users['users_mail'].')</a>';
        }
        
    }
    elseif($sd==1)
    {
        echo '<center><font color="RED"> No records Found :(</font></center>';
    }
    else
    {
        echo '';
    }    
       


?>
</div>
      
    </body>
</html>
