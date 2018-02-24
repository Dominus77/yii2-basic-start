<?php

/**
 * @var $this yii\web\View
 * @var $model modules\admin\models\User
 * @var $url string
 */

use yii\helpers\Html;
use yii\helpers\Url;
use modules\admin\Module;

$this->registerJs(new yii\web\JsExpression("
    $(function () {
        $('[data-toggle=\"tooltip\"]').tooltip();
        $('#auth_key_link').click(ajaxLinkGenerateAuthKey);
    });
"), yii\web\View::POS_END);

$url = (isset($url)) ? $url : Url::to(['generate-auth-key', 'id' => $model->id]);
?>
<div id="auth_key_container">
    <div class="col-md-6">
        <code><?= $model->auth_key ?></code>
    </div>
    <div class="col-md-6">
        <?= Html::a('<span class="glyphicon glyphicon-refresh"></span> ' . Module::t('users', 'Generate'), $url, [
            'id' => 'auth_key_link',
            'class' => 'btn btn-sm btn-default',
            'title' => Module::t('users', 'Generate new key'),
            'data' => [
                'toggle' => 'tooltip',
                'pjax' => 0,
            ]
        ]); ?>
    </div>
</div>
