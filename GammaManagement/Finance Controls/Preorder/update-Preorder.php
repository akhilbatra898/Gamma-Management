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
  $updateSQL = sprintf("UPDATE `preorder` SET good_name=%s, transacting_org=%s, country=%s, `currency`=%s, currency_rate=%s, import_duty=%s, availability=%s WHERE PreSR=%s",
                       GetSQLValueString($_POST['good_name'], "text"),
                       GetSQLValueString($_POST['transacting_org'], "text"),
                       GetSQLValueString($_POST['country'], "text"),
                       GetSQLValueString($_POST['currency'], "text"),
                       GetSQLValueString($_POST['currency_rate'], "double"),
                       GetSQLValueString($_POST['import_duty'], "double"),
                       GetSQLValueString($_POST['availability'], "int"),
                       GetSQLValueString($_POST['PreSR'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());

  $updateGoTo = "Preorder.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Preorder = "-1";
if (isset($_GET['PreSR'])) {
  $colname_Preorder = $_GET['PreSR'];
}
mysql_select_db($database_localhost, $localhost);
$query_Preorder = sprintf("SELECT * FROM `preorder` WHERE PreSR = %s", GetSQLValueString($colname_Preorder, "int"));
$Preorder = mysql_query($query_Preorder, $localhost) or die(mysql_error());
$row_Preorder = mysql_fetch_assoc($Preorder);
$totalRows_Preorder = mysql_num_rows($Preorder);

mysql_free_result($Preorder);
?>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Good_name:</td>
      <td><input type="text" name="good_name" value="<?php echo htmlentities($row_Preorder['good_name'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Transacting_org:</td>
      <td><input type="text" name="transacting_org" value="<?php echo htmlentities($row_Preorder['transacting_org'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Country:</td>
      <td><input type="text" name="country" value="<?php echo htmlentities($row_Preorder['country'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Currency:</td>
      <td><input type="text" name="currency" value="<?php echo htmlentities($row_Preorder['currency'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Currency_rate:</td>
      <td><input type="text" name="currency_rate" value="<?php echo htmlentities($row_Preorder['currency_rate'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Import_duty:</td>
      <td><input type="text" name="import_duty" value="<?php echo htmlentities($row_Preorder['import_duty'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Availability:</td>
      <td><input type="text" name="availability" value="<?php echo htmlentities($row_Preorder['availability'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Update record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="PreSR" value="<?php echo $row_Preorder['PreSR']; ?>">
</form>
