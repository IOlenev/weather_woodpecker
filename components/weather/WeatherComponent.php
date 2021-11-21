<?php
namespace app\components\weather;

/**
 * weather component
 */
class WeatherComponent implements WeatherInterface
{
    /**
     * @var WeatherInterface
     */
    private $_provider;

    public function __construct(string $class)
    {
        if (class_exists($class)) {
            $this->_provider = new $class;
        }

        if (empty($this->_provider)) {
            throw new \Exception('Weather component unknown provider class');
        }
    }

    /**
     * @inheritDoc
     */
    public function byCity(string $city): ?string
    {
        return $this->_provider->byCity($city);
    }

    public function getError(): ?string
    {
        return $this->_provider->getError();
    }
}