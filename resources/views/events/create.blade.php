<h1>Create Event</h1>

<form method="POST" action="{{ route('events.store') }}">
@csrf
<input type="text" name="title" placeholder="Title"><br>
<textarea name="description" placeholder="Description"></textarea><br>
<input type="text" name="venue" placeholder="Venue"><br>
<input type="date" name="date"><br>
<input type="time" name="time"><br>
<input type="number" name="capacity" placeholder="Capacity"><br>
<button type="submit">Create</button>
</form>
