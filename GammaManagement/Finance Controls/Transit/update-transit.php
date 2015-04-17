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
  $updateSQL = sprintf("UPDATE transit SET carrier=%s, route=%s, documents_required=%s, place_of_delivery=%s WHERE TranSR=%s",
                       GetSQLValueString($_POST['carrier'], "text"),
                       GetSQLValueString($_POST['route'], "text"),
                       GetSQLValueString($_POST['documents_required'], "text"),
                       GetSQLValueString($_POST['place_of_delivery'], "text"),
                       GetSQLValueString($_POST['TranSR'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());

  $updateGoTo = "Transit.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Transit = "-1";
if (isset($_GET['TranSR'])) {
  $colname_Transit = $_GET['TranSR'];
}
mysql_select_db($database_localhost, $localhost);
$query_Transit = sprintf("SELECT * FROM transit WHERE TranSR = %s", GetSQLValueString($colname_Transit, "int"));
$Transit = mysql_query($query_Transit, $localhost) or die(mysql_error());
$row_Transit = mysql_fetch_assoc($Transit);
$totalRows_Transit = mysql_num_rows($Transit);

mysql_free_result($Transit);
?>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">TranSR:</td>
      <td><?php echo $row_Transit['TranSR']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Carrier:</td>
      <td><input type="text" name="carrier" value="<?php echo htmlentities($row_Transit['carrier'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Route:</td>
      <td><input type="text" name="route" value="<?php echo htmlentities($row_Transit['route'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Documents_required:</td>
      <td><input type="text" name="documents_required" value="<?php echo htmlentities($row_Transit['documents_required'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Place_of_delivery:</td>
      <td><input type="text" name="place_of_delivery" value="<?php echo htmlentities($row_Transit['place_of_delivery'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Update record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="TranSR" value="<?php echo $row_Transit['TranSR']; ?>">
</form>
<p>&nbsp;</p>
