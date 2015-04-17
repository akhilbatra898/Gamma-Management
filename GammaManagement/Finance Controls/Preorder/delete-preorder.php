<?php require_once('../../Connections/localhost.php'); ?>
<?php
if ((isset($_GET['PreSR'])) && ($_GET['PreSR'] != "")) {
  $deleteSQL = sprintf("DELETE FROM ``preorder`` WHERE PreSR=%s",
                       GetSQLValueString($_GET['PreSR'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($deleteSQL, $localhost) or die(mysql_error());

  $deleteGoTo = "Preorder.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
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
