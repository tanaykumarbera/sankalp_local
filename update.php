<?php
      require_once 'dbconnection.php';
      
      $owncollege=TRUE;
      
      if(!(isset($_SESSION['op_id']))||(($_SESSION['event_id']!=1)&&($_SESSION['event_id']!=0)))
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

          
    
        
        
                
                
      if(isset($_REQUEST['updt']))
      {
          $nam=mysql_real_escape_string($_REQUEST['u_name']);
          $mal=mysql_real_escape_string($_REQUEST['u_email']);
          $ins=mysql_real_escape_string($_REQUEST['u_ins']);
          $ueve=$_REQUEST['events'];
          $no=mysql_real_escape_string($_REQUEST['u_no']);
          $uid=mysql_real_escape_string($_REQUEST['u_id']);
          $u_pay=mysql_real_escape_string($_REQUEST['u_pay']);
          $c_pay=mysql_real_escape_string($_REQUEST['c_pay']);
          $evnt_ls="";
            foreach ($ueve as $i)
            {
                $evnt_ls=$evnt_ls."_".$i;
            }
          $event_ls=mysql_real_escape_string($evnt_ls);
          date_default_timezone_set('Asia/Calcutta');
	  $up_date=date("Y-m-d H:i:s");
          $sql_up="UPDATE registration SET users_name='$nam', users_mail='$mal', users_ins='$ins', users_no='$no', users_events='$event_ls', users_payment='$u_pay', last_update='$up_date' WHERE registeration_id='$uid'";
          mysql_query($sql_up) or die(mysql_query(mysql_error()));
          $sq_op="SELECT amnt_clctd FROM operator WHERE op_id='".$_SESSION['op_id']."'";
          $op= mysql_fetch_array(mysql_query($sq_op));
          $op['amnt_clctd']=$op['amnt_clctd']+($u_pay-$c_pay);
          $sq_op="UPDATE operator SET amnt_clctd='".$op['amnt_clctd']."' WHERE op_id='".$_SESSION['op_id']."'";
          mysql_query($sq_op);
          header('Location: update.php?uid='.$uid.'&b=2');
          
      }
      else if(isset($_REQUEST['uid']))
      {
      $uid=$_REQUEST['uid'];
      $sql="SELECT * FROM registration WHERE registeration_id='$uid'";
      $res=  mysql_query($sql);
      if(mysql_num_rows($res)>0)
      {
          $bool=TRUE;
      }
      else
      {
          $bool=FALSE;
      }
      $stud=  mysql_fetch_array($res);
      $events=  str_getcsv($stud['users_events'], '_');
      
      $sq_chkk="SELECT clg_id FROM college_mapping WHERE clg_name LIKE '%".$stud['users_ins']."%' LIMIT 1";
                             
      $sq_chkkr=  mysql_query($sq_chkk);
      if(mysql_num_rows($sq_chkkr)!=0)
       {
                            
            $tmar=  mysql_fetch_array($sq_chkkr);
            if($tmar['clg_id']!=92)
            {
                        
               $owncollege=FALSE;
            }
        }
      
      }
 
      else
      {
          $bool=FALSE;
      }

      
   
      
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="_css/style.css" type="text/css">
        <title></title>
    </head>
    <body style=" background-color: transparent; " onload="amt_cal()">
        
        
 <script type="text/javascript">
        var e_no;
        function amt_cal()
        {
            var no=0;
            var inputs = document.getElementsByTagName("input");
           

            for(var i=0;i<inputs.length;++i)
            {
                if((inputs[i].type=="checkbox")&&(inputs[i].checked))
                    no++;
            }
            e_no=no;
            document.getElementById("p1").innerHTML="Number of events: &nbsp"+no;
            pay();
        }
        
        function pay()
        {
            if(e_no==0)
                {
                    val=0;
                    alert("At least One event required. STUPID!!");
                }
            else
            val= <?php if($owncollege) echo 30; else echo 50;?>;
        
            val=val-<?php echo $stud['users_payment']; ?>;
            document.getElementById("p2").innerHTML="Amount to pay: &nbspRs "+val;
            if(val>0)
                document.getElementById("p4").innerHTML='<font color="red"><a href="#" onclick="do_payment()">Collected Rs. '+val+'</a></font>';
            else if(val<0)
                document.getElementById("p4").innerHTML='<font color="red"><a href="#" onclick="do_payment()">Returned Rs. '+(-1*val)+'</a></font>';
            else
                document.getElementById("p4").innerHTML='';
            
        }
        
        function do_payment()
        {
            var amt=val+ <?php echo $stud['users_payment']; ?>;
            
                        document.getElementById("hid").innerHTML='<input type="hidden" name="u_pay" value="'+amt+'"/><input type="hidden" name="updt" value="UPDATE"/>';
            document.forms["reg_updt"].submit();
           
        }
             
    </script>
        
        
        
        <?php
        if($bool)
        {
            
            if(isset($_REQUEST['b']))
            {
                if($_REQUEST['b']==2)
                {
                    
                    echo '<div class="notification" style="color: lawngreen; position: fixed; top: 10px; right: 10px;"> <center>&nbsp;&nbsp;Update Successfull.&nbsp;&nbsp;</center> </div>';
                }
            }
            
            
        ?>    
        
        
        
        
        <form name="reg_update" id="reg_updt" action="" method="POST">
            <font face="Calibri"><b>
                <input type="hidden" name="u_id" value="<?php echo $uid;?>" />
                <center><div class="notification" style="margin-left: 30%; color: white;">&nbsp;&nbsp;Verification of student id <?php echo $uid;?>&nbsp;&nbsp; </div></center>
               <div id="table_div" style="width: 100%; height: 250px; float: left; margin-top: 20px;">
                    
                   
                <br/>
                <br/>
                <table width="100%" height="65%">
                <tr>
                    <td width="25%" >&nbsp;&nbsp;NAME</td>
                    <td width="75%"><input type="text" name="u_name" class="box" size="30" <?php echo 'value="'.$stud['users_name'].'"'; ?>/></td>
                </tr>
                
                <tr>
                    <td> &nbsp;&nbsp;EMAIL</td>
                    <td><input type="email" name="u_email" class="box" size="30" <?php echo 'value="'.$stud['users_mail'].'"'; ?>/></td>
                </tr>
                
                <tr>
                    <td> &nbsp;&nbsp;Phone No.</td>
                    <td><input type="text" name="u_no" class="box" <?php echo 'value="'.$stud['users_no'].'"'; ?>/></td>
                </tr>
                
                <tr>
                    <td> &nbsp;&nbsp;INSTITUTION</td>
                    <td> <input type="text" name="u_ins" value="<?php echo $stud['users_ins'];?>" class="box" size="70"/>  </td>
                </tr>
             </table>
           </div>
                <div style="width: 100%; float: left;">
                
                <div id="status" style="width: 470px; height: 318px; float: left;">
                    <div id="st" class="notification" style="color: white;   padding: 20px; margin-top: 100px; margin-left: 40px;">
                        <p id="p1"></p>
                        <p id="p2"></p><br/>
                        Payment Status: &nbsp;<?php if($stud['users_payment']==0) echo 'unpaid'; else echo 'Rs '.$stud['users_payment'].' paid';?><br/>
                        <p id="p4"></p>
                        
                        
                    </div>
                </div>
                
                <div id="event_div" style="width: 250px;  float: left;">
                    
                    Events: 
                    <br/>
                          <?php
                            
                            $sql_eve="SELECT * FROM event_mapping";
                            $res_eve=  mysql_query($sql_eve);
                            if(mysql_num_rows($res_eve)!=0)
                            while($i=  mysql_fetch_array($res_eve))
                            {
                                if(iselected($events,$i['event_id']))
                                        echo '<br/> <input type="checkbox" value="'.$i['event_id'].'" name="events[]" checked="checked" onclick="amt_cal()"/>&nbsp;&nbsp;'.$i['event_name'];
                                else
                                        echo '<br/> <input type="checkbox" value="'.$i['event_id'].'" name="events[]" onclick="amt_cal()"/>&nbsp;&nbsp;'.$i['event_name'];
                            }
                            ?>
            
                 <input type="hidden" name="c_pay" value="<?php echo $stud['users_payment'];?>"/>   
                </div>
                </div>
                <br/>
            </b></font>
            <p id="p5"></p>
            <div id="hid" style="position: fixed" ><input type="hidden" name="u_pay" value="<?php echo $stud['users_payment'];?>"/></div>
            <center><input type="submit" name="updt" value="UPDATE USER" class="button blue" /></center>
            
         </form>
        <?php
        }
        else
        {
        ?>
        
          <center> <div style="margin-top: 10%; alignment-adjust: central;" class="notification"> <font face="Times New Roman" color="RED"><b>&nbsp;&nbsp;Sorry, no records related to <?php    echo $uid;?> found!!!&nbsp;&nbsp;</b></font></div></center>
        <?php
        }
        ?>
          
    </body>
    
    
</html>
