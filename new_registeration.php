<?php
    require_once 'dbconnection.php';
    $uevents;
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
   

    if(isset($_REQUEST['sbtn']))
    {
    if(iset($_REQUEST['u_name']) &&  iset($_REQUEST['u_email']) && iset($_REQUEST['u_no']) && (count($_REQUEST['events'])!=0)  && ($_REQUEST['ins']!="0"))
        {
        $bool=4;
        $uname=  mysql_real_escape_string($_REQUEST['u_name']);
        $umail=  mysql_real_escape_string($_REQUEST['u_email']);
        $uno=  mysql_real_escape_string($_REQUEST['u_no']);
        $uins=  mysql_real_escape_string($_REQUEST['ins']);
        $uevents=$_REQUEST['events'];
        
        $evnt_ls="";
        $sql_eve="SELECT * FROM event_mapping WHERE event_id='-1'";
        foreach ($uevents as $i)
        {
            $evnt_ls=$evnt_ls."_".$i;
            $sql_eve=$sql_eve." OR event_id='".$i."'";
        }
        $event_list=mysql_real_escape_string($evnt_ls);
        
        $sqcheck="SELECT users_name FROM registration WHERE users_mail='$umail'";
        if(mysql_num_rows(mysql_query($sqcheck))==0)
        {
          //  $r=  rand(10000000, 99999999);
            
            
            $sub="SANKALP 2k13";
            
            $msg="Thanks for Registering. The technical club of Neotia Institute of Technology Management And Science, welcomes you to SANKALP 2k13. Get yourself boosted.. come, play fair and win amaizing amounts. You have registered for";
            
            
            $res_eve=mysql_query($sql_eve);
            if(mysql_num_rows($res_eve)!=0)
            while($i=mysql_fetch_array($res_eve))
            {
              $msg=$msg." '".$i['event_name']."',";
             
            }
            
            $msg=$msg." and your unique registration id is '".$r."'. Please note it down carefully. You have to produce it at our onsite Registration desk for further formalties and fee payments. If you want to make any changes, It would be done only at our institution registration desk";
            $head="FROM: noreply@snklp.in";
           // mail($umail, $sub, $msg, $head);
           
           echo $msg;
            date_default_timezone_set('Asia/Calcutta');
			$up_date=date("Y-m-d H:i:s");
            $sql_insert="INSERT INTO registration VALUES('','$uname','$umail','$uno','$uins','$event_list','0','','$up_date','$up_date')"; //payment, teamid
            mysql_query($sql_insert) or die(mysql_error());
            
			$sq_id="SELECT registeration_id FROM registration WHERE users_mail='$umail' LIMIT 1";
			$arr_id=mysql_fetch_array(mysql_query($sq_id));
			$r=$arr_id['registeration_id'];
			
			$bool=3;
            
            
            
            
        }
        else $bool=2;
        
        
    }
    else  $bool=1;
        
    }
    else $bool=4;
            
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="_css/reg_styl.css" type="text/css">
        <title></title>
    </head>
    <body>
        <div style="position: fixed; background: url('_img/black.png') repeat; bottom:5px; left: 5px;height: 20px; padding-top: 2px; color: white; font-family: Monospace; border-radius: 5px;">&nbsp;&nbsp;© Tanay Kumar Bera, Tech-niché, Sankalp-2k13&nbsp;&nbsp;</div>
        <div id="body_upper">
        <div id="reg_back">
            <?php
            if($bool==1)
            {    
            ?>
            <div class="notification" style=" color: red;"> <center>&nbsp;&nbsp;All Fields are mandatory. Even at least one event must be choosen.&nbsp;&nbsp;</center> </div>
            <?php
            }
            ?>
            
            <?php
            if($bool==2)
            {    
            ?>
            <div class="notification" style="color: red;"> <center>&nbsp;&nbsp;<?php echo $_REQUEST['u_email'];?> seems to be already registered. Check your mail please. &nbsp;&nbsp;</center> </div>
            <?php
            }
            ?>
            
            <?php
            if($bool==3)
            {    
            ?>
             <center><div  style="  position: fixed; top: 30px; background: url('_img/black.png') repeat;  color: lawngreen;  height: auto; width: 200px auto; padding: 20px; border-radius: 10px; ">Registration Successfull. Your Registeration ID:&nbsp;<?php echo 'SN'.$r;?>. Please use it at our Payment desk for further procedure.. </div></center>
            <?php
            }
            ?>
            
        <form name="reg" action="" method="POST">
            <font face="Calibri" color="white"><b>
               <div id="table_div" style="width: 100%; height: 300px; float: left; margin-top: 100px;">
                    
                <center> Every participant has to register individually. Team registrations will be done
                    only after your Individual registration is over. Enter the necessary details below to get started.    </center>
                <br/>
                <br/>
                <table width="100%" height="65%">
                <tr>
                    <td width="50%">&nbsp;&nbsp;NAME</td>
                    <td width="50%"><input type="text" name="u_name" class="box" size="30" <?php if(iset($_REQUEST['u_name'])&& ($bool!=3)) echo 'value="'.$_REQUEST['u_name'].'"'; ?>/></td>
                </tr>
                
                <tr>
                    <td> &nbsp;&nbsp;EMAIL</td>
                    <td><input type="email" name="u_email" class="box" size="30" <?php if(iset($_REQUEST['u_email'])&& ($bool!=3)) echo 'value="'.$_REQUEST['u_email'].'"'; ?>/></td>
                </tr>
                
                <tr>
                    <td> &nbsp;&nbsp;Phone No.</td>
                    <td><input type="text" name="u_no" class="box" <?php if(iset($_REQUEST['u_no'])&&($bool!=3)) echo 'value="'.$_REQUEST['u_no'].'"'; ?> min="10000000000"/></td>
                </tr>
                
                <tr>
                    <td> &nbsp;&nbsp;INSTITUTION</td>
                    <td><select name="ins" class="box" style="width: 300px;">
                            <option value="0">------CHOOSE YOUR INSTITUTION--------</option>
                            <?php
                            $res_ins=  mysql_query("SELECT * FROM college_mapping ORDER BY clg_name");
                            if(mysql_num_rows($res_ins)!=0)
                            while($i=  mysql_fetch_array($res_ins))
                            {
                            ?>
                            <?php echo '<option value="'.$i['clg_name'].'">'.$i['clg_name'].'</option>';?>
                            <?php
                            }
                            ?>
                            <option value="Not Listed">Your college not Listed? Select this for other Colleges.</option>
                         </select>
                    </td>
                </tr>
             </table>
           </div>
                <div id="event_div" style="padding-left: 10%;">
                    
                    Choose your events below. 
                    <br/>
                          <?php
                            $sql_eve="SELECT * FROM event_mapping ORDER BY event_id";
                            $res_eve=  mysql_query($sql_eve);
                            if(mysql_num_rows($res_eve)!=0)
                            while($i=  mysql_fetch_array($res_eve))
                            {
                                if(iselected($_REQUEST['events'],$i['event_id'])&& ($bool!=3))
                                        echo '<br/> <input type="checkbox" value="'.$i['event_id'].'" name="events[]" checked="checked"/>&nbsp;&nbsp;'.$i['event_name'];
                                else
                                        echo '<br/> <input type="checkbox" value="'.$i['event_id'].'" name="events[]"/>&nbsp;&nbsp;'.$i['event_name'];
                            }
                            ?>
            
                    <br/>
                    <br/>
                    NOTE:: Every individual must produce a valid ID proof along with College Name clearly mentioned on it. Any other ID
                    other than College Icard, issued by respective colleges, will be accepted on condition that it must contain your photograph
                    along with your name and institution name mentioned over it. 
                </div>
                <br/>
            </b></font>
            
            
            <center><input type="submit" name="sbtn" value="SUBMIT" class="button blue" /></center>
         </form>
      </div>               
            </div>
    </body>
</html>
