<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
/* @var $this yii\web\View
 * @var $model backend\models\Users
 */

$this->title=empty($model->id)?"Добавление пользователя":"Редактирование: ".$model->username;
$form=ActiveForm::begin();
?>
<?= $form->field($model,'username')->textInput() ?>
<?= $form->field($model,'email')->textInput() ?>
<?= $form->field($model,'npassword')->passwordInput() ?>
<?= $form->field($model,'cpassword')->passwordInput() ?>
<?//echo $form->field($model, 'password')->passwordInput();
//echo $form->field($model,'country')->dropDownList($model->getCountrys());
?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
<?
ActiveForm::end();
?>