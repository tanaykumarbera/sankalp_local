<?php
    require 'dbconnection.php';
?>
<html>

    <body style="background: transparent fixed; width: 250px;">
<?php
    if(isset($_REQUEST['sr']))
    {
        $sql="SELECT registeration_id, users_name, users_mail FROM registration WHERE (users_name LIKE '%".$_REQUEST['sr']."%' OR users_mail LIKE '%".$_REQUEST['sr']."%')";
        
        $r=  mysql_query($sql);
        while($a=  mysql_fetch_array($r))
        {
            echo '<a href="#" onclick="parent.asrch('.$a['registeration_id'].');"><div style="padding: 5px; color: white; margin-top: 10px; width: 250px; font: monospace; font-size: 14px; background: url('."'_img/black.png'".') repeat; border-radius: 5px;"><center>'.$a['users_name'].'<br/>'.$a['users_mail'].'</center></div></a>';
        }
    }
?>
    </body>
</html>