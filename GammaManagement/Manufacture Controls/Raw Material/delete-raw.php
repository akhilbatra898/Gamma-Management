<?php require_once('../../Connections/localhost.php'); ?>
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

if ((isset($_GET['RawSR'])) && ($_GET['RawSR'] != "")) {
  $deleteSQL = sprintf("DELETE FROM raw_material WHERE RawSR=%s",
                       GetSQLValueString($_GET['RawSR'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($deleteSQL, $localhost) or die(mysql_error());

  $deleteGoTo = "Raw Material.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_Raw = "-1";
if (isset($_GET['RawSR'])) {
  $colname_Raw = $_GET['RawSR'];
}
mysql_select_db($database_localhost, $localhost);
$query_Raw = sprintf("SELECT * FROM raw_material WHERE RawSR = %s", GetSQLValueString($colname_Raw, "int"));
$Raw = mysql_query($query_Raw, $localhost) or die(mysql_error());
$row_Raw = mysql_fetch_assoc($Raw);
$totalRows_Raw = mysql_num_rows($Raw);

mysql_free_result($Raw);
?>
