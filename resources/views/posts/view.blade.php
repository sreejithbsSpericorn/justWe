@extends('layouts.app')

@section('content')
        <div class="container ">
                <input type="hidden" id="post_id" name="post_id" value="{{$post->id}}">
                <div class="detailed-feeds">
                    <div class="topic-title">
                        <div class="title-wrapper">
                            <h1>{{$post->title}}</h1>
                            <div class="feeds-details">
                                <a class="category">
                                    <span class="badge-category-bg"></span>
                                    <span class="question-category">php</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="detailed-topic">
                        <div class="topic-container">
                            <div class="topic-avatar">
                                <div class="pro-pic">
                                    <a>{{$user->name[0]}}</a>
                                </div>
                            </div>
                            <div class="topic-body ">
                                <div class="topic-owner">
                                    <a class="name" href="#">{{$user->name}}</a>
                                <p class="posting-time">{{$post->created_at}}</p>
    
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
                                                          <a href="#" class="username">{{$comment->name}}</a>
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
@endsection
@section('scripts')
<script src="https://malsup.github.io/jquery.form.js"></script>
<script>
$(document).ready(function(){
    // loadComments();

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
function loadComments(){
    var id = $('#post_id').val();
$.ajax({
    type:'POST',
    url: "{{ route('loadcomments') }}",
    data: {
        _token: CSRF_TOKEN,
        id
        },
    success:function(data){
        console.log('object', data);
        data.comments.forEach(element => {
            $('#comments').append('<br><b>'+element.name+'</b>:'+element.created_at+'<br>'
                           +element.comments);
        });
    }
});
}
</script>
@endsection
