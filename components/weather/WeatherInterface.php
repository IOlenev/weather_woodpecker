<?php
namespace app\components\weather;

/**
 * weather component interface
 */
interface WeatherInterface
{
    /**
     * get weather forecast data by city name
     * @param string $city - city name
     * @return string|null
     */
    public function byCity(string $city) : ?string;

    /**
     * get weather component last request error
     * @return string|null
     */
    public function getError() : ?string;
}