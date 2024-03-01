<?php

namespace App\Http\Controllers\Relatorio\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\Os\Os;
use Illuminate\Http\Request;

class BalanceteController extends Controller
{
    function __construct()
    {
        // ACL DE PERMISSÕES
        $this->middleware('permission:relatorio_financeiro_balancete', ['only'=> ['index']]);

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $osRelatorio = null;
        if ($request->input()) {
            $validated = $request->validate([
                'data_inicio' => 'required|date',
                'data_fim' => 'required|date|after_or_equal:data_inicio',
                'tipo_de_agrupamento' => 'required|in:os,mes,centro_de_custo',
                'ordenacao' => 'required|in:data,nome,saldo',
            ]);
            if($validated['tipo_de_agrupamento'] == 'os'){
                // $os = new Os;
                // $osRelatorio = $os->RelatorioBalancete();

                $osRelatorio = Os::RelatorioBalancete($validated['data_inicio'], $validated['data_fim'], $validated['ordenacao']);

            }
            return view('relatorio.financeiro.balancete.relatorio', [
                'osRelatorio' => $osRelatorio
            ]);
        } else {
            return view('relatorio.financeiro.balancete.index');
        }

    }

}
