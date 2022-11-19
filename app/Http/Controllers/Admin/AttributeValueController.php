<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Contracts\AttributeContract;

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
}
