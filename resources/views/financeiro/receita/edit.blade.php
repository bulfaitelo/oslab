@extends('adminlte::page')

@section('title', 'Editar Receita')

@section('content_header')
    <h1><i class="fa-solid fa-up-long "></i> Editar Receita</h1>
@stop

@section('content')

<div class="row justify-content-md-center">
    <div class="col-md-11 ">
        <!-- general form elements -->
        <div class="card">
            <div class="card-header receita">
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

          <form action="{{ route('financeiro.receita.update', $receita) }}" id="form-receita" method="post">
            @csrf
            @method('PUT')
          <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="name">Receita</label>
                    {!! html()->text('name', $receita->name)->class('form-control')->placeholder('Descrição da receita')->required() !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="centro_custo_id">Centro de Custo</label>
                    {!! html()->select('centro_custo_id', \App\Models\Configuracao\Financeiro\CentroCusto::orderBy('name')->where('receita', '1')->pluck('name', 'id'),$receita->centro_custo_id)->class('form-control')->placeholder('Selecione o Centro de Custo')->required() !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="cliente_id">Cliente / Fornecedor </label>
                    {!! html()->select('cliente_id', [$receita->cliente_id => $receita->cliente->name], $receita->cliente_id)->class('form-control cliente')->placeholder('Selecione')->required() !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="observacoes"> Observações </label>
                    {!! html()->textarea('observacoes', $receita->observacoes)->class('form-control')->placeholder('Observações (opcional)') !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="valor"> Valor </label>
                    {!! html()->text('valor', $receita->valor)->class('form-control decimal')->placeholder('Valor total da Receita')->required() !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group ">
                    <label for="parcelas"> Parcelas </label>
                    <div class="input-group">
                        {!! html()->text('parcelas', $receita->parcelas)->class('form-control int')->placeholder('Parcelas')->required() !!}
                        @can('financeiro_receita_pagamento_create')
                            <span class="input-group-append">
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-pagamento">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </span>
                        @endcan
                    </div>
                    {!! html()->form()->close() !!}
                    @can('financeiro_receita_pagamento_create')
                    <div class="modal fade" id="modal-pagamento">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Adicionar uma nova parcela</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('financeiro.receita.pagamento.store', $receita) }}" id="form-pagamento" method="post">
                                        @csrf
                                    <div class="row">
                                        <div  class="col-md-2">
                                            <div class="form-group">
                                                <label for="parcela"> Parcela </label>
                                                {!! html()->text('parcela')->class('form-control int')->placeholder('Parcela')->required() !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="vencimento"> Vencimento </label>
                                                {!! html()->date('vencimento')->class('form-control')->placeholder('Nome da forma de pagamento')->required() !!}
                                            </div>
                                        </div>
                                        <div  class="col-md-4">
                                            <div class="form-group">
                                                <label for="forma_pagamento_id">Forma de pagamento</label>
                                                {!! html()->select('forma_pagamento_id', \App\Models\Configuracao\Financeiro\FormaPagamento::orderBy('name')->pluck('name', 'id'))->class('form-control')->placeholder('Selecione') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label for="pago">Pago</label>
                                                <div class="custom-control custom-switch custom-switch-md">
                                                    <input type="checkbox" name="pago" @checked(old('pago') == 'on') id="pago" class="custom-control-input" onclick="alternaPago()">
                                                    <label class="custom-control-label" for="pago"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row div_pago collapse" id="collapseExample">
                                        <div  class="col-md-4">
                                            <div class="form-group">
                                                <label for="pagamento_valor"> Valor </label>
                                                {!! html()->text('pagamento_valor')->class('form-control decimal')->placeholder('Valor') !!}
                                            </div>
                                        </div>
                                        <div  class="col-md-4 ">
                                            <div class="form-group">
                                                <label for="data_pagamento"> Data pagamento </label>
                                                {!! html()->date('data_pagamento')->class('form-control')->placeholder('Valor Pago') !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                        <i class="fas fa-times"></i>
                                        Fechar
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i>
                                        Salvar
                                    </button>
                                </div>
                                {!! html()->form()->close() !!}
                            </div>
                        </div>
                    </div>
                    @endcan
                </div>
            </div>

        </div>

        <div class="card-body pt-2 table-responsive">
            <table class="table table-sm table-hover text-nowrap">
              <thead>
                <tr>
                  <th style="width: 10px">Parcela</th>
                  <th>Forma Pagamento</th>
                  <th>Usuario</th>
                  <th>Valor</th>
                  <th>Vencimento</th>
                  <th>Data Pagamento</th>
                  <th style="width: 40px"></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($receita->pagamentos as $item)
                  <tr>
                    <td>{{ $item->parcela }}</td>
                    <td>{{ $item->formaPagamento?->name}}</td>
                    <td>{{ $item->user->name}}</td>
                    <td>R$ {{ number_format($item->valor, 2, ',', '.')}}</td>
                    <td>{{ $item->vencimento?->format('d/m/Y') ?? ''}}</td>
                    <td>{{ $item->data_pagamento?->format('d/m/Y') ?? ''}}</td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            @can('financeiro_receita_pagamento_edit')
                                <button  title="Editar" class="btn btn-left btn-info" data-toggle="modal" data-target="#modal-editar_{{ $item->id }}"><i class="fas fa-edit"></i></button>
                            @endcan
                            @can('financeiro_receita_pagamento_destroy')
                                <button type="button" class="btn btn-block btn-danger" data-toggle="modal" data-target="#modal-excluir_{{ $item->id }}"><i class="fas fa-trash"></i></button>
                            @endcan
                        </div>
                        @can('financeiro_receita_pagamento_edit')
                                <div class="modal fade" id="modal-editar_{{ $item->id }}">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Editar: Parcela </h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('financeiro.receita.pagamento.update', [$receita->id, $item->id]) }}" id="form-pagamento" method="post">
                                                    @method('put')
                                                    @csrf
                                                <div class="row">
                                                    <div  class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="parcela"> Parcela </label>
                                                            {!! html()->text('parcela', $item->parcela)->class('form-control int')->placeholder('Parcela')->required() !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="vencimento"> Vencimento </label>
                                                            {!! html()->date('vencimento', $item->vencimento)->class('form-control')->placeholder('Nome da forma de pagamento')->required() !!}
                                                        </div>
                                                    </div>
                                                    <div  class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="forma_pagamento_id">Forma de pagamento</label>
                                                            {!! html()->select('forma_pagamento_id', \App\Models\Configuracao\Financeiro\FormaPagamento::orderBy('name')->pluck('name', 'id'), $item->forma_pagamento_id)->class('form-control')->placeholder('Selecione') !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group">
                                                            <label for="pago_{{$item->id}}">Pago</label>
                                                            <div class="custom-control custom-switch custom-switch-md">
                                                                <input type="checkbox" name="pago" @checked($item->data_pagamento) id="pago_{{$item->id}}" class="custom-control-input" onclick="alternaPagoEdit({{ $item->id }})">
                                                                <label class="custom-control-label" for="pago_{{$item->id}}"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row div_pago_{{$item->id}}  @if (!$item->data_pagamento) collapse @endif " id="collapseExample">
                                                    <div  class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="pagamento_valor"> Valor </label>
                                                            {!! html()->text('pagamento_valor', $item->valor)->class('form-control decimal')->placeholder('Valor') !!}
                                                        </div>
                                                    </div>
                                                    <div  class="col-md-4 ">
                                                        <div class="form-group">
                                                            <label for="data_pagamento"> Data pagamento </label>
                                                            {!! html()->date('data_pagamento', $item->data_pagamento)->class('form-control')->placeholder('Valor Pago') !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                                    <i class="fas fa-times"></i>
                                                    Fechar
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-save"></i>
                                                    Salvar
                                                </button>
                                            </div>
                                            {!! html()->form()->close() !!}

                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                            @endcan

                            @can('financeiro_receita_pagamento_destroy')
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
                                                {!! html()->form('delete', route('financeiro.receita.pagamento.destroy', [$receita->id, $item->id]))->open() !!}
                                                    <input type="submit" class="btn btn-danger delete-permission" value="Excluir Receita">
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
            <button type="button" onclick="$('#form-receita').submit();" class="btn btn-primary">
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
<link href="{{ url('') }}/vendor/tom-select/tom-select.bootstrap4.min.css" rel="stylesheet" />
<style>
    .receita {
        border-top: 3px solid #12cd37;
        /* background-color: #aaceb1; */
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

    .ts-wrapper .option .title {
        display: block;
    }
    .ts-wrapper .option .url {
        font-size: 15px;
        display: block;
        color: #7c7c7c;
    }

    .ts-wrapper::after {
        display: none;
    }
</style>
@stop

@section('js')
@routes
<script src="{{ url('') }}/vendor/tom-select/tom-select.complete.min.js"></script>
<script src="{{ url('') }}/src/js/select-cliente.js"></script>

<script>

    $('.decimal').mask('#.##0,00', { reverse: true });
    $('.int').mask('#0', { reverse: true });
    $('#data_info').popover({
        trigger: 'hover'
    });
</script>
<script>

$(document).ready(function () {
        alternaPago();
});
function alternaPago() {
        var checkPago = $('#pago');
        var divPAgo = $('.div_pago');
        if (checkPago.prop('checked') == true) {
            // divPAgo.css('display', '');
            $('.div_pago').collapse('show');
            $('#pagamento_valor').attr("required","required");
            $('#forma_pagamento_id').attr("required","required");
            $('#data_pagamento').attr("required","required");
        } else {
            // divPAgo.css('display', 'none');
            $('.div_pago').collapse('hide');
            $('#pagamento_valor').removeAttr("required");
            $('#forma_pagamento_id').removeAttr("required");
            $('#data_pagamento').removeAttr("required");
        }
    }

    function alternaPagoEdit(id) {
        var checkPago = $('#pago_'+id);

        if (checkPago.prop('checked') == true) {
            // divPAgo.css('display', '');

            $('.div_pago_'+id).collapse('show');
            // $('#pagamento_valor').attr("required","required");
            // $('#forma_pagamento_id').attr("required","required");
            // $('#data_pagamento').attr("required","required");
        } else {
            // divPAgo.css('display', 'none');
            $('.div_pago_'+id).collapse('hide');
            // $('#pagamento_valor').removeAttr("required");
            // $('#forma_pagamento_id').removeAttr("required");
            // $('#data_pagamento').removeAttr("required");
        }
    }
</script>
@stop
