<?php  
require_once('includes/settings.php')
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

    <!-- Custom Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
</head>
<body>
    <div id="map">
        
    </div>
    <aside id="menu" class="asideOpen">
        <div id="search">
            <div id="searchWrap">
                <div id="menuButton" class="">
                    
                </div>
                <div id="bar">
                    <input type="text" id="address" placeholder="Zoeken, Postcode, etc.">
                </div>
                <div id="searchOption">
                    <div id="delete">
                        
                    </div>
                    <div id="searchButton">
                        
                    </div>
                </div>
            </div>
            <div id="searchResults">
                
            </div>
        </div>
        <div id="searchBackground">
                
        </div>
        <ul id="results">
        </ul>
        <div id="opener">
            
        </div>
    </aside>

    <ul class="mfb-component--br mfb-zoomin" data-mfb-toggle="click" data-mfb-state="closed">
        <li class="mfb-component__wrap">
    <!-- the main menu button -->
    <a data-mfb-label="menu" class="mfb-component__button--main">
      <!-- the main button icon visibile by default -->
      <i class="mfb-component__main-icon--resting"></i>
      <!-- the main button icon visibile when the user is hovering/interacting with the menu -->
      <i class="mfb-component__main-icon--active"></i>
    </a>
    <ul class="mfb-component__list">
      <!-- a child button, repeat as many times as needed -->
      <li>
        <a href="link.html" data-mfb-label="test" class="mfb-component__button--child">
          <i class="mfb-component__child-icon"></i>
        </a>
      </li>
    </ul>
  </li>
    </ul>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="scripts/init.js"></script>
    <script src="scripts/Location.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?=KEY?>&callback=initMap"></script>

    <script src="node_modules/mfb/src/mfb.js"></script>
</body>