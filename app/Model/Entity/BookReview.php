<?php

namespace App\Model\Entity;

use \App\Db\Database;
class BookReview
{

    public int $id;

    public string $name;

    public string $message;

    public string $createdDate;

    public function insertBookReview(): bool
    {
        $this->createdDate = date('Y-m-d H:i:s');
        $this->id = (new Database('bookReviews'))->insert([
            'name' => $this->name,
            'message' => $this->message,
            'createdDate' => $this->createdDate
        ]);
        return true;
    }

    public function updateBookReview()
    {
        return (new Database('bookReviews'))->update('id = '.$this->id,[
            'name' => $this->name,
            'message' => $this->message,
            'createdDate' => $this->createdDate
        ]);
    }

    public function deleteBookReview()
    {
        return (new Database('bookReviews'))->delete('id = '.$this->id);
    }

    public static function getBookReviewById(int $id)
    {
        return self::getBookReviews('id = '.$id)->fetchObject(self::class);
    }

    public static function getBookReviews($where = '', $order = '', $limit = '', $fields = '*')
    {
        return (new Database('bookReviews'))->select($where,$order,$limit,$fields);
    }

}