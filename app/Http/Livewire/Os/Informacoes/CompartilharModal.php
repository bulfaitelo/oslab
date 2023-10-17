<?php

namespace App\Http\Livewire\Os\Informacoes;

use App\Models\Os\Os;
use App\Models\Os\OsInformacao;
use Carbon\Carbon;
use Livewire\Component;

class CompartilharModal extends Component
{

    public $item;
    public $os_id;
    public $informacao_id;
    protected $listeners = ['open' => 'loadCompartilharModal'];


    function loadCompartilharModal($informacao_id) {
        $this->informacao_id = $informacao_id;

        $this->emit('toggleCompartilharModal');
    }
    public function render()
    {
        $this->item = Os::find($this->os_id)->informacoes->find($this->informacao_id);
        return view('livewire.os.informacoes.compartilhar-modal', [
            'item' => $this->item
        ]);
    }


    /**
     * Cria a uuid para compartilhar item
     *
     * @param int $id id da informacao
     * @return void
     **/
    public function createShareUrl(int $id) : void {
        $informacao = Os::find($this->os_id)->informacoes->find($id);
        $informacao->uuid = \Str::uuid();
        $informacao->validade_link = Carbon::now()->addMinutes(getConfig('os_link_time_limit'));
        $informacao->save();
        $this->emit('updateCompartilhar');

    }

    /**
     * delete a uuid para do item
     *
     * @param int $id id da informacao
     * @return void
     **/
    public function deleteShareUrl(int $id) : void {
        $informacao = Os::find($this->os_id)->informacoes->find($id);
        $informacao->uuid = null;
        $informacao->validade_link = null;
        $informacao->save();
        $this->emit('updateCompartilhar');


    }
}
