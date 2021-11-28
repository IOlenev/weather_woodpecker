# Weather Woodpecker
Fun web application peck each hour weather forecasts follows list of cities. Based on Yii2 basic template 


REQUIREMENTS
------------

Any computer with Docker & Git installed (but no warranties ;)


INSTALLATION
------------

### Install steps for Docker users

1. Create directory named on your taste
~~~
mkdir wwp.local
~~~
2. Change directory
~~~
cd wwp.local
~~~
3. Clone repo
~~~
git clone https://github.com/IOlenev/weather_woodpecker.git
~~~
4. Prepare directory tree and Run shell script from the project`s docker directory to build and run docker containers
~~~
mv weather_woodpecker www && cd www/docker && sh build.sh
~~~
5. Edit the file `config/params-local.php`. Set API key param value from your [openweathermap.org](https://openweathermap.org) account
```php
return [
    'weather.openweather.apikey' => '[your API key]',
];
```
6. Append two host records to system file hosts
~~~
127.0.0.1   wwp.local
127.0.0.1   wwp.pma
~~~
7. Open app url [wwp.local](http://wwp.local)
8. Open phpmyadmin db client (optional)  [wwp.pma](http://wwp.pma:81)