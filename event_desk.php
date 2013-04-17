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
        ?>
       
        <div style="width: 100%; height: 100%;">
      
            <a href="#" style="text-decoration: none;"><div style="position: fixed; background: url('_img/black.png') repeat; top:24%; left: 10%; border-top-left-radius:5px; border-bottom-left-radius: 5px; border-top-right-radius: 20px; border-bottom-right-radius: 20px; color: white; height: 30px; width: auto;padding-top: 5px;" onclick="window.top.location.href = 'events_over.php?eid=<?php echo $e_id;?>';"> &nbsp;&nbsp;&nbsp;Click here for Teams already performed&nbsp;&nbsp;&nbsp;&nbsp;</div></a>
            <div id="ifm" style="position: fixed;  left: 10%; top: 30%; height: 350px; width: 550px; background: url('_img/black.png') repeat; border-radius: 5px;" >
            
        
        </div>
        
        
        <div style="position: absolute; right: 10%; margin: 10px auto; height: auto; top: auto; width: 300px; background: url('_img/black.png') repeat; border-radius: 0px;" >
           <?php
            $k=1;
            $et=TRUE;
        
            
            foreach($eve_ls as $j)
            {
                $b=TRUE;
                if($j['event_performed']!=-1)
                {
                    $temp=  str_getcsv($j['event_performed'],'_');
                    foreach ($temp as $t)
                    {
                        $evarr=str_getcsv($t,'#');
                        if($evrnd==1)
                        $b=  ($evarr[0]==$e_id); //1st
                        else if($evrnd==2)
                        $b= ($evarr[0]==$e_id &&  $evarr[2]==1); //2nd
                        if($b) break;
                    }
                    
                }
                else
                {
                    $b=FALSE;
                }
                
                if(!$b)
                {
                    $et=FALSE;
                    echo '<a href="#" style="text-decoration: none;"><div id="'.$j['team_id'].'"style="position:relative; margin:10px; width:94%; height:30px; padding-top:5px; background: url('."'_img/white.png'".') repeat; border-radius: 3px;" onclick="ifrm('.$j['team_id'].');"><center><font face="Monospace"><b>['.$k++.']&nbsp;'.$j['team_name'].'&nbsp[ '.$j['team_id'].' ]</b></font></center></div></a>';   
                }
                
               // echo '<br/>'.$j['event_list'].'-----fgttft--------'.$j['team_id'];
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



