@extends('admin.app')
@section('title'){{ $pageTitle }}@endsection
@section('content')
	<div class="app-title">
        <div>
            <h1><i class="fa fa-cogs"></i> {{ $subTitle }}</h1>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row user">
        <div class="col-md-3">
            <div class="tile p-0">
                <ul class="nav flex-column nav-tabs user-tabs">
                    <li class="nav-item">
                    	<a class="nav-link active" href="#general" data-toggle="tab">General</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            <div class="tab-content">
                <div class="tab-pane active" id="general">
                    <div class="tile">
                        <form action="{{ route('admin.attributes.update', $attribute->id) }}" method="POST" role="form">
                            @csrf
                            @method('put')
                            <h3 class="tile-title">Informação de Atributo</h3>
                            <hr>
                            <div class="tile-body">
                                <div class="form-group">
                                    <label class="control-label" for="code">Codigo</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        placeholder="Digite codigo do atributo"
                                        id="code"
                                        name="code"
                                        value="{{ $attribute->code }}"
                                    />
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="name">Nome</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        placeholder="Digito o nome do atributo"
                                        id="name"
                                        name="name"
                                        value="{{ $attribute->name }}"
                                    />
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="frontend_type">Frontend Type</label>
                                    @php $types = ['select' => 'Select Box', 'radio' => 'Radio Button', 'text' => 'Text Field', 'text_area' => 'Text Area']; @endphp
                                    <select name="frontend_type" id="frontend_type" class="form-control">
                                        @foreach($types as $key => $label)
                                            @if($attribute->frontend_type == $key)
                                                <option value="{{ $key }}" selected>{{ $label }}</option>
                                            @else
                                                <option value="{{ $key }}">{{ $label }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" {{ $attribute->is_filterable?'checked':'' }} type="checkbox" id="is_filterable" name="is_filterable"/>Filterable
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" {{ $attribute->is_required?'checked':'' }} type="checkbox" id="is_required" name="is_required"/>Required
                                        </label>
                                    </div>
                                </div>
                                <input type="hidden" name="id" value={{ $attribute->id }}>
                            </div>
                            <div class="tile-footer">
                                <div class="row d-print-none mt-2">
                                    <div class="col-12 text-right">
                                        <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Editar Atributo</button>
                                        <a class="btn btn-danger" href="{{ route('admin.attributes.index') }}"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Voltar</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection