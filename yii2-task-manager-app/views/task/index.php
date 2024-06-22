<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap5\Modal;
use yii\helpers\Url;

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::button('Create Task', ['value' => Url::to(['task/create']), 'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </p>

    <?php
    Modal::begin([
        'title' => '<h4 id="modalTitle">Create Task</h4>',
        'id' => 'modal',
        'size' => 'modal-lg',
    ]);

    echo "<div id='modalContent'></div>";

    Modal::end();
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null, // Disable filtering inputs
        'options' => ['class' => 'table-responsive'],
        'tableOptions' => ['class' => 'table table-bordered table-striped table-hover'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'title',
                'headerOptions' => ['style' => 'width:20%'],
            ],
            'description:ntext',
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d/m/Y'],
                'headerOptions' => ['style' => 'width:15%'],
            ],
            [
                'attribute' => 'completed_at',
                'format' => ['date', 'php:d/m/Y'],
                'headerOptions' => ['style' => 'width:15%'],
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function($model) {
                    if ($model->status === 'completed') {
                        return '<span class="badge bg-success">Completed</span>';
                    } elseif ($model->status === 'ongoing') {
                        return '<span class="badge bg-info">Ongoing</span>';
                    } else {
                        return '<span class="badge bg-warning text-dark">Pending</span>';
                    }
                },
                'headerOptions' => ['style' => 'width:10%'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<i class="bi bi-eye"></i>', $url, [
                            'title' => Yii::t('app', 'View'),
                            'class' => 'btn btn-secondary btn-sm me-2',
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::button('Update', [
                            'value' => $url,
                            'class' => 'btn btn-primary btn-sm me-2 update-button',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::button('Delete', [
                            'value' => $url,
                            'class' => 'btn btn-danger btn-sm me-2 delete-button',
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>

<?php
$this->registerJs("
    $(function() {
        // Abre o modal de criação de tarefa
        $('#modalButton').click(function() {
            $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
            $('#modalTitle').text('Create Task');
        });

        // Abre o modal de atualização de tarefa
        $('.task-index').on('click', '.update-button', function() {
            $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
            $('#modalTitle').text('Update Task');
        });

        // Função para eliminar uma tarefa
        $('.task-index').on('click', '.delete-button', function() {
            if (confirm('Are you sure you want to delete this item?')) {
                $.post($(this).attr('value'), function(data) {
                    if (data.success) {
                        location.reload();
                    }
                });
            }
        });
    });
");
?>
