<?php

namespace kouosl\forms\controllers\frontend;


use Yii;
use kouosl\forms\models\Forms;
use kouosl\forms\models\FormsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kouosl\forms\FormBase;
use kouosl\forms\Form;
use kouosl\forms\FormBuilder;
use kouosl\forms\email\Send;
use yii\helpers\Url;
use yii\web\Response;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

/**
 * FormsController implements the CRUD actions for Forms model.
 */
class FormsController extends \yii\web\Controller
{
   /**
     * @var array List all actions to rule of access
     */
    protected $list_action = ['index', 'create', 'update', 'delete', 'list'];
        
    
    /**
     * @var string Prefix table (if you need storage data in SQL)
     */
        protected $table = 'poll_';
        
        public function behaviors() {
            return [
                'access' => [
                        'class' => \yii\filters\AccessControl::className(),
                        'only' => $this->list_action,
                        'rules' => [
                            [
                                'allow' => true,
                                'roles' => ['?'],
                            ],
                            [
                                'allow' => true,
                                'actions' => $this->list_action,
                                'roles' => ['@'],
                            ],
                            
                        ],
                    ],
                    'verbs' => [
                        'class' => VerbFilter::className(),
                        'actions' => [
                            'delete' => ['post'],
                        ],
                    ],
                ];
            }
            
      /**
     * Index Controller.
     *
     * List of all forms
     * @return Void View
    */
    public function actionIndex()
    {
        $searchModel = new FormsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * View Controller.
     *
     * Preview form.
     * @return Void View
    */
    public function actionView($id)
    {
        $form = Forms::findModelByUrl($url);
            $r = Yii::$app->request;
    
        
            if ($r->isAjax && $r->isGet) {
                echo $form->body;
                return;
    
            }
    
    
            if (($data = Yii::$app->request->post('DynamicModel')) !== null) {
                
                foreach ($data as $i => $v) {
                    if (is_array($data[$i])) $data[$i] = join(',', $data[$i]);
                }
                
                $query = Yii::$app->db->createCommand()->insert($this->table.$form->form_id, $data);
                
                if ($query->execute()){
                    
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Registration successfully completed'));
                    
                    if (isset($data['email']) && isset(Json::decode($form->body)['response'])){
                        Send::widget([
                            'from' => 'info@seda.net',
                            'to' => $data['email'],
                            'subject' => Yii::t('app', 'Registration successfully completed'),
                            'textBody' => Json::decode($form->body)['response'],
                        ]);
                    }
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('app', 'An confirmation email was not sent'));
                }
                
                return $this->redirect(['index']);
            } else {
                return $this->render('view', [ 'form' => $form->body] );
            }
    }

  /**
     * Create Controller.
     *
     * Create form - FormBuilder
     * @return Void View
    */   	
    public function actionCreate(){
        
        $r = Yii::$app->request;
        
         if ($r->isAjax && $r->post('form_data')) {
         
             $form = new FormBuilder(['table' => $this->table]);
             $form->load($r->post());
            $form->save();
            $form->createTable();
     return $form->response();
            
        } else {
            return $this->render('create');
        }
    }
/**
     * Update Controller.
     *
     * Update form - FormBuilder
     * @return Void View
    */   
    public function actionUpdate($id){
       
        $form = new FormBuilder(['table' => $this->table.$id]);
        $form->findModel($id);
        $r = Yii::$app->request;
        
        if ($r->isAjax) {
            \Yii::$app->response->format = 'json';
            
            switch (true) { 
                case $r->isGet: 
                    echo $form->model->body; break;
                
                case $r->post('form_data'): 
                    
                    $form->load($r->post());
                    
                    return ['success' => $form->save()]; 
                
                case $r->post('add'):
                    return ['success' => $form->addColumn($r->post('add'))];
                
                case $r->post('delete'):
                    return ['success' => $form->dropColumn($r->post('delete'))];
                
                case $r->post('change'):
                    return ['success' => $form->renameColumn($r->post('change'))];
                              
                default: return ['success' => false];
            }
            
        } else {
            return $this->render('update', ['id' => $id]);
        }
    }
    /**
     * Deletes an existing Forms model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $form = new FormBuilder();
            $form->model->findModel($id)->delete();
            return $this->redirect(['index']);
    }
    public function actionList($id) {
        
        $query = (new \yii\db\Query)->from($this->table.$id);
        $form = Forms::findModel($id);
        $array = Json::decode($form->body);
        
        $merge_array = FormBase::onlyCorrectDataFields($array['body']);
        
        $dataProvider = new \yii\data\ActiveDataProvider(['query' => $query]);
        
         return $this->render('list', [
         //   'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'only_data_fields' => ArrayHelper::getColumn($merge_array, 'name')
        ]);
    }
    
    
   
}
