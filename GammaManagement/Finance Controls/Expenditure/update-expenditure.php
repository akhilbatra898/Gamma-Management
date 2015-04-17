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
  $updateSQL = sprintf("UPDATE expenditure SET purpose=%s, amount=%s, date_of_payment=%s, signee=%s WHERE ExpSR=%s",
                       GetSQLValueString($_POST['purpose'], "text"),
                       GetSQLValueString($_POST['amount'], "double"),
                       GetSQLValueString($_POST['date_of_payment'], "date"),
                       GetSQLValueString($_POST['signee'], "text"),
                       GetSQLValueString($_POST['ExpSR'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());

  $updateGoTo = "Expenditure.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Expenditure = "-1";
if (isset($_GET['ExpSR'])) {
  $colname_Expenditure = $_GET['ExpSR'];
}
mysql_select_db($database_localhost, $localhost);
$query_Expenditure = sprintf("SELECT * FROM expenditure WHERE ExpSR = %s", GetSQLValueString($colname_Expenditure, "int"));
$Expenditure = mysql_query($query_Expenditure, $localhost) or die(mysql_error());
$row_Expenditure = mysql_fetch_assoc($Expenditure);
$totalRows_Expenditure = mysql_num_rows($Expenditure);

mysql_free_result($Expenditure);
?>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Purpose:</td>
      <td><input type="text" name="purpose" value="<?php echo htmlentities($row_Expenditure['purpose'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Amount:</td>
      <td><input type="text" name="amount" value="<?php echo htmlentities($row_Expenditure['amount'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Date_of_payment:</td>
      <td><input type="text" name="date_of_payment" value="<?php echo htmlentities($row_Expenditure['date_of_payment'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Signee:</td>
      <td><select name="signee">
                           <?php 
							  $result = mysql_query("SELECT employee_id FROM employees",$localhost);
							  while ($values = mysql_fetch_array($result, MYSQL_NUM)){?>
										<option value="<?php echo $values[0]; ?>"><?php echo $values[0]; ?></option>
									<?php } ?>
                          
                          </select></td>
    </tr>
    <tr valign="baseline">
      <td><input type="submit" value="Update record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="ExpSR" value="<?php echo $row_Expenditure['ExpSR']; ?>">
</form>
