<?php
$provider = $atts['provider'];
$data = $data ?? array();
$num = $atts['num'];

if ($provider == 'spotify') {
    $showUrlFunction = function($showUri) {
        return "https://open.spotify.com/show/" . str_replace('spotify:show:', '', $showUri);
    };
}

$output = '<div class="swiper tp-grid-container tp-carousel-container ' . $provider . '-podcasts swiper-container">
              <div class="swiper-wrapper">';

foreach ($data as $key => $entry) {
    if ($key >= $num) break;
    $imageUrl = ($provider == 'apple') ? str_replace('170x170', '300x300', $entry['im:image'][2]['label']) : $entry['showImageUrl'];
    $title = ($provider == 'apple') ? $entry['im:name']['label'] : $entry['showName'];
    $link = ($provider == 'apple') ? $entry['link']['attributes']['href'] : $showUrlFunction($entry['showUri']);
    $publisher = ($provider == 'apple') ? $entry['im:artist']['label'] : $entry['showPublisher'];
    $output .= '<div class="swiper-slide tp-grid-item">
                    <div class="tp-counter">' . ($key + 1) . '</div>
                    <a href="' . $link . '" target="_blank"><img class="tp-podcast-image" src="' . $imageUrl . '" alt="' . $title . '"></a>
                    <a href="' . $link . '" target="_blank"><h4 class="tp-podcast-title">' . $title . '</h4></a>
                    <div class="tp-podcast-publisher">' . $publisher . '</div>
                </div>';
}

$output .= '    </div>
            </div>';

echo $output;
