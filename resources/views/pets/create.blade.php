<!DOCTYPE html>
<html>
<head>
    <title>Add Pet</title>
</head>
<body>
    <h1>Add Pet</h1>
    <form action="{{ route('pets.store')}}" method="POST">
        @csrf
        <label>ID:</label>
        <input type="number" name="id" required>
        <label>Name:</label>
        <input type="text" name="name" required>
        <label>image Url:</label>
        <input type="text" name="photoUrls">
        <label>Status:</label>
        <select name="status" id="status">
            <option value="available">available</option>
            <option value="pending">pending</option>
            <option value="sold">sold</option>
        </select>
        <button type="submit">Add Pet</button>
    </form>
</body>
</html>