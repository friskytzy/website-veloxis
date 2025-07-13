@extends('layouts.admin')

@section('title', 'Manage Events')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4">Events Management</h1>
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Event
        </a>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-calendar-alt me-1"></i>
            Events
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="events-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Location</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $event)
                            <tr>
                                <td>{{ $event->title }}</td>
                                <td>{{ $event->start_date ? date('Y-m-d', strtotime($event->start_date)) : 'Not set' }}</td>
                                <td>{{ $event->location }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this event?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                        <a href="{{ route('events.show', $event->id) }}" class="btn btn-sm btn-info" target="_blank">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No events found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $events->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#events-table').DataTable({
            paging: false,
            searching: true,
            ordering: true,
        });
    });
</script>
@endpush 