@extends('layout')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Add New Event</h1>
    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label class="block">Event Name</label>
            <input type="text" name="name" class="border rounded w-full p-2" required>
        </div>
        <div>
            <label class="block">Date</label>
            <input type="date" name="date" class="border rounded w-full p-2" required>
        </div>
        <div>
            <label class="block">Location</label>
            <input type="text" name="location" class="border rounded w-full p-2" required>
        </div>
        <div>
            <label class="block">Poster</label>
            <input type="file" name="poster" accept="image/*" class="border rounded w-full p-2">
        </div>
        <div>
            <label class="block">Assign Manager</label>
            <select name="manager_id" class="border rounded w-full p-2">
                <option value="">Select Manager</option>
                @foreach($managers as $manager)
                    <option value="{{ $manager->id }}">{{ $manager->name }} ({{ $manager->email }})</option>
                @endforeach
            </select>
            <a href="{{ route('admin.managers.create') }}" class="text-blue-500 ml-2">Create new manager</a>
        </div>
        <div>
            <label class="block">Confirm Payment</label>
            <input type="checkbox" name="payment_confirmed" value="1" class="mr-2"> Payment received
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create Event</button>
    </form>
</div>
@endsection
