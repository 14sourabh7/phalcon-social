<?php

use Phalcon\Mvc\Model;

class Stats extends Model
{
    public $post_id;
    public $stats;

    public function getStats($id)
    {
        $stats = Stats::find($id);
        return json_encode($stats);
    }
}
