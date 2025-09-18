@extends('layout')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Create Manager</h1>
    <form action="{{ route('admin.managers.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block">Name</label>
            <input type="text" name="name" class="border rounded w-full p-2" required>
        </div>
        <div>
            <label class="block">Email</label>
            <input type="email" name="email" class="border rounded w-full p-2" required>
        </div>
        <div>
            <label class="block">Password</label>
            <input type="password" name="password" class="border rounded w-full p-2" required>
        </div>
        <div>
            <label class="block">Confirm Password</label>
            <input type="password" name="password_confirmation" class="border rounded w-full p-2" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create Manager</button>
    </form>
</div>
@endsection
