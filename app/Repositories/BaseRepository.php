<?php
namespace App\Repositories;
use App\Contracts\BaseContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BaseRepository implements BaseContract{

    /**
     * @var null
     */
    protected $model = null;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    /**
     * create model instance
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
       return $this->model->create($attributes);
    }

    /**
     * update instance model
     * @param array $attributes
     * @param int $id
     * @return mixed
     */
    public function update(array $attributes, int $id)
    {
       return $this->model->find($id)->update($attributes);
    }

    /**
     * retorne todos os registros do banco de dados
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return mixed
     */
    public function all($columns = ['*'], string $orderBy = 'id', string $sortBy = 'asc')
    {
        return $this->model->orderBy($orderBy, $sort)->get($columns);
    }

    /**
     * retorne apenas um registro
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * busca por id ou retorna uma exceção
     * @param int $id
     * @return mixed
     */
    public function findOneOrFail(int $id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Localiza com base em uma coluna
     * @param array $data
     * @return mixed
     */
    public function findBy(array $data)
    {

    }

    /**
     * localiza um regstro com base em uma coluna
     * @param array $data
     * @return mixed
     */
    public function findOneBy(array $data)
    {

    }

    /**
     * localiza por uma coluna ou lança uma exceçãos
     * @param array $data
     * @return mixed
     */
    public function findOneByOrFail(array $data)
    {

    }

    /**
     * deleta um registro pelo id
     * @param int $id
     * @return mixed
     */
    public function delete(int $id)
    {

    }
}
