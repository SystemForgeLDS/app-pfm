@extends('layouts.main')

@section('title', 'Nova tarefa')
    
@section('content')

<div id="layout-form-container" class="col-md-6 offset-md-3 dados">

    @include('components.alert.error')

    <h2>Adicionar tarefa</h2>

    <form action="{{ route('task.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Título:</label>
            <input class="form-control" type="text" id="title" name="title" placeholder="Título da atividade" value="{{old('title')}}" required>
        </div>

        <div class="form-group">
            <label for="description">Descrição:</label>
            <textarea class="form-control" id="description" name="description" placeholder="Descrição" required>{{old('description')}}</textarea>
        </div>

        <div class="form-group">
            <label for="value">Valor:</label>
            <input class="form-control" type="text" name="value" id="value" placeholder="Valor da atividade" value="{{old('value')}}" required>
        </div>
        
        <div class="form-group">
            <label for="value">Consultor:</label>
            <select class="form-select" name="user_id" required>
                <option selected>Selecione um consultor</option>
                @foreach ($consultants as $consultant)
                    <option value="{{$consultant->id}}">{{$consultant->name}}</option>
                @endforeach
            </select>
        </div>

        {{-- <div class="form-group">
            <label for="predicted_hour">Horas:</label>
            <input class="form-control" type="text" name="predicted_hour" id="predicted_hour" placeholder="Horas previstas" value="{{old('predicted_hour')}}" required>
        </div> --}}

        <div class="form-group">
            <label for="predicted_hour">Horas Previstas:</label>
            <div style="display: flex; gap: 10px;">
                <input type="number" class="form-control hours" placeholder="Horas" min="0" max="999"  required>
                <input  type="number" class="form-control minutes" placeholder="Minutos" min="0" max="59" required>
            </div>
        </div>

        <input type="hidden" name="predicted_hour" class="timeHours">

        <input type="hidden" name="project_id" id="project_id" value="{{ $project->id }}">

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('project.show', $project->id) }}" class="btn btn-secondary" style="width: 45%">Cancelar</a>
            @include('components.button.add', ['entity' => 'tarefa'])
        </div>

    </form>

</div>

@endsection

@push('style')
    <link rel="stylesheet" href="/css/client/create.css">
@endpush

@push('script')
    <script src="/js/formatacao/value.js"></script>
    <script src="/js/formatacao/hour.js"></script>
@endpush
