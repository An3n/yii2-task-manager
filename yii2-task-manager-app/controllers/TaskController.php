<?php

namespace app\controllers;

use Yii;
use app\models\Task;
use app\models\TaskSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;


/**
 * TaskController implementa as ações CRUD para o modelo Task.
 */
class TaskController extends Controller
{
    // Define os comportamentos do controlador
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],  // Permitir acesso apenas para usuários autenticados
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lista todas as instâncias de Task.
     * @return mixed
     */
    public function actionIndex()
    {
        // Cria um novo modelo de busca
        $searchModel = new TaskSearch();
        // Usa o modelo de busca para filtrar os dados de acordo com os parâmetros da requisição
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Renderiza a view 'index' com os dados do modelo de busca e o data provider
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Exibe uma única instância de Task.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException se o modelo não puder ser encontrado
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $this->checkAccess($model);

        // Renderiza a view 'view' com o modelo da tarefa encontrado pelo ID
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Cria uma nova instância de Task.
     * Se a criação for bem-sucedida, o navegador será redirecionado para a página 'view'.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Task();
        $model -> user_id = Yii::$app->user->id;

        // Verifica se os dados foram carregados no modelo e se foram guardados com sucesso
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Verifica se a requisição é AJAX
            if (Yii::$app->request->isAjax) {
                // Define o formato da resposta como JSON e retorna sucesso
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['success' => true];
            } else {
                // Redireciona para a view da tarefa criada
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        // Renderiza a view de criação de forma AJAX ou padrão
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create', [
                'model' => $model,
                'title' => 'Create Task'
            ]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Atualiza uma instância existente de Task.
     * Se a atualização for bem-sucedida, o navegador será redirecionado para a página 'view'.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException se o modelo não puder ser encontrado
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $this->checkAccess($model);

        // Verifica se os dados foram carregados no modelo e se foram guardados com sucesso
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Verifica se a requisição é AJAX
            if (Yii::$app->request->isAjax) {
                // Define o formato da resposta como JSON e retorna sucesso
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['success' => true];
            } else {
                // Redireciona para a view da tarefa atualizada
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        // Renderiza a view de atualização de forma AJAX ou padrão
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('update', [
                'model' => $model,
                'title' => 'Update Task'
            ]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Elimina uma instância existente de Task.
     * Se a exclusão for bem-sucedida, o navegador será redirecionado para a página 'index'.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException se o modelo não puder ser encontrado
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $this->checkAccess($model);

        // Verifica se a requisição é AJAX
        if (Yii::$app->request->isAjax) {
            // Elimina a tarefa e retorna uma resposta de sucesso
            $model->delete();
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['success' => true];
        }

        $model->delete();
        // Redireciona para a lista de tarefas
        return $this->redirect(['index']);
    }

    /**
     * Verifica se o utilizador atual tem permissão para aceder ao modelo.
     * @param Task $model
     * @throws NotFoundHttpException se o utilizador não tiver permissão
     */
    protected function checkAccess($model)
    {
        if ($model->user_id !== Yii::$app->user->id) {
            throw new NotFoundHttpException('You do not have permission to access this page.');
        }
    }

    /**
     * Encontra o modelo Task baseado no valor da chave primária.
     * Se o modelo não puder ser encontrado, uma exceção HTTP 404 será lançada.
     * @param integer $id
     * @return Task o modelo carregado
     * @throws NotFoundHttpException se o modelo não puder ser encontrado
     */
    protected function findModel($id)
    {
        // Tenta encontrar o modelo pelo ID e retorna-o se encontrado
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }

         // Lança uma exceção se o modelo não for encontrado
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
