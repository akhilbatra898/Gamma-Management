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

if ((isset($_GET['ResaleSR'])) && ($_GET['ResaleSR'] != "")) {
  $deleteSQL = sprintf("DELETE FROM resale WHERE ResaleSR=%s",
                       GetSQLValueString($_GET['ResaleSR'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($deleteSQL, $localhost) or die(mysql_error());

  $deleteGoTo = "Resale.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_Resale = "-1";
if (isset($_GET['ResaleSR'])) {
  $colname_Resale = $_GET['ResaleSR'];
}
mysql_select_db($database_localhost, $localhost);
$query_Resale = sprintf("SELECT * FROM resale WHERE ResaleSR = %s", GetSQLValueString($colname_Resale, "int"));
$Resale = mysql_query($query_Resale, $localhost) or die(mysql_error());
$row_Resale = mysql_fetch_assoc($Resale);
$totalRows_Resale = mysql_num_rows($Resale);

mysql_free_result($Resale);
?>
