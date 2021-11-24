<?php
return [
    'weather' => function() {
        return new app\components\weather\WeatherComponent(
            'app\components\weather\OpenWeatherProvider'
        );
    },
];
