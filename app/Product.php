<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function getSql()
    {
        $builder = $this->getBuilder();
        $sql = $builder->toSql();
        foreach($builder->getBindings() as $binding)
        {
            $value = is_numeric($binding) ? $binding : "'".$binding."'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        return $sql;
    }

    public function category()
    {
        return $this->belongsTo('\App\Category');
    }
}
