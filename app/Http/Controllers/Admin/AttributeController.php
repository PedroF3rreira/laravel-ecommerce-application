<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Contracts\AttributeContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instanciator\Exception\InvalidArgumentException;

class AttributeController extends BaseController
{

    protected $attributeRepository;

    public function __construct(AttributeContract $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    
        $attributes = $this->attributeRepository->listAttributes();
        
        $this->setPageTitle('Atributos', 'Todos atributos de produtos');
        
        return view('admin.attributes.index',compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setPageTitle('Attributos', 'Criar Atributos');

        return view('admin.attributes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required',
            'code'          => 'required',
            'frontend_type' => 'required'
        ]);

        $params = $request->except('_token');

        $attribute = $this->attributeRepository->createAttribute($params);

        if(!$attribute){
            return $this->responseRedirectBack('Ocorreu um erro ao cadastrar o atributo', 'error', true, true);
        }

        return $this->responseRedirect('admin.attributes.index', 'Attributo '.$attribute->code.' cadastrado', 'success', false, false);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $attribute = $this->attributeRepository->findAttributeById($id);

        $this->setPageTitle('Atributos', 'editar Atributo');

        return view('admin.attributes.edit', compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {   
        $request->validate([
            'name'          => 'required',
            'code'          => 'required',
            'frontend_type' => 'required'
        ]);

        $params = $request->except('_token');

        $attribute = $this->attributeRepository->updateAttribute($params);

        if(!$attribute){
            return $this->responseRedirectBack('Ocorreu um erro ao editar o atributo', 'error', true, true);
        }

        return $this->responseRedirect('admin.attributes.index', 'Attributo '.$attribute->code.' editado', 'success', false, false);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attribute = $this->attributeRepository->deleteAttribute($id);

        if(!$attribute){
            return $this->responseRedirectBack('ocorreu um erro ao deletar atributo', 'error', false, false);
        }
        return $this->responseRedirectBack('atributo deletado com exito', 'success', false, false);
    }
}
