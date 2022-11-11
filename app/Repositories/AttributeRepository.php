<?php
namespace App\Repositories;
use App\Models\Attribute;
use App\Contracts\AttributeContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instanciator\Exception\InvalidArgumentException;

class AttributeRepository extends BaseRepository implements AttributeContract
{
	
	/**
	 * construtor de AttributeRepository
	 * @param Attribute $Attribute
	 */
	public function __construct(Attribute $model)
	{
		parent::__construct($model);
		$this->model = $model;
	}

	/**
	 * **
	 * @param  string $order   
	 * @param  string $sort    
	 * @param  array  $columns
	 * @return mixed           
	 */
	public function listAttributes(string $order='id', string $sort='asc', array $columns=['*']){
		return $this->all($columns, $order, $sort);
	}

	/**
	 * @param  int    $id 
	 * @return mixed
	 * @throws ModelNotFoundException
	 */
	public function findAttributeById(int $id){
		try{
			
			return $this->findOneOrfail($id);
		}
		catch(ModelNotFoundException $e){
			throw new ModelNotFoundException($e);
		}
	}

	/**
	 * @param  array  $params 
	 * @return Attribute|mixed
	 */
	public function createAttribute(array $params){

		try{

			$collection = collect($params);

			$is_filterable = $collection->has('is_filterable') ? 1 : 0;
			$is_required = $collection->has('is_required') ? 1 : 0;

			$merge = $collection->merge(compact('is_filterable', 'is_required'));

			$attribute = new Attribute($merge->all());

			$attribute->save();

			return $attribute;
		}
		catch(QueryException $e){
			throw new InvalidArgumentException($e->getMessage());
		}
	}

	/**
	 * @param  array  $params
	 * @return mixed
	 */
	public function updateAttribute(array $params){
		
		$attribute = $this->findAttributeById($params['id']);

		$collection = collect($params);

		$is_filterable = $collection->has('is_filterable') ? 1 : 0;
		$is_required = $collection->has('is_required') ? 1 : 0;

		$merge = $collection->merge(compact('is_filterable', 'is_required'));

		$attribute->update($merge->all());

		return $attribute;

	}
	
	/**
	 * @param  int    $id
	 * @return bool
	 */
	public function deleteAttribute(int $id){
		
		$attribute = $this->findAttributeById($id);

		$attribute->delete();

		return $attribute;

	}
	
}