@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="my-4">Cadastro de Usuário</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form id="register-form" action="{{ route('usuarios.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome') }}" required>
            </div>
            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="text" class="form-control cpf-mask" id="cpf" name="cpf" value="{{ old('cpf') }}" required>
            </div>
            <div class="form-group">
                <label for="foto">Foto:</label>
                <div>
                    <video id="video" width="320" height="240" autoplay></video>
                    <canvas id="canvas" width="320" height="240" style="display:none;"></canvas>
                </div>
                <input type="hidden" name="foto" id="foto">
            </div>
            <button type="submit" class="btn btn-primary mt-3">Cadastrar</button>
        </form>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/jquery-mask-plugin@1.14.16/dist/jquery.mask.min.js"></script>
        <script>
            $(document).ready(function(){
                $('.cpf-mask').mask('000.000.000-00', {reverse: true});

                const video = document.getElementById('video');
                const canvas = document.getElementById('canvas');
                const context = canvas.getContext('2d');

                navigator.mediaDevices.getUserMedia({ video: true })
                    .then(stream => {
                        video.srcObject = stream;
                    })
                    .catch(err => {
                        console.error('Erro ao acessar a câmera: ', err);
                        alert('Erro ao acessar a câmera. Verifique as permissões e tente novamente.');
                    });

                document.getElementById('register-form').addEventListener('submit', function(event) {
                    context.drawImage(video, 0, 0, canvas.width, canvas.height);
                    const dataURL = canvas.toDataURL('image/png');
                    document.getElementById('foto').value = dataURL;
                });
            });
        </script>
    @endpush
@endsection
