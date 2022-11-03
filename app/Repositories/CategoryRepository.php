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
	public function listCategories(array $columns = ['*'], string $order = 'id', string $sort = 'desc')
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

	public function createCategory(array $params)
	{
		try{

			$collection = collect($params);

			$image = null;

			if($collection->has('image') && ($params['image'] instanceof UploadedFile)){
				$image = $this->uploadOne($params['image'], 'categories');
			}

			$feature = $collection->has('featured') ?? 0;
			$menu = $collection->has('menu') ?? 0;

			$merger = $collection->merge(compact('menu', 'image', 'featured'));

			$category = new Category($merge->all());

			$category->save();

			return $category;
		}
		catch(QueryException $exception){
			throw new InvalidArgumentException($exception->getMessage());
		}
	}
}