<?php
    
    // Including Class Files
    include 'classes/PrayerTimes.class.php';
    
    // Set the Default Site Link and Title
    $sitelink = "http://localhost/prayertimes/";
    $title = "Islamic Prayer Times";
    
    // If Data is Submitted
    if(isset($_POST['submit']) AND (!empty($city = $_POST['city']))) {
        
        // Grabbing Data
        $city = $_POST['city'];
        header('location: '.$sitelink.''.$city.'.html');
    }
    
    if(isset($_GET['city']) AND (!empty($_GET['city']))){
        // Grabbing Data
        $city = $_GET['city'];
        $title = "Prayer Times of ".ucwords($city);
        
        // Object and Methods
        $prayerTimes = new PrayerTimes($city);
        $result = $prayerTimes->getData();
        $dataresult = $prayerTimes->country;
    }
    
    if(!isset($_GET['city']) AND (empty($_GET['city']))){
        // Grabbing Data
        $city = null;
        $prayerTimes = new PrayerTimes($city);
        $ip = $prayerTimes->getClintIp();
        $ipData = $prayerTimes->ipData($ip);
    }
    
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Get current Prayer times of your city." />
        <meta name="keywords" content="prayer times, salat times, namaj times" />
        <meta name="author" content="Saidul Mursalin: fb/itzmonir" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content= "width=device-width, user-scalable=no" />
        
        <!-- .//Open Graph Protocol Properties -->
        <meta property="og:url" content="<?php echo $sitelink; ?>" />
        <meta property="og:title" content="Islamic Prayer Times" />
        <meta property="og:description" content="Get current Prayer times of your city." />
        <meta property="og:image" content="<?php echo $sitelink; ?>img/prayertimes_ogp.jpg" />
        
        <title><?php echo $title ?></title>
        
        <!-- .//Bootstrap and Custom CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo $sitelink; ?>css/app.css" rel="stylesheet" />
        
        <!-- .//Favicon -->
        <link rel="icon" href="<?php echo $sitelink; ?>img/prayer_icon.png" type="image/gif" />
        
    </head>
    <body>
        <div class="container">
            <div class="wrapper">
                <div class="content">
                    <!-- .//Nav -->
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <div class="container-fluid">
                            <img src="<?php echo $sitelink; ?>img/prayer_icon.png"><a class="navbar-brand" href="<?php echo $sitelink; ?>">PrayerTimes</a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                                <div class="navbar-nav">
                                    <a class="nav-link active" aria-current="page" href="<?php echo $sitelink; ?>">Home</a>
                                    <a class="nav-link" href="http://miniscripts.ml/weather" target="_blank">Weather</a>
                                    <a class="nav-link" href="http://miniscripts.ml/prayertimes">PrayerTimes</a>
                                    <a class="nav-link" href="http://miniscripts.ml" target="_blank">MiniScripts</a>
                                    <a class="nav-link" href="https://github.com/r0ck70" target="_blank">GitHub</a>
                                    <a class="nav-link" href="https://facebook.com/itzmonir" target="_blank">Contact</a>
                                </div>
                            </div>
                        </div>
                    </nav>
                    <div class="row justify-content-center">
                        <div class="col-md-3">
                            <!-- .//Form -->
                            <div class="form">
                                <form class="form-inline" action="" method="POST">
                                    <div class="form-group mx-sm-3 mb-2">
                                        <label for="city" class="sr-only">Enter Your City</label>
                                        <input type="text" id="city" name="city" placeholder="Ex: Jamalpur" value="<?php if(isset($city)) { echo $city; } ?>" required />
                                    </div>
                                    <div class="form-group mx-sm-3 mb-2">
                                        <input type="submit" class="button" name="submit" value="Show Times" />
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- .//Main Contents -->
                            <div class="main-contents">
                                
                                <?php  if(!isset($_GET['city']) AND ($ipData)) {
                                ?>
                                <!-- .// Times From IP -->
                                <table class="table text-center">
                                    <thead>
                                        <tr>
                                            <th>শহর</th>
                                            <th>দেশ</th>
                                            <th>টাইমজোন</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $prayerTimes->ipcity; ?></td>
                                            <td><?php echo $prayerTimes->country; ?> 
                                            <img src="flag/<?php echo strtolower($prayerTimes->countrycode); ?>.png"></td>
                                            <td><?php echo $prayerTimes->timezone; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th scope="col">সুবেহ সাদিক</th>
                                            <th scope="col">ফজর</th>
                                            <th scope="col">সূর্যোদয় </th>
                                            <th scope="col">যোহর</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo date("h:i A", strtotime($prayerTimes->imsak)); ?></td>
                                            <td><?php echo date("h:i A", strtotime($prayerTimes->fajr)); ?></td>
                                            <td><?php echo date("h:i A", strtotime($prayerTimes->sunrise)); ?></td>
                                            <td><?php echo date("h:i A", strtotime($prayerTimes->dhuhr)); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th scope="col">আসর</th>
                                            <th scope="col">সূর্যাস্ত</th>
                                            <th scope="col">মাগরিব</th>
                                            <th scope="col">ইশা</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo date("h:i A", strtotime($prayerTimes->asr)); ?></td>
                                            <td><?php echo date("h:i A", strtotime($prayerTimes->sunset)); ?></td>
                                            <td><?php echo date("h:i A", strtotime($prayerTimes->maghrib)); ?></td>
                                            <td><?php echo date("h:i A", strtotime($prayerTimes->isha)); ?></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <?php } 
                                if(isset($_GET['city']) AND (!empty($dataresult))) {
                                ?>
                                <!-- .// Times From City -->
                                <table class="table text-center">
                                    <thead>
                                        <tr>
                                            <th>শহর</th>
                                            <th>দেশ</th>
                                            <th>টাইমজোন</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $prayerTimes->mycity; ?></td>
                                            <td><?php echo $prayerTimes->country; ?> 
                                            <img src="flag/<?php echo strtolower($prayerTimes->countrycode); ?>.png"></td>
                                            <td><?php echo $prayerTimes->timezone; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th scope="col">সুবেহ সাদিক</th>
                                            <th scope="col">ফজর</th>
                                            <th scope="col">সূর্যোদয় </th>
                                            <th scope="col">যোহর</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo date("h:i A", strtotime($prayerTimes->imsak)); ?></td>
                                            <td><?php echo date("h:i A", strtotime($prayerTimes->fajr)); ?></td>
                                            <td><?php echo date("h:i A", strtotime($prayerTimes->sunrise)); ?></td>
                                            <td><?php echo date("h:i A", strtotime($prayerTimes->dhuhr)); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th scope="col">আসর</th>
                                            <th scope="col">সূর্যাস্ত</th>
                                            <th scope="col">মাগরিব</th>
                                            <th scope="col">ইশা</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo date("h:i A", strtotime($prayerTimes->asr)); ?></td>
                                            <td><?php echo date("h:i A", strtotime($prayerTimes->sunset)); ?></td>
                                            <td><?php echo date("h:i A", strtotime($prayerTimes->maghrib)); ?></td>
                                            <td><?php echo date("h:i A", strtotime($prayerTimes->isha)); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <?php }
                                if(isset($_GET['city']) AND (empty($dataresult))) {

                                    print '<div class="alert alert-danger" role="alert"><p class="text-center">Something went wrong!</p><p class="text-center">We are sorry for the interruption. Please search again.</p></div>';

                                }   ?>
                            </div>
                        </div>
                    </div>
                </div>
                <h6 class="align-items-end text-center">&copy; 2021 <a href="http://miniscripts.ml">MiniScripts</a> by <a href="https://fb.me/itzmonir">Saidul Mursalin</a></h6>
            </div>
        </div>
        <!-- .//JavaScripts -->
        <!-- <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    </body>
</html>