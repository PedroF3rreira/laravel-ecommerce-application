<?php

namespace App\Repositories;

use App\Models\Category;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\CategoryContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instanciator\Exception\InvalidArgumentException;

class CategoryRepository extends BaseRepository implements CategoryContract{

	use UploadAble;

	public function __construct(Category $model)
	{
		parent::__construct($model);
		$this->model = $model;
	}

	/**
	 *
	 * @param  array  $columns determina colunas a serem retornadas
	 * @param  string $order   ordenação da lista por coluna
	 * @param  string $sort    orden da lista
	 * @return mixed
	 */
	public function listCategories(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
	{
		return $this->all($columns, $order, $sort);
	}

	/**
	 *
	 * @param  int    $id
	 * @return mixed
	 * @throws ModelNotFoundException
	 */
	public function findCategoryById(int $id)
	{
		try{
			return $this->findOneOrfail($id);
		}
		catch(ModelNotFoundException $e){
			throw new ModelNotFoundException($e);
		}
	}

    /**
     * @param array $params
     * @return mixed|Category
     * @throws InvalidArgumentException
     */
	public function createCategory(array $params)
	{
		try{

            //criando uma coleção dos dados passados como array
			$collection = collect($params);

			$image = null;

			if($collection->has('image') && ($params['image'] instanceof UploadedFile)){
				$image = $this->uploadOne($params['image'], 'categories');
			}

			$featured = $collection->has('featured') ?? 0;
			$menu = $collection->has('menu') ?? 0;

			$merger = $collection->merge(compact('menu', 'image', 'featured'));

			$category = new Category($merger->all());

			$category->save();

			return $category;
		}
		catch(QueryException $exception){
			throw new InvalidArgumentException($exception->getMessage());
		}
	}

    /**
     * @param array $params
     * @return mixed
     *
     */
    public function updateCategory(array $params)
    {
        $category = $this->findCategoryById($params['id']);

        $collection = collect($params)->except('_token');

        $image = null;

        if($collection->has('image') && ($params['image'] instanceof UploadedFile)){
            if($category->image != null){
                $this->deleteOne($category->image);
            }
            
            $image = $this->uploadOne($params['image'], 'categories');            
        }

        $featured = $collection->has('featured') ?? 0;
        $menu = $collection->has('menu') ?? 0;

        $merger = $collection->merge(compact('image', 'featured', 'menu'));

        $category->update($merger->all());

        return $category;
    }

    /**
     * @param int $id
     * @return bool|mixed
     */
    public function deleteCategory(int $id)
    {
        $category = $this->findCategoryById($id);

        if($category->iamge != null){
            $this->deleteOne($category->image);
        }

        $category->delete();

        return $category;
    }
}
