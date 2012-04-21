<?php
header("content-Type: text/html; charset=utf-8");
    require_once 'FunctionBase.php';
    require_once 'mysql.php';
    /*
    print_r($_REQUEST['feature']);
    echo '<br />';
    print_r($_REQUEST['info']);
    echo '<br />';
    */
    $action = isset($_REQUEST['action']) ? $_REQUEST['action']:'';
    $regex = $_REQUEST['regex'];
    $info = $_REQUEST['info'];
    $type = $_REQUEST['type'];
    
    if($action=='new')
    {
        $mysql = MySql::getInstance();
        $regex = mysql_real_escape_string($regex);
        $info = mysql_real_escape_string($info);
        $sql = "insert into ErrFeature(regex, info, type) values('" . $regex."','".$info."','".$type."');\n";  
        $rq = $mysql->query($sql);
    }
    else if($action=='update')
    {
        $id = intval($_REQUEST['id']);
        $mysql = MySql::getInstance();
        $regex = mysql_real_escape_string($regex);
        $info = mysql_real_escape_string($info);
        $sql = "update ErrFeature set regex='".$regex."', info='" . $info. "', type='" . $type . "' where id=". $id.";";
        $rq = $mysql->query($sql);
    }
    emDirect('FeatureList.php');
    
?>