@foreach($posts as $post)
    <tr>
        <td class="topic-section">
            @if($post->post_type == "3")
                <a  href="javascript:void(0);" class="newfeed-question">
            @else
                <a href="{{ route('posts.view', $post->id) }}" class="newfeed-question">
            @endif

            <a href="{{ route('posts.view', $post->id) }}" class="newfeed-question">
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
                            <form>
                                @php $poll_options = $post->options()->get(); @endphp

                                @foreach($poll_options as $option)
                                    <label class="poll-container">
                                        {{ $option->options }}
                                        <input type="radio" name="choosed-poll-option" value="{{ $option->id }}">
                                        <span class="checkmark"></span>
                                    </label>
                                @endforeach
                                <div class="poll-submit">
                                    <button class="btn poll-submit-btn">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>

                @endif

            @else
                <div class="topic-content">
                    <p>
                        {{ $post->description }}
                    </p>
                </div>
            @endif

        </td>
        <td class="d-replay">
            <a>3</a>
        </td>
        <!-- <td class="d-views">
            <a>36</a>
        </td> -->
        <td class="d-activity">
            <a>3m</a>
        </td>
    </tr>
@endforeach