<?php

namespace App;

use App\Traits\DB;

class Post
{
    use DB;
    
    protected int $id;

    protected string $status;

    protected string $title;

    public function __construct($id)
    {
        $this->load($id);
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     * 
     * @return void
     */
    public function setstatus(string $status)
    {
        $this->status = $status;
    }

    public function toJson()
    {
        return json_encode([
            'id' => $this->id,
            'title' => $this->title,
            'status' => $this->status
        ]);
    }
}