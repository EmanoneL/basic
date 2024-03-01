<?php

namespace app\controllers;

use app\models\Author;
use app\models\Book;
use app\models\Genre;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */

    public function actionIndex()
    {
        $genreFilter = Yii::$app->request->get('genre_filter');
        $authorFilter = Yii::$app->request->get('author_filter');

        $query = Book::find()->with('authors', 'genres');

        if ($genreFilter) {
            $query->joinWith(['genres' => function ($query) use ($genreFilter) {
                $query->where(['genre.idGenre' => $genreFilter]);
            }]);
        }

        if ($authorFilter) {
            $query->joinWith(['authors' => function ($query) use ($authorFilter) {
                $query->where(['author.idAuthor' => $authorFilter]);
            }]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $genres = Genre::find()->select(['name', 'idGenre'])->indexBy('idGenre')->column();
        $authors = Author::find()->select(['surname', 'idAuthor'])->indexBy('idAuthor')->column();


        $topAuthors = Author::find()
            ->select(['author.*, COUNT(book.idBook) as bookCount'])
            ->joinWith('books')
            ->groupBy('author.idAuthor')
            ->orderBy(['bookCount' => SORT_DESC])
            ->limit(3)
            ->all();

        $topGenres = Genre::find()
            ->select(['genre.*, COUNT(book.idBook) as bookCount'])
            ->joinWith('books')
            ->groupBy('genre.idGenre')
            ->orderBy(['bookCount' => SORT_DESC])
            ->limit(3)
            ->all();


        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'genres' => $genres,
            'authors' => $authors,
            'topAuthors' => $topAuthors,
            'topGenres' => $topGenres,
        ]);
    }

}
