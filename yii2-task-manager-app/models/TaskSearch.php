<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Task;

/**
 * TaskSearch representa o modelo para a forma de pesquisa `app\models\Task`.
 */
class TaskSearch extends Task
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['title', 'description', 'status', 'created_at', 'completed_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // Ignora a implementação de scenarios() na classe pai
        return Model::scenarios();
    }

    /**
     * Cria uma instância de provedor de dados com consulta de pesquisa aplicada
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Task::find();

        // Adiciona condições que sempre devem ser aplicadas aqui
        $query->andWhere(['user_id' => \Yii::$app->user->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // Descomente a linha seguinte se você não quiser retornar nenhum registro quando a validação falhar
            // $query->where('0=1');
            return $dataProvider;
        }

        // Condições de filtro de grade
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'completed_at' => $this->completed_at,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
