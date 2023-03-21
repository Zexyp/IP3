<?php

class OrderBuilder {
    static function build(array $order) : string {
        return ' ORDER BY ' . implode(', ', array_map(function ($e) {
            $r = "`$e[0]` ";
            if ($e[1] < 0)
                $r .= 'ASC';
            if ($e[1] > 0)
                $r .= 'DESC';
            return $r;
        }, $order));
    }
}