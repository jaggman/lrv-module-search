<?php

namespace Modules\Search\Models;

use Eloquent as Model;
use DB;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Log extends Model {

    protected $table = 'trace_log';
    protected $connection = 'search';
    public $timestamps = false;
    
    private function raw($string){
        return DB::connection($this->connection)->raw($string);
    }
    
    public static function stat($back = 2,$diff = 1) //время в часах: back - на сколько назад смотрим, diff - за какой период
    {
        if((int) $back < 1 ) $back = 1;
        if((int) $diff < 1 ) $diff = 1;
        $stat = new self();
        return $stat::
            select($stat->raw(implode(', ', [
                'FROM_UNIXTIME(UNIX_TIMESTAMP(min(`time_s`))-`time`) `start`',
                'SUM(`time`) `curltime`',
                '`time` `timef`',
                'max(`time_s`)-min(`time_s`)+`time` `usertime`',
                'SUM(`size`) `size`',
                '`searchId` `search`',
                'count(`id`) `cnt`',
            ])))
            //->whereBetween('time_s', ['NOW()-10800','NOW()-7200'])
            ->whereRaw('`time_s` between FROM_UNIXTIME(UNIX_TIMESTAMP(NOW())-'.(($back+$diff)*3600).') and FROM_UNIXTIME(UNIX_TIMESTAMP(NOW())-'.($back*3600-1800).')')
            ->groupBy('search')
            ->having($stat->raw('min(`time_s`)'), 'between', $stat->raw('FROM_UNIXTIME(UNIX_TIMESTAMP(NOW())-'.(($back+$diff)*3600).') AND FROM_UNIXTIME(UNIX_TIMESTAMP(NOW())-'.($back*3600).')'))
            ->orderBy('start', 'asc')
            //->toSql()
            ->get()
                ;
    }
}