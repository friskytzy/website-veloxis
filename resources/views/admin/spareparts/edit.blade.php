@extends('layouts.admin')

@section('title', 'Edit Sparepart')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Sparepart</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.spareparts.index') }}">Spareparts</a></li>
        <li class="breadcrumb-item active">Edit</li>
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
        <div class="card-header"><i class="fas fa-edit me-1"></i>Edit Sparepart</div>
        <div class="card-body">
            <form action="{{ route('admin.spareparts.update', $sparePart) }}" method="POST">
                @method('PUT')
                @include('admin.spareparts._form', ['submitLabel' => 'Update Sparepart'])
            </form>
        </div>
    </div>
</div>
@endsection
