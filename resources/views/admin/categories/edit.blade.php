@extends('admin.app')
@section('title'){{ $pageTitle }}@endsection
@section('content')
	<div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">Editar Categoria: {{ $subTitle }}</h3>
                <form action="{{ route('admin.categories.update', $targetCategory->id) }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name">Nome <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ $targetCategory->name }}"/>
                            @error('name') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="description">Descrição</label>
                            <textarea class="form-control" rows="4" name="description" id="description">{{ $targetCategory->description??'' }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="parent">Parent Category <span class="m-l-5 text-danger"> *</span></label>
                            <select id=parent class="form-control custom-select mt-15 @error('parent_id') is-invalid @enderror" name="parent_id">
                                <option value="0">Selecione uma categoria pai</option>
                                @foreach($categories as $category)
	                                @if($targetCategory->parent_id === $category->parent_id)
	                                	<option value="{{ $category->id }}" selected> {{ $category->name }} </option>
	                                @endif
                                    <option value="{{ $category->id }}"> {{ $category->name }} </option>
                                @endforeach
                            </select>
                            @error('parent_id') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" id="featured" name="featured" {{ $targetCategory->featured == 1 ? 'checked':'' }}/>Categoria em Destaque
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" id="menu" name="menu"
                                    {{ $targetCategory->menu == 1 ? 'checked' : '' }}/>Mostrar no Menu
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                        	<div class="row">
                        		@if($targetCategory->image !== null)
	                        		<figure  class = "mt-2"  style = "width: 80px; height: auto;" > 
	                        			<img  src = " {{ asset('storage/'.$targetCategory->image) }} "  id = "categoryImage"  class = "img-fluid"  alt = "img" > 
	                        		</figure >
                        		@endif
                        	</div>
                            <label class="control-label">Imagem da Categoria</label>
                            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
                            @error('image') {{ $message }} @enderror
                        </div>
                        <input type="hidden" name="id" value={{ $targetCategory->id }}>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Editar Categoria</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.categories.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection