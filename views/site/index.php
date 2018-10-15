<?php

    $this->title = 'Сайт с призами';
?>
<div class="indexdiv">
    <?php
        if(\Yii::$app->user->isGuest)
        {?>
            <p>В розыгрыше могут принимать участие только зарегистрированные пользователи.
                <a href="<?=Yii::$app->urlManager->createUrl(['/user/login']);?>">Войдите</a> или <a href="<?=Yii::$app->urlManager->createUrl(['/user/register']);?>">зарегистрируйтесь</a>.</p>
        <?php }
        else {?>
        <div class="startdiv">
            <div class="divbutton" style="margin-top: 100px;" id="startbutton">
                <a class="buttonstart" id="start">
                    Испытать удачу!
                </a>
            </div>
            <div style="text-align: center; margin-top: 10px;">
                <img style="width: 300px; height: 225px"  id="imgprize" alt="" src=""/>
                <p id="textp" style="font-size: 20px;"></p>
                <div id="moneydiv" style="display: none;">
                    <button id="getmoney">Получить на счёт</button>
                    <button id="changemoney">Поменять на балы (1 к 2)</button>
                </div>
                <div id="prizediv" style="display: none;">
                    <button id="getthing">Получить приз</button>
                    <button id="refusething">Отказаться от приза</button>
                </div>
            </div>
        </div>
         <div class="divbutton" style="display: none; margin-top: 50px;" id="mainbutton">
            <a class="buttonstart" href="/">
                На главную
            </a>
        </div>    
    <?php } ?>
</div>