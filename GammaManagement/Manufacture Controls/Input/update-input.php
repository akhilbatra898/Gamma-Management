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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE `input` SET product=%s, raw_inputs=%s, weight=%s, volume=%s, initial_temp=%s WHERE InpSR=%s",
                       GetSQLValueString($_POST['product'], "text"),
                       GetSQLValueString($_POST['raw_inputs'], "text"),
                       GetSQLValueString($_POST['weight'], "int"),
                       GetSQLValueString($_POST['volume'], "text"),
                       GetSQLValueString($_POST['initial_temp'], "int"),
                       GetSQLValueString($_POST['InpSR'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());

  $updateGoTo = "Input.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
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

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Product:</td>
      <td><input type="text" name="product" value="<?php echo htmlentities($row_Input['product'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Raw_inputs:</td>
      <td><input type="text" name="raw_inputs" value="<?php echo htmlentities($row_Input['raw_inputs'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Weight:</td>
      <td><input type="text" name="weight" value="<?php echo htmlentities($row_Input['weight'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Volume:</td>
      <td><input type="text" name="volume" value="<?php echo htmlentities($row_Input['volume'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Initial_temp:</td>
      <td><input type="text" name="initial_temp" value="<?php echo htmlentities($row_Input['initial_temp'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td><input type="submit" value="Update record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="InpSR" value="<?php echo $row_Input['InpSR']; ?>">
</form>
<p>&nbsp;</p>
