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
  $updateSQL = sprintf("UPDATE intermediate SET product=%s, concentration=%s, temp=%s, transfer_rate=%s, time_taken=%s, amount=%s WHERE MediateSR=%s",
                       GetSQLValueString($_POST['product'], "text"),
                       GetSQLValueString($_POST['concentration'], "double"),
                       GetSQLValueString($_POST['temp'], "double"),
                       GetSQLValueString($_POST['transfer_rate'], "double"),
                       GetSQLValueString($_POST['time_taken'], "double"),
                       GetSQLValueString($_POST['amount'], "double"),
                       GetSQLValueString($_POST['MediateSR'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());

  $updateGoTo = "Intermediate.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Intermediate = "-1";
if (isset($_GET['MediateSR'])) {
  $colname_Intermediate = $_GET['MediateSR'];
}
mysql_select_db($database_localhost, $localhost);
$query_Intermediate = sprintf("SELECT * FROM intermediate WHERE MediateSR = %s", GetSQLValueString($colname_Intermediate, "int"));
$Intermediate = mysql_query($query_Intermediate, $localhost) or die(mysql_error());
$row_Intermediate = mysql_fetch_assoc($Intermediate);
$totalRows_Intermediate = mysql_num_rows($Intermediate);

mysql_free_result($Intermediate);
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
      <td nowrap align="right">Concentration:</td>
      <td><input type="text" name="concentration" value="<?php echo htmlentities($row_Intermediate['concentration'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Temp:</td>
      <td><input type="text" name="temp" value="<?php echo htmlentities($row_Intermediate['temp'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Transfer_rate:</td>
      <td><input type="text" name="transfer_rate" value="<?php echo htmlentities($row_Intermediate['transfer_rate'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Time_taken:</td>
      <td><input type="text" name="time_taken" value="<?php echo htmlentities($row_Intermediate['time_taken'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Amount:</td>
      <td><input type="text" name="amount" value="<?php echo htmlentities($row_Intermediate['amount'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Update record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="MediateSR" value="<?php echo $row_Intermediate['MediateSR']; ?>">
</form>
<p>&nbsp;</p>
