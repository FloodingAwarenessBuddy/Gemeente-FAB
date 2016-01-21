<?php  
require_once('includes/settings.php');
session_start();
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Project Hogeschool Rotterdam - Flooding Awareness Buddy">
    <meta name="author" content="">
    <title>Gemeente FAB</title>

    <!-- Css -->
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="node_modules/mfb/src/mfb.css">
    <link rel="stylesheet" href="css/ionicons.css">

    <!-- Custom Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
</head>
<body>
    <div id="map" <?=(!isset($_SESSION['user'])) ? 'class="blur"' : '' ?>>
        
    </div>
    <?php if(isset($_SESSION['user'])){ ?>
    <aside id="menu" <?=(!isset($_SESSION['user'])) ? 'class="asideFullClose"' : 'asideOpen' ?>>
        <div id="search">
            <div id="searchWrap">
                <div id="menuButton" class="">
                    
                </div>
                <div id="bar">
                    <input type="text" id="address" placeholder="Zoeken, Postcode, etc.">
                </div>
                <div id="searchOption">
                    <div id="delete">
                        <i class="ion-close-round"></i>
                    </div>
                    <div id="searchButton">
                        <i class="ion-search"></i>
                    </div>
                </div>
            </div>
            <div id="searchResults">
                
            </div>
        </div>
        <div id="searchBackground">
                
        </div>
        <div id="results">
        
        </div>
        <div id="opener">
            
        </div>
    </aside>
    <?php } ?>


    <?php if(!isset($_SESSION['user'])){ ?>
    <div id="login">
        <div id="loginInner">
        <div id="imageWrap">
            <img src="image/logo.png" alt="Logo">
        </div>
        <form action="includes/login.php" method="POST">
            <label for="username">Gebruikersnaam/Email:</label>
            <input type="text" id="username" name="username" class="input">
            <label for="username">Wachtwoord:</label>
            <input type="password" id="password" name="password" class="input">
            <input type="submit" value="Login" id="loginButton">
        </form>
        </div>
    </div>
    <?php } ?>
    <?php if(isset($_SESSION['user'])){ ?>
    <ul class="mfb-component--br mfb-zoomin" data-mfb-toggle="click" data-mfb-state="closed">
        <li class="mfb-component__wrap">
            <!-- the main menu button -->
            <a data-mfb-label="Close" class="mfb-component__button--main">
                <!-- the main button icon visibile by default -->
                <i class="mfb-component__main-icon--resting ion-navicon-round"></i>
                <!-- the main button icon visibile when the user is hovering/interacting with the menu -->
                <i class="mfb-component__main-icon--active ion-close-round"></i>
            </a>
            <ul class="mfb-component__list">
                <!-- a child button, repeat as many times as needed -->
                <li>
                    <a href="link.html" data-mfb-label="Nieuw Fab" class="mfb-component__button--child">
                        <i class="mfb-component__child-icon ion-plus"></i>
                    </a>
                </li>
                <li>
                    <a href="includes/logout.php" data-mfb-label="logout" class="mfb-component__button--child">
                        <i class="mfb-component__child-icon ion-log-out"></i>
                    </a>
                </li>
            </ul>
          </li>
    </ul>
    <?php } ?>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="scripts/init.js"></script>
    <script src="scripts/fab.js"></script>
    <script src="scripts/Location.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?=KEY?>&callback=initMap"></script>
    <script src="node_modules/mfb/src/mfb.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
    <?php if(!isset($_SESSION['user'])){ ?>
    <script>
        timer = window.setInterval(rotate,100)

        var xRotate = Math.floor((Math.random() * 3)+1);
        xRotate *= Math.floor(Math.random()*2) == 1 ? 1 : -1;
        var yRotate = Math.floor((Math.random() * 3)+1);
        yRotate *= Math.floor(Math.random()*2) == 1 ? 1 : -1;

        function rotate () {
            map.panBy(xRotate, yRotate);
        }
    </script>
    <?php } ?>
</body>