@extends('layouts.main')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div><br />
                @endif
                <div class="panel panel-default">
                <div class="panel-heading">New Post</div>
                <div class="panel-body">
                    <form method="post" enctype="multipart/form-data" action="{{ route('blog.posts.create') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Title *</label>
                            <input type="text" class="form-control" name="title" aria-describedby="title">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Slug *</label>
                            <input type="text" class="form-control" name="slug" aria-describedby="slug">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Excerpt</label>
                            <textarea class="form-control" name="excerpt" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Content</label>
                            <textarea class="form-control" name="body" rows="7"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Image</label>
                            <input type="file" name="img" class="form-control-file">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Category</label>
                            <select class="form-control" name="category">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('blog.posts') }}" class="btn btn-warning" role="button" aria-pressed="true">Cancel</a>
                    </form>
                </div>
                </div>
            </div>

            @include('layouts.sidebar')
        </div>
    </div>

@endsection
