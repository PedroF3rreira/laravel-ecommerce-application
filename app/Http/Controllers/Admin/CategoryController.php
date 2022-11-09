<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Contracts\CategoryContract;

class CategoryController extends BaseController
{

    protected $categoryRepository;

    public function __construct(CategoryContract $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryRepository->listCategories();

        $this->setPageTitle('Categorias', 'Categorias');

        return view('admin.categories.index', compact('categories'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categoryRepository->listCategories('id', 'asc');
        $this->setPageTitle('Categorias', 'Cadastro de categorias');

        return view('admin.categories.create', compact('categories'));
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
            'name' => 'required|string|max:191',
            'parent_id' => 'required|not_in:0',
            'image' => 'mimes:jpg,jpeg,png|max:1000'
        ]);

        $params = $request->except('_token');

        $category = $this->categoryRepository->createCategory($params);

        if(!$category){
            return $this->responseRedirectBack(
                'Um erro ocorreu no cadastro da categoria',
                'error',
                true,
                true
            );
        }

        return $this->responseRedirect('admin.categories.index', 'Categoria adicionada com exito!', 'success', false, false);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $targetCategory = $this->categoryRepository->findCategoryById($id);
        $categories = $this->categoryRepository->listCategories('id', 'desc');
        $this->setPageTitle('Editar Categoria', $targetCategory->name);

        return view('admin.categories.edit', compact('categories', 'targetCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'parent_id' => 'required|not_in:0',
            'image' => 'mimes:jpg,jpeg,png|max:1000'
        ]);

        $params = $request->except(['_token', 'method']);

        $category = $this->categoryRepository->updateCategory($params);

        if(!$category){
            return $this->responseRedirectBack('Ocorreu um erro ao atualizar categorias', 'error', true, true);
        }

        return $this->responseRedirect('admin.categories.index','Categoria '.$category->name .' atualizada com exito!', 'success', false, false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->categoryRepository->deleteCategory($id);

        if(!$category){
            return $this->responseRedirectBack('Ocorreu um erro em deletar a categoria', 'error', true, true);
        }

        return $this->responseRedirect('admin.categories.index', 'Categoria deletada com exito!', 'success', false, false);
    }
}
