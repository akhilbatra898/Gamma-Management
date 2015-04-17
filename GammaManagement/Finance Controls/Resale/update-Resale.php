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
  $updateSQL = sprintf("UPDATE resale SET available=%s, tax=%s, market_rate=%s, cost_price=%s WHERE ResaleSR=%s",
                       GetSQLValueString($_POST['available'], "double"),
                       GetSQLValueString($_POST['tax'], "double"),
                       GetSQLValueString($_POST['market_rate'], "double"),
                       GetSQLValueString($_POST['cost_price'], "double"),
                       GetSQLValueString($_POST['ResaleSR'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());

  $updateGoTo = "Resale.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
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

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Available:</td>
      <td><input type="text" name="available" value="<?php echo htmlentities($row_Resale['available'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Tax:</td>
      <td><input type="text" name="tax" value="<?php echo htmlentities($row_Resale['tax'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Market_rate:</td>
      <td><input type="text" name="market_rate" value="<?php echo htmlentities($row_Resale['market_rate'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Cost_price:</td>
      <td><input type="text" name="cost_price" value="<?php echo htmlentities($row_Resale['cost_price'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Update record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="ResaleSR" value="<?php echo $row_Resale['ResaleSR']; ?>">
</form>
<p>&nbsp;</p>
