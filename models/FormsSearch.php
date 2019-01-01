<?php

namespace kouosl\forms\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use kouosl\forms\models\Forms;

/**
 * FormsSearch represents the model behind the search form of `kouosl\forms\models\Forms`.
 */
class FormsSearch extends Forms
{
     /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['form_id', 'maximum'], 'integer'],
            [['body', 'title', 'author', 'date_start', 'date_end', 'meta_title', 'url', 'response'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Forms::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'form_id' => $this->form_id,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'maximum' => $this->maximum,
        ]);

        $query->andFilterWhere(['like', 'body', $this->body])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'meta_title', $this->meta_title])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'response', $this->response]);

        return $dataProvider;
    }
}
