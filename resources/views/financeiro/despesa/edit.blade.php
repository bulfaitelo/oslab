@extends('adminlte::page')

@section('title', 'Editar Despesa')

@section('content_header')
    <h1>Editar Despesa</h1>
@stop

@section('content')

<div class="row justify-content-md-center">
    <div class="col-md-11 ">
        <!-- general form elements -->
        <div class="card">
            <div class="card-header despesa">
                <a href="{{ url()->previous() }}">
                    <button type="button"  class="btn btn-sm btn-default">
                        <i class="fa-solid fa-chevron-left"></i>
                        Voltar
                    </button>
                </a>
            </div>
          <!-- /.card-header -->
          <!-- form start -->

          <div class="card-body">
          @include('adminlte::partials.form-alert')

          <form action="{{ route('financeiro.despesa.update', $despesa) }}" id="form-despesa" method="post">
            @csrf
            @method('PUT')
          <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="name">Despesa</label>
                    {!! html()->text('name', $despesa->name)->class('form-control')->placeholder('Descrição da despesa ')->required() !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="centro_custo_id">Centro de Custo</label>
                    {!! html()->select('centro_custo_id', \App\Models\Configuracao\Financeiro\CentroCusto::orderBy('name')->where('despesa', '1')->pluck('name', 'id'),$despesa->centro_custo_id)->class('form-control')->placeholder('Selecione o Centro de Custo')->required() !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="cliente_id">Cliente / Fonrcedor </label>
                    {!! html()->select('cliente_id', [$despesa->cliente_id => $despesa->cliente->name], $despesa->cliente_id)->class('form-control cliente')->placeholder('Selecione')->required() !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="observacoes"> Observações </label>
                    {!! html()->textarea('observacoes', $despesa->observacoes)->class('form-control')->placeholder('Observações (opcional)') !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="valor"> Valor </label>
                    {!! html()->text('valor', $despesa->valor)->class('form-control decimal')->placeholder('Valor total da despesa')->required() !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group ">
                    <label for="parcelas"> Parcelas </label>
                        {!! html()->text('parcelas', $despesa->parcelas)->class('form-control int')->placeholder('Parcelas')->required() !!}
                </div>
            </div>
        </div>
        {!! html()->form()->close() !!}
        <div class="card-body pt-2 table-responsive">
            <table class="table table-sm table-hover text-nowrap">
              <thead>
                <tr>
                  <th style="width: 10px">Parcela</th>
                  <th>Forma Pagamento</th>
                  <th>Usuario</th>
                  <th>Valor</th>
                  <th>Vencimento</th>
                  <th>data Pagamento</th>
                  <th style="width: 40px"></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($despesa->pagamentos as $item)
                  <tr>
                    <td>{{ $item->parcela }}</td>
                    <td>{{ $item->formaPagamento?->name}}</td>
                    <td>{{ $item->user->name}}</td>
                    <td>R$ {{ number_format($item->valor, 2, ',', '.')}}</td>
                    <td>{{ $item->vencimento}}</td>
                    <td>{{ $item->data_pagamento}}</td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            @can('financeiro_despesa_edit')
                                <a href="{{ route('financeiro.despesa.edit', $item->id) }}" title="Editar" class="btn btn-left btn-info"><i class="fas fa-edit"></i></a>
                            @endcan
                            @can('financeiro_despesa_show')
                                <a href="{{ route('financeiro.despesa.show', $item->id) }}" title="Editar" class="btn btn-left btn-default"><i class="fas fa-eye"></i></a>
                            @endcan
                            @can('financeiro_despesa_destroy')
                                <button type="button" class="btn btn-block btn-danger" data-toggle="modal" data-target="#modal-excluir_{{ $item->id }}"><i class="fas fa-trash"></i></button>
                            @endcan
                        </div>
                            @can('financeiro_despesa_destroy')
                            <div class="modal fade" id="modal-excluir_{{ $item->id }}">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h4 class="modal-title">Realmente deseja Excluir?</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                    <p><b>Nome:</b> {{ $item->name}}</p>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                        {!! html()->form('delete', route('financeiro.despesa.destroy', $item->id))->open() !!}
                                            <input type="submit" class="btn btn-danger delete-permission" value="Excluir Despesa">
                                        {!! html()->form()->close() !!}

                                    </div>
                                </div>
                                <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            @endcan
                        </div>
                      <!-- /.modal -->
                    </td>
                  </tr>

                @endforeach
              </tbody>
            </table>
          </div>



          </div>
          {{-- Minimal with icon only --}}
          <!-- /.card-body -->
          <div class="card-footer">
            <button type="button" onclick="$('#form-despesa').submit();" class="btn btn-primary">
                <i class="fas fa-save"></i>
                Salvar
            </button>
          </div>
        </div>
      <!-- /.card -->

      </div>
</div>
@stop

@section('css')

<link href="{{ url('') }}/vendor/select2/dist/css/select2.min.css" rel="stylesheet" />
<link href="{{ url('') }}/vendor/select2/dist/css/select2-bootstrap4.min.css" rel="stylesheet" />
    <style>
        .despesa {
            border-top: 3px solid #cd121f;
        }

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
@routes
<script src="{{ url('') }}/vendor/select2/dist/js/select2.full.min.js"></script>
<script src="{{ url('') }}/vendor/select2/dist/js/i18n/pt-BR.js"></script>
<script src="{{ url('') }}/src/js/select-cliente.js"></script>
{{-- <script src="https://adminlte.io/themes/v3/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script> --}}
{{-- <script src="{{ url('') }}/vendor/bootstrap-switch/bootstrap-switch.min.js"></script> --}}

<script>

    $('.decimal').mask('#.##0,00', { reverse: true });
    $('.int').mask('#0', { reverse: true });
    $('#data_info').popover({
        trigger: 'hover'
    });
</script>

@stop
