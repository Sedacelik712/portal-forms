<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $searchModel kouosl\forms\models\FormsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'FormBuilder';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Yii::t('app', 'FormBuilder') ?></h1>


	<?= Html::a(Yii::t('app', 'Create form'), ['create'], ['class' => 'btn btn-success']) ?>
	
   <?= \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
             [
				'attribute' => 'url',
				'format' => 'html',
				'value' => function ($m, $key) {
							return  Html::a ( $m->url, ['forms/view', 'url' => $m->url], ['target' => 'new']);
						},
			],

            ['class' => 'yii\grid\ActionColumn',
            
            'buttons' => [
		        'view' => function ($url, $model, $key) {
					return Html::a ( '<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> ', ['forms/view', 'url' => $model->url] );
				},
		        'list' => function ($url, $model, $key) {
					return Html::a ( '<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> ', ['forms/list', 'id' => $model->form_id] );
				},
            ],
			'template' => '{update} {view} {delete} {list}'
            
            
            ],
        ],
    ]); ?>
    
  




    
