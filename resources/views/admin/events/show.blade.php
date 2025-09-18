@extends('layout')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">{{ $event->name }}</h1>
    <div class="flex flex-col md:flex-row gap-8">
        <div>
            @if($event->poster)
                <img src="{{ asset('storage/' . $event->poster) }}" alt="Poster" class="w-96 h-96 object-cover rounded shadow" />
            @else
                <span class="text-gray-500">No poster available</span>
            @endif
        </div>
        <div class="flex-1">
            <p><strong>Date:</strong> {{ $event->date }}</p>
            <p><strong>Location:</strong> {{ $event->location }}</p>
            <p><strong>Manager:</strong> {{ $event->manager ? $event->manager->name : 'Not assigned' }}</p>
            <p><strong>Description:</strong> {{ $event->description }}</p>
            <p><strong>Packages:</strong></p>
            <ul class="list-disc ml-6">
                @foreach($event->packages as $package)
                    <li>{{ $package->name }} - {{ $package->price }}</li>
                @endforeach
            </ul>
            <a href="{{ route('admin.events.pdf', $event) }}" class="bg-green-500 text-white px-4 py-2 rounded mt-4 inline-block">Download PDF (1080x1080)</a>
        </div>
    </div>
</div>
@endsection
