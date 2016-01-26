<?php  
require_once('includes/settings.php');
session_start();

if (!isset($_SESSION['user'])) {
    header('location: index.php');
} 
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
    <div id="map" class="blur"></div>

    <div class="formBox">
        <div class="innerBox">
            <div id="imageWrap">
                <img src="image/logo.png" alt="Logo">
            </div>
            <form action="includes/newFab.php" method="POST">
                <div id="info">
                    <label for="name">Fab name:</label>
                    <input type="text" id="name" name="name">
                    <label for="id">Alternatief Id:</label>
                    <input type="text" id="id" name="id">
                </div>
                <div id="address">
                    <label for="">Location:</label>
                    <div id="location">
                        <div class="locationInput">
                            <input type="text" id="lat" name="lat" placeholder="Latitude">
                        </div>
                        <div class="locationInput">
                            <input type="text" id="lng" name="lng" placeholder="Longitude">
                        </div>
                        <div class="locationInput" id="geolocation">
                            <i class="ion-pinpoint"></i>
                        </div>
                    </div>
                    <label for="">Straat:</label>
                    <div id="streetWrap">
                        <input type="text" name="street" placeholder="Bakkersweg" id="street">
                        <input type="number" name="number" placeholder="31" id="number">
                    </div>
                    <label for="city">City</label>
                    <input type="text" name="city" id="city" placeholder="Rotterdam">
                    <label for="postalCode">Postcode</label>
                    <input type="text" id="postalCode" name="postalCode" placeholder="3571 AM">
                </div>
                <input type="submit" value="Nieuw Fab" id="newFabButton">
            </form>
        </div>
    </div>

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
    <script src="https://maps.googleapis.com/maps/api/js?key=<?=KEY?>&callback=initMap"></script>
    <script src="scripts/location.js"></script>
    <script src="node_modules/mfb/src/mfb.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
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
</body>