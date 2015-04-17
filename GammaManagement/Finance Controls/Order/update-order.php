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
  $updateSQL = sprintf("UPDATE orders SET org_paid=%s, mode_of_shipment=%s, date_of_delivery=%s, amount_paid=%s WHERE OrderSR=%s",
                       GetSQLValueString($_POST['org_paid'], "text"),
                       GetSQLValueString($_POST['mode_of_shipment'], "text"),
                       GetSQLValueString($_POST['date_of_delivery'], "date"),
                       GetSQLValueString($_POST['amount_paid'], "double"),
                       GetSQLValueString($_POST['OrderSR'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());

  $updateGoTo = "Order.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Order = "-1";
if (isset($_GET['OrderSR'])) {
  $colname_Order = $_GET['OrderSR'];
}
mysql_select_db($database_localhost, $localhost);
$query_Order = sprintf("SELECT * FROM orders WHERE OrderSR = %s", GetSQLValueString($colname_Order, "int"));
$Order = mysql_query($query_Order, $localhost) or die(mysql_error());
$row_Order = mysql_fetch_assoc($Order);
$totalRows_Order = mysql_num_rows($Order);

mysql_free_result($Order);
?>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Org_paid:</td>
      <td><input type="text" name="org_paid" value="<?php echo htmlentities($row_Order['org_paid'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Mode_of_shipment:</td>
      <td><input type="text" name="mode_of_shipment" value="<?php echo htmlentities($row_Order['mode_of_shipment'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Date_of_delivery:</td>
      <td><input type="text" name="date_of_delivery" value="<?php echo htmlentities($row_Order['date_of_delivery'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Amount_paid:</td>
      <td><input type="text" name="amount_paid" value="<?php echo htmlentities($row_Order['amount_paid'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Update record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="OrderSR" value="<?php echo $row_Order['OrderSR']; ?>">
</form>
<p>&nbsp;</p>
