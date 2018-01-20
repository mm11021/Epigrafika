<!DOCTYPE html>
<html ng-app='epigrafikaModul'>
<head>
    <title>  Epigrafika </title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1"/>

    <!-- eksterne biblioteke-->
    <script src='static/scripts/libs/angular.min.js' type='text/javascript' > </script>
    <!-- <script type="text/javascript" src="https://code.angularjs.org/1.1.1/angular.js"></script> -->
    <script src="static/scripts/libs/jquery-1.11.1.js" type='text/javascript'></script>
    <script src="static/scripts/libs/bootstrap.js"></script>
    <script src="static/scripts/libs/cookies.js"></script>
    <script src="static/scripts/libs/ui-bootstrap-tpls-0.9.0.min.js"></script>

    <!-- ucitavanje kontrolera -->
    <script src="static/scripts/translation.js" type="text/javascript"></script>
    <script src="static/scripts/header.js" type='text/javascript'> </script>

    <link rel="stylesheet" type="text/css" href="static/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="static/css/bootstrap-theme.css">
    <link rel="stylesheet" type="text/css" href="static/css/style.css" />
</head>
<body ng-controller='rootController' ng-cloak>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">Epigrafika</a>
        </div>
        <ul class="nav navbar-nav navbar-left">
            <li><a href="index.php" class="btn btn-link"><span class="glyphicon glyphicon-home"></span></a></li> <!--Home-->
        </ul>
        <!-- meni koji se prikazuje ako je korisnik ulogovan -->
        <div class="nav navbar-nav navbar-right vertical-center" style="padding-top:10px;">
            <a href="index.php" class="btn btn-info">{{tr.pretraga}}</a>
            <a href="unos.php" class="btn btn-info">{{tr.unesi_objekat}}</a>
            <a href="../server/logout.php" class="btn btn-danger">Logout </a>
            <a href="#" class="btn btn-warning dropdown open dropdown-toggle" data-toggle="dropdown" aria-expanded="true">{{tr.jezici}} <b class="caret"></b></a>
            <div class="dropdown-menu">
                <button ng-click="changeTo('serbian')" type="button" class="btn btn-link menu-black"> <img src="static/img/rs.png" class="btn btn-link" alt="Srpski" title="Srpski"> Srpski </button><br/>
                <button ng-click="changeTo('english')" type="button" class="btn btn-link menu-black"> <img src="static/img/gb.png" class="btn btn-link" alt="English" title="English"> English </button>
            </div>
        </div>
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