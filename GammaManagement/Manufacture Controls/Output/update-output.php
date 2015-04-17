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
  $updateSQL = sprintf("UPDATE `output` SET product=%s, volume=%s, temp=%s, storage_needed=%s, curr_market_val=%s WHERE OutputSR=%s",
                       GetSQLValueString($_POST['product'], "text"),
                       GetSQLValueString($_POST['volume'], "double"),
                       GetSQLValueString($_POST['temp'], "double"),
                       GetSQLValueString($_POST['storage_needed'], "double"),
                       GetSQLValueString($_POST['curr_market_val'], "double"),
                       GetSQLValueString($_POST['OutputSR'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());

  $updateGoTo = "Output.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Output = "-1";
if (isset($_GET['OutputSR'])) {
  $colname_Output = $_GET['OutputSR'];
}
mysql_select_db($database_localhost, $localhost);
$query_Output = sprintf("SELECT * FROM `output` WHERE OutputSR = %s", GetSQLValueString($colname_Output, "int"));
$Output = mysql_query($query_Output, $localhost) or die(mysql_error());
$row_Output = mysql_fetch_assoc($Output);
$totalRows_Output = mysql_num_rows($Output);

mysql_free_result($Output);
?>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Product:</td>
      <td><select name="product">
                              <?php 
							  $result = mysql_query("SELECT product FROM input",$localhost);
							  while ($values = mysql_fetch_array($result, MYSQL_NUM)){?>
										<option value="<?php echo $values[0]; ?>"><?php echo $values[0]; ?></option>
									<?php } ?>
                            </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Volume:</td>
      <td><input type="text" name="volume" value="<?php echo htmlentities($row_Output['volume'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Temp:</td>
      <td><input type="text" name="temp" value="<?php echo htmlentities($row_Output['temp'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Storage_needed:</td>
      <td><input type="text" name="storage_needed" value="<?php echo htmlentities($row_Output['storage_needed'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Curr_market_val:</td>
      <td><input type="text" name="curr_market_val" value="<?php echo htmlentities($row_Output['curr_market_val'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Update record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="OutputSR" value="<?php echo $row_Output['OutputSR']; ?>">
</form>
<p>&nbsp;</p>
