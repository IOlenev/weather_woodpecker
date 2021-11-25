<?php

/* @var $this yii\web\View */

use app\models\CityRecord;
use yii\helpers\Url;

$this->title = 'Cities';

?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <p><a class="btn btn-lg btn-success" href="/site/add">Add City</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <?php
            foreach (CityRecord::find()->all() as $row) {
                ?>
                <a class="btn" href="<?=Url::to(['city', 'id' => $row->id])?>"><?=$row->name?></a>
                <?php ;
            }

            ?>
        </div>

    </div>
</div>
