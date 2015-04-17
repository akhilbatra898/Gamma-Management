<?php require_once('../Connections/localhost.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE tasks SET task_name=%s, assigned_to=%s, `role`=%s, tasks=%s, due_date=%s WHERE TaskSR=%s",
                       GetSQLValueString($_POST['task_name'], "text"),
                       GetSQLValueString($_POST['assigned_to'], "text"),
                       GetSQLValueString($_POST['role'], "text"),
                       GetSQLValueString($_POST['tasks'], "text"),
                       GetSQLValueString($_POST['due_date'], "date"),
                       GetSQLValueString($_POST['TaskSR'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());

  $updateGoTo = "Tasks.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Tasks = "-1";
if (isset($_GET['TaskSR'])) {
  $colname_Tasks = $_GET['TaskSR'];
}
mysql_select_db($database_localhost, $localhost);
$query_Tasks = sprintf("SELECT * FROM tasks WHERE TaskSR = %s", GetSQLValueString($colname_Tasks, "int"));
$Tasks = mysql_query($query_Tasks, $localhost) or die(mysql_error());
$row_Tasks = mysql_fetch_assoc($Tasks);
$totalRows_Tasks = mysql_num_rows($Tasks);

mysql_free_result($Tasks);
?>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Task_name:</td>
      <td><input type="text" name="task_name" value="<?php echo htmlentities($row_Tasks['task_name'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Assigned_to:</td>
      <td><input type="text" name="assigned_to" value="<?php echo htmlentities($row_Tasks['assigned_to'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Role:</td>
      <td><input type="text" name="role" value="<?php echo htmlentities($row_Tasks['role'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Tasks:</td>
      <td><input type="text" name="tasks" value="<?php echo htmlentities($row_Tasks['tasks'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Due_date:</td>
      <td><input type="text" name="due_date" value="<?php echo htmlentities($row_Tasks['due_date'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Update record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="TaskSR" value="<?php echo $row_Tasks['TaskSR']; ?>">
</form>
<p>&nbsp;</p>
