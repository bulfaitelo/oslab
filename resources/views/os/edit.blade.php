@extends('adminlte::page')

@section('title', 'Editar Ordem de Serviço')

@section('content_header')
    <h1>Editar Ordem de Serviço</h1>
@stop

@section('content')

<div class="row justify-content-md-center">
    <div class="col-12 col-md-12">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link " id="detalhes-tab" data-toggle="pill" href="#detalhes" role="tab" aria-controls="detalhes" aria-selected="false">
                            <i class="fa-regular fa-rectangle-list "></i>
                            Detalhes
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" id="#produtos-tab" data-toggle="pill" href="#produtos" role="tab" aria-controls="produtos" aria-selected="true">
                            <i class="fas fa-box-open "></i>
                            Produtos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="servicos-tab" data-toggle="pill" href="#servicos" role="tab" aria-controls="servicos" aria-selected="false">
                            <i class="fas fa-hand-holding-usd "></i>
                            Serviços
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="anexos-tab" data-toggle="pill" href="#anexos" role="tab" aria-controls="anexos" aria-selected="false">
                            <i class="fa-solid fa-paperclip"></i>
                            Anexos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="informacoes-tab" data-toggle="pill" href="#informacoes" role="tab" aria-controls="informacoes" aria-selected="false">
                            <i class="fa-solid fa-circle-info"></i>
                            Informações
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="balancete-tab" data-toggle="pill" href="#balancete" role="tab" aria-controls="balancete" aria-selected="false">
                            <i class="fas fa-balance-scale"></i>
                            Balancete
                        </a>
                    </li>

                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade " id="detalhes" role="tabpanel" aria-labelledby="detalhes-tab">
                        @livewire('os.detalhes', ['os' => $os])
                    </div>
                    <div class="tab-pane fade active show" id="produtos" role="tabpanel" aria-labelledby="produtos-tab">
                        @livewire('os.produto-tab', ['os' => $os])
                        {{-- @livewire('teste') --}}
                    </div>
                    <div class="tab-pane fade" id="servicos" role="tabpanel" aria-labelledby="servicos-tab">
                        servicos
                    </div>
                    <div class="tab-pane fade" id="anexos" role="tabpanel" aria-labelledby="anexos-tab">
                        anexos
                    </div>
                    <div class="tab-pane fade" id="informacoes" role="tabpanel" aria-labelledby="informacoes-tab">
                        informacoes
                    </div>
                    <div class="tab-pane fade" id="balancete" role="tabpanel" aria-labelledby="balancete-tab">
                        balancete
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
{{-- <link href="{{ url('') }}/vendor/select2/dist/css/select2.min.css" rel="stylesheet" />
<link href="{{ url('') }}/vendor/select2/dist/css/select2-bootstrap4.min.css" rel="stylesheet" /> --}}
<link rel="stylesheet" href="{{ url('') }}/vendor/summernote/summernote-bs4.min.css">
<link href="{{ url('') }}/vendor/tom-select/tom-select.bootstrap4.min.css" rel="stylesheet" />
{{-- <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet"> --}}
<style>
    .os {
        border-top: 3px solid #39cccc;
    }


    .icon{
        width: 3rem;
    }
    .item{
        width: 100%;
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
{{-- <script src="{{ url('') }}/vendor/tom-select/tom-select.complete.min.js"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.base.min.js"></script> --}}

<script src="{{ url('') }}/vendor/select2/dist/js/select2.full.min.js"></script>
<script src="{{ url('') }}/vendor/select2/dist/js/i18n/pt-BR.js"></script>
<script src="{{ url('') }}/vendor/summernote/summernote-bs4.min.js"></script>
<script src="{{ url('') }}/vendor/summernote/lang/summernote-pt-BR.js"></script>
<script src="{{ url('') }}/src/js/os.js"></script>
<script>
    $('.decimal').mask('#.##0,00', { reverse: true });
    $('.numero').mask('#', { reverse: true });
</script>
<script>
    new TomSelect("#os-produto",{
        // allowEmptyOption: true,
        create: true,
        valueField: 'id',
		labelField: 'name',
		searchField: 'name',
		// fetch remote data
		load: function(query, callback) {

			var url = route('produto.select') + '?q=' + encodeURIComponent(query);
			fetch(url)
				.then(response => response.json())
				.then(json => {
                    callback(json);
				}).catch(()=>{
					callback();
				});

		},
        // custom rendering function for options
		render: {
            option: function(data, escape) {
			return '<div>' +
					'<span class="title">' + escape(data.name) + '</span>' +
					'<span class="url"> <b> Custo: </b> R$ ' + escape(data.valor_custo) + ' | <b> Venda: </b> R$ ' + escape(data.valor_venda) + ' | <b> Estoque: </b> ' + escape(data.estoque) + '</span>' +
				'</div>';
            },
            item: function(data, escape) {
                return '<div title="' + escape(data.id) + '">' + escape(data.name) + '</div>';
            }
		},
    });

</script>
<script>
    $(document).ready(function() {
        $('.texto').summernote({
            lang: 'pt-BR',
            height: 300,
            toolbar: [
                [ 'style', [ 'style' ] ],
                [ 'font', [ 'bold', 'italic', 'clear'] ],
                // [ 'fontname', [ 'fontname' ] ],
                [ 'fontsize', [ 'fontsize' ] ],
                [ 'color', [ 'color' ] ],
                [ 'para', [ 'ol', 'ul', 'paragraph', ] ],
                [ 'table', [ 'table' ] ],
                [ 'insert', ['link', 'picture',]],
                [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
            ]
        });
    });
</script>
@stop
