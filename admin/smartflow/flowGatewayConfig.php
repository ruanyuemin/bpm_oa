<?php
 define('IN_DAEM', true); include '../includes/init.php'; $jsonFlowData = $_REQUEST["flowData"]; $flowDataAry = json_decode($jsonFlowData,true); $flowDataConfigAry = array(); foreach($flowDataAry as $key=>$val) { $flowDataConfigAry[$key] = $val["name"]; } include template();