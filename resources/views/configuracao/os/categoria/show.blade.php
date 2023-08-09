@extends('adminlte::page')

@section('title', 'Visualizando Categoria')

@section('content_header')
    <h1>Visualizando Categoria</h1>
@stop

@section('content')

<div class="row justify-content-md-center">
    <div class="col-md-10 ">
        <!-- general form elements -->
        <div class="card">
            <div class="card-header">
                <a href="{{ url()->previous() }}">
                    <button type="button"  class="btn  btn-default">
                        <i class="fa-solid fa-chevron-left"></i>
                        Voltar
                    </button>
                </a>
            </div>

          <!-- /.card-header -->
          <!-- form start -->

          <div class="card-body">
            <div class="form-group">
                <label for="name">Categoria</label>
                {!! html()->text('name', $categoria->name)->class('form-control')->placeholder('Categoria')->disabled() !!}
            </div>
            <div class="form-group">
                <label for="descricao">Descrição</label>
                {!! html()->text('descricao', $categoria->descricao)->class('form-control')->placeholder('Descrição')->disabled() !!}
            </div>
            <div class="form-group">
                <label for="garantia_id">Garantia</label>
                {!! html()->select('garantia_id', \App\Models\Configuracao\Os\Garantia::orderBy('name')->pluck('name', 'id'), $categoria->garantia_id)->class('form-control')->placeholder('Selecione')->disabled() !!}
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="checklist_id">Checklist</label>
                        {!! html()->select('checklist_id', \App\Models\Checklist\Checklist::orderBy('name')->pluck('name', 'id'), $categoria->checklist_id)->class('form-control')->placeholder('Selecione')->disabled() !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="checklist_required">Obrigatório</label>
                        <div class="custom-control custom-switch custom-switch-md">
                            <input type="checkbox" name="checklist_required" @checked((old('checklist_required') == 1) || ($categoria->checklist_required)) value="1" id="checklist_required" class="custom-control-input" @disabled(true)>
                            <label class="custom-control-label" for="checklist_required"></label>
                        </div>
                    </div>
                </div>
            </div>
          </div>
          {{-- Minimal with icon only --}}
          <!-- /.card-body -->
        </div>
      <!-- /.card -->

      </div>
</div>
@stop

@section('css')
<style>
    .custom-switch.custom-switch-md .custom-control-label {
        padding-left: 2rem;
        padding-bottom: 1.5rem;
    }

    .custom-switch.custom-switch-md .custom-control-label::before {
        height: 1.5rem;
        width: calc(2rem + 0.75rem);
        border-radius: 3rem;
    }

    .custom-switch.custom-switch-md .custom-control-label::after {
        width: calc(1.5rem - 4px);
        height: calc(1.5rem - 4px);
        border-radius: calc(2rem - (1.5rem / 2));
    }

    .custom-switch.custom-switch-md .custom-control-input:checked ~ .custom-control-label::after {
        transform: translateX(calc(1.5rem - 0.25rem));
    }
</style>
@stop

@section('js')
@stop
