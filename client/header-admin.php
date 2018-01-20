<!DOCTYPE html>
<html ng-app='epigrafikaModul'>
    <head>
		<title>  Epigrafika Admin</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width,initial-scale=1"/>
		
       <!-- eksterne biblioteke -->
        <script src='static/scripts/libs/angular.min.js' type='text/javascript' > </script>
        <script src="static/scripts/libs/jquery-1.11.1.js" type='text/javascript'></script>
        <script src="static/scripts/libs/bootstrap.js"></script>
        <script src="static/scripts/libs/cookies.js"></script>
        <script src="static/scripts/libs/ui-bootstrap-tpls-0.9.0.min.js"></script>
        <!-- ucitavanje kontrolera -->
        <script src="static/scripts/translation.js" type="text/javascript"></script>
        <script src="static/scripts/header.js" type='text/javascript'> </script>  
        
        <link rel="stylesheet" type="text/css" href="static/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="static/css/bootstrap-theme-admin.css">
        <link rel="stylesheet" type="text/css" href="static/css/style.css">
    </head>
    <body ng-controller="rootController">
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="admin.php">Epigrafika Admin</a>
				</div>
				<ul class="nav navbar-nav navbar-left">
					<li><a href="admin.php" class="btn btn-link"><span class="glyphicon glyphicon-home"></span></a></li> <!--Home-->
					<li><a href="znamenitosti.php" class="btn btn-link">Znamenitosti</a></li>
					<li><a href="korisnici.php" class="btn btn-link">Korisnici</a></li>
					<li><a href="provincije.php" class="btn btn-link">Provincije</a> <li>
					<li><a href="natpisi.php" class="btn btn-link">Natpisi</a> <li>
					<li><a href="gradovi.php" class="btn btn-link">Gradovi</a> <li>
				</ul>
				
				<ul class="nav navbar-nav navbar-right">
					<li><a href="index.php" class="btn btn-link">Sajt</a></li>
					<li><a href="../server/logout.php"  class="btn btn-link">Logout </a></li>
					<li><a href="config.php" class="btn btn-link"><span class="glyphicon glyphicon-cog"></span></a></li>
				</ul> 
			</div>
		</nav>

		<script type="text/javascript" src="/test/tastatura/keyboard.js"></script>
		<script type="text/javascript">
			var language = "english";
			var napravljena = false;
			function prikaziTastaturu()
			{
				if(!napravljena)
				{
					var node = document.getElementById("ABCD");
					var tastatura = document.createElement("div");
					tastatura.id = "keyboard";
					tastatura.style.margin = "auto";
					tastatura.style.backgroundColor = "red";
					tastatura.style.width = "450px";
					node.appendChild(tastatura);
					createKeyboard(language);
					napravljena = true;
				}
				else
				{
					var tastatura = document.getElementById("keyboard");
					var parent = tastatura.parentNode;
					parent.removeChild(tastatura);
					napravljena = false;
				}
			}
		</script>
		<div id="ABCD" style="position:sticky;top:0;z-index:1;background-color:green;width:auto;">
			<div style="width:50px;margin:auto;">
				<img class="keyboard" style="margin:auto;" src="static/img/keyboard.png" alt="Tastatura" onclick="prikaziTastaturu()"/>
			</div>
		</div>
		<br/>
		
        
