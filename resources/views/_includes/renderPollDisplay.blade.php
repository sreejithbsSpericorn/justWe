@php
$pollCount = App\Polling::where('post_id', $post->id)->count();
@endphp

@if($getPoll)  <!-- if user already submitted the poll -->

<div class="poll-ratio-container">
    <div class="poll-ratio">
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

@endif