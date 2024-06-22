<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Create Task';
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="task-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="task-form">

        <?php $form = ActiveForm::begin([
            'id' => 'task-form',
            'enableAjaxValidation' => false,
            'action' => $model->isNewRecord ? ['task/create'] : ['task/update', 'id' => $model->id],
            'options' => [
                'data-pjax' => '',
                'onsubmit' => new \yii\web\JsExpression('function(){ submitTaskForm(this); return false; }')
            ],
        ]); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        <?= $form->field($model, 'status')->dropDownList([
            'pending' => 'Pending',
            'completed' => 'Completed',
            'ongoing' => 'Ongoing',
        ]) ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>

<?php
$this->registerJs("
    // Função para submeter o formulário da tarefa
    function submitTaskForm(form) {
        $.post(
            $(form).attr('action'),
            $(form).serialize()
        )
        .done(function(data) {
            if (data.success) {
                $('#modal').modal('hide');
                $.pjax.reload({container: '#tasks-grid-pjax'});
            } else {
                alert('Error occurred while saving task');
            }
        })
        .fail(function() {
            alert('Error occurred while saving task');
        });
    }
");
?>


