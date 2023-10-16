@extends('adminlte::page')

@section('title', 'Produtos')

@section('content_header')
    <h1><i class="fas fa-box-open"></i> Produtos</h1>
@stop

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
                <a href="{{ url()->previous() }}">
                    <button type="button"  class="btn btn-sm btn-default">
                        <i class="fa-solid fa-chevron-left"></i>
                        Voltar
                    </button>
                </a>
                @can('produto_create')
                <a href="{{ route('produto.create') }}">
                    <button type="button"  class="btn btn-sm btn-primary">
                        <i class="fa-solid fa-plus"></i>
                        Adicionar Produto
                    </button>
                </a>
                @endcan
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            <table class="table table-sm table-hover text-nowrap">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Produto</th>
                        <th>Estoque</th>
                        <th>Valor</th>
                        <th>Ultima atualização</th>
                        <th style="width: 40px"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($produtos as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name}}</td>
                        <td>{{ $item->estoque}}</td>
                        <td>{{ $item->valor_venda}}</td>
                        <td>{{ $item->updated_at->format('H:i:s d/m/Y') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @can('produto_movimentacao')
                                    <a href="{{ route('movimentacao.index', $item->id) }}" title="Movimentações" class="btn btn-left bg-olive"><i class="fa-solid fa-boxes-packing"></i></a>
                                @endcan
                                @can('produto_movimentacao_create')
                                    <a href="{{ route('movimentacao.create', $item->id) }}" title="Adicionar Estoque" class="btn btn-left bg-primary"><i class="fa-solid fa-plus"></i></a>
                                @endcan
                                @can('produto_edit')
                                    <a href="{{ route('produto.edit', $item->id) }}" title="Editar" class="btn btn-left btn-info"><i class="fas fa-edit"></i></a>
                                @endcan
                                @can('produto_show')
                                    <a href="{{ route('produto.show', $item->id) }}" title="Vizualizar" class="btn btn-left btn-default"><i class="fas fa-eye"></i></a>
                                @endcan
                                @can('produto_destroy')
                                    <button type="button" class="btn btn-block btn-danger" data-toggle="modal" data-name="{{$item->name}}" data-url="{{route('produto.destroy', $item->id)}}" data-target="#modal-excluir"><i class="fas fa-trash"></i></button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
      <!-- /.card-body -->
      <div class="card-footer clearfix">
          {{-- {{$Produtos->appends(['busca' => $busca])->links() }} --}}
          {{ $produtos->links() }}
      </div>
    </div>
    {{-- Modal Excluir --}}
    @can('produto_destroy')
    <div class="modal fade"  id="modal-excluir" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">Realmente deseja Excluir?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                <p><b>Nome:</b> <span></span></p>
                </div>
                <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    {!! html()->form('delete')->open() !!}
                        <input type="submit" class="btn btn-danger delete-permission" value="Excluir Produto">
                    {!! html()->form()->close() !!}
                </div>
            </div>
        </div>
    </div>
    @endcan
    {{-- // Modal Excluir --}}
</div>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
<script>
    $('#modal-excluir').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var name = button.data('name') // Extract info from data-* attributes
        var url = button.data('url') // Extract info from data-* attributes
        var modal = $(this)
        modal.find('.modal-body span').text(name)
        modal.find('form').attr('action', url);
    })
</script>
@stop
