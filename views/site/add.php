<?php
use app\models\CityForm;

use yii\web\View;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * @var View $this
 * @var CityForm $city
 */
?>
    <h3>Add city</h3>
<?php
$this->title = 'Add city';
$form = ActiveForm::begin();
echo $form->field($city, 'name');
echo Html::submitButton();
ActiveForm::end();



