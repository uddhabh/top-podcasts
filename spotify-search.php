<?php
$spotify_client_id = '8ae6c8d75d2a434d8b3558ba7f319cb6';
$spotify_client_secret = '58489260866944b1bdce810aaeec161d';

// Get an access token from the Spotify API
$authOptions = array(
  'url' => 'https://accounts.spotify.com/api/token',
  'headers' => array(
    'Authorization: Basic '.base64_encode($spotify_client_id.':'.$spotify_client_secret)
  ),
  'form' => array(
    'grant_type' => 'client_credentials'
  ),
  'json' => true
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $authOptions['url']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $authOptions['headers']);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($authOptions['form']));
$response = curl_exec($ch);
curl_close($ch);

if ($response) {
  $body = json_decode($response, true);
  if (isset($body['access_token'])) {
    $access_token = $body['access_token'];
  }
}

// Use the access token to get the top podcasts
if (isset($access_token)) {
  $apiEndpoint = 'https://api.spotify.com/v1/search';
  $apiOptions = array(
    'headers' => array(
      'Authorization: Bearer '.$access_token
    ),
    'query' => array(
      'q' => '*',
      'type' => 'show',
      'market' => 'US',
      'limit' => 10
    )
  );

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $apiEndpoint.'?'.http_build_query($apiOptions['query']));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $apiOptions['headers']);
  $response = curl_exec($ch);
  curl_close($ch);

  if ($response) {
    $body = json_decode($response, true);
    echo '<script>console.log('.json_encode($body).')</script>';
  }
}
?>
