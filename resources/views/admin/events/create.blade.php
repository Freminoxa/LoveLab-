@extends('layout')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-white mb-8">Create New Event</h1>
        
        @if($errors->any())
        <div class="bg-red-500/20 border border-red-500/50 text-white px-4 py-3 rounded-lg mb-6">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <!-- Event Basic Info -->
            <div class="bg-white/10 backdrop-blur-lg rounded-xl p-6 border border-white/20">
                <h2 class="text-xl font-semibold text-white mb-4">Event Details</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-white/80 font-medium mb-2">Event Name *</label>
                        <input type="text" name="name" required
                               class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:border-pink-400 outline-none"
                               placeholder="e.g., Valentine's Night Party">
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-white/80 font-medium mb-2">Date & Time *</label>
                            <input type="datetime-local" name="date" required
                                   class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white focus:border-pink-400 outline-none">
                        </div>
                        <div>
                            <label class="block text-white/80 font-medium mb-2">Location *</label>
                            <input type="text" name="location" required
                                   class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:border-pink-400 outline-none"
                                   placeholder="e.g., Nairobi Club">
                        </div>
                    </div>

                    <div>
                        <label class="block text-white/80 font-medium mb-2">Description</label>
                        <textarea name="description" rows="3"
                                  class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:border-pink-400 outline-none"
                                  placeholder="Brief description of the event"></textarea>
                    </div>

                    <div>
                        <label class="block text-white/80 font-medium mb-2">Event Poster</label>
                        <input type="file" name="poster" accept="image/*"
                               class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-pink-500 file:text-white">
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-white/80 font-medium mb-2">Assign Manager</label>
                            <select name="manager_id"
                                    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white focus:border-pink-400 outline-none">
                                <option value="">Select Manager</option>
                                @foreach($managers as $manager)
                                    <option value="{{ $manager->id }}">{{ $manager->name }} ({{ $manager->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <a href="{{ route('admin.managers.create') }}" 
                               class="text-pink-400 hover:text-pink-300 flex items-center">
                                <i class="fas fa-plus-circle mr-2"></i>Create New Manager
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ticket Packages -->
            <div class="bg-white/10 backdrop-blur-lg rounded-xl p-6 border border-white/20">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-white">Ticket Packages *</h2>
                    <button type="button" onclick="addPackage()" 
                            class="bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600 transition-all">
                        <i class="fas fa-plus mr-2"></i>Add Package
                    </button>
                </div>

                <div id="packages-container" class="space-y-4">
                    <!-- Package 1 (Default) -->
                    <div class="package-item bg-white/5 rounded-lg p-4 border border-white/10">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-white font-medium">Package 1</h3>
                            <button type="button" onclick="removePackage(this)" class="text-red-400 hover:text-red-300">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-white/70 text-sm mb-2">Package Name</label>
                                <input type="text" name="packages[0][name]" required
                                       class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded text-white placeholder-white/50"
                                       placeholder="e.g., Single Entry">
                            </div>
                            <div>
                                <label class="block text-white/70 text-sm mb-2">Price (KSH)</label>
                                <input type="number" name="packages[0][price]" required min="0" step="0.01"
                                       class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded text-white"
                                       placeholder="1000">
                            </div>
                            <div>
                                <label class="block text-white/70 text-sm mb-2">Group Size (Tickets)</label>
                                <input type="number" name="packages[0][group_size]" required min="1"
                                       class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded text-white"
                                       placeholder="1">
                            </div>
                            <div>
                                <label class="block text-white/70 text-sm mb-2">Available Tickets (Optional)</label>
                                <input type="number" name="packages[0][available_tickets]" min="0"
                                       class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded text-white"
                                       placeholder="Leave empty for unlimited">
                            </div>
                            <div>
                                <label class="block text-white/70 text-sm mb-2">Icon (Emoji)</label>
                                <input type="text" name="packages[0][icon]" maxlength="10"
                                       class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded text-white"
                                       placeholder="🎫">
                            </div>
                            <div>
                                <label class="block text-white/70 text-sm mb-2">Description</label>
                                <input type="text" name="packages[0][description]"
                                       class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded text-white placeholder-white/50"
                                       placeholder="Package description">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex space-x-4">
                <button type="submit"
                        class="flex-1 bg-gradient-to-r from-pink-500 to-purple-600 text-white font-semibold py-3 px-6 rounded-lg hover:from-pink-600 hover:to-purple-700 transition-all">
                    <i class="fas fa-save mr-2"></i>Create Event
                </button>
                <a href="{{ route('admin.events.index') }}"
                   class="flex-1 bg-white/10 text-white font-semibold py-3 px-6 rounded-lg hover:bg-white/20 transition-all text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
let packageCount = 1;

function addPackage() {
    const container = document.getElementById('packages-container');
    const newPackage = document.createElement('div');
    newPackage.className = 'package-item bg-white/5 rounded-lg p-4 border border-white/10';
    newPackage.innerHTML = `
        <div class="flex justify-between items-start mb-4">
            <h3 class="text-white font-medium">Package ${packageCount + 1}</h3>
            <button type="button" onclick="removePackage(this)" class="text-red-400 hover:text-red-300">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-white/70 text-sm mb-2">Package Name</label>
                <input type="text" name="packages[${packageCount}][name]" required
                       class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded text-white placeholder-white/50"
                       placeholder="e.g., Couple Entry">
            </div>
            <div>
                <label class="block text-white/70 text-sm mb-2">Price (KSH)</label>
                <input type="number" name="packages[${packageCount}][price]" required min="0" step="0.01"
                       class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded text-white"
                       placeholder="2000">
            </div>
            <div>
                <label class="block text-white/70 text-sm mb-2">Group Size (Tickets)</label>
                <input type="number" name="packages[${packageCount}][group_size]" required min="1"
                       class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded text-white"
                       placeholder="2">
            </div>
            <div>
                <label class="block text-white/70 text-sm mb-2">Available Tickets (Optional)</label>
                <input type="number" name="packages[${packageCount}][available_tickets]" min="0"
                       class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded text-white"
                       placeholder="Leave empty for unlimited">
            </div>
            <div>
                <label class="block text-white/70 text-sm mb-2">Icon (Emoji)</label>
                <input type="text" name="packages[${packageCount}][icon]" maxlength="10"
                       class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded text-white"
                       placeholder="💑">
            </div>
            <div>
                <label class="block text-white/70 text-sm mb-2">Description</label>
                <input type="text" name="packages[${packageCount}][description]"
                       class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded text-white placeholder-white/50"
                       placeholder="Package description">
            </div>
        </div>
    `;
    
    container.appendChild(newPackage);
    packageCount++;
}

function removePackage(button) {
    const packageItem = button.closest('.package-item');
    const container = document.getElementById('packages-container');
    
    if (container.children.length > 1) {
        packageItem.remove();
    } else {
        alert('You must have at least one package!');
    }
}
</script>
@endsection