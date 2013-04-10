<?php
  require_once 'dbconnection.php';

  if(!(isset($_SESSION['op_id']))||!(isset($_REQUEST['eid'])))
      {
          header('Location:index.php');
      }
  
  
      
      
                function iselected($arr,$key)
                {
                    foreach ($arr as $i)
                    {
                        if($i==$key)
                        {
                            return TRUE;
                        }
                    }

                    return FALSE;
                    
                    
                }

      $e_id=$_REQUEST['eid'];
      $tm_ls=array();
      $i=0;
      $sql="SELECT * FROM team_registration ORDER BY reg_order DESC";
      $res=  mysql_query($sql) or die(mysql_error());
      while($a=  mysql_fetch_array($res))
      {
         if($a['event_performed']!=-1)
                {
                    $temp=  str_getcsv($a['event_performed'],'_');
                    foreach ($temp as $t)
                    {
                        $e=str_getcsv($t,'#');
                        $b=  iselected($e,$e_id);
                        if($b)
                        {
                            $tm_ls[$i]=array();
                            $a['event_performed']=$e[1];
                            $tm_ls[$i]=$a;
                            //echo $tm_ls[$i]['event_performed'];
                         //   $tm_ls[$i]['event_performed']="23";//$e[0];
                            $i++;
                            break;
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
        <title></title>
    </head>
    <body style="background: url('_img/bb.jpg') fixed;">
      <a href="logout.php"><div class="logout" title="Click to logout"></div></a> <a href="search.php"><div class="serch" title="Search Student or Team Details"></div></a> <div style="position: fixed; background: url('_img/black.png') repeat; bottom:5px; left: 69px;height: 20px; padding-top: 2px; color: white; font-family: Monospace; border-radius: 5px;">&nbsp;&nbsp;Logged in as <?php echo $_SESSION['op_name'];?>&nbsp;-© Tanay Kumar Bera, Tech-niché, Sankalp-2k13&nbsp;&nbsp;</div>
        <?php
     foreach ($tm_ls as $t)
     {
     ?>
     <div style="background: url('_img/black.png') repeat; border-radius: 5px; margin-top: 10px; width: 90%; height: 100px;  padding-left: 2%; color: white; font-family: monospace; font-weight: bold; font-size: 15px;" >
         <br/>
         TEAM NAME: &nbsp;<?php echo $t['team_name'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TEAM ID:&nbsp;<?php echo $t['team_id'];?>
         <p style="position: relative; float: right; margin-right: 10px;"><?php echo '('.$i--.')';?></p>
         <br/>
         TEAM MEMBERS:&nbsp;&nbsp;&nbsp;|&nbsp;
         <?php
         if($t['member1']>10000000)             echo $t['member1'].'&nbsp;|&nbsp;';
         if($t['member2']>10000000)             echo $t['member2'].'&nbsp;|&nbsp;';
         if($t['member3']>10000000)             echo $t['member3'].'&nbsp;|&nbsp;';
         if($t['member4']>10000000)             echo $t['member4'].'&nbsp;|&nbsp;';
         if($t['member5']>10000000)             echo $t['member5'].'&nbsp;|&nbsp;';
         ?>
         
         <br/>
         SCORED:&nbsp<?php echo $t['event_performed'];?>
     </div>
    <?php
     }
     ?>
    </body>
</html>
