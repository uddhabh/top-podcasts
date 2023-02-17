<?php
$endpoint = "https://itunes.apple.com/us/rss/toppodcasts/limit=100/json";
$response = file_get_contents($endpoint);
$data = json_decode($response, true);
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            grid-gap: 20px;
        }

        .grid-item {
            text-align: center;
        }

        .grid-item img {
            display: block;
            margin: 0 auto;
            max-width: 100%;
        }

        .grid-item a {
            color: black;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="grid-container">
        <?php $counter = 1; ?>
        <?php foreach($data['feed']['entry'] as $entry): ?>
            <?php
            $image_url = $entry['im:image'][2]['label'];
            $title = $entry['im:name']['label'];
            $link = $entry['link']['attributes']['href'];
            ?>
            <div class="grid-item">
                <a href="<?php echo $link ?>" target="_blank">
                    <div><?php echo $counter . ". " ?></div>
                    <img src="<?php echo $image_url ?>">
                    <div><?php echo $title ?></div>
                </a>
            </div>
            <?php $counter++; ?>
        <?php endforeach; ?>
    </div>
</body>
</html>
