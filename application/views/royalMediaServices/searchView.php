<!DOCTYPE html>
<html>
<head>
	<title>Search Results</title>
</head>
<body>
<a href = "">Show Registered Items<a>
<a href=""  class="btn btn-primary">Search results</a>
<table class="table table-condensed table-striped table-bordered table-hover">
   <tr>
      <th>#</th>
      <th>category</th>
      <th> Item</th>
      <th>Quantity</th>
      <th>Units</th>
      <th>Price</th>
      <th>image</th>
      <th>searched at</th>
      <th colspan="2">Actions</th>
   </tr>
   @foreach($items as $item)
   <tr>
      <td>{{ $item->id }}</td>
      <td>{{ $item->category }} </td>
      <td>{{ $item->quantity }} </td>
      <td>{{ $item->units }} </td>
      <td>{{ $item->price }} </td>
      <td>{{ $item->image }} </td>
      <td>{{ $product->created_at->toFormattedDateString() }}</td>
     <td><a href ="" class="btn btn-sm btn-primary">edit</a></td>
      <td><a href="" class="btn btn-sm btn-danger"  onclick()="are you sure you want to delete">delete</a></td>
   </tr>
   @endforeach
</table>

</body>
</html>
