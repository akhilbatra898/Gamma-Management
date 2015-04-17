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

if ((isset($_GET['ExpSR'])) && ($_GET['ExpSR'] != "")) {
  $deleteSQL = sprintf("DELETE FROM expenditure WHERE ExpSR=%s",
                       GetSQLValueString($_GET['ExpSR'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($deleteSQL, $localhost) or die(mysql_error());

  $deleteGoTo = "Expenditure.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_Expenditure = "-1";
if (isset($_GET['ExpSR'])) {
  $colname_Expenditure = $_GET['ExpSR'];
}
mysql_select_db($database_localhost, $localhost);
$query_Expenditure = sprintf("SELECT * FROM expenditure WHERE ExpSR = %s", GetSQLValueString($colname_Expenditure, "int"));
$Expenditure = mysql_query($query_Expenditure, $localhost) or die(mysql_error());
$row_Expenditure = mysql_fetch_assoc($Expenditure);
$totalRows_Expenditure = mysql_num_rows($Expenditure);

mysql_free_result($Expenditure);
?>
