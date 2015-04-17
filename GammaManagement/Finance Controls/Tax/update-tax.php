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
  $updateSQL = sprintf("UPDATE tax SET authority=%s, tax_slab=%s, tax_rate=%s, commodity_name=%s WHERE TaxSR=%s",
                       GetSQLValueString($_POST['authority'], "text"),
                       GetSQLValueString($_POST['tax_slab'], "text"),
                       GetSQLValueString($_POST['tax_rate'], "int"),
                       GetSQLValueString($_POST['commodity_name'], "text"),
                       GetSQLValueString($_POST['TaxSR'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());

  $updateGoTo = "Tax.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Tax = "-1";
if (isset($_GET['TaxSR'])) {
  $colname_Tax = $_GET['TaxSR'];
}
mysql_select_db($database_localhost, $localhost);
$query_Tax = sprintf("SELECT * FROM tax WHERE TaxSR = %s", GetSQLValueString($colname_Tax, "int"));
$Tax = mysql_query($query_Tax, $localhost) or die(mysql_error());
$row_Tax = mysql_fetch_assoc($Tax);
$totalRows_Tax = mysql_num_rows($Tax);

mysql_free_result($Tax);
?>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Authority:</td>
      <td><input type="text" name="authority" value="<?php echo htmlentities($row_Tax['authority'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Tax_slab:</td>
      <td><input type="text" name="tax_slab" value="<?php echo htmlentities($row_Tax['tax_slab'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Tax_rate:</td>
      <td><input type="text" name="tax_rate" value="<?php echo htmlentities($row_Tax['tax_rate'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Commodity_name:</td>
      <td><input type="text" name="commodity_name" value="<?php echo htmlentities($row_Tax['commodity_name'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Update record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="TaxSR" value="<?php echo $row_Tax['TaxSR']; ?>">
</form>
<p>&nbsp;</p>
