<!DOCTYPE html>
<html>
<head>
    <title>Pets</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1>Pets</h1>
    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <form action="{{ route('pets.index') }}" method="POST">
        @csrf
        @method('GET')
        <select name="status" id="status">
            <option value="available">available</option>
            <option value="pending">pending</option>
            <option value="sold">sold</option>
        </select>
        <button type="submit">Change status</button>
    </form>
    <div style="border:1px solid rgb(65, 64, 64); background-color: gray;display: flex;justify-content: center;align-items: center;width:fit-content;border-radius: 25px;padding:4px;" ><a style="text-decoration: none;" href="{{ route('pets.create') }}">Add Pet</a></div>
    <ul>
        @foreach($pets as $pet)
            <li>
                {{ \Illuminate\Support\Arr::get($pet, 'name', 'No name') }} <br>

                @if(!empty($pet['photoUrls']))
                    <img style='width:100px;height:100px' src="{{ $pet['photoUrls'][0] }}" alt="no photo"> <br>
                @endif

                {{ \Illuminate\Support\Arr::get($pet, 'status', 'No status') }} <br>

                <a href="{{ route('pets.edit', $pet['id']) }}">Edit</a>
                <form action="{{ route('pets.destroy', $pet['id']) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>