<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Genre".
 *
 * @property int $idGenre
 * @property string $name
 */
class Genre extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Genre';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idGenre' => 'Id Genre',
            'name' => 'Name',
        ];
    }

    public function getBooks()
    {
        return $this->hasMany(Book::className(), ['idBook' => 'idBook'])
            ->viaTable('genre_has_book', ['idGenre' => 'idGenre']);
    }


}
