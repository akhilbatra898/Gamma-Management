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
  $updateSQL = sprintf("UPDATE stock SET product=%s, market_rate=%s, shelf_life=%s WHERE StockSR=%s",
                       GetSQLValueString($_POST['product'], "text"),
                       GetSQLValueString($_POST['market_rate'], "int"),
                       GetSQLValueString($_POST['shelf_life'], "int"),
                       GetSQLValueString($_POST['StockSR'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());

  $updateGoTo = "Stock.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Stock = "-1";
if (isset($_GET['StockSR'])) {
  $colname_Stock = $_GET['StockSR'];
}
mysql_select_db($database_localhost, $localhost);
$query_Stock = sprintf("SELECT * FROM stock WHERE StockSR = %s", GetSQLValueString($colname_Stock, "int"));
$Stock = mysql_query($query_Stock, $localhost) or die(mysql_error());
$row_Stock = mysql_fetch_assoc($Stock);
$totalRows_Stock = mysql_num_rows($Stock);

mysql_free_result($Stock);
?>

<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Product:</td>
      <td><select name="product">
                              <?php 
							  $result = mysql_query("SELECT product FROM input",$localhost);
							  while ($values = mysql_fetch_array($result, MYSQL_NUM)){?>
										<option value="<?php echo $values[0]; ?>"><?php echo $values[0]; ?></option>
									<?php } ?>
                            </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Market_rate:</td>
      <td><input type="text" name="market_rate" value="<?php echo htmlentities($row_Stock['market_rate'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Shelf_life:</td>
      <td><input type="text" name="shelf_life" value="<?php echo htmlentities($row_Stock['shelf_life'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="StockSR" value="<?php echo $row_Stock['StockSR']; ?>" />
</form>
