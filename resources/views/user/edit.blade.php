@extends('layouts.main')

@section('title', 'Usuários')

@section('content')

    <div id="layout-form-container" class="col-md-6 offset-md-3">

        @include('components.alert.error')

        <h2>Atualizar usuário</h2>

        <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nome</label>
                <input class="form-control" type="text" id="name" name="name" placeholder="Nome do usuário"
                    value="{{$user->name}}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input class="form-control" type="email" id="email" name="email" placeholder="Endereço de email"
                    value="{{$user->email}}" required>
            </div>

            <div class="form-group">
                <label for="value">Valor</label>
                <input class="form-control" type="text" name="value_hour" id="value"
                    placeholder="Valor por hora trabalhada" value="{{ number_format($user->value_hour ?? 0, 2, ',', '.') }}" required>
            </div>

            <div class="form-group">
                <label for="type">Cargo</label>
                <select id="type" name="type" class="form-select" required>
                    @foreach([
                            $roles::PARTNER => 'Sócio',
                            $roles::CONSULTANT => 'Consultor',
                            $roles::FINANCIER => 'Financeiro',
                            $roles::INTERN => 'Estagiário'
                        ] as $key => $type)
                        <option value="{{$key}}" {{ old('type', $user->type) == $key ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            {{-- <div class="form-group">
                <label for="password">Nova senha</label>
                <input id="password" class="form-control" type="password" name="password" placeholder="Senha" required>
            </div> --}}

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('users.index') }}" class="btn btn-secondary" style="width: 30%">Cancelar</a>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#redefinirSenha" style="width: 30%">
                    Redefinir senha
                </button>

                <input type="submit" id="create-btn" class="btn btn-success" style="width: 30%" value="Atualizar usuário">
            </div>

        </form>

        

        @include('user.components.modal-senha')

    </div>

@endsection

@push('style')
    <link rel="stylesheet" href="/css/client/create.css">
@endpush

@push('script')
    <script src="/js/formatacao/phone.js"></script>
    <script src="/js/formatacao/value.js"></script>
@endpush
