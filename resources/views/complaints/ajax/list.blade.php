<div class="table-responsive custom-table">
	
	<table class="table table-striped">
		<thead>
<tr>
<td>Title</td>
<td>Descrption</td>
<td>Actions</td>

</tr>
</thead>
<tbody>
	

@foreach($post as $list)
<tr>
<td>{{$list->title}}</td>
<td>{{$list->descriptions}}</td>

<td>
	
    <a class="btn btn-danger btn-xs" onclick="Changestatus(this)" data-type="delete" data-id="{{$list->id}}"> Delete</a></td>

</tr>
@endforeach
@if (count($post)== 0 )
<tr>
  <td colspan="3" style="text-align:center"> No Data</td>
</tr>
@endif
</table>
</tbody>
{!! $post->render() !!}
