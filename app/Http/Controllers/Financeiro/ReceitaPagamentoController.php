<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Http\Requests\Financeiro\StoreContaPagamentoRequest;
use App\Http\Requests\Financeiro\UpdateContaPagamentoRequest;
use App\Models\Financeiro\Contas;
use App\Models\Financeiro\Pagamentos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReceitaPagamentoController extends Controller
{

    function __construct()
    {
        // ACL DE PERMISSÕES

        $this->middleware('permission:financeiro_receita_pagamento_create', ['only'=> ['store']]);
        $this->middleware('permission:financeiro_receita_pagamento_edit', ['only'=> [ 'update']]);
        $this->middleware('permission:financeiro_receita_pagamento_destroy', ['only'=> 'destroy']);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Contas $receita, StoreContaPagamentoRequest $request)
    {
        DB::beginTransaction();
        try {
            $pagamento[] =  [
                'forma_pagamento_id' => $request->parcelado_forma_pagamento_id,
                'user_id' => Auth::id(),
                'valor' => $request->pagamento_valor,
                'vencimento' =>  $request->vencimento,
                'data_pagamento' => $request->data_pagamento,
                'parcela' => $request->parcela,
                'forma_pagamento_id' => $request->forma_pagamento_id,
            ];
            $receita->pagamentos()->createMany($pagamento);
            if ($receita->parcelas < $receita->pagamentos->count()) {
                $receita->parcelas = $receita->parcelas + 1;
            }
            if (($receita->pagamentos->sum('valor') + $request->pagamento_valor) >= $receita->valor) {
                $receita->data_quitacao = $request->data_pagamento;
            }
            $receita->save();
            DB::commit();
            return redirect()->route('financeiro.receita.edit', $receita)
            ->with('success', 'Pagamento adicionado com sucesso.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContaPagamentoRequest $request, Contas $receita, Pagamentos $pagamento)
    {
        DB::beginTransaction();
        $pagamento = $receita->pagamentos()->findOrFail($pagamento->id);
        try {
                $pagamento->forma_pagamento_id = $request->parcelado_forma_pagamento_id;
                $pagamento->user_id = Auth::id();
                $pagamento->valor = $request->pagamento_valor;
                $pagamento->vencimento =  $request->vencimento;
                $pagamento->data_pagamento = $request->data_pagamento;
                $pagamento->parcela = $request->parcela;
                $pagamento->forma_pagamento_id = $request->forma_pagamento_id;
                $pagamento->save();

            if (($receita->pagamentos->sum('valor') + $request->pagamento_valor) >= $receita->valor) {
                $receita->data_quitacao = $request->data_pagamento;
            }
            $receita->save();
            DB::commit();
            return redirect()->route('financeiro.receita.edit', $receita)
            ->with('success', 'Pagamento editado com sucesso.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contas $receita, Pagamentos $pagamento)
    {
        // $receita::with('pagamentos')->findOrFail($receita->id);
        $pagamento = $receita->pagamentos()->findOrFail($pagamento->id);
        try {
            $pagamento->delete();
            return redirect()->route('financeiro.receita.edit', $receita)
                ->with('success', 'Pagamento excluído com sucesso.');

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
