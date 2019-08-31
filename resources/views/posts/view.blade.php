@extends('layouts.master')

@section('content')
    <div class="container ">
        <input type="hidden" id="post_id" name="post_id" value="{{$post->id}}">
        <div class="detailed-feeds">
            <div class="topic-title">
                <div class="title-wrapper">
                    <h1>{{$post->title}}</h1>
                    <div class="feeds-details">
                        <a class="category">
                            @if($post->post_tags)
                                @php $tempArr = json_decode($post->post_tags, TRUE); @endphp
                                @foreach($tempArr as $single)
                                    <span class="badge-category-bg"></span>
                                    <span class="question-category">{{ $single }}</span>
                                @endforeach

                            @endif
                        </a>
                    </div>
                </div>
            </div>
            <div class="detailed-topic">
                <div class="topic-container">
                    <div class="topic-avatar">
                        <div class="pro-pic">
                            <a>{{$post->user()->first()->name[0]}}</a>
                        </div>
                    </div>
                    <div class="topic-body ">
                        <div class="topic-owner">
                            <a class="name">{{$post->user()->first()->name}}</a>
                            <p class="posting-time">{{ Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</p>
                        </div>
                        <div class="regular-contents">
                            @if($post->image)
                                <img src="{{asset($post->image)}}" alt="">
                            @endif
                            <p> {{$post->descriptions}}</p>
                        </div>
                        <div class="comment-section">
                            <div class="topic-avatar">
                                <div class="pro-pic">
                                    <a>{{Auth::user()->name[0]}}</a>
                                </div>
                            </div>
                            <div class="comment-textbox">
                                <textarea rows="4" id="newComment"></textarea>
                                <button class="btn btn-default btn-comment" id="addComment">comment</button>
                            </div>
                        </div>

                        <div class="comment-append">
                            @foreach($comments as $comment)
                                <div class="view-comment-section">
                                    <div class="comment-user-profile">
                                        <div class="topic-avatar">
                                            <div class="pro-pic">
                                                <a>{{$comment->name[0]}}</a>
                                            </div>
                                        </div>
                                        <div class="user-details">
                                          <a class="username">{{$comment->name}}</a>
                                          <span class="post-date">{{$comment->created_at}}</span>
                                        </div>
                                    </div>
                                    <div class="user-comment">
                                        <p>{{$comment->comments}}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('custom_scripts')
    <script>
        $(document).ready(function(){

            $(document).on('click','#addComment',function(){

            var post_id = $('#post_id').val();
            var comments = $('#newComment').val();

            if(comments.trim()!=''){
                $.ajax({
                    type:'POST',
                    url:"{{route('addcomment')}}",
                    data:{
                        _token: CSRF_TOKEN,
                        comments:comments,
                        post_id:post_id
                    },
                    dataType:'JSON',
                    success:function(data){
                        if(data.status){
                          $('.comment-append').prepend('<div class="view-comment-section"><div class="comment-user-profile">'+
                              '<div class="topic-avatar">'+
                                '<div class="pro-pic">'+
                                 '<a>S</a>'+
                                '</div>'+
                              '</div>'+
                              '<div class="user-details">'+
                                '<a href="#" class="username">'+data.comment.user+'</a>'+
                                '<span class="post-date">'+data.comment.created_at+'</span>'+
                              '</div>'+
                            '</div>'+
                            '<div class="user-comment">'+
                            '<p>'+data.comment.comments+'</p>'+
                            '</div></div>');
                          $('#newComment').val('');
                        }
                    }
                })
            }
            });
        });
    </script>
@endsection
