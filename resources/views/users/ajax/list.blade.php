


<div class="table-responsive custom-table">
	
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Name</th>
				<th>Email</th>
				<th>Actions</th>
			</tr>
		</thead>
		
		<tbody>

			@foreach($users as $list)
			<tr>
			<td>{{$list->name}}</td>
			<td>{{$list->email}}</td>

			<td>
				@if($list->active == 0)
				 <a class="btn btn-primary btn-xs" onclick="Changestatus(this)" data-type="deactivate" data-id="{{$list->id}}">Deactivate
			     </a> 
			    @else
			      <a class="btn btn-success btn-xs" onclick="Changestatus(this)" data-type="activate" data-id="{{$list->id}}">Activate
			     </a> 
			    @endif
			    <a class="btn btn-danger btn-xs" onclick="Changestatus(this)" data-type="delete" data-id="{{$list->id}}"> Delete</a></td>

			</tr>
			@endforeach
			@if (count($users)== 0 )
			<tr>
			  <td colspan="3" style="text-align:center"> No Data</td>
			</tr>
			@endif

		</tbody>

	</table>

</div>
{!! $users->render() !!}
