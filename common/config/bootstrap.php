<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@uploads', dirname(dirname(__DIR__)) . '/uploads');
Yii::setAlias('@employee', dirname(dirname(__DIR__)) . '/employee');
Yii::setAlias('@client', dirname(dirname(__DIR__)) . '/client');


require __DIR__ . '/../../common/config/functions.php';