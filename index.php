<?php
// iTunes top podcasts
$itunes_endpoint = "https://itunes.apple.com/us/rss/toppodcasts/limit=100/json";
$itunes_response = file_get_contents($itunes_endpoint);
$itunes_data = json_decode($itunes_response, true);

// Spotify top podcasts
$spotify_endpoint = "https://podcastcharts.byspotify.com/api/charts/top?region=us";
$spotify_response = file_get_contents($spotify_endpoint);
$spotify_data = json_decode($spotify_response, true);

function getSpotifyShowUrl($showUri) {
  $showId = str_replace('spotify:show:', '', $showUri);
  return "https://open.spotify.com/show/$showId";
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/modern-normalize/1.1.0/modern-normalize.min.css" integrity="sha512-wpPYUAdjBVSE4KJnH1VR1HeZfpl1ub8YT/NKx4PuQ5NmX2tKuGu6U/JRp5y+Y8XG2tV+wKQpNHVUX03MfMFn9Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h2>Top 100 Apple Podcasts</h2>
    <div class="grid-container">
        <?php $counter = 1; ?>
        <?php foreach($itunes_data['feed']['entry'] as $entry): ?>
            <?php
            $image_url = $entry['im:image'][2]['label'];
            $title = $entry['im:name']['label'];
            $link = $entry['link']['attributes']['href'];
            ?>
            <div class="grid-item">
                <a href="<?php echo $link ?>" target="_blank">
                    <div><?php echo $counter ?></div>
                    <img src="<?php echo $image_url ?>">
                    <div><?php echo $title ?></div>
                </a>
            </div>
            <?php $counter++; ?>
        <?php endforeach; ?>
    </div>

    <h2>Top 100 Spotify Podcasts</h2>
    <div class="grid-container">
        <?php $counter = 1; ?>
        <?php foreach($spotify_data as $entry): ?>
            <?php
            $image_url = $entry['showImageUrl'];
            $title = $entry['showName'];
            $link = getSpotifyShowUrl($entry['showUri']);
            ?>
            <div class="grid-item">
                <a href="<?php echo $link ?>" target="_blank">
                    <div><?php echo $counter ?></div>
                    <img src="<?php echo $image_url ?>">
                    <div><?php echo $title ?></div>
                </a>
            </div>
            <?php $counter++; ?>
            <?php if ($counter > 100) break; ?>
        <?php endforeach; ?>
    </div>
</body>
</html>
