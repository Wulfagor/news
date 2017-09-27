<?php

use yii\widgets\Pjax;
use yii\helpers\Url;
use app\components\Great;
use app\assets\Select2Asset;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\widgets\LinkPager;

Select2Asset::register($this);

$this->title = 'News';
?>

<div id="section_news" class="clearfix">

    <div class="s_n_title"><?= $this->title ?></div>

    <div class="row">

        <?php

        Pjax::begin([
            'id' => 'news-list-pjax',
            'enablePushState' => true,
            'scrollTo' => 1
        ]);

        $form = ActiveForm::begin([
            'id' => 'news-filter-form',
            'action' => Url::to(['/site/index']),
            'method' => 'get',
            'enableAjaxValidation' => false,
            'enableClientValidation' => false,
            'validateOnBlur' => false,
            'validateOnType' => false,
            'validateOnChange' => false
        ]);

        echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
        echo $form->field($searchModel, 'page_size')->label('News number per page', [
            'class' => 'filter_label'
        ])->widget(Select2::classname(), [
            'data' => [
                5 => 5,
                10 => 10,
                15 => 15,
                20 => 20
            ],
            'hideSearch' => true,
            'options' => ['placeholder' => 'Choose number'],
            'theme' => 'custom',
            'pluginEvents' => [
                'change' => 'function(){
                    $("#news-filter-form").submit();
                }'
            ]
        ]);
        echo '</div>';

        ActiveForm::end();

        if ($dataProvider->getTotalCount() > 0) {

            foreach ($dataProvider->getModels() as $key => $value) {

                echo '<div class="col-lg-6 col-md-6">';
                echo '<div class="s_h_one_section">';

                echo '<a href="' . Url::to(['/news/view', 'id' => $value->id]) . '" data-pjax="0">';

                $use_image = Yii::getAlias('@web') . '/images/no-photo.png';

                if (!empty($value->image)) {
                    $use_image = Yii::getAlias('@web') . $value->image;
                }

                echo '<div class="s_h_o_s_image_block" style="background: url(' . $use_image . ') center center no-repeat; background-size: cover;"></div>';

                echo '<div class="s_h_o_inner">';

                echo '<div class="s_h_o_s_time"><span class="glyphicon glyphicon-time"></span>' . date('d F Y', $value->created_at) . '</div>';
                echo '<div class="s_h_o_s_title">' . Great::cut_text($value->title, 150) . '</div>';
                echo '<div class="s_h_o_s_description">' . Great::cut_text($value->description_mini, 150) . '</div>';

                echo '</div>';

                echo '</a>';

                echo '</div>';
                echo '</div>';

            }

            echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center pagination_main">';
            echo LinkPager::widget([
                'pagination' => $dataProvider->pagination,
                'activePageCssClass' => 'pagination_widget_item_active',
                'linkOptions' => [
                    'class' => 'pagination_widget_item'
                ]
            ]);
            echo '</div>';

        } else
            echo '<p class="simply_text text-center">No result found</a>';

        Pjax::end();

        ?>

    </div>
</div>
