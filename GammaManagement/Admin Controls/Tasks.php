<?php require_once('../Connections/localhost.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "3";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../Access Denied.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO tasks (task_name, assigned_to, `role`, tasks, due_date) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['task_name'], "text"),
                       GetSQLValueString($_POST['assigned_to'], "text"),
                       GetSQLValueString($_POST['role'], "text"),
                       GetSQLValueString($_POST['tasks'], "text"),
                       GetSQLValueString($_POST['due_date'], "date"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());

  $insertGoTo = "Tasks.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_localhost, $localhost);
$query_Tasks = "SELECT * FROM tasks";
$Tasks = mysql_query($query_Tasks, $localhost) or die(mysql_error());
$row_Tasks = mysql_fetch_assoc($Tasks);
$totalRows_Tasks = mysql_num_rows($Tasks);
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>Tasks</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="">
      <meta name="author" content="">
      <!--link rel="stylesheet/less" href="less/bootstrap.less" type="text/css" /-->
      <!--link rel="stylesheet/less" href="less/responsive.less" type="text/css" /-->
      <!--script src="js/less-1.3.3.min.js"></script-->
      <!--append ‘#!watch’ to the browser URL, then refresh the page. -->
      <link href="../css/bootstrap.min.css" rel="stylesheet">
      <link href="../css/style.css" rel="stylesheet">
      <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
      <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <![endif]-->
      <!-- Fav and touch icons -->
      <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../img/apple-touch-icon-144-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../img/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../img/apple-touch-icon-72-precomposed.png">
      <link rel="apple-touch-icon-precomposed" href="../img/apple-touch-icon-57-precomposed.png">
      <link rel="shortcut icon" href="img/favicon.png">
      <script type="text/javascript" src="../js/jquery.min.js"></script>
      <script type="text/javascript" src="../js/bootstrap.min.js"></script>
      <script type="text/javascript" src="../js/scripts.js"></script>
   </head>
   <body>
      <br>
      <div class="container">
         <div class="row clearfix">
            <div class="col-md-12 column">
               <nav class="navbar navbar-default" role="navigation">
                  <div class="navbar-header">
                     <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> <a class="navbar-brand" href="#">Gamma</a>
                  </div>
                  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                     <ul class="nav navbar-nav">
                        <li class="">
                           <a href="../ControlPanel.php">Control Panel</a>
                        </li>
                        <li class="dropdown">
                           <a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin<strong class="caret"></strong></a>
                           <ul class="dropdown-menu">
                              <li>
                                 <a href="Employee.php">Employee</a>
                              </li>
                              <li>
                                 <a href="Tasks.php">Tasks</a>
                              </li>
                           </ul>
                        </li>
                        <li class="dropdown">
                           <a href="#" class="dropdown-toggle" data-toggle="dropdown">Manufacture<strong class="caret"></strong></a>
                           <ul class="dropdown-menu">
                              <li>
                                 <a href="../Manufacture Controls/Input/Input.php">Input</a>
                              </li>
                              <li>
                                 <a href="../Manufacture Controls/Intermediate/Intermediate.php">Intermediate</a>
                              </li>
                              <li>
                                 <a href="../Manufacture Controls/Output/Output.php">Output</a>
                              </li>
                              <li>
                                 <a href="../Manufacture Controls/Raw Material/Raw Material.php">Raw Material</a>
                              </li>
                           </ul>
                        </li>
                        <li class="dropdown">
                           <a href="#" class="dropdown-toggle" data-toggle="dropdown">Finance<strong class="caret"></strong></a>
                           <ul class="dropdown-menu">
                              <li>
                                 <a href="../Finance Controls/Expenditure/Expenditure.php">Expenditure</a>
                              </li>
                              <li>
                                 <a href="../Finance Controls/Resale/Resale.php">Resale</a>
                              </li>
                              <li class="divider">
                              </li>
                              <li>
                                 <a href="../Finance Controls/Transit/Transit.php">Transit</a>
                              </li>
                              <li class="divider">
                              </li>
                              <li>
                                 <a href="../Finance Controls/Tax/Tax.php">Tax</a>
                              </li>
                              <li class="divider">
                              </li>
                              <li>
                                 <a href="../Finance Controls/Stock/Stock.php">Stock</a>
                              </li>
                              <li class="divider">
                              </li>
                              <li>
                                 <a href="../Finance Controls/Preorder/Preorder.php">Preorder</a>
                              </li>
                              <li>
                                 <a href="../Finance Controls/Order/Order.php">Order</a>
                              </li>
                           </ul>
                        </li>
                        <li>
                           <a href="../Logout.php">Logout</a>
                        </li>
                     </ul>
                  </div>
               </nav>
            </div>
         </div>
      </div>
      <div class="container">
        <table class="table table-bordered">
        <thead>
          <tr>
            <td>Task SR</td>
            <td>Name</td>
            <td>Assigned To</td>
            <td>Role</td>
            <td>Manager</td>
            <td>Due</td>
            <td>Update</td>
            <td>Delete</td>
          </tr>
         </thead>
         <tbody>
          <?php do { ?>
            <tr>
              <td><?php echo $row_Tasks['TaskSR']; ?></td>
              <td><?php echo $row_Tasks['task_name']; ?></td>
              <td><?php echo $row_Tasks['assigned_to']; ?></td>
              <td><?php echo $row_Tasks['role']; ?></td>
              <td><?php echo $row_Tasks['tasks']; ?></td>
              <td><?php echo $row_Tasks['due_date']; ?></td>
              <td><a href="update-tasks.php?TaskSR=<?php echo $row_Tasks['TaskSR']; ?>"> Update</a></td>
              <td><a href="delete-tasks.php?TaskSR=<?php echo $row_Tasks['TaskSR']; ?>">Delete</a></td>
            </tr>
            <?php } while ($row_Tasks = mysql_fetch_assoc($Tasks)); ?>
           </tbody>
        </table>
        
        <!--Insert Modal-->
         
         <!-- Insert Button trigger modal -->
         <center> <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#Insert">
            Insert New Field
            </button> 
         </center>
         <!-- Modal -->
         
         <div class="modal fade" id="Insert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
               <div class="modal-content">
                  <div class="modal-header">
                     <h4 class="modal-title" id="myModalLabel">Insert</h4>
                  </div>
                  <div class="modal-body">
                    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                      <table align="center">
                        <tr valign="baseline">
                          <td nowrap align="right">Task_name:</td>
                          <td><input type="text" name="task_name" value="" size="32" required></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap align="right">Assigned_to:</td>
                          <td><input type="text" name="assigned_to" value="" size="32" required></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap align="right">Role:</td>
                          <td><input type="text" name="role" value="" size="32"></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap align="right">Tasks:</td>
                          <td><input type="text" name="tasks" value="" size="32"></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap align="right">Due_date:</td>
                          <td><input type="text" name="due_date" value="" size="32"></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap align="right">&nbsp;</td>
                          <td><input type="submit" value="Insert record"></td>
                        </tr>
                      </table>
                      <input type="hidden" name="MM_insert" value="form1">
                    </form>
                    <p>&nbsp;</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
               </div>
            </div>
         </div>
         <!-- End Insert Modal -->
        
      </div>
</body>
</html>
<?php
mysql_free_result($Tasks);
?>
