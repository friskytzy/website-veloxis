@extends('layouts.admin')

@section('title', 'Manage News')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4">News Management</h1>
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add News Article
        </a>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-newspaper me-1"></i>
            News Articles
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="news-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Published Date</th>
                            <th>Featured</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($news as $article)
                            <tr>
                                <td>{{ $article->title }}</td>
                                <td>{{ $article->published_at ? $article->published_at->format('Y-m-d') : 'Not published' }}</td>
                                <td>{!! $article->is_featured ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>' !!}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.news.edit', $article) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.news.destroy', $article) }}" method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this article?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                        <a href="{{ route('news.show', $article) }}" class="btn btn-sm btn-info" target="_blank">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No news articles found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $news->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#news-table').DataTable({
            paging: false,
            searching: true,
            ordering: true,
        });
    });
</script>
@endpush 