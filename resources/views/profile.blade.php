@extends('layouts.master')

@section('content')

<div class="container profile-container">
	<div class="profile-header">
		<p>Profile</p>
		<!-- <div>
			<a class="btn btn-edit" data-toggle="modal" data-target="#edit-profile"><i
					class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit</a>
		</div> -->
	</div>
	<div class="profile-section">

		<div class="profile-page-pic">
			<div class="profile-pic">
				<a>{{ $user->name[0] }}</a>
			</div>
		</div>
		<div class="user-profile-details">
			<p class="user-profile-name">{{ $user->name }}</p>
			<p class="user-email">{{ $user->email }}</p>
		</div>
		<!-- <div class="employee-id">
			<p>Emp id : <span>001</span></p>
		</div> -->
	</div>
	<div class="employee-post-details">
		<div class="d-flex">
			<div class="d-flex post-count">
				<p>Total Posts : </p> <a>{{ $posts->count() }}</a>
			</div>
			<!-- <div class="d-flex post-count">
				<p>Comment : </p> <a>24</a>
			</div> -->
			<div class="random-password">
				<p>Guest Password :</p>
				<a>1%$spericorn!</a>
			</div>
		</div>
	</div>
	<div class="employee-all-post">
		<div class="category-selector">
			<div class="row">
				<div class="content-right-wrap">
					<div class="newfeeds-container table-responsive">
					    <table class="newsfeed-table">
					        <thead>
					            <tr>
					                <th>Topic</th>
					                <th class="replies">Comments</th>
					                <!-- <th class="views">Views</th> -->
					                <th class="activity">Activity</th>
					            </tr>
					        </thead>
					        <tbody>
					          @foreach($posts as $post)
					              <tr>
					                  <td class="topic-section">
					                      @if($post->post_type == "3")
					                          <a  class="newfeed-question">
					                      @else
					                          <a href="{{ route('posts.view', $post->id) }}" class="newfeed-question">
					                      @endif
					                          <span class="type">[ {{ $post->posttype()->first()->type}} ] </span>
					                          {{ $post->title }}
					                      </a>
					                      <div class="d-flex mb-10">
					                          <div class="tags">
					                              @php
					                                  if($post->post_tags){
					                                      $tempArr = json_decode($post->post_tags, TRUE);
					                                      foreach($tempArr as $single){
					                                          echo '<a class="category"> <span class="square"></span>' . $single . '</a>';
					                                      }
					                                  }
					                              @endphp
					                          </div>
					                          <div class="user-details">
					                              <div class="link-bottom-line">
					                                  <div class="profile-pic-container">
					                                      <div class="pro-pic">
					                                          <a>{{ $post->user->name[0] }}</a>
					                                      </div>
					                                  </div>
					                                  <div class="user-details">
					                                      <a class="username">{{ $post->user->name }}</a>
					                                      <span class="post-date">{{ $post->created_at->format('D j, Y') }}</span>
					                                  </div>
					                              </div>
					                          </div>
					                      </div>

					                      <!-- Check if Post Type is `POLL` -->
					                      @if($post->post_type == '3')

					                          @php
					                              $poll_options = $post->options()->get();
					                              $getPoll = App\Polling::where('user_id', Auth::id())->where('post_id', $post->id)->first();
					                              $pollCount = App\Polling::where('post_id', $post->id)->count();
					                          @endphp

					                          @if($getPoll)  <!-- if user already submitted the poll -->

					                              <div class="poll-ratio-container">
					                                  <div class="poll-ratio">
					                                      <div class="poll-img-wrap">
					                                          @if($post->image)
					                                              <img src="{{ asset($post->image) }}" class="img-fluid">
					                                          @endif
					                                      </div>
					                                      <dl>
					                                          @foreach($poll_options as $option)
					                                              <div class="percentage">
					                                                  <span class="text"> {{ $option->options }} </span>
					                                                  <div class="graph-bar">
					                                                      @php
					                                                          $submittedPollsCount = App\Polling::where('post_id', $post->id)->where('post_options_id', $option->id)->count();

					                                                          if($submittedPollsCount > 0){
					                                                              $calcWidth = ( $submittedPollsCount / $pollCount ) * 100;
					                                                              echo '<span style="width: '. $calcWidth . '%" class="graph">'. $calcWidth . '%</span>';
					                                                          } else{
					                                                              echo '<span style="width: 0%" class="graph">0%</span>';
					                                                          }

					                                                      @endphp
					                                                  </div>
					                                              </div>
					                                          @endforeach
					                                      </dl>
					                                  </div>
					                              </div>

					                          @else  <!-- User not polled-->

					                              <div class="topic-content poll-content">
					                                  <div class="poll-list">
					                                      <div class="poll-img-wrap">
					                                          @if($post->image)
					                                              <img src="{{ asset($post->image) }}" class="img-fluid">
					                                          @endif
					                                  </div>
					                                      @php $poll_options = $post->options()->get(); @endphp

					                                      @foreach($poll_options as $option)
					                                          <label class="poll-container">
					                                              {{ $option->options }}
					                                              <input type="radio" class="choosed-poll-option" name="choosed-poll-option" value="{{ $option->id }}">
					                                              <span class="checkmark"></span>
					                                          </label>
					                                      @endforeach
					                                      <div class="poll-submit">
					                                      <button class="btn poll-submit-btn" data-post_id="{{$post->id}}">Submit</button>
					                                      </div>
					                                  </div>
					                              </div>

					                          @endif

					                      @endif

					                      <div class="topic-content">
					                          <p>
					                              {{ $post->description }}
					                          </p>
					                      </div>

					                  </td>
					                  <td class="d-replay">
					                      <a>{{ $post->comments()->count() }}</a>
					                  </td>
					                  <!-- <td class="d-views">
					                      <a>36</a>
					                  </td> -->
					                  <td class="d-activity" style="white-space: nowrap;">
					                      <a>
					                          @php
					                              if($post->comments()->get()->isNotEmpty()){
					                                  echo $post->comments()->latest()->first()->created_at;
					                              } else{
					                                  echo 'No Activity';
					                              }
					                          @endphp
					                      </a>
					                  </td>
					              </tr>
					          @endforeach
					        </tbody>
					    </table>
					</div>
				</div>
			</div>



		</div>
	</div>
</div>


@stop

@section('custom_scripts')
<script src="//js.pusher.com/3.1/pusher.min.js"></script>

<script type="text/javascript">
  var pusher = new Pusher('09143f0b85f847fa4a08', {
	encrypted: true
  });

// Subscribe to the channel we specified in our Laravel Event
var channel = pusher.subscribe('postsave');

// Bind a function to a Event (the full Laravel class)
channel.bind('App\\Events\\Postsave', function(data) {
	// this is called when the event notification is received...
//alert(1);
loadPosts();
});

	var post_type;
	// var page_num = 0;
	var filter_type = $("#category-sel").val();

	$(document).ready(function() {

		loadPosts();

		// Create New Button click event
		$("#addNew").click(function(){
			$(".create-add-form").show();
			$(this).hide();
		});

		$(".close-home-post").click(function(){
			$(".home-add-post").hide();
			$("#addNew").show();
		});

		//Poll Submission
		$('body').on('click','.poll-submit-btn',function(){

			var $this = $(this);
			var post_id = $this.attr('data-post_id');
			var option_id = $('.choosed-poll-option').val();

			$.ajax({
				url: base_url+'/posts/submitpoll',
				type: 'POST',
				data: {
					post_id,
					option_id,
					_token: CSRF_TOKEN
				},
				success: function (data) {
					if(data.status){
						$this.parent().parent().children('.poll-container').remove();
						$this.parent().parent().append(data.renderer);
						$this.remove();
					}
				}
			});

		});



		// Tags on change event
		$('body').on('change','#post_type',function(){

			post_type = $(this).val();
			if(! post_type){
				toastr.error('Please select a Post Type');
				toggleDivs('hide');
				return false;
			}

			if(post_type == '1'){
				toggleDivs('show');
			} else{
				$(".tag-div").hide();
				$(".content-div").show();
				$(".outer-div").show();
			}
		});

		$("#category-sel").change(function(){
			filter_type = $(this).val();
			loadPosts();
		});

		// Create form submission event
		$("form#createForm").submit(function(e) {
			e.preventDefault();

			var formData = new FormData(this);

			$.ajax({
				url: base_url+'/posts/create',
				type: 'POST',
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				success: function (data) {
					if(data.status){
						toastr.success('Post created successfully');
						toggleDivs('hide');
						$(".createForm").hide();
						$("form#createForm")[0].reset();
						$("form#createForm").parsley().reset();

						loadPosts();
					}
				}
			});
		});


		// CUSTOM SELECT BOX CSS
		$("body").on("click", "#custom-select" ,function(){
			$("#custom-select-option-box").toggle();
		});
		$("body").on("click", ".custom-select-option" ,function(){
			var checkboxObj = $(this).children("input");
			$(checkboxObj).prop("checked",true);
			toggleFillColor(checkboxObj);
		});
		$("body").on("click",function(e){
			if(e.target.id != "custom-select" && $(e.target).attr("class") != "custom-select-option") {
				$("#custom-select-option-box").hide();
			}
		});
		// CUSTOM SELECT BOX CSS
	});


	// LOAD MAIN POSTS
	function loadPosts(){
		$.ajax({
			url: base_url+'/posts/loadPosts',
			type: 'POST',
			data: {
				filter_type: filter_type,
				_token: CSRF_TOKEN
			},
			success: function (data) {
				if(data.status){
					$(".newsfeed-table tbody").empty().append(data.renderer);
				}
			}
		});
	}


	// CUSTOM SELECT BOX CSS
	function toggleFillColor(obj) {
		$("#custom-select-option-box").show();
		if($(obj).prop('checked') == true) {
			$(obj).parent().css("background",'#c6e7ed');
		} else {
			$(obj).parent().css("background",'#FFF');
		}
	}

	// SHOW/HIDE DIV HELPER
	function toggleDivs(type){
		if(type == 'show'){
			$(".tag-div").show();
			$(".content-div").show();
			$(".outer-div").show();
		} else{
			$(".tag-div").hide();
			$(".content-div").hide();
			$(".outer-div").hide();
		}
	}
</script>

@endsection