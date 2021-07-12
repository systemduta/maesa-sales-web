<h3>Index</h3>
@if (session()->has('status'))
<p>{{session()->get('status')}}</p>
@endif
<table border="1">
    <tr>
        <td>ID</td>
        <td>Name</td>
        <td>Address</td>
    </tr>
    @foreach ($customers as $customer)
    <tr>
        <td>{{$customer->id}}</td>
        <td>{{$customer->name}}</td>
        <td>{{$customer->address}}</td>
    </tr>
    @endforeach
</table>
