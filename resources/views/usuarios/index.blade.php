@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Usuários Cadastrados</h1>
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary mb-3">Novo Usuário</a>
        <table id="usuarios-table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
            <thead>
            <tr>
                <th>Nome</th>
                <th>CPF</th>
                <th>Data de Cadastro</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->nome }}</td>
                    <td>{{ $usuario->cpf }}</td>
                    <td>{{ $usuario->created_at->format('d/m/Y H:i:s') }}</td>
                    <td>
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#fotoModal{{ $usuario->id }}">
                            Ver Foto
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="fotoModal{{ $usuario->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Foto de {{ $usuario->nome }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <img src="{{ asset('storage/' . $usuario->foto) }}" alt="Foto de {{ $usuario->nome }}" class="img-fluid">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    @push('scripts')
        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#usuarios-table').DataTable({
                    responsive: true
                });
            });
        </script>
    @endpush
@endsection
