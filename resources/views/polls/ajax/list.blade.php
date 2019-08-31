<div class="table-responsive custom-table">
	
	<table class="table table-striped">
		<thead>
			<td>SL No</td>
			<td>Title</td>
			<td>Date</td>
			<td>Status</td>
			<td>Actions</td>

		</tr>
	</thead>
	<tbody>

		<?php $index =1; ?>
		@foreach($post as $list)
		<tr>
			<td>{{$index}}</td>
			<td><a onclick="Detailview(this)" data-id="{{$list->id}}" class="text-primary">{{$list->title}}</a></td>
			<td>{{date("d M Y", strtotime($list->expire_date))}}</td>
			<td class='@if($list->expire_date >= date("Y-m-d")) text-success @else text-warning @endif'>@if($list->expire_date >= date("Y-m-d")) Active @else Expired @endif</td>


			<td>

				<a class="btn btn-danger btn-xs" onclick="Changestatus(this)" data-type="delete" data-id="{{$list->id}}"> Delete</a></td>

			</tr>
			<?php ++$index  ?>
			@endforeach
			@if (count($post)== 0 )
			<tr>
				<td colspan="4" style="text-align:center"> No Data</td>
			</tr>
			@endif

		</tbody>
	</table>
	{!! $post->render() !!}