<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model kouosl\forms\models\Forms */

$this->title = 'Form generator Yii2';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Forms') , 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Form create');


echo \kouosl\forms\widgets\FormBuilder::widget([
		'test_mode' => false,
		'easy_mode' => true
]);
?>