<?php
// Set the number of podcasts to display
$numOfPodcasts = 100;

// Get iTunes top podcasts
$itunesEndpoint = "https://itunes.apple.com/us/rss/toppodcasts/limit=$numOfPodcasts/json";
$itunesResponse = file_get_contents($itunesEndpoint);
$itunesData = json_decode($itunesResponse, true);

// Get Spotify top podcasts
$spotifyEndpoint = "https://podcastcharts.byspotify.com/api/charts/top?region=us";
$spotifyResponse = file_get_contents($spotifyEndpoint);
$spotifyData = json_decode($spotifyResponse, true);

// Function to get Spotify show URL
function getSpotifyShowUrl($showUri)
{
    return "https://open.spotify.com/show/" . str_replace('spotify:show:', '', $showUri);
}

// Output HTML
?>
<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top <?php echo $numOfPodcasts ?> Podcasts from Apple and Spotify</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h2>Top <?php echo $numOfPodcasts ?> Apple Podcasts</h2>
    <div class="grid-container apple-podcasts">
        <?php foreach ($itunesData['feed']['entry'] as $key => $entry) :
            if ($key >= $numOfPodcasts) break;
            $imageUrl = $entry['im:image'][2]['label'];
            $title = $entry['im:name']['label'];
            $link = $entry['link']['attributes']['href'];
        ?>
            <a class="grid-item" href="<?php echo $link ?>" target="_blank">
                <div class="counter"><?php echo $key + 1 ?></div>
                <img class="podcast-image" src="<?php echo $imageUrl ?>" alt="<?php echo $title ?>" loading="lazy">
                <div class="podcast-title"><?php echo $title ?></div>
            </a>
        <?php endforeach; ?>
    </div>
    <h2>Top <?php echo $numOfPodcasts ?> Spotify Podcasts</h2>
    <div class="grid-container spotify-podcasts">
        <?php foreach ($spotifyData as $key => $entry) :
            if ($key >= $numOfPodcasts) break;
            $imageUrl = $entry['showImageUrl'];
            $title = $entry['showName'];
            $link = getSpotifyShowUrl($entry['showUri']);
        ?>
            <a class="grid-item" href="<?php echo $link ?>" target="_blank">
                <div class="counter"><?php echo $key + 1 ?></div>
                <img class="podcast-image" src="<?php echo $imageUrl ?>" alt="<?php echo $title ?>" loading="lazy">
                <div class="podcast-title"><?php echo $title ?></div>
            </a>
        <?php endforeach; ?>
    </div>
</body>
</html>
