<?php
 define('IN_DAEM', TRUE); include_once '../includes/init.php'; $type = $_GET['type']; $aid = ceil($_POST['aid']); $gid = $_POST['gid']; $username = (trim($_POST['username'])); $realname = (trim($_POST['realname'])); $department = (trim($_POST['department'])); $number = (trim($_POST['number'])); $tel = (trim($_POST['tel'])); $newpwd = $_POST['newpwd']; $ispermit = $_POST['ispermit']; $language = $_POST['language']; if ($type == 'add') { chkpurview('addadminuser'); if ($gid == '' || $username == '' || $realname == '' || $ispermit == '') { $db->close(); gourl('缺少关键参数。','',-1); } $tmpPassword = $newpwd; $newpwd = md5($newpwd); $sql = "insert into ".DB_DAEMDB.".".TB_SUFFIX."db_adminuser(a_gid,a_account,a_password,a_department,a_username,a_number,a_tel,a_logtime,a_logip,a_ispermit,a_regtime,a_language) values('".$gid."','".$username."','".$newpwd."','".$department."','".$realname."','".$number."','".$tel."','".time()."','".$_SERVER['REMOTE_ADDR']."','".$ispermit."','".time()."','".$language."')"; $db->query($sql); writerecord($_SESSION['UserId'],'添加管理员！',$username); $db->close(); $sql = "INSERT INTO [DRSDatabase].[dbo].[SysUserEntity]
            ([UserName],[Password],[LastLoginTime],[PasswordFailTime],[UserEmail],[UserTelephone]) VALUES
            ('".$username."','".$tmpPassword."','".date('Y-m-d H:i:s',DAEM_TIME)."','0','".$realname."','".$tel."')"; $stmt = $conn->query( $sql ); if(!$stmt) { gourl("添加用户节点2失败，请联系管理员!", "templateList.php"); } gourl('添加管理员成功。','user_list.php'); } else { chkpurview('editadminuser'); if ($gid == '' || $username == '' || $realname == '' || $ispermit == '' || $aid < 1) { if ($gid == '') echo 1; if ($username == '') echo 2; if ($realname == '') echo 3; if ($ispermit == '') echo 4; if ($aid < 1) echo 5;die; $db->close(); gourl('缺少关键参数。','',-1); } $sql = "select b.g_id,b.g_name from ".DB_DAEMDB.".".TB_SUFFIX."db_adminuser as a left join ".DB_DAEMDB.".".TB_SUFFIX."db_admingroup as b on a.a_gid=b.g_id where a.a_id='".$aid."'"; $row = $db->query_first($sql); if ($row['g_name'] == 'administrator') { $sql1 = "select g_name from ".DB_DAEMDB.".".TB_SUFFIX."db_admingroup where g_id='".$gid."'"; $row1 = $db->query_first($sql1); if ($row1['g_name'] != 'administrator') { $sql2 = "select a_id from ".DB_DAEMDB.".".TB_SUFFIX."db_adminuser where a_gid='".$row['g_id']."'"; $result = $db->query($sql2); $count = $db->num_rows($result); if ($count < 2) { $db->close(); gourl('对不起，修改失败，超级管理员群组下至少要保留一个管理员。','',-1); } } } $pwd = ''; if ($newpwd != '' && $newpwd != '********') { $pwd = ",a_password='".md5($newpwd)."'"; } $sql = "update ".DB_DAEMDB.".".TB_SUFFIX."db_adminuser set a_gid='".$gid."',a_account='".$username."',a_department='".$department."',a_username='".$realname."',a_number='".$number."',a_tel='".$tel."',a_language='".$language."',a_ispermit='".$ispermit."'".$pwd." where a_id='".$aid."'"; $db->query($sql); writerecord($_SESSION['UserId'],'修改管理员信息！',$username); $db->close(); gourl('修改管理员成功。','user_list.php'); } 