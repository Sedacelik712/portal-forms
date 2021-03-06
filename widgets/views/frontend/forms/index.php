<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $searchModel kouosl\forms\models\FormsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'FormBuilder';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
.btn-purple{background-color:#6C006C;color: #FFF;}
    .btn-black:hover{color: #FFF;}
</style>
<h1><?= Yii::t('app', 'FormBuilder') ?></h1>


	<?= Html::a(Yii::t('app', 'Create form'), ['create'], ['class'=>'btn btn-purple']) ?>
	
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
					return Html::a ( '<span class="glyphicon glyphicon-eye-open" style="color:red" aria-hidden="true"></span> ', ['forms/view', 'url' => $model->url] );
				},
		        'list' => function ($url, $model, $key) {
					return Html::a ( '<span class="glyphicon glyphicon-th-list" style="color:red" aria-hidden="true"></span> ', ['forms/list', 'id' => $model->form_id] );
				},
            ],
			'template' => '{update} {view} {delete} {list}'
            
            
            ],
        ],
    ]); ?>
    
  




    
