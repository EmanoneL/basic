<?php

use app\models\Author;
use app\models\Book;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;


/** @var yii\web\View $this */
/** @var app\models\AuthorSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var $genres */
/** @var $authors */
/** @var $topAuthors */
/** @var $topGenres */

$this->title = 'Books Information';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]);
    echo Html::beginForm(['site/index'], 'get');

    echo Html::dropDownList('genre_filter', Yii::$app->request->get('genre_filter'), $genres, ['prompt' => 'All Genres']);

    echo Html::dropDownList('author_filter', Yii::$app->request->get('author_filter'), $authors, ['prompt' => 'All Authors']);

    echo Html::submitButton('Filter', ['class' => 'btn btn-primary']);

    echo Html::endForm();
    ?>
    <?=


    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'name',
            'page_count',
            'publication_date',
            [
                'label' => 'Authors',
                'value' => function ($model) {
                    $authors = [];
                    foreach ($model->authors as $author) {
                        $authors[] = $author->name . ' ' . $author->surname;
                    }
                    return implode(', ', $authors);
                },
            ],
            [
                'label' => 'Genres',
                'value' => function ($model) {
                    $genres = [];
                    foreach ($model->genres as $genre) {
                        $genres[] = $genre->name;
                    }
                    return implode(', ', $genres);
                },
            ],
        ],
    ]);

    ?>

    <h2>Top 3 Authors by Number of Books</h2>
    <ul>
        <?php foreach ($topAuthors as $author): ?>
            <li><?= $author->name ?> <?= $author->surname ?> </li>
        <?php endforeach; ?>
    </ul>

    <h2>Top 3 Genres by Number of Books</h2>
    <ul>
        <?php foreach ($topGenres as $genre): ?>
            <li><?= $genre->name ?> </li>
        <?php endforeach; ?>
    </ul>



</div>
