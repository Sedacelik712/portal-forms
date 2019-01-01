<?php
namespace kouosl\forms;

use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\web\HttpException;


/**
 * forms module definition class
 */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'kouosl\forms\controllers';
    public $defaultRoute = 'forms';
    public $table;
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
 
    public function table(){
		return $this->table;
	}
    public function registerTranslations()
    {
        Yii::$app->i18n->translations['site/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@kouosl/forms/messages',
            'fileMap' => [
                'forms/forms' => 'forms.php',
            ],
        ];
    }

    
 
}
