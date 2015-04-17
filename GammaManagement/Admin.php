<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

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
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "Access Denied.php";
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
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

	<!--link rel="stylesheet/less" href="less/bootstrap.less" type="text/css" /-->
	<!--link rel="stylesheet/less" href="less/responsive.less" type="text/css" /-->
	<!--script src="js/less-1.3.3.min.js"></script-->
	<!--append ‘#!watch’ to the browser URL, then refresh the page. -->
	
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">

  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
  <![endif]-->

  <!-- Fav and touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="img/favicon.png">
  
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/scripts.js"></script>
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
							<a href="ControlPanel.php">Control Panel</a>
						</li>
						
						<li class="dropdown">
							 <a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin<strong class="caret"></strong></a>
							<ul class="dropdown-menu">
								<li>
									<a href="Admin Controls/Employee.php">Employee</a>
								</li>
								<li>
									<a href="Admin Controls/Tasks.php">Tasks</a>
								</li>
								
							</ul>
						</li>
                        
                        <li class="dropdown">
							 <a href="#" class="dropdown-toggle" data-toggle="dropdown">Manufacture<strong class="caret"></strong></a>
							<ul class="dropdown-menu">
								<li>
									<a href='Manufacture Controls/Input/Input.php'>Input</a>
								</li>
								<li>
									<a href="Manufacture Controls/Intermediate/Intermediate.php">Intermediate</a>
								</li>
                                <li>
									<a href="Manufacture Controls/Output/Output.php">Output</a>
								</li>
								
							</ul>
						</li>
                        
                        <li class="dropdown">
							 <a href="#" class="dropdown-toggle" data-toggle="dropdown">Finance<strong class="caret"></strong></a>
							<ul class="dropdown-menu">
								<li>
									<a href="Finance Controls/Expenditure/Expenditure.php">Expenditure</a>
								</li>
								
								<li>
									<a href="Finance Controls/Resale/Resale.php">Resale</a>
								</li>
								<li class="divider">
								</li>
								<li>
									<a href="Finance Controls/Transit/Transit.php">Transit</a>
								</li>
								<li class="divider">
								</li>
								<li>
									<a href="Finance Controls/Tax/Tax.php">Tax</a>
								</li>
                                <li class="divider">
								</li>
								<li>
									<a href="Finance Controls/Stock/Stock.php">Stock</a>
								</li>
                                <li class="divider">
								</li>
								<li>
									<a href="Finance Controls/Preorder/Preorder.php">Preorder</a>
								</li>
                                <li>
									<a href="Finance Controls/Order/Order.php">Order</a>
								</li>
							</ul>
						</li>
                        <li>
							<a href="Logout.php">Logout</a>
						</li>
					</ul>
					
					
				</div>
				
			</nav>
			
		</div>
	</div>
	
	</div>
</div>
</body>
</html>
