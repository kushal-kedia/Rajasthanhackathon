<?php 
$servername = "localhost";
$username = "root";
$password = "root";

// Create connection
$conn = new mysqli($servername, $username, $password,'etow');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$regId = $_POST["regid"];
$towerId = $_POST["towerid"];
$sql = "SELECT PhoneNumber from ownerdetails where RegistrationNumber ='".$regId."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $phoneNumber = $row["PhoneNumber"];
    }
} else {
    echo "0 results";
}
$sql =  "SELECT warehouseaddress from towerwarehouse where towerid =".$towerId;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
         $pickupaddress = $row["warehouseaddress"];
    }
} else {
    echo "0 results";
}
echo $phoneNumber;
echo $pickupaddress;

$apiKey = urlencode('KlUv522D1Ng-glS5HZw9TQNuyjj4P3Lw7HxGkOubSk');
        
        // Message details
        $numbers = array($phoneNumber);
        $sender = urlencode('TXTLCL');
        $message = rawurlencode('Your Vehical '.$regId. 'Has been towed up from near Rajasthan college , you can pick it from '.$pickupaddress.' after paying a fine of rs 300');
 
        $numbers = implode(',', $numbers);
 
        // Prepare data for POST request
        $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
 
        // Send the POST request with cURL
        $ch = curl_init('https://api.textlocal.in/send/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        
        // Process your response here
        echo $response;
$conn->close();





?>
