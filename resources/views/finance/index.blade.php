@extends('layouts.main')

@section('title', 'Financeiro')
    
@section('content')

<div class="d-flex justify-content-between">
    <div class="mb-3">
        <button id="showTable1" class="btn btn-outline-danger active">Despesas</button>
        <button id="showTable2" class="btn btn-outline-success">Receitas</button>
    </div>

    <div class="dropdown">
        <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          Opções
        </button>
        <ul class="dropdown-menu">
          <li><a href="{{ route('receipt.create') }}" class="dropdown-item">Adicionar receita</a></li>
          <li><a href="{{ route('expense.create') }}" class="dropdown-item">Adicionar despesa</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a href="{{ route('categories.index') }}" class="dropdown-item">Ver categorias</a></li>
        </ul>
    </div>

</div>



<div id="expense-table" class="">
    @livewire(App\Livewire\ExpensesTable::class)
</div>

<div id="receipt-table" class="d-none">
    @livewire(App\Livewire\ReceiptsTable::class)
</div>

<script>
    document.getElementById('showTable1').addEventListener('click', function() {
        document.getElementById('expense-table').classList.remove('d-none');
        document.getElementById('receipt-table').classList.add('d-none');

        this.classList.add('active');
        document.getElementById('showTable2').classList.remove('active');
    });

    document.getElementById('showTable2').addEventListener('click', function() {
        document.getElementById('expense-table').classList.add('d-none');
        document.getElementById('receipt-table').classList.remove('d-none');

        this.classList.add('active');
        document.getElementById('showTable1').classList.remove('active');
    });
</script>

@endsection

@push('style')
    @filamentStyles
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="/css/main/dashboard.css">
@endpush
@push('script')
    @filamentScripts
    @vite('resources/js/app.js')
@endpush