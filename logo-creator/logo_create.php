<?php
 include 'connection.php';

$fonts = [];
$fontname = "";

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['fontname']) && !empty($_POST['fontname'])) {
    $fontname = $_POST['fontname'];
    // $fonts[] = $fontname;

    $stmt = $conn->prepare("INSERT INTO MyFonts (fontname) VALUES (?)");
    $stmt->bind_param("s", $fontname);
    
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();

}

$result = $conn->query("SELECT fontname FROM MyFonts");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $fonts[] = $row['fontname'];
    }
}

// if (!empty($fontname)) {
//   $fonts[] = $fontname;
// }

$reversed_fonts = array_reverse($fonts);


$logotext = isset($_POST['text']) ? $_POST['text'] : "";

if ($_SERVER['REQUEST_METHOD'] == "POST" && $logotext) {
    $logotext = isset($_POST['text']) ? $_POST['text'] : "";
    $logoSuggestions = generateLogoSuggestions($logotext);    
}
else {
    $logoSuggestions = generateLogoSuggestions("My Logo");
}

function getRandomColor()
    {
        $letters = '0123456789ABCDEF';
        $color = '#';
        for ($i = 0; $i < 6; $i++) {
            $color .= $letters[rand(0, 15)];
        }
        return $color;
    }

function generateLogoSuggestions($text) {
    global $reversed_fonts;
    // global $grcolor;

    if (isset($_POST['generate'])) {
        
        $iconUrl  = $_POST['iconUrl'];
    
        $suggestions = '';
        foreach ($reversed_fonts as $reversed_font) {
        
            $grcolor = getRandomColor();

            $suggestions .= '<div class="logo-suggestion" style="font-family:' . $reversed_font . '; color:' . $grcolor . ';">' . $text .'<img src="'.$iconUrl. '" /></div>';
    
        }
        return $suggestions;
    }
}

//icons api key and its procedures

//freepik api key
$apiKey = 'FPSXe1a81cfc27ad4821aa06631025f83dbf';

$query = "logo";
$endpoint = "https://api.freepik.com/v1/icons?query=$query";

$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => $endpoint,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => [
    "x-freepik-api-key: $apiKey"
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  $data = json_decode($response, true);
  
  if (isset($data['data'])) {
    $icons = $data['data'];
  } else {
    $icons = [];
  }
}
?>

