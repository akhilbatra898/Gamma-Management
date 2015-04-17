<?php require_once('../Connections/localhost.php'); ?>
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
  $updateSQL = sprintf("UPDATE employees SET employee_id=%s, name=%s, contact_number=%s, bank_account_number=%s, date_of_joining=%s, salary=%s, loan_amount_allowed=%s, bonus=%s, Password=%s, AccessLevel=%s WHERE EmployeeSr=%s",
                       GetSQLValueString($_POST['employee_id'], "text"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['contact_number'], "text"),
                       GetSQLValueString($_POST['bank_account_number'], "text"),
                       GetSQLValueString($_POST['date_of_joining'], "date"),
                       GetSQLValueString($_POST['salary'], "int"),
                       GetSQLValueString($_POST['loan_amount_allowed'], "int"),
                       GetSQLValueString($_POST['bonus'], "int"),
                       GetSQLValueString($_POST['Password'], "text"),
                       GetSQLValueString($_POST['AccessLevel'], "int"),
                       GetSQLValueString($_POST['EmployeeSr'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());

  $updateGoTo = "Employee.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Employee = "-1";
if (isset($_GET['EmployeeSr'])) {
  $colname_Employee = $_GET['EmployeeSr'];
}
mysql_select_db($database_localhost, $localhost);
$query_Employee = sprintf("SELECT * FROM employees WHERE EmployeeSr = %s ORDER BY EmployeeSr ASC", GetSQLValueString($colname_Employee, "int"));
$Employee = mysql_query($query_Employee, $localhost) or die(mysql_error());
$row_Employee = mysql_fetch_assoc($Employee);
$totalRows_Employee = mysql_num_rows($Employee);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Update Employee</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="UpdateEmployee" class="">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Serial:</td>
      <td><?php echo $row_Employee['EmployeeSr']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Employee ID:</td>
      <td><input type="text" name="employee_id" value="<?php echo htmlentities($row_Employee['employee_id'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Name:</td>
      <td><input type="text" name="name" value="<?php echo htmlentities($row_Employee['name'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Phone:</td>
      <td><input type="text" name="contact_number" value="<?php echo htmlentities($row_Employee['contact_number'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Bank A/C No:</td>
      <td><input type="text" name="bank_account_number" value="<?php echo htmlentities($row_Employee['bank_account_number'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">DOJ:</td>
      <td><input type="text" name="date_of_joining" value="<?php echo htmlentities($row_Employee['date_of_joining'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Salary:</td>
      <td><input type="text" name="salary" value="<?php echo htmlentities($row_Employee['salary'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Loan Amt Allowed:</td>
      <td><input type="text" name="loan_amount_allowed" value="<?php echo htmlentities($row_Employee['loan_amount_allowed'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Bonus:</td>
      <td><input type="text" name="bonus" value="<?php echo htmlentities($row_Employee['bonus'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Password:</td>
      <td><input type="text" name="Password" value="<?php echo htmlentities($row_Employee['Password'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Access Level:</td>
      <td><input type="text" name="AccessLevel" value="<?php echo htmlentities($row_Employee['AccessLevel'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="EmployeeSr" value="<?php echo $row_Employee['EmployeeSr']; ?>" />
</form>
</body>
</html>
<?php
mysql_free_result($Employee);
?>
