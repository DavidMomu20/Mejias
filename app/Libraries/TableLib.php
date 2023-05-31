<?php

namespace App\Libraries;

use Codeigniter\Model;

class TableLib
{

    private $model;
    private $group;
    private $columns;

    public function __construct(Model $model, string $group, array $columns)
    {
        $this->model = $model;
        $this->group = $group;
        $this->columns = $columns;
    }

    public function getResponse(array $filters)
    {
        [
            "draw" => $draw, 
            "length" => $length, 
            "start" => $start, 
            "order" => $order, 
            "direction" => $direction
        ] = $filters;

        $page = ceil(($start - 1) / $length + 1);

        $data = $this->model
            ->orderBy($this->getColumn($order), $direction)
            ->paginate($length, $this->group, $page);

        return [
            "draw" => $draw,
            "recordsTotal" => $this->model->countAll(),
            "recordsFiltered" => $this->model->pager->getTotal($this->group),
            "data" => $data
        ];
    }

    private function getColumn($index)
    {
        return $this->columns[$index];
    }
}