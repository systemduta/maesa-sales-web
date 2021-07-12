<h3>Edit</h3>
<form action="/models/{{$model->id}}" method="POST">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    Name: <input type="text" name="name" value="{{$model->name}}"></br>
    Address: <input type="text" name="address" value="{{$model->address}}"></br>
    <button type="submit" name="_method" value="PUT">Simpan</button>
    <button type="submit" name="_method" value="DELETE">Hapus</button>
</form>
