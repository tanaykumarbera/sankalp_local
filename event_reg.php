<?php
require_once 'dbconnection.php';

if(!(isset($_SESSION['op_id']))||(($_SESSION['event_id']!=-1)&&($_SESSION['event_id']!=0)))
      {
          header('Location:index.php');
      }

      
                function iset($v)
                {
                    if(($v=="")||($v=='')||($v==" ")||($v==' '))
                    {
                        return FALSE;
                    }
                else
                    {
                        return TRUE;
                    }

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
                $mem=array();
                $eve=array();
               
                
                
                $mem[1]=$mem[2]=$mem[3]=$mem[4]=$mem[5]=-1;
                $st_cnt=0;
                if(iset($_REQUEST['memid_1'])) { $mem[1]=$_REQUEST['memid_1']; $boool=TRUE; $st_cnt++; }
                if(iset($_REQUEST['memid_2'])) { $mem[2]=$_REQUEST['memid_2']; $boool=TRUE; $st_cnt++; }
                if(iset($_REQUEST['memid_3'])) { $mem[3]=$_REQUEST['memid_3']; $boool=TRUE; $st_cnt++; }
                if(iset($_REQUEST['memid_4'])) { $mem[4]=$_REQUEST['memid_4']; $boool=TRUE; $st_cnt++; }
                if(iset($_REQUEST['memid_5'])) { $mem[5]=$_REQUEST['memid_5']; $boool=TRUE; $st_cnt++; }
                
                
                
                
                
                 if(isset($_REQUEST['mem_sbtn']) && $boool)
                        {
                            $sq="SELECT event_id FROM event_mapping";
                            $r=  mysql_query($sq);
                            $ul=array();
                            while($fd=mysql_fetch_array($r))
                                {
                                array_push($ul, $fd['event_id']);
                                }
                            $event_ls=array();
                            $event_reg=array();
                            $users_team=array();
                            for($i=1;$i<=5;$i++)
                            {
                              $event_reg[$i]=array();
                              $users_team[$i]=array();
                              $sq_eve="SELECT users_events, users_team, users_payment FROM registration WHERE registeration_id='$mem[$i]'";
                              $res=  mysql_query($sq_eve);
                              if((mysql_num_rows($res)==0))
                              {
                                  $mem[$i]=-2;
                                  
                                  continue;
                              }
                              
                              
                                                       
                              $stu=mysql_fetch_array($res);
                              
                              
                              $event_ls[$i]=str_getcsv($stu['users_events'], '_');
                              
                              
                              
                              if($stu['users_payment']<50)
                              {
                                  $mem[$i]=-9;
                                  
                                  continue;
                                  
                              }
                              
                             
                              
                              
                              if($stu['users_team']==-1)
                              {
                                 $ul= array_intersect($ul,$event_ls[$i]);
                              }
                              else
                              {
                              $users_team[$i]=str_getcsv($stu['users_team'], '_');
                            
                              foreach ($users_team[$i] as $f)
                              {
                              $sq_tm="SELECT event_list FROM team_registration WHERE team_id='$f'";
                              $res_tm= mysql_query($sq_tm);
                              if((mysql_num_rows($res_tm)>0))
                              {   
                                 $stu_eve=mysql_fetch_array($res_tm);
                                 $t=str_getcsv($stu_eve['event_list'], '_');
                                  
                                  
                                 foreach ($t as $w)
                                 {
                                     array_push($event_reg[$i], $w);
                                     
                                 }
                                
                                  
                              }
                              
                              }
                              
                             
                              $ul= array_intersect($ul, array_diff($event_ls[$i],$event_reg[$i]));
                              //array_diff($event_ls[$i],$event_reg[$i])
                              }
                            }
                            
                                
                               
                           
                        }
                       
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="_css/style.css" type="text/css">
        <title>Sankalp 2k13 - Team Registration</title>
    </head>
    <body style="background: url('_img/team_back.jpg') fixed no-repeat;" <?php if($st_cnt >= 1) echo 'onload="amt_cal();"';?> >
      <a href="logout.php"><div class="logout" title="Click to logout"></div></a> <a href="search.php"><div class="serch" title="Search Student or Team Details"></div></a> <div style="position: fixed; background: url('_img/black.png') repeat; bottom:5px; left: 69px;height: 20px; padding-top: 2px; color: white; font-family: Monospace; border-radius: 5px;">&nbsp;&nbsp;Logged in as <?php echo $_SESSION['op_name'];?>&nbsp;-© Tanay Kumar Bera, Tech-niché, Sankalp-2k13&nbsp;&nbsp;</div>
        <div style="<?php if(isset($_REQUEST['mem_sbtn'])&& $boool) echo 'margin: 2% auto;'; else echo 'margin: 20% auto;';?> width: 100%; height: auto; background: url('_img/black.png') repeat; padding-top: 20px; color: white;">
            <font face="Calibri">
              <form name="mem_list" action="" method="POST">
                  
                <center>
            <table  style="position: relative; color: white; ">
            <tr>
                <td >
                    Member 01:&nbsp;&nbsp;
                </td>
                <td>
                    <input type="text" name="memid_1" class="box" size="25" onclick="this.value=''" <?php if(iset($_REQUEST['memid_1'])) { if($mem[1]==-2) { echo 'value="INVALID ID" style="background-color: #ffcccc; color: red;"'; $boool=FALSE; } else if($mem[1]==-5) { echo 'value="'.$_REQUEST['memid_1'].' - Rs.50 due" style="background-color: #ffcccc; color: red;"'; $boool=FALSE; } else if($mem[1]==-9) { echo 'value="'.$_REQUEST['memid_1'].' - NOT PAID" style="background-color: #ffcccc; color: red;"'; $boool=FALSE; } else echo 'value="'.$_REQUEST['memid_1'].'" style="background-color: #ccffcc; color: green;"'; }?>/>
                </td>
                <?php
                    if(isset($_REQUEST['mem_sbtn']))
                    {
                     
                ?>
                 <td>
                        events :
                        <?php
                        if(iset($_REQUEST['memid_1']))
                        {
                           
                            $sql="SELECT * FROM event_mapping WHERE event_id='-1'";
                            foreach($event_ls[1] as $q)
                                {
                                    $sql=$sql." OR event_id='$q'";
                                }
                              
                            $r=  mysql_query($sql);
                           
                            while($ar=mysql_fetch_array($r))
                            {
                                if(iselected($ul, $ar['event_id']))
                                {
                                    echo '&nbsp; <font color="lawngreen">'.$ar['event_name'].'</font>';
                                }
                                else if(iselected($event_reg[1], $ar['event_id']))
                                {
                                    echo '&nbsp; <font color="blue">'.$ar['event_name'].'</font>';
                                }
                                else
                                {
                                    echo '&nbsp; <font color="red">'.$ar['event_name'].'</font>';
                                }
                                 
                            }
                        }
                         ?>
                   
                 </td>
                <?php
                        
                    }
                ?>
            </tr>
            
            <tr>
                <td >
                    Member 02:&nbsp;&nbsp;
                </td>
                <td >
                    <input type="text" name="memid_2" class="box" size="25" onclick="this.value=''" <?php if(iset($_REQUEST['memid_2'])) { if($mem[2]==-2) { echo 'value="INVALID ID" style="background-color: #ffcccc; color: red;"'; $boool=FALSE; } else if($mem[2]==-5) { echo 'value="'.$_REQUEST['memid_2'].' - Rs.50 due" style="background-color: #ffcccc; color: red;"'; $boool=FALSE; } else if($mem[2]==-9) { echo 'value="'.$_REQUEST['memid_2'].' - NOT PAID" style="background-color: #ffcccc; color: red;"'; $boool=FALSE; } else echo 'value="'.$_REQUEST['memid_2'].'" style="background-color: #ccffcc; color: green;"'; }?>/>
                </td>
                
                <?php
                    if(isset($_REQUEST['mem_sbtn']))
                    {
                     
                ?>
                 <td>
                        events :
                        <?php
                         if(iset($_REQUEST['memid_2']))
                        {
                           
                            $sql="SELECT * FROM event_mapping WHERE event_id='-1'";
                            foreach($event_ls[2] as $q)
                                {
                                    $sql=$sql." OR event_id='$q'";
                                }
                              
                            $r=  mysql_query($sql);
                           
                            while($ar=mysql_fetch_array($r))
                            {
                                if(iselected($ul, $ar['event_id']))
                                {
                                    echo '&nbsp; <font color="lawngreen">'.$ar['event_name'].'</font>';
                                }
                                else if(iselected($event_reg[2], $ar['event_id']))
                                {
                                    echo '&nbsp; <font color="blue">'.$ar['event_name'].'</font>';
                                }
                                else
                                {
                                    echo '&nbsp; <font color="red">'.$ar['event_name'].'</font>';
                                }
                                 
                            }
                        }
                         ?>
                   
                 </td>
                <?php
                        
                    }
                ?>
            </tr>
            
            <tr>
                <td >
                    Member 03:&nbsp;&nbsp;
                </td>
                <td >
                    <input type="text" name="memid_3" class="box" size="25" onclick="this.value=''" <?php if(iset($_REQUEST['memid_3'])) { if($mem[3]==-2) { echo 'value="INVALID ID" style="background-color: #ffcccc; color: red;"'; $boool=FALSE; } else if($mem[3]==-5) { echo 'value="'.$_REQUEST['memid_3'].' - Rs.50 due" style="background-color: #ffcccc; color: red;"'; $boool=FALSE; } else if($mem[3]==-9) { echo 'value="'.$_REQUEST['memid_3'].' - NOT PAID" style="background-color: #ffcccc; color: red;"'; $boool=FALSE; } else echo 'value="'.$_REQUEST['memid_3'].'" style="background-color: #ccffcc; color: green;"'; }?>/>
                </td>
                <?php
                    if(isset($_REQUEST['mem_sbtn']))
                    {
                     
                ?>
                 <td>
                        events :
                        <?php
                         if(iset($_REQUEST['memid_3']))
                        {
                           
                            $sql="SELECT * FROM event_mapping WHERE event_id='-1'";
                            foreach($event_ls[3] as $q)
                                {
                                    $sql=$sql." OR event_id='$q'";
                                }
                              
                            $r=  mysql_query($sql);
                           
                            while($ar=mysql_fetch_array($r))
                            {
                                if(iselected($ul, $ar['event_id']))
                                {
                                    echo '&nbsp; <font color="lawngreen">'.$ar['event_name'].'</font>';
                                }
                                else if(iselected($event_reg[3], $ar['event_id']))
                                {
                                    echo '&nbsp; <font color="blue">'.$ar['event_name'].'</font>';
                                }
                                else
                                {
                                    echo '&nbsp; <font color="red">'.$ar['event_name'].'</font>';
                                }
                                 
                            }
                        }
                         ?>
                   
                 </td>
                <?php
                        
                    }
                ?>
            </tr>
            
            <tr>
                <td >
                    Member 04:&nbsp;&nbsp;
                </td>
                <td >
                    <input type="text" name="memid_4" class="box"  size="25" onclick="this.value=''" <?php if(iset($_REQUEST['memid_4'])) { if($mem[4]==-2) { echo 'value="INVALID ID" style="background-color: #ffcccc; color: red;"'; $boool=FALSE; } else if($mem[4]==-5) { echo 'value="'.$_REQUEST['memid_4'].' - Rs.50 due" style="background-color: #ffcccc; color: red;"'; $boool=FALSE; } else if($mem[4]==-9) { echo 'value="'.$_REQUEST['memid_4'].' - NOT PAID" style="background-color: #ffcccc; color: red;"'; $boool=FALSE; } else echo 'value="'.$_REQUEST['memid_4'].'" style="background-color: #ccffcc; color: green;"'; }?>/>
                </td>
                <?php
                    if(isset($_REQUEST['mem_sbtn']))
                    {
                     
                ?>
                 <td>
                        events :
                        <?php
                         if(iset($_REQUEST['memid_4']))
                        {
                           
                            $sql="SELECT * FROM event_mapping WHERE event_id='-1'";
                            foreach($event_ls[4] as $q)
                                {
                                    $sql=$sql." OR event_id='$q'";
                                }
                              
                            $r=  mysql_query($sql);
                           
                            while($ar=mysql_fetch_array($r))
                            {
                                if(iselected($ul, $ar['event_id']))
                                {
                                    echo '&nbsp; <font color="lawngreen">'.$ar['event_name'].'</font>';
                                }
                                else if(iselected($event_reg[4], $ar['event_id']))
                                {
                                    echo '&nbsp; <font color="blue">'.$ar['event_name'].'</font>';
                                }
                                else
                                {
                                    echo '&nbsp; <font color="red">'.$ar['event_name'].'</font>';
                                }
                                 
                            }
                        }
                         ?>
                   
                 </td>
                <?php
                        
                    }
                ?>
                
            </tr>
            
            <tr>
                <td >
                    Member 05:&nbsp;&nbsp;
                </td>
                <td >
                    <input type="text" name="memid_5" class="box" size="25" onclick="this.value=''" <?php if(iset($_REQUEST['memid_5'])) { if($mem[5]==-2) { echo 'value="INVALID ID" style="background-color: #ffcccc; color: red;"'; $boool=FALSE; }  else if($mem[5]==-5) { echo 'value="'.$_REQUEST['memid_5'].' - Rs.50 due" style="background-color: #ffcccc; color: red;"'; $boool=FALSE; } else if($mem[5]==-9) { echo 'value="'.$_REQUEST['memid_5'].' - NOT PAID" style="background-color: #ffcccc; color: red;"'; $boool=FALSE; } else echo 'value="'.$_REQUEST['memid_5'].'" style="background-color: #ccffcc; color: green;"'; }?> />
                </td>
                 <?php
                    if(isset($_REQUEST['mem_sbtn']))
                    {
                     
                ?>
                 <td>
                        events :
                        <?php
                         if(iset($_REQUEST['memid_5']))
                        {
                           
                            $sql="SELECT * FROM event_mapping WHERE event_id='-1'";
                            foreach($event_ls[5] as $q)
                                {
                                    $sql=$sql." OR event_id='$q'";
                                }
                              
                            $r=  mysql_query($sql);
                           
                            while($ar=mysql_fetch_array($r))
                            {
                                if(iselected($ul, $ar['event_id']))
                                {
                                    echo '&nbsp; <font color="lawngreen">'.$ar['event_name'].'</font>';
                                }
                                else if(iselected($event_reg[5], $ar['event_id']))
                                {
                                    echo '&nbsp; <font color="blue">'.$ar['event_name'].'</font>';
                                }
                                else
                                {
                                    echo '&nbsp; <font color="red">'.$ar['event_name'].'</font>';
                                }
                                 
                            }
                        }
                         ?>
                   
                 </td>
                <?php
                        
                    }
                ?>
            </tr>
            </table>
           </center>
              
                
                <center> <input type="submit" name="mem_sbtn" value="GO" class="button blue"/></center>     
                
                </form>
                
            </font>
        </div>
        
        <div style="margin-top: 20px; width: 100%;">
            
            <?php
                if(isset($_REQUEST['mem_sbtn'])&& $boool)
                {
                    
             ?>
           
            <div style="position:relative; padding-left: 40%; padding-top: 20px; padding-bottom:20px; height: auto; background: url('_img/black.png') repeat; color: white;" >
                <form name="team_details" action="<?php if($st_cnt > 1) echo 'post_team.php?ut=1';else echo 'post_team.php?ut=2';?>" method="POST" onsubmit="javascript:subb();return false;">
                <font face="Calibri"><b>
                    <?php
                    
                            for($i=1;$i<=5;$i++)
                            {
                                if(($mem[$i]!=-1)&&($mem[$i]!=-2))
                                {
                                    echo '<input type="hidden" name="member_'.$i.'" value="'.$mem[$i].'"/>';
                                }
                                        
                            }
                        
                            echo '<u>Choose the team events:</u><br/><br/>';
                        $sq_eve="SELECT * FROM event_mapping WHERE event_id='-1'";
                        foreach ($ul as $j)
                        {
                            $sq_eve=$sq_eve."OR event_id='$j'";
                        }
                        $res=  mysql_query($sq_eve);
                        $newbool=FALSE;
                        while ($a=mysql_fetch_array($res))
                        {
                            if($st_cnt > 1)
                            {
                                if($a['event_id']==36||$a['event_id']==35||$a['event_id']==30)
                                    continue;
                            }
                            else
                            {
                                if($a['event_id']!=36&&$a['event_id']!=35&&$a['event_id']!=30&&$a['event_id']!=38)
                                    continue;
                            }
                            $newbool=TRUE;
                            echo '<input type="checkbox" name="events[]" value="'.$a['event_id'].'" checked="checked" onclick="amt_cal();"/><input type="hidden" id = "ev'.$a['event_id'].'" value = "'.$a['Amount'].'"/> &nbsp;&nbsp;'.$a['event_name'].'<br/>';
                        }
                        
                      if($newbool)
                      {
                    ?>
                    <?php if($st_cnt > 1) echo '<br/> TEAM NAME: &nbsp;&nbsp;<input type="text" name="team_name" class="box" /><br/><br/>';?>
                    <br/>
                    <div id="totamt"></div>
                    <br/>
                    
                    <input type="submit" id="team_sbtn" name="team_sbtn" value="<?php if($st_cnt > 1) echo 'REGISTER TEAM'; else echo 'REGISGTER PARTICIPANT'; ?>" class="button blue"  />
                    
             </b></font>
             </form>
            </div>
            <?php
                
                      }
                }
             ?>
        </div>

    </body>
    
    <script>
        var ev = 0
        function amt_cal()
        {
            var amt = 0;
            ev=0;
            var inputs = document.getElementsByTagName("input");
           

            for(var i=0;i<inputs.length;++i)
            {
                if((inputs[i].type=="checkbox")&&(inputs[i].checked))
                    {
                        amt = amt + parseInt(document.getElementById(("ev" + inputs[i].value)).value); 
                        ev++;
                    }
            }
            
            document.getElementById("totamt").innerHTML="Total amount for "+ev+" events: Rs.&nbsp"+ amt;
            
        }
        
        function subb()
                       {
                           
                           if(ev==0)
                               {
                                   alert('NO event choosen.');
                               }
                           else
                               {
                                   if(confirm("Money Collected?")==1)
                                   document.forms["team_details"].submit();
                               }
                       }
        
        
    </script>
    
</html>
