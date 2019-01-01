<?php 
namespace kouosl\forms;
use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\base\Widget;
use kouosl\forms\Form;
use kouosl\forms\FormBase;
use kouosl\forms\models\Forms;



class FormBuilder extends Widget {
    /**
     * @var bool If true FormBuilder set test data on begin
     * @since 1.0
     */
    
	public $test_mode = false;

    /**
     * @var bool If true - only basic options of form and fields
     * @since 1.0
     */
    
	public $easy_mode = true;

    /**
     * @var bool If true - form can send email response
     * @since 1.4
     */
    
	public $email_response = false;
	
    /**
     * @var array  Configuration data from widget/user
     * @since 1.0
     */
	public $config = [];
    
    /**
     * @var array Configuration data for JavaScript assets  
     * @since 1.0
     */
	private $options = [];

	
	/**
	 * @var string Table name eg. form_, poll_ 
	 * @since 1.0
	 */
	public $table;

    /**
     * @var Forms Model data
     * @since 1.0
     */
	public $model;

    
    /**
     * @var bool Response from backend to message success 
     * @since 1.0
     */
	public $success = false;  	// for response
		
    /**
     * Initializes the object.
     *
     * Variables and functions init
     * @since 1.0
     *
    */
	public function init() {
		parent::init();
		
		$this->registerTranslations();
		$this->model = new Forms();
		
        $this->options = [
			'easy_mode' => $this->easy_mode,
			'test_mode' => $this->test_mode,
			'email_response' => $this->email_response,
			'update' => false,
			'config' =>  $this->config
		];
	}

/**
    * Executes the widget.
    * @since 1.0
    * @return void
*/
	public function run() {
		return $this->formBuilderRender();
	}

/**
    * Populates the model with input ajax data.
    * @since 1.0
    * @param object $data Data from request post
    * @return null 
*/
	public function load($data) {
	    
		$this->model->body = $data['form_data'];
		$this->model->title = (isset($data['title'])) ? $data['title'] : null;
		$this->model->url = (isset($data['url'])) ? $data['url'] : null; 
		$this->model->meta_title = (isset($data['title'])) ? $data['title'] : null; 
	
	}
	
    /**
     * Creates an yii\db\ActiveQueryInterface instance for query purpose.
     * @since 1.0
     * @param int $id Data from request post
     * @return null
    */
	public function findModel($id) {
		$this->model = $this->model->findModel($id);
	}
	
    /**
     * Saves the current record.
     * @since 1.0
     * @return array|bool Return message error or true if saved corretly
    */	
    public function save() {
    
   		if (!($this->success = $this->model->save())){
   			 return $this->success = $this->model->getFirstErrors();
   		} else {
   			return true;
   		}
   		
	}
    /**
     * Populates the model with input data.
     * @since 1.0
     * @see FormBase::tableShema
     * @return array Return array table shema for self::createTable()
    */	
    protected function tableShema(){
		$form_body = Json::decode($this->model->body)['body'];
    	return FormBase::tableShema($form_body);
    }
    
    

/**
 * Create table
 * Creates a SQL command for creating a new DB table. Execute the SQL statement. 
 * If table crate table correctly @return array message success
 * @since 1.0
 * @return object Return json message callback
*/
	public function createTable() {
		
        if ($this->success === true){
			$table_name = $this->table . $this->model->getPrimaryKey();
			$query = Yii::$app->db->createCommand()->createTable($table_name, $this->tableShema(), 'CHARACTER SET utf8 COLLATE utf8_general_ci'); 

            return $this->execute($query);
		}
	}


	
/**
 * Add column 
 * Creates a SQL command for adding a new DB column and execute.
 * @since 1.0
 * @param array|bool $field
 * @return object Return json message callback
*/
	public function addColumn($field = false) {
		
		if (isset($field['name'])){
		
			$column_name = $field['name'];
			$column_type = FormBase::getColumnType($field);

        	$query = Yii::$app->db->createCommand()->addColumn($this->table, $column_name, $column_type ); 
        
		    return $this->execute($query);
		}
	}

/**
 * Rename column 
 * Creates a SQL command for renaming a column and execute.
 * @since 1.0
 * @param array $name Array with old and new name of the column.
 * @return object Return json message callback
*/
	public function renameColumn($name) {
		
		if ( !isset($name['old']) && !isset($name['new']) && $name['old'] === $name['new'] ){
			return $this->success = false;
		}
    	$query = Yii::$app->db->createCommand()->renameColumn( $this->table, $name['old'],$name['new']); 
        
       	return $this->execute($query);
	}

/**
 * Drop column 
 * Creates a SQL command for dropping a DB column. and execute.
 * @since 1.0
 * @param string $column The name of the column to be dropped.
 * @return object Return json message callback
*/
	public function dropColumn($column) {
		
       $query = Yii::$app->db->createCommand()->dropColumn($this->table, $column); 
       
       return $this->execute($query);
	}
	
	
    /**
     * Executes the SQL statement and @return array callback.
     * @since 1.0
     * @param object $query
     * @return object Return json message callback
    */	
	public function execute($query){
		
        try {
            $query->execute();
            $this->success = true;
        } catch (\Exception $e) {
            return $this->success = $e->errorInfo[2];
        }

        return $this->response();
    }

    /**
     * Function @return array for ajax callback
     * @since 1.0
     * @param string $format format response
     * @return array Return json message callback
    */		
	public function response($format = 'json') {
	
		\Yii::$app->response->format = $format;
		return ['success' => $this->success, 'url' => Url::to(['index'])];
	}

    /**
     * Render view
     * @since 1.0
     * @return void
    */		
	public function formBuilderRender() {
	
		return $this->render('builder/main', $this->options );
	}

    /**
     * Translates a message to the specified language.
     * @since 1.0
     * @return null
    */		
	public function registerTranslations() {
	
        Yii::$app->i18n->translations['builder'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@backend/modules/portalforms/messages',
            
        ];
    }

   
}
    
?>
