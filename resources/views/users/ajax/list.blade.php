<table>
<tr>
<td>Name</td>
<td>Email</td>
<td>Actions</td>

</tr>
@foreach($users as $list)
<tr>
<td>{{$list->name}}</td>
<td>{{$list->email}}</td>
<td>Actions</td>

</tr>
@endforeach
@if (count($users)== 0 )
 <tr>
  <td colspan="3" style="text-align:center"> No Data</td>                                                    



</tr>
@endif
</table>
{!! $users->render() !!}
