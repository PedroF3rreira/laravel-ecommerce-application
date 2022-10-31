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

    /**
     * retorne todos os registros do banco de dados
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return mixed
     */
    public function all($columns = ['*'], string $orderBy = 'id', string $sortBy = 'asc');

    /**
     * retorne apenas um registro
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * busca por id ou retorna uma exceção
     * @param int $id
     * @return mixed
     */
    public function findOneOrFail(int $id);

    /**
     * Localiza com base em uma coluna
     * @param array $data
     * @return mixed
     */
    public function findBy(array $data);

    /**
     * localiza um regstro com base em uma coluna
     * @param array $data
     * @return mixed
     */
    public function findOneBy(array $data);

    /**
     * localiza por uma coluna ou lança uma exceçãos
     * @param array $data
     * @return mixed
     */
    public function findOneByOrFail(array $data);

    /**
     * deleta um registro pelo id
     * @param int $id
     * @return mixed
     */
    public function delete(int $id);
}
