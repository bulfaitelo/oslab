@extends('adminlte::page')

@section('title', 'Perfil editar dados ')

@section('content_header')
    <h1>Editar perfil </h1>
@stop

@section('content')

<div class=" row justify-content-md-center">
    <div class="col-md-10 ">
        <div class="card ">
            <div class="card-header">
              <h3 class="card-title">Seus Dados</h3>
            </div>
            {!! Form::open(['route' => ['configuracoes.user.perfil.update'],'method' => 'put']) !!}

            <div class="card-body">
                @include('adminlte::partials.alert')
                <div class="form-group">
                    <label for="nome">Nome</label>
                    {!! Form::text('name', \Auth::user()->name, ['id' => 'name', 'class' => 'form-control', 'placeholder' => 'Nome do usuário', 'required']) !!}
                </div>
                <div class="form-group">
                    <label for="email">Setor</label>
                    <input disabled value="{{ \Auth::user()->setor->name ?? '' }}" type="email" class="form-control" id="email" >
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input disabled value="{{ \Auth::user()->email }}" type="email" class="form-control" id="email" >
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Senha </label>
                            {!! Form::password('password', ['id' => 'password','class' => 'form-control', 'placeholder' => 'Senha',  ]) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation">Repita a Senha</label>
                            {!! Form::password('password_confirmation', ['id' => 'password_confirmation','class' => 'form-control', 'placeholder' => 'Repita a Senha',  ]) !!}
                        </div>
                    </div>
                </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                </div>
            {!! Form::close() !!}
        </div>

    </div>

</div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
@stop

{{-- @include('section_footer') --}}
{{-- @include('adminlte::partials.footer.section_footer') --}}
