<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event - Admin Dashboard</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }
        
        .form-container {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 1rem;
            padding: 2rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            color: white;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 0.5rem;
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #ff2e63;
            box-shadow: 0 0 0 2px rgba(255, 46, 99, 0.2);
            background: rgba(0, 0, 0, 0.4);
        }
        
        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #ff2e63, #764ba2);
            color: white;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            width: 100%;
            justify-content: center;
            font-size: 1rem;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(255, 46, 99, 0.4);
        }
        
        select option {
            background: #2a2a2a;
            color: white;
        }
        
        .grid {
            display: grid;
            gap: 1.5rem;
        }
        
        .grid-cols-2 {
            grid-template-columns: repeat(2, 1fr);
        }
        
        @media (max-width: 768px) {
            .grid-cols-2 {
                grid-template-columns: 1fr;
            }
        }
        
        .back-btn {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .back-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <div style="background: rgba(0, 0, 0, 0.3); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255, 255, 255, 0.1); padding: 1rem 2rem;">
        <div style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center;">
            <a href="{{ route('admin.dashboard') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>Back to Dashboard
            </a>
            <div style="color: white; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-user-shield"></i>Admin Panel
            </div>
        </div>
    </div>

    <div style="max-width: 800px; margin: 2rem auto; padding: 0 1rem;">
        <!-- Success/Error Messages -->
        @if(session('success'))
        <div style="background: rgba(34, 197, 94, 0.2); border: 1px solid rgba(34, 197, 94, 0.5); color: white; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i>{{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div style="background: rgba(239, 68, 68, 0.2); border: 1px solid rgba(239, 68, 68, 0.5); color: white; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            @foreach($errors->all() as $error)
                <div><i class="fas fa-exclamation-circle" style="margin-right: 0.5rem;"></i>{{ $error }}</div>
            @endforeach
        </div>
        @endif

        <!-- Create Event Form -->
        <div class="form-container">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h1 style="color: white; font-size: 2rem; font-weight: bold; margin-bottom: 0.5rem;">Create New Event</h1>
                <p style="color: rgba(255, 255, 255, 0.7);">Add a new event to the system</p>
            </div>

            <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-2">
                    <!-- Event Name -->
                    <div class="form-group">
                        <label for="name" class="form-label">
                            <i class="fas fa-tag" style="margin-right: 0.5rem;"></i>Event Name
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               class="form-input" 
                               placeholder="Enter event name"
                               required>
                    </div>

                    <!-- Date -->
                    <div class="form-group">
                        <label for="date" class="form-label">
                            <i class="fas fa-calendar" style="margin-right: 0.5rem;"></i>Event Date
                        </label>
                        <input type="datetime-local" 
                               id="date" 
                               name="date" 
                               value="{{ old('date') }}"
                               class="form-input" 
                               required>
                    </div>

                    <!-- Location -->
                    <div class="form-group">
                        <label for="location" class="form-label">
                            <i class="fas fa-map-marker-alt" style="margin-right: 0.5rem;"></i>Location
                        </label>
                        <input type="text" 
                               id="location" 
                               name="location" 
                               value="{{ old('location') }}"
                               class="form-input" 
                               placeholder="Enter event location"
                               required>
                    </div>

                    <!-- Till Number -->
                    <div class="form-group">
                        <label for="till_number" class="form-label">
                            <i class="fas fa-credit-card" style="margin-right: 0.5rem;"></i>Till Number (Optional)
                        </label>
                        <input type="text" 
                               id="till_number" 
                               name="till_number" 
                               value="{{ old('till_number') }}"
                               class="form-input" 
                               placeholder="M-Pesa Till Number">
                    </div>

                    <!-- Manager -->
                    <div class="form-group">
                        <label for="manager_id" class="form-label">
                            <i class="fas fa-user-tie" style="margin-right: 0.5rem;"></i>Assign Manager
                        </label>
                        <select id="manager_id" name="manager_id" class="form-input" required>
                            <option value="">Select a manager</option>
                            @foreach($managers as $manager)
                                <option value="{{ $manager->id }}" {{ old('manager_id') == $manager->id ? 'selected' : '' }}>
                                    {{ $manager->name }} ({{ $manager->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Event Status -->
                    <div class="form-group">
                        <label for="status" class="form-label">
                            <i class="fas fa-toggle-on" style="margin-right: 0.5rem;"></i>Event Status
                        </label>
                        <select id="status" name="status" class="form-input" required>
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', 'published') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <!-- Event Poster -->
                    <div class="form-group">
                        <label for="poster" class="form-label">
                            <i class="fas fa-image" style="margin-right: 0.5rem;"></i>Event Poster (Optional)
                        </label>
                        <input type="file" 
                               id="poster" 
                               name="poster" 
                               class="form-input"
                               accept="image/*">
                    </div>
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description" class="form-label">
                        <i class="fas fa-align-left" style="margin-right: 0.5rem;"></i>Event Description (Optional)
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="4"
                              class="form-input" 
                              placeholder="Describe the event...">{{ old('description') }}</textarea>
                </div>

                <!-- Ticket Packages Section -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-tickets-alt" style="margin-right: 0.5rem;"></i>Ticket Packages
                    </label>
                    
                    <div id="packages-container">
                        <div class="package-item" style="background: rgba(0, 0, 0, 0.2); border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 0.5rem; padding: 1.5rem; margin-bottom: 1rem;">
                            <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 1rem;">
                                <h4 style="color: white; margin: 0;">Package 1</h4>
                                <button type="button" class="remove-package" style="background: rgba(239, 68, 68, 0.3); color: white; border: 1px solid rgba(239, 68, 68, 0.5); border-radius: 0.25rem; padding: 0.25rem 0.5rem; cursor: pointer; display: none;">Remove</button>
                            </div>
                            
                            <div class="grid grid-cols-2" style="gap: 1rem;">
                                <div class="form-group" style="margin-bottom: 1rem;">
                                    <label class="form-label" style="font-size: 0.8rem;">Package Name</label>
                                    <input type="text" name="packages[0][name]" class="form-input" placeholder="e.g., VIP, Regular, Student" required>
                                </div>
                                
                                <div class="form-group" style="margin-bottom: 1rem;">
                                    <label class="form-label" style="font-size: 0.8rem;">Price (KSH)</label>
                                    <input type="number" name="packages[0][price]" class="form-input" placeholder="0" min="0" step="1" required>
                                </div>
                                
                                <div class="form-group" style="margin-bottom: 1rem;">
                                    <label class="form-label" style="font-size: 0.8rem;">Group Size</label>
                                    <input type="number" name="packages[0][group_size]" class="form-input" placeholder="1" min="1" value="1" required>
                                </div>
                                
                                <div class="form-group" style="margin-bottom: 1rem;">
                                    <label class="form-label" style="font-size: 0.8rem;">Available Tickets (Optional)</label>
                                    <input type="number" name="packages[0][available_tickets]" class="form-input" placeholder="Unlimited" min="1">
                                </div>
                                
                                <div class="form-group" style="margin-bottom: 1rem;">
                                    <label class="form-label" style="font-size: 0.8rem;">Icon (Emoji)</label>
                                    <input type="text" name="packages[0][icon]" class="form-input" placeholder="🎫" maxlength="10">
                                </div>
                            </div>
                            
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label" style="font-size: 0.8rem;">Package Description (Optional)</label>
                                <textarea name="packages[0][description]" rows="2" class="form-input" placeholder="Describe what this package includes..."></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <button type="button" id="add-package" style="background: rgba(34, 197, 94, 0.3); color: white; border: 1px solid rgba(34, 197, 94, 0.5); border-radius: 0.5rem; padding: 0.75rem 1rem; cursor: pointer; margin-top: 1rem;">
                        <i class="fas fa-plus" style="margin-right: 0.5rem;"></i>Add Another Package
                    </button>
                </div>

                <!-- Submit Button -->
                <div style="margin-top: 2rem;">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-plus" style="margin-right: 0.5rem;"></i>Create Event
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let packageCount = 1;

        document.getElementById('add-package').addEventListener('click', function() {
            const container = document.getElementById('packages-container');
            const packageItem = document.createElement('div');
            packageItem.className = 'package-item';
            packageItem.style.cssText = 'background: rgba(0, 0, 0, 0.2); border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 0.5rem; padding: 1.5rem; margin-bottom: 1rem;';
            
            packageItem.innerHTML = `
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h4 style="color: white; margin: 0;">Package ${packageCount + 1}</h4>
                    <button type="button" class="remove-package" style="background: rgba(239, 68, 68, 0.3); color: white; border: 1px solid rgba(239, 68, 68, 0.5); border-radius: 0.25rem; padding: 0.25rem 0.5rem; cursor: pointer;">Remove</button>
                </div>
                
                <div class="grid grid-cols-2" style="gap: 1rem;">
                    <div class="form-group" style="margin-bottom: 1rem;">
                        <label class="form-label" style="font-size: 0.8rem;">Package Name</label>
                        <input type="text" name="packages[${packageCount}][name]" class="form-input" placeholder="e.g., VIP, Regular, Student" required>
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 1rem;">
                        <label class="form-label" style="font-size: 0.8rem;">Price (KSH)</label>
                        <input type="number" name="packages[${packageCount}][price]" class="form-input" placeholder="0" min="0" step="1" required>
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 1rem;">
                        <label class="form-label" style="font-size: 0.8rem;">Group Size</label>
                        <input type="number" name="packages[${packageCount}][group_size]" class="form-input" placeholder="1" min="1" value="1" required>
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 1rem;">
                        <label class="form-label" style="font-size: 0.8rem;">Available Tickets (Optional)</label>
                        <input type="number" name="packages[${packageCount}][available_tickets]" class="form-input" placeholder="Unlimited" min="1">
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 1rem;">
                        <label class="form-label" style="font-size: 0.8rem;">Icon (Emoji)</label>
                        <input type="text" name="packages[${packageCount}][icon]" class="form-input" placeholder="🎫" maxlength="10">
                    </div>
                </div>
                
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" style="font-size: 0.8rem;">Package Description (Optional)</label>
                    <textarea name="packages[${packageCount}][description]" rows="2" class="form-input" placeholder="Describe what this package includes..."></textarea>
                </div>
            `;
            
            container.appendChild(packageItem);
            packageCount++;
            
            // Show remove buttons when there are multiple packages
            updateRemoveButtons();
        });

        // Handle removing packages
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-package')) {
                e.target.closest('.package-item').remove();
                updateRemoveButtons();
            }
        });

        function updateRemoveButtons() {
            const packages = document.querySelectorAll('.package-item');
            const removeButtons = document.querySelectorAll('.remove-package');
            
            removeButtons.forEach(button => {
                button.style.display = packages.length > 1 ? 'block' : 'none';
            });
        }

        // Initialize remove button visibility
        updateRemoveButtons();
    </script>
</body>
</html>
