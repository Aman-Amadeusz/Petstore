
<body>
    <h1>Edit Pet</h1>

    <form action="{{ route('pets.update', $pet['id'])}}" method="POST">
        @csrf
        @method('PUT')
        <label>Name:</label>
        <input type="text" name="name" value="{{ $pet['name'] }}" required>
        <label>image Url:</label>
        <input type="text" name="photoUrls" value="{{ isset($pet['photoUrls'][0]) ? $pet['photoUrls'][0] : 'string' }}">
        <label>Status:</label>
        <select name="status" id="status">
            <option value="available">available</option>
            <option value="pending">pending</option>
            <option value="sold">sold</option>
        </select>
        <button type="submit">Update Pet</button>
    </form>
</body>
