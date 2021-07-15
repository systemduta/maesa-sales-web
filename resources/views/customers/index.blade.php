<h3>Index</h3>
@if (session()->has('status'))
<p>{{session()->get('status')}}</p>
@endif
<table border="1">
    <tr>
        <td>Name</td>
        <td>Address</td>
    </tr>
    @foreach ($customers as $customer)
    <tr>
        <td>{{$customer->name}}</td>
        <td>{{$customer->address}}</td>
    </tr>
    @endforeach
</table>
<a href="{{ route('customers.create') }}" role="button">Tambah</a>
