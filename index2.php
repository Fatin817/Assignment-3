<?php error_reporting(0); ?> 
<!DOCTYPE html>
<html>
<head>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
</head>
<body>
    <div class="container ">
	 <h1 class="text-center"> Weather app </h1>
			<div class="row">
				<div class=" p-5 ">
					<div class=" text-dark text-sm-start text-md-center text-lg-center">
						<form action="index2.php" method="GET">
						<label for="city">City:</label>
					    <input type="text" id="city" name="city"  required>
						<input type="submit" class="btn btn-primary btn-sm" value="Get weather" class="add-button"/>
					</form >
                    </div>
                    </div>
                    </div>
    </div>
    <?php
$altText = " Image";
// Check if city is submitted
if (isset($_GET['city'])) {
    // Get city from form
    $city = $_GET['city'];

    // API URL
    $apiUrl = "http://api.openweathermap.org/data/2.5/forecast?q=$city&appid=71c10e114d9e62c08394d29b5c17871c&units=metric";

    // Fetch weather data from API
    $weatherDat = file_get_contents($apiUrl);

    // Decode JSON response
    $weatherDataa = json_decode($weatherDat, true);
    $cityName = $city;
    echo '<div id="weatherCarousel" class="carousel slide mt-5" data-bs-ride="carousel">';
    echo '<div class="container " >';
    echo "<h2 class='text-center' >Current Weather in $cityName</h2>";
    echo '</div>';
    echo '<div class="carousel-inner">';

    $totalCards = count($weatherDataa['list']);
    $cardsPerSlider = 3;
    $totalSliders = ceil($totalCards / $cardsPerSlider);
    $cardCounter = 0;

    for ($i = 0; $i < $totalSliders; $i++) {
        $active = ($i == 0) ? 'active' : '';
        echo '<div class="carousel-item ' . $active . '">';
        echo '<div class="container">';
        echo '<div class="row">';

        for ($j = 0; $j < $cardsPerSlider; $j++) {
            if ($cardCounter < $totalCards) {
                $weatherData = $weatherDataa['list'][$cardCounter];
                // Retrieve max temperature and min temperature
                $maxTemperature = $weatherData['main']['temp_max'];
                $minTemperature = $weatherData['main']['temp_min'];
                $iconCode = $weatherData['weather'][0]['icon'];
                $iconUrl = "https://openweathermap.org/img/w/$iconCode.png";
                $dtTxt = $weatherData["dt_txt"];
                $timestamp = strtotime($dtTxt);
                $formattedDate = date("d-M-Y", $timestamp);
                $formattedTime = date("h:i a", $timestamp);

                echo '<div class="col-md-4">';
                echo '<div class="card bg-secondary ">';
                echo '<div class="card-header  bg-primary text-white fs-4 ">' . $formattedDate . '  ' . $formattedTime . '</div>';
                echo '<div class="card-body">';
                echo '<img src="' . $iconUrl . '" alt="' . $altText . '" class="img-fluid rounded ">';
                echo '<p class="card-text fs-4 "><strong>Maximum Temperature : ' . $maxTemperature . '</strong>'.'</p>';
                echo '<p class="card-text display-8 fs-4"><strong>Minimum Temperature : ' . $minTemperature .'</strong>'. '</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';

                $cardCounter++;
            }
        }

        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

    echo '</div>';
    echo '<a class="carousel-control-prev " href="#weatherCarousel" role="button" data-bs-slide="prev">';
    echo '<span class="carousel-control-prev-icon bg-dark" aria-hidden="true"></span>';
    echo '<span class="visually-hidden" >Previous</span>';
    echo '</a>';
    echo '<a class="carousel-control-next" href="#weatherCarousel" role="button" data-bs-slide="next">';
    echo '<span class="carousel-control-next-icon bg-dark" aria-hidden="true"></span>';
    echo '<span class="visually-hidden">Next</span>';
    echo '</a>';
    echo '</div>';
}
?>

</body>
</html>