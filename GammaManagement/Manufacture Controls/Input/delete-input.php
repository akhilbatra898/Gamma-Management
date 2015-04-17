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

if ((isset($_GET['InpSR'])) && ($_GET['InpSR'] != "")) {
  $deleteSQL = sprintf("DELETE FROM ``input`` WHERE InpSR=%s",
                       GetSQLValueString($_GET['InpSR'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($deleteSQL, $localhost) or die(mysql_error());

  $deleteGoTo = "Input.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_Input = "-1";
if (isset($_GET['InpSR'])) {
  $colname_Input = $_GET['InpSR'];
}
mysql_select_db($database_localhost, $localhost);
$query_Input = sprintf("SELECT * FROM `input` WHERE InpSR = %s", GetSQLValueString($colname_Input, "int"));
$Input = mysql_query($query_Input, $localhost) or die(mysql_error());
$row_Input = mysql_fetch_assoc($Input);
$totalRows_Input = mysql_num_rows($Input);

mysql_free_result($Input);
?>
