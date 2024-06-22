<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="task-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::button('Delete', [
            'class' => 'btn btn-danger',
            'id' => 'deleteButton',
            'data-id' => $model->id,
            'data-url' => Url::to(['task/delete', 'id' => $model->id]),
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            'description:ntext',
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d/m/Y'],
            ],
            [
                'attribute' => 'completed_at',
                'format' => ['date', 'php:d/m/Y'],
            ],
            'status',
        ],
    ]) ?>

</div>

<?php
$this->registerJs("
    // Função para eliminar uma tarefa
    $('#deleteButton').click(function() {
        if (confirm('Are you sure you want to delete this item?')) {
            $.ajax({
                url: $(this).data('url'),
                type: 'POST',
                success: function(data) {
                    if (data.success) {
                        window.location.href = '" . Url::to(['task/index']) . "';
                    } else {
                        alert('Error occurred while deleting the task');
                    }
                },
                error: function() {
                    alert('Error occurred while deleting the task');
                }
            });
        }
    });
");
?>
