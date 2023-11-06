{{-- @extends('adminlte::page', ['iFrameEnabled' => true]) --}}
@extends('adminlte::page')


@section('title', 'Home')

@section('content_header')
    <h1>OSLAB - Home</h1>
@stop

@section('content')

<div class="row justify-content-md-center">
    <div class="col-md-8">
        <!-- general form elements -->
        <div class="card">
            <div class="card-header">
                <a href="{{ url()->previous() }}">
                    <button type="button"  class="btn btn-sm btn-default">
                        <i class="fa-solid fa-chevron-left"></i>
                        Voltar
                    </button>
                </a>
            </div>
            <div class="card-body">
                {!! html()->form('post', route('configuracao.wiki.modelo.store'))->open() !!}
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="descricao">Descrição</label>
                            {!! html()->text('descricao')->class('form-control')->placeholder('Modelo do aparelho')->required() !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="centro_custo_id">Centro de Custo</label>
                            {!! html()->select('centro_custo_id', \App\Models\Configuracao\Financeiro\CentroCusto::orderBy('name')->where('receita', '1')->pluck('name', 'id'))->class('form-control')->placeholder('Selecione o Centro de Custo')->required() !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-0">
                            <label data-toggle="collapse" href="#observacoes-div" role="button" for="observacoes" aria-expanded="true" aria-controls="observacoes" >
                                Observações
                                <i id="obervacoes-icon" class="fa-solid fa-caret-right"></i>
                            </label>
                            <div id="observacoes-div" class="collapse ">
                                {!! html()->textarea('observacoes')->class('form-control mb-2')->placeholder('Observações (opcional)') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="entrada">Entrada</label>
                            {!! html()->date('entrada')->class('form-control')->placeholder('Modelo do aparelho')->required() !!}
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="valor">Valor</label>
                            {!! html()->text('valor')->class('form-control')->placeholder('Modelo do aparelho')->required() !!}
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="recebido">Recebido</label>
                            <div class="custom-control custom-switch custom-switch-md">
                                <input type="checkbox" name="recebido" id="recebido" class="custom-control-input" >
                                <label class="custom-control-label" for="recebido"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="recebido-div" class="row" style="display: none">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="data_recebimento">Data Recebimento</label>
                            {!! html()->date('data_recebimento')->class('form-control')->placeholder('Modelo do aparelho')->required() !!}
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="forma_pagamento_id">Forma de pagamento</label>
                            {!! html()->select('forma_pagamento_id', \App\Models\Configuracao\Financeiro\FormaPagamento::orderBy('name')->pluck('name', 'id'))->class('form-control')->placeholder('Selecione') !!}
                        </div>
                    </div>
                </div>

            </div>
            {{-- Minimal with icon only --}}
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="fas fa-save"></i>
                    Salvar
                </button>
            </div>
        </div>
      <!-- /.card -->
      {!! html()->form()->close() !!}
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
<script>

    $('#observacoes-div').on('show.bs.collapse', function () {
        $('#obervacoes-icon').removeClass('fa-caret-right').addClass('fa-caret-down');
    })
    $('#observacoes-div').on('hidden.bs.collapse', function () {
        $('#obervacoes-icon').removeClass('fa-caret-down').addClass('fa-caret-right');
    })

    $('#recebido').on('change', function () {
        if (this.checked) {
            $('#recebido-div').css('display', '');
        } else {
            $('#recebido-div').css('display', 'none');
        }
    });
</script>
@stop

@section('footer')

@stop

{{-- @include('section_footer') --}}
{{-- @include('adminlte::partials.footer.section_footer') --}}
