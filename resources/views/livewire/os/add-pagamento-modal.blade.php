@if ($os->fatura_id)
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Adicionar um Novo Pagamento</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form method="post"  wire:submit.prevent="pagamentoCreate()">
                @csrf
            <div class="row" >
                <div  class="col-md-4">
                    <div class="form-group">
                        <label for="pagamento_valor"> Valor </label>
                        {!! html()->text('pagamento_valor')->class('form-control decimal')->placeholder('Valor')->required() !!}
                    </div>
                </div>
                <div  class="col-md-4 ">
                    <div class="form-group"> wire:model.defer="anotacao"
                        <label for="data_pagamento"> Data pagamento </label>
                        {!! html()->date('data_pagamento', now())->class('form-control')->placeholder('Valor Pago')->required() !!}
                    </div>
                </div>
                <div  class="col-md-4">
                    <div class="form-group">
                        <label for="forma_pagamento_id">Forma de pagamento</label>
                        {!! html()->select('forma_pagamento_id', \App\Models\Configuracao\Financeiro\FormaPagamento::orderBy('name')->pluck('name', 'id'))->class('form-control')->placeholder('Selecione')->required() !!}
                    </div>
                </div>
            </div>
            <div class="row">
                {{-- @dd($os->contas()->where('tipo', 'R')->first()->pagamentos); --}}
                <h4>Pagamentos Recebidos</h4>
                <table class="table table-sm">
                    @if (!$conta->pagamentos->isEmpty())
                    <thead>
                        <tr>
                        <th>Data</th>
                        <th>Forma de Pagamento</th>
                        <th>Valor</th>
                        </tr>
                    </thead>
                    @endif
                    <tbody>
                        @forelse ($conta->pagamentos as $pagamento)
                            <tr>
                                <td> {{ $pagamento->data_pagamento->format('d/m/Y') }} </td>
                                <td> {{ $pagamento->formaPagamento->name }} </td>
                                <td>R$ {{ number_format($pagamento->valor, 2, ',', '.') }}</td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="3" >
                                <h4>Ainda não existem pagamentos</h4>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot style=" border-top: 2px solid rgb(225, 225, 225)">
                        @if (!$conta->pagamentos->isEmpty())
                        <tr>
                            <td colspan="1"></td>
                            <td class="text-right">
                                <b>
                                    Total Recebido:
                                </b>
                            </td>
                            <td>R$ {{ number_format($conta->pagamentos->sum('valor'), 2, ',', '.') }}</td>
                        </tr>
                        @endif
                        <tr style="border-bottom: 2px solid rgb(156, 156, 156)">
                            <td colspan="1"></td>
                            <td class="text-right">
                                <b>
                                    Pendente:
                                </b>
                            </td>
                            <td>R$ {{ number_format(($conta->valor - $conta->pagamentos->sum('valor')), 2, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
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
    <script>
        document.addEventListener('livewire:load', function () {
            window.livewire.on('toggleAddPagamentoModal', () => $('#addPagamentoModal').modal('toggle'));
        });
    </script>
</div>
@endif
