<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Book".
 *
 * @property int $idBook
 * @property int $ISBN
 * @property string $name
 * @property int $page_count
 * @property string|null $publication_date
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ISBN', 'name', 'page_count'], 'required'],
            [['ISBN', 'page_count'], 'integer'],
            [['name', 'publication_date'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idBook' => 'Id Book',
            'ISBN' => 'Isbn',
            'name' => 'Name',
            'page_count' => 'Page Count',
            'publication_date' => 'Publication Date',
        ];
    }

    /**
     * Relationships
     */
//    public function getAuthors()
//    {
//        return $this->hasMany(Author::class, ['idBook' => 'idAuthor'])
//            ->viaTable('book_has_author', ['idBook' => 'idBook']);
//    }
    public function getAuthors()
    {
        return $this->hasMany(Author::className(), ['idAuthor' => 'idAuthor'])
            ->viaTable('book_has_author', ['idBook' => 'idBook']);
    }


    public function getGenres()
    {
        return $this->hasMany(Genre::className(), ['idGenre' => 'idGenre'])
            ->viaTable('genre_has_book', ['idBook' => 'idBook']);
    }
}
