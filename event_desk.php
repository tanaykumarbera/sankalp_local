<?php
  require_once 'dbconnection.php';
  
  
  
  if(!(isset($_SESSION['op_id']))||(($_SESSION['event_id']==1)||($_SESSION['event_id']==-1)))
      {
          header('Location:index.php');
      }

        
      function iskeypresent($arr, $key)
      {
          $ctar=  count($arr);
          for($i=0; $i<$ctar; $i++)
          {
              if($arr[$i]==$key)
                  return TRUE;
          }
          return FALSE;
          
      }


if(($_SESSION['event_id']==0))
{
                if(isset($_REQUEST['evid']))
                {
                    $bo=TRUE;
                    
                    $e_id=$_REQUEST['evid'];
                    
                    if(isset($_REQUEST['evrnd']))
                        {
                            $evrnd=$_REQUEST['evrnd'];
                            $bor=TRUE;
                        }
                        else
                        {
                            $bor=FALSE;
                        }
                }
                else
                {
                    $bo=FALSE;
                }
}
else
{
        $bo=TRUE;
        $e_id=$_SESSION['event_id'];

        
        if(isset($_REQUEST['evrnd']))
        {
        
            $evrnd=$_REQUEST['evrnd'];
            $bor=TRUE;
        }
        else
        {
            $bor=FALSE;
        }
}

if($bo&&$bor)
{
    $eve_ls=array();
      $i=0;
      $sql="SELECT * FROM team_registration ORDER BY reg_order";
      $res=  mysql_query($sql);
      while($a=  mysql_fetch_array($res))
      {
          $temp=  str_getcsv($a['event_list'],'_');
          
         if(iskeypresent($temp,(int) $e_id))
                {
                      $eve_ls[$i]=array();
                      $eve_ls[$i]=$a;
                      $i++;
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
            if($bo)
            {
                if($bor)
                {
                    
                    $sqleve="SELECT event_name FROM event_mapping WHERE event_id LIKE '$e_id'";
                    $reve=  mysql_query($sqleve);
                    $aar=  mysql_fetch_array($reve);
                    $evnam=$aar['event_name'];
        ?>
       
        <div style="width: 100%; height: 100%;">
      
            <a href="#" style="text-decoration: none;"><div style="position: fixed; background: url('_img/black.png') repeat; top:24%; left: 10%; border-top-left-radius:5px; border-bottom-left-radius: 5px; border-top-right-radius: 20px; border-bottom-right-radius: 20px; color: white; height: 30px; width: auto;padding-top: 5px;" onclick="window.top.location.href = 'events_over.php?eid=<?php echo stripslashes(stripslashes($e_id)."&evrnd=".stripslashes($evrnd));?>'">&nbsp;&nbsp;&nbsp;Click here for Teams already performed&nbsp;&nbsp;&nbsp;&nbsp;</div></a>
            <div id="ifm" style="position: fixed;  left: 10%; top: 30%; height: 350px; width: 550px; background: url('_img/black.png') repeat; border-radius: 5px;" >
            
        
        </div>
            <div style="position: fixed; background: url('_img/black.png') repeat; top: 20px; left: 100px; height: auto; padding: 2%; color: white; font-family: Monospace; border-radius: 5px;">
                <br/>Participant List for ROUND <?php echo $evrnd;?><br/><?php echo $evnam;?>
        </div>
        
        
        <div style="position: absolute; right: 5%; margin: 10px auto; height: auto; top: auto; width: 500px; background: url('_img/black.png') repeat; border-radius: 0px;" >
           <?php
            $k=1;
            $et=TRUE;
            $tmtr=0;
            
            foreach($eve_ls as $j)
            {
                $b=TRUE;
               
                if($j['event_performed']!='-1'||$j['event_performed']!="-1"||$j['event_performed']!=-1)
                {
                    $temp=  str_getcsv($j['event_performed'],'_');
               
                    
                    $bb=FALSE;
                    foreach ($temp as $t)
                    {
                        $evarr=str_getcsv($t,'#');
                        
                        if($evarr[0]==$e_id)
                        {
                        
                            if($evarr[2]==$evrnd)
                            {

                                continue 2;
                            }
                            else
                            {
                                if($evarr[2]<$evrnd)
                                {
                                    if($evarr[2]=($evrnd-1))
                                    {
                                        $bb=TRUE;
                                        $tmscr=$evarr[1];
                                        continue;
                                    }
                                  
                                }
                                
                            }
                        }
                        
                        $b=FALSE;
                    }
                    
                    if($bb)
                        $b=FALSE;
                    
                }
                else
                {
                   if($evrnd==1||$evrnd=="1"||$evrnd=='1')
                    $b=FALSE;
                }
                
                if(!$b)
                {
                    $et=FALSE;
                    
                   if($evrnd==1) echo '<a href="#" style="text-decoration: none;"><div id="'.$j['team_id'].'"style="position:relative; margin:10px; width:94%; height:30px; padding-top:5px; background: url('."'_img/white.png'".') repeat; border-radius: 3px;" onclick="ifrm('.$j['team_id'].');"><center><font face="Monospace"><b>['.$k++.']&nbsp;'.$j['team_name'].'&nbsp[ '.$j['team_id'].' ]</b></font></center></div></a>';   
                   else
                   {
                       $tm[$tmtr]=array($j['team_id'],$j['team_name'],$tmscr);
                       $tmtr++;
                   }
                }
                
               // echo '<br/>'.$j['event_list'].'-----fgttft--------'.$j['team_id'];
            }
            
            
            if($evrnd!=1)
            {
                for($i=0;$i<$tmtr;$i++)
                {
                    for($j=0;$j<$tmtr-$i-1; $j++)
                    if($tm[$j+1][2]>$tm[$j][2])
                    {
                        $temp=$tm[$j+1];
                        $tm[$j+1]=$tm[$j];
                        $tm[$j]=$temp;
                    }
                }
                
                if(isset($_REQUEST['limtn']))
                {
                    if($_REQUEST['limit']<=0||($_REQUEST['limit']=="")) { $lim=900; }
                    else $lim=(int) $_REQUEST['limit'];
                        
                }
                else
                {
                    $lim=900;
                }
                
                
                echo '<div style="position: fixed; background: url('."'_img/black.png'".') repeat; top: 20px; left:400px; height: auto; padding: 2%; color: white; font-family: Monospace; border-radius: 5px;">Limit upto top:<br/><form name="lim" action="" method="POST"><input type="number" name="limit"/><input type="submit" name="limtn" value="go"/><input type="hidden" name="evrnd" value="'.$evrnd.'"/><input type="hidden" name="evid" value="'.$_REQUEST['evid'].'"/></form></div>'; 
                $trel=0;
                foreach ($tm as $j)
                {
                   
                    if($trel<$lim) echo '<a href="#" style="text-decoration: none;"><div id="'.$j[0].'"style="position:relative; margin:10px; width:94%; height:30px; padding-top:5px; background: url('."'_img/white.png'".') repeat; border-radius: 3px;" onclick="ifrm('.$j[0].');"><center><font face="Monospace"><b>['.$k++.']&nbsp;'.$j[1].'&nbsp[ '.$j[0].' ]</b> prv score: '.$j[2].'</font></center></div></a>';   
                    else echo '<a href="#" style="text-decoration: none;"><div id="'.$j[0].'"style="position:relative; margin:10px; width:94%; height:30px; padding-top:5px; background: url('."'_img/whired.png'".') repeat; border-radius: 3px;"><center><font face="Monospace"><b>['.$k++.']&nbsp;'.$j[1].'&nbsp[ '.$j[0].' ]</b> prv score: '.$j[2].'</font></center></div></a>';   
                    $trel++;
                }
            }
            
            if($et) echo '<a href="#" style="text-decoration: none;"><div style="position:relative; top: 30%; margin:10px; width:94%; height:50px; padding-top:5px; background: url('."'_img/white.png'".') repeat; border-radius: 3px; color: red;" onclick="window.top.location.href ='."'events_over.php?eid=".$e_id."'".'"><center><font face="Monospace"><b>&nbsp; NO MORE PARTICIPANTS REGISTERED.. Click here.&nbsp;</b></font></center></div></a>';

//echo $eve_ls[0]['event_list'].'-------------'.$eve_ls[0]['team_id'];
            ?>
        
       
        </div>
       </div>

        <?php
            }
            else
                {
                
            ?>
                                <div style="position: fixed; background: url('_img/black.png') repeat; top: 5%; height: auto; padding: 2%; color: white; font-family: Monospace; border-radius: 5px;">
                        EVENT ROUND: <br/><br/>
                        <form id="noid" action="" method="POST">
                        <?php
                                   
                               echo '<input type="radio" name="evrnd" value="1" onclick="'."document.forms['noid'].submit()".'"/>FIRST ROUND<br/><input type="radio" name="evrnd" value="2" onclick="'."document.forms['noid'].submit()".'"/>SECOND ROUND<br/><input type="hidden" name="evid" value="'.$_REQUEST['evid'].'/">';
                                   
                        ?>
               
            </form>
        </div>
                
         <?php
                }
            
            
           }
            else
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
                           echo '<input type="radio" name="evid" value="'.$a['event_id'].'" onclick="'."document.forms['noid'].submit()".'"/>'.$a['event_name'].'<br/>';
                       }
            
            ?>
               
            </form>
        </div>
            <?php
            
            
           }
            ?>
        
    </body>
    
    <script type="text/javascript">
        function ifrm(a)
        {
            document.getElementById("ifm").innerHTML='<iframe style="background-color: transparent; border-radius: 5px; border-width: 0px; height: 350px; width: 550px;" src="team_detail.php?eve=<?php echo $e_id;?>&tm='+a+'&evrnd=<?php echo $evrnd;?>"></iframe>';
        }
        
        
        
   </script>
</html>



