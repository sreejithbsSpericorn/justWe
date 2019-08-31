<div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content crate-modal-content">
		<div class="modal-header">
			<h4 class="modal-title">Poll Details</h4>
		</div>
		<div class="modal-body">
			
			<p>{{$post->title}}</p>

			<dl>
				@foreach($post_options as $data)




				<div class="percentage percentage-11">
					<span class="text">{{$data->options}}</span>
					<?php
					 $percantage = $data->polling_count/$totalcount*100
					?>
					<div class="d-flex">
						<div class="graph-bar">
							<span  style="width: {{$percantage}}%" class="graph"></span>
						</div>
						<p class="poll-value"> {{$percantage}}%</p>
					</div>
				</div>
				@endforeach

			</dl>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		</div>
	</div>

</div>