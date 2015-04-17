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

if ((isset($_GET['EmployeeSr'])) && ($_GET['EmployeeSr'] != "")) {
  $deleteSQL = sprintf("DELETE FROM employees WHERE EmployeeSr=%s",
                       GetSQLValueString($_GET['EmployeeSr'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($deleteSQL, $localhost) or die(mysql_error());

  $deleteGoTo = "Employee.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_Employee = "-1";
if (isset($_GET['EmployeeSr'])) {
  $colname_Employee = $_GET['EmployeeSr'];
}
mysql_select_db($database_localhost, $localhost);
$query_Employee = sprintf("SELECT * FROM employees WHERE EmployeeSr = %s", GetSQLValueString($colname_Employee, "int"));
$Employee = mysql_query($query_Employee, $localhost) or die(mysql_error());
$row_Employee = mysql_fetch_assoc($Employee);
$totalRows_Employee = mysql_num_rows($Employee);

mysql_free_result($Employee);
?>
