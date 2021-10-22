<?php

class PrayerTimes {

	// Properties
	private $city;
	private $key;
	private $ip;
	public $imsak;
	public $fajr;
	public $dhuhr;
	public $asr;
	public $maghrib;
	public $isha;
	public $sunrise;
	public $sunset;
	public $timestamp;
	public $hijritime;
	public $timezone;
	public $country;
	public $mycity;
	public $countrycode;
	public $error;

	public function __construct($city) {
		
		// Intiating Data
		$this->city = $city;
		$this->key = "MagicKey";
	}

	public function getData() {
		// Grabbing Data From API
		$apiData = @file_get_contents("https://api.pray.zone/v2/times/today.json?city=".$this->city."&key=".$this->key);
		if ($apiData) {
		
			// Converting JSON to ARRAY
			$dataArray = json_decode($apiData, true);

			// Get the Data
			$this->imsak = $dataArray['results']['datetime']['0']['times']['Imsak'];
			$this->fajr = $dataArray['results']['datetime']['0']['times']['Fajr'];
			$this->dhuhr = $dataArray['results']['datetime']['0']['times']['Dhuhr'];
			$this->asr = $dataArray['results']['datetime']['0']['times']['Asr'];
			$this->maghrib = $dataArray['results']['datetime']['0']['times']['Maghrib'];
			$this->isha = $dataArray['results']['datetime']['0']['times']['Isha'];
			$this->sunrise = $dataArray['results']['datetime']['0']['times']['Sunrise'];
			$this->sunset = $dataArray['results']['datetime']['0']['times']['Sunset'];

			$this->timestamp = $dataArray['results']['datetime']['0']['date']['timestamp'];
			$this->hijritime = $dataArray['results']['datetime']['0']['date']['hijri'];

			$this->country = $dataArray['results']['location']['country'];
			$this->mycity = $dataArray['results']['location']['city'];
			$this->countrycode = $dataArray['results']['location']['country_code'];
			$this->timezone = $dataArray['results']['location']['timezone'];

			// Set TimeZone
			date_default_timezone_set($this->timezone);
			return true;

		}
	}

	// Function to get the client IP address
	public function getClintIp() {
	    if (isset($_SERVER['HTTP_CLIENT_IP']))
	        $this->ip = $_SERVER['HTTP_CLIENT_IP'];
	    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	        $this->ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    else if(isset($_SERVER['HTTP_X_FORWARDED']))
	        $this->ip = $_SERVER['HTTP_X_FORWARDED'];
	    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
	        $this->ip = $_SERVER['HTTP_FORWARDED_FOR'];
	    else if(isset($_SERVER['HTTP_FORWARDED']))
	        $this->ip = $_SERVER['HTTP_FORWARDED'];
	    else if(isset($_SERVER['REMOTE_ADDR']))
	        $this->ip = $_SERVER['REMOTE_ADDR'];
	    else
	        $this->ip = 'UNKNOWN';
	    return $this->ip;
	}

	public function ipData($ip) {
		// Grabbing Data From API
		$apiData = @file_get_contents("https://api.pray.zone/v2/times/today.json?ip=".$ip."&key=".$this->key);
		if ($apiData) {
		
			// Converting JSON to ARRAY
			$dataArray = json_decode($apiData, true);

			// Get the Data
			$this->imsak = $dataArray['results']['datetime']['0']['times']['Imsak'];
			$this->fajr = $dataArray['results']['datetime']['0']['times']['Fajr'];
			$this->dhuhr = $dataArray['results']['datetime']['0']['times']['Dhuhr'];
			$this->asr = $dataArray['results']['datetime']['0']['times']['Asr'];
			$this->maghrib = $dataArray['results']['datetime']['0']['times']['Maghrib'];
			$this->isha = $dataArray['results']['datetime']['0']['times']['Isha'];
			$this->sunrise = $dataArray['results']['datetime']['0']['times']['Sunrise'];
			$this->sunset = $dataArray['results']['datetime']['0']['times']['Sunset'];

			$this->timestamp = $dataArray['results']['datetime']['0']['date']['timestamp'];
			$this->hijritime = $dataArray['results']['datetime']['0']['date']['hijri'];

			$this->country = $dataArray['results']['location']['country'];
			$this->ipcity = $dataArray['results']['location']['city'];
			$this->countrycode = $dataArray['results']['location']['country_code'];
			$this->timezone = $dataArray['results']['location']['timezone'];

			// Set TimeZone
			date_default_timezone_set($this->timezone);
			return true;

		}
		else {
			return false;
		}
	}

	public function checkSite() {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $url = @file_get_contents("https://api.pray.zone/v2/times/today.json?city=".$this->city."&key=".$this->key);

        $options = array(
                CURLOPT_RETURNTRANSFER => true,      // return web page
                CURLOPT_HEADER         => false,     // do not return headers
                CURLOPT_FOLLOWLOCATION => true,      // follow redirects
                CURLOPT_USERAGENT      => $useragent, // who am i
                CURLOPT_AUTOREFERER    => true,       // set referer on redirect
                CURLOPT_CONNECTTIMEOUT => 2,          // timeout on connect (in seconds)
                CURLOPT_TIMEOUT        => 2,          // timeout on response (in seconds)
                CURLOPT_MAXREDIRS      => 10,         // stop after 10 redirects
                CURLOPT_SSL_VERIFYPEER => false,     // SSL verification not required
                CURLOPT_SSL_VERIFYHOST => false,     // SSL verification not required
        );
        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        curl_exec($ch);

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($httpcode == 200) {
        	return true;
        } else {
        	return false;
        }
}

}