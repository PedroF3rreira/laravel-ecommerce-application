<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Contracts\AttributeContract;
use App\Models\AttributeValue;

class AttributeValueController extends BaseController
{
    protected $attributeRepository;

    public function __construct(AttributeContract $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    /**
     * 
     * @param  Request $request [description]
     * @return mixed|json
     */
    public function getValues(Request $request)
    {
        $attributeId = $request->input('id');

        $attribute = $this->attributeRepository->findAttributeById($attributeId);

        $values = $attribute->values;

        return response()->json($values);
    }

    /**
     * 
     * @param Request $request
     */
    public function addValues(Request $request)
    {
        $value = new AttributeValue();
        $value->attribute_id = $request->input('id');
        $value->price = $request->input('price');
        $value->value = $request->input('value');
        $value->save();

        return response()->json($value); 
    }

    /**
     * 
     * @param  Request $request 
     * @return mixed
     */
    public function updateValues(Request $request)
    {
        $attributeValue = AttributeValue::findOrFail($request->input('valueId'));
        $attributeValue->attribute_id = $request->input('id');
        $attributeValue->price = $request->input('price');
        $attributeValue->value = $request->input('value');
        $attributeValue->save();

        return response()->json($attributeValue);
    }

    public function deleteValues($id)
    {
        
        
    }
}
