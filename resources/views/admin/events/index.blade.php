@extends('layout')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Events</h1>
    <a href="{{ route('admin.events.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add New Event</a>
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2">Poster</th>
                <th class="py-2">Name</th>
                <th class="py-2">Date</th>
                <th class="py-2">Location</th>
                <th class="py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
            <tr>
                <td class="py-2">
                    @if($event->poster)
                        <img src="{{ asset('storage/' . $event->poster) }}" alt="Poster" class="h-16 w-16 object-cover rounded" />
                    @else
                        <span>No poster</span>
                    @endif
                </td>
                <td class="py-2">{{ $event->name }}</td>
                <td class="py-2">{{ $event->date }}</td>
                <td class="py-2">{{ $event->location }}</td>
                <td class="py-2">
                    <a href="{{ route('admin.events.show', $event) }}" class="text-blue-600">View</a> |
                    <a href="{{ route('admin.events.edit', $event) }}" class="text-yellow-600">Edit</a> |
                    <form action="{{ route('admin.events.destroy', $event) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600" onclick="return confirm('Delete this event?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
