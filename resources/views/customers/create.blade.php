<h3>Create</h3>
@if (count($errors) > 0)
<p> {{$errors->first()}}</p>
@endif
<form action="{{ route('customers.store') }}" method="GET">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    Name: <input type="text" name="name"></br>
    Address: <input type="text" name="address"></br>
    <input type="submit"></br>
</form>

