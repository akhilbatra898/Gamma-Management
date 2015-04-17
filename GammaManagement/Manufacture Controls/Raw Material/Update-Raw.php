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
  $updateSQL = sprintf("UPDATE raw_material SET material=%s, market_rate=%s, volume=%s, expected_use=%s, final_use=%s, date_of_next_order=%s, expiry=%s WHERE RawSR=%s",
                       GetSQLValueString($_POST['material'], "text"),
                       GetSQLValueString($_POST['market_rate'], "int"),
                       GetSQLValueString($_POST['volume'], "double"),
                       GetSQLValueString($_POST['expected_use'], "text"),
                       GetSQLValueString($_POST['final_use'], "text"),
                       GetSQLValueString($_POST['date_of_next_order'], "date"),
                       GetSQLValueString($_POST['expiry'], "date"),
                       GetSQLValueString($_POST['RawSR'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());

  $updateGoTo = "Raw Material.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_UpdateRaw = "-1";
if (isset($_GET['RawSR'])) {
  $colname_UpdateRaw = $_GET['RawSR'];
}
mysql_select_db($database_localhost, $localhost);
$query_UpdateRaw = sprintf("SELECT * FROM raw_material WHERE RawSR = %s", GetSQLValueString($colname_UpdateRaw, "int"));
$UpdateRaw = mysql_query($query_UpdateRaw, $localhost) or die(mysql_error());
$row_UpdateRaw = mysql_fetch_assoc($UpdateRaw);
$totalRows_UpdateRaw = mysql_num_rows($UpdateRaw);

mysql_free_result($UpdateRaw);
?>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Material:</td>
      <td><input type="text" name="material" value="<?php echo htmlentities($row_UpdateRaw['material'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Market_rate:</td>
      <td><input type="text" name="market_rate" value="<?php echo htmlentities($row_UpdateRaw['market_rate'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Volume:</td>
      <td><input type="text" name="volume" value="<?php echo htmlentities($row_UpdateRaw['volume'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Expected_use:</td>
      <td><select name="expected_use" > <?php 
							  $result = mysql_query("SELECT product FROM input",$localhost);
							  while ($values = mysql_fetch_array($result, MYSQL_NUM)){?>
										<option value="<?php echo $values[0]; ?>"><?php echo $values[0]; ?></option>
									<?php } ?> </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Final_use:</td>
      <td><select name="final_use" > <?php 
							  $result = mysql_query("SELECT product FROM input",$localhost);
							  while ($values = mysql_fetch_array($result, MYSQL_NUM)){?>
										<option value="<?php echo $values[0]; ?>"><?php echo $values[0]; ?></option>
									<?php } ?> </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Date_of_next_order:</td>
      <td><input type="text" name="date_of_next_order" value="<?php echo htmlentities($row_UpdateRaw['date_of_next_order'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Expiry:</td>
      <td><input type="text" name="expiry" value="<?php echo htmlentities($row_UpdateRaw['expiry'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Update record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="RawSR" value="<?php echo $row_UpdateRaw['RawSR']; ?>">
</form>
<p>&nbsp;</p>
