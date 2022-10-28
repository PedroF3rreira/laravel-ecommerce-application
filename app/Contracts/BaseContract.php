<?php
namespace App\Contracts;

interface BaseContract {

    /**
     * create model instance
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * update instance model
     * @param array $attributes
     * @param int $id
     * @return mixed
     */
    public function update(array $attributes, int $id);

}
