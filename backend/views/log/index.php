<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Logs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-index box">

    <div class="box-header with-border">

        <table>
        <tr>
        <td>
        <?= Html::a(Yii::t('app', 'Delete All'), ['delete-all'], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete all log data?'),
                'method' => 'post',
            ],
        ]) ?>&nbsp;</td>
        <td>
        <?= $fullExportMenu = ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'filename' => 'Try Out Apps U-Kom '.date('Y-m-d'),
            'target' => ExportMenu::TARGET_SELF,
            'fontAwesome' => true,
            'pjaxContainerId' => 'kv-pjax-container',
            'dropdownOptions' => [
                'label' => 'Export',
                'class' => 'btn btn-default',
                'itemsBefore' => [
                    '<li class="dropdown-header">Export All Data</li>',
                ],
            ],
            'exportConfig' => [
                ExportMenu::FORMAT_HTML => false,
                ExportMenu::FORMAT_TEXT => false,
                ExportMenu::FORMAT_PDF => false,
            ],
            'columns' => [
                'id',
                [
                    'attribute' => 'level',
                    'value' => function($model) 
                    {   
                        return \yii\Log\Logger::getLevelName($model->level);
                    },
                ],
                'category',
                [
                    'attribute' => 'log_time',
                    'format' => 'raw',
                    'value' => function($model) 
                    {   
                        $arr = explode('.', $model->log_time);
                        $arr[1] = isset($arr[1]) ? '.'.$arr[1] : '';
                        return date('Y-m-d H:i:s'.$arr[1], $arr[0]);
                    }
                ],
                'prefix',
                'message',
            ],
        ]); ?>
        </td>
        </tr>
        </table>

    </div>
    <div class="box-body">

    <?php Pjax::begin(); ?>    
    <?= GridView::widget([
        'tableOptions'=> ['class' => 'table'],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => '',
                'format' => 'raw',
                'contentOptions' => ['class' => 'options'],
                'value' => function($model) {
                    return '
                        <a href="'.Url::to(['view', 'id' => $model->id]).'" class="btn btn-xs btn-default btn-text-info"><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="'.Url::to(['delete', 'id' => $model->id]).'" class="btn btn-xs btn-default btn-text-danger" data-method="post" data-confirm="Are you sure you want to delete this item?" ><i class="glyphicon glyphicon-trash"></i></a>
                    ';
                }
            ],

            // 'id',
            [
                'attribute' => 'level',
                'contentOptions' => ['class' => 'text-mono'],
                'value' => function($model) 
                {   
                    return \yii\Log\Logger::getLevelName($model->level);
                },
                'filter' => [
                    '1' => 'error',
                    '2' => 'warning',
                    '4' => 'info',
                    '8' => 'trace',
                    '64' => 'profile',
                    '80' => 'profile begin',
                    '96' => 'profile end',
                ],
            ],
            'category',
            // 'log_time',
            [
                'attribute' => 'log_time',
                'format' => 'raw',
                'contentOptions' => ['class' => 'text-mono'],
                'value' => function($model) 
                {   
                    $arr = explode('.', $model->log_time);
                    $arr[1] = isset($arr[1]) ? '.'.$arr[1] : '';
                    return str_replace(' ', '<br>', date('Y-m-d H:i:s'.$arr[1], $arr[0]));
                }
            ],
            [
                'attribute' => 'prefix',
                'format' => 'html',
                'contentOptions' => ['class' => 'text-mono'],
                'value' => function($model) 
                {
                    return str_replace(']', ']<br>', $model->prefix);
                }
            ],
            [
                'attribute' => 'message',
                'format' => 'html',
                'contentOptions' => ['class' => 'text-mono', 'style' => 'white-space:normal'],
                'value' => function($model) 
                {
                    return substr($model->message, 0, 200).' . . . ';
                }
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>

    </div>
</div>
