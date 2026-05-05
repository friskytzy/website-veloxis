@extends('layouts.admin')

@section('title', 'Add Sparepart')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Add Sparepart</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.spareparts.index') }}">Spareparts</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ol>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-plus me-1"></i>Create Sparepart</div>
        <div class="card-body">
            <form action="{{ route('admin.spareparts.store') }}" method="POST">
                @include('admin.spareparts._form', ['submitLabel' => 'Create Sparepart'])
            </form>
        </div>
    </div>
</div>
@endsection
