<?php

/**
 * @var $this yii\web\View
 */

use app\models\CityRecord;
use app\models\ForecastRecord;

use yii\grid\GridView;
use yii\data\ArrayDataProvider;

$this->title = 'Weather forecasts';

?>
<div class="site-index">

    <div class="text-center">
        <p><a class="btn btn-lg btn-success" href="/site/add">Add City</a></p>
        <p>
            <?php
            foreach (CityRecord::find()->all() as $row) {
                ?>
                <a class="btn" nohref><?=$row->name?></a>
                <?php
            }
            ?>
        </p>
    </div>

    <div class="body-content">
        <div class="row">
            <?php
            echo GridView::widget([
                'dataProvider' => new ArrayDataProvider(['allModels' => ForecastRecord::getLast()->all()]),
                'columns' => [
                    ['label' => 'City', 'attribute' => 'id', 'format' => 'raw', 'value' => function ($forecast) { return $forecast->name;} ],
                    ['label' => 'Date', 'attribute' => 'created', 'value' => function($forecast) { return date('d.m.Y H:i', strtotime($forecast->created)); } ],
                    ['label' => 'Forecast', 'attribute' => 'forecastDetail', 'format' => 'raw', 'value' =>
                        function ($forecast) {
                            /**
                             * @var ForecastRecord $forecast
                             */
                            //return var_export($forecast, true);
                            return $forecast->html;
                            //return json_encode($forecast->detail->data);
                        }],
                ]]);
            ?>
        </div>
    </div>
</div>
