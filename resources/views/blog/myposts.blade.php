@extends('layouts.main')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <a href="{{ route('blog.posts.create') }}" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Add a post</a>
                <hr/>
                @if(session()->get('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}  
                </div><br />
                @endif
                @if (! $posts->count())
                    <div class="alert alert-warning">
                        <p>Nothing Found</p>
                    </div>
                @else
                    @if (isset($categoryName))
                        <div class="alert alert-info">
                            <p>Category: <strong>{{ $categoryName }}</strong></p>
                        </div>
                    @endif
                
                    @foreach($posts as $post)
                    <div class="btn-group">
                    <form action="{{ route('blog.posts.delete', $post->id)}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this article?')">
                        <a href="{{ route('blog.posts.edit',$post->id) }}" class="btn btn-primary" role="button" aria-pressed="true">Edit</a>
                        @if ($post->date == '')
                        <a href="{{ route('blog.posts.publish',$post->id) }}" class="btn btn-warning" role="button" aria-pressed="true">Publish</a>
                        @else
                        <a href="{{ route('blog.posts.publish',$post->id) }}" class="btn btn-warning" role="button" aria-pressed="true">Unpublish</a>
                        @endif
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                    </div>
                        <article class="post-item">
                             
                            @if ($post->image_url)
                                <div class="post-item-image">
                                    <a href="{{ route('blog.show', $post->slug) }}">
                                        <img src="{{ $post->image_url }}" alt="">
                                    </a>
                                </div>
                            @endif

                            <div class="post-item-body">
                                <div class="padding-10">
                                    <h2><a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a></h2>
                                    {!! $post->excerpt_html !!}
                                </div>

                                <div class="post-meta padding-10 clearfix">
                                    <div class="pull-left">
                                        <ul class="post-meta-group">
                                            <li><i class="fa fa-user"></i><a href="#"> {{ $post->author->name }}</a></li>
                                            @if ($post->date == '')
                                                <li><i class="fa fa-clock-o"></i><time> Not published </time></li>
                                            @else
                                                <li><i class="fa fa-clock-o"></i><time> {{ $post->date }} </time></li>
                                            @endif
                                            <li><i class="fa fa-folder"></i><a href="{{ route('category', $post->category->slug) }}"> {{ $post->category->title }}</a></li>
                                            <li><i class="fa fa-comments"></i><a href="#">4 Comments</a></li>
                                        </ul>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{{ route('blog.show', $post->slug) }}">Continue Reading &raquo;</a>
                                    </div>
                                </div>
                            </div>
                        </article>

                    @endforeach

                @endif

                <nav>
                  {{ $posts->links() }}
                </nav>
            </div>

            @include('layouts.sidebar')
        </div>
    </div>

@endsection
