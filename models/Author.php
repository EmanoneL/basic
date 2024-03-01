<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Author".
 *
 * @property int $idAuthor
 * @property string $name
 * @property string $surname
 */
class Author extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Author';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname'], 'required'],
            [['name', 'surname'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idAuthor' => 'Id Author',
            'name' => 'Name',
            'surname' => 'Surname',
        ];
    }

    public function getBooks()
    {
        return $this->hasMany(Book::className(), ['idBook' => 'idBook'])
            ->viaTable('book_has_author', ['idAuthor' => 'idAuthor']);
    }


}
