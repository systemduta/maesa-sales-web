<h3>Create</h3>
@if (count($errors) > 0)
<p> {{$errors->first()}}</p>
@endif
<form action="/models" method="POST">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    ID: <input type="text" name="id"></br>
    Name: <input type="text" name="name"></br>
    Address: <input type="text" name="address"></br>
    <input type="submit"></br>
</form>
