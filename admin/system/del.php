<?php
 define('IN_DAEM', true); include_once '../includes/init.php'; $id = ceil(trim($_GET['id'])); $type = trim($_GET['type']); switch ($type) { case 'group': chkpurview('delgroup'); $sql = "select a_id,a_gid from ".DB_DAEMDB.".".TB_SUFFIX."db_adminuser where a_gid='".$id."'"; if ($row = $db->query_first($sql)) { $db->close(); gourl('该群组下面存在一个或多个管理员，请先删除管理员后再删除此群组！','',-1); } if ($row['a_gid'] == 1) { $db->close(); gourl('不能删除超级管理员群组！','',-1); } $sql = "delete from ".DB_DAEMDB.".".TB_SUFFIX."db_admingroup where g_id='".$id."'"; $db->query($sql); writerecord($_SESSION['UserId'],'删除管理员群组！',$row['g_name']); $db->close(); gourl('群组删除成功！','./group_list.php'); break; case 'user': chkpurview('deladminuser'); $user = trim($_GET['user']); $sql = "delete from ".DB_DAEMDB.".".TB_SUFFIX."db_adminuser where a_id='".$id."'"; $db->query($sql); writerecord($_SESSION['UserId'],'删除管理员！',$user); $db->close(); gourl('删除管理员成功！','./user_list.php'); break; case 'menu': chkpurview('delmenu'); $name = urldecode(trim($_GET['user'])); $sql = "select m_id from ".DB_DAEMDB.".".TB_SUFFIX."db_menu where m_parentid='".$id."'"; if ($row = $db->query_first($sql)) { $db->close(); gourl('该菜单下存在一个或多个子菜单，请先删除子菜单后再删除此菜单。','',-1); } $sql = "delete from ".DB_DAEMDB.".".TB_SUFFIX."db_menu where m_id='".$id."'"; $db->query($sql); writerecord($_SESSION['UserId'],'删除系统菜单！',$name); $db->close(); gourl('菜单删除成功！','./menu_list.php'); break; case 'resource': $sql = "select r_id from ".DB_DAEMDB.".".TB_SUFFIX."db_resource where r_parentid='".$id."'"; if ($db->query_first($sql)) { $db->close(); gourl('该资源下存在一个或多个子资源，请先删除子资源后再删除此资源。','',-1); } $sql = "delete from ".DB_DAEMDB.".".TB_SUFFIX."db_resource where r_id='".$id."'"; $db->query($sql); $db->close(); gourl('资源删除成功！','./resource_list.php'); break; case 'department': $sql = "select id from ".DB_DAEMDB.".".TB_SUFFIX."db_department where parent_id='".$id."'"; if ($db->query_first($sql)) { $db->close(); gourl('该部门下存在一个或多个子部门，请先删除子部门后再删除此资源。','',-1); } $sql = "delete from ".DB_DAEMDB.".".TB_SUFFIX."db_department where id='".$id."'"; $db->query($sql); $db->close(); gourl('部门删除成功！','./department_list.php'); break; } 