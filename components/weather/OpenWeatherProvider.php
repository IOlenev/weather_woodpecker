<?php
namespace app\components\weather;

/**
 * Provids weather forecast by weather service openweathermap.org
 */
class OpenWeatherProvider implements WeatherInterface
{
    const _API_KEY_ = "weather.openweather.apikey";
    const _API_URL_ = "https://api.openweathermap.org/data/2.5/weather";
    const _API_LANG_ = 'ru';

    private $_params;
    private $_error;

    public function __construct()
    {
        $this->_params = [
            'appid' => \Yii::$app->params[self::_API_KEY_],
            'lang' => self::_API_LANG_,
        ];
    }

    /**
     * @inheritDoc
     */
    public function byCity(string $city): ?string
    {
        return $this->request(['q' => $city]);
    }

    /**
     * @inheritDoc
     */
    public function getError(): ?string
    {
        return $this->_error;
    }

    /**
     * request service API
     * @param array $params
     * @return string|null
     */
    protected function request(array $params) : ?string
    {
        $this->_error = null;
        $ch = curl_init();
        try {
            $params = http_build_query(array_merge($this->_params, $params));
            $url = sprintf("%s?%s", self::_API_URL_, $params);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            $result = curl_exec($ch);
            if (curl_getinfo($ch, CURLINFO_RESPONSE_CODE) != 200) {
                throw new \Exception('Error ' . $result . ' in ' . __METHOD__);
            }
        } catch(\Exception $e) {
            $this->_error = $e->getMessage();
            $result = null;
        }
        curl_close($ch);

        return $result;
    }
}