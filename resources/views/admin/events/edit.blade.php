<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event - Admin Dashboard</title>
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
        .form-group { margin-bottom: 1rem; }
        .form-label { display: block; color: white; font-weight: 600; margin-bottom: 0.4rem; font-size: 0.9rem; }
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 0.5rem;
            color: white;
        }
        .btn-primary {
            background: linear-gradient(135deg, #ff2e63, #764ba2);
            color: white;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 0.5rem;
            width: 100%;
            font-weight: 600;
            cursor: pointer;
        }
        .back-btn {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
    </style>
</head>
<body>
    <div style="background: rgba(0, 0, 0, 0.3); border-bottom: 1px solid rgba(255, 255, 255, 0.1); padding: 1rem 2rem;">
        <div style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center;">
            <a href="{{ route('admin.events.index') }}" class="back-btn"><i class="fas fa-arrow-left"></i>Back to Events</a>
            <div style="color: white;"><i class="fas fa-user-shield"></i> Admin Panel</div>
        </div>
    </div>

    <div style="max-width: 900px; margin: 2rem auto; padding: 0 1rem;">
        @if($errors->any())
            <div style="background: rgba(239, 68, 68, 0.2); border: 1px solid rgba(239, 68, 68, 0.5); color: white; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="form-container">
            <h1 style="color: white; font-size: 1.8rem; margin-bottom: 1.5rem;">Edit Event</h1>

            <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Event Name</label>
                        <input class="form-input" type="text" name="name" value="{{ old('name', $event->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Date</label>
                        <input class="form-input" type="datetime-local" name="date" value="{{ old('date', $event->date ? $event->date->format('Y-m-d\TH:i') : '') }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Location</label>
                        <input class="form-input" type="text" name="location" value="{{ old('location', $event->location) }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Till Number (Paid Events)</label>
                        <input class="form-input" type="text" name="till_number" value="{{ old('till_number', $event->till_number) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Manager</label>
                        <select class="form-input" name="manager_id">
                            <option value="">Select manager</option>
                            @foreach($managers as $manager)
                                <option value="{{ $manager->id }}" {{ (string) old('manager_id', $event->manager_id) === (string) $manager->id ? 'selected' : '' }}>
                                    {{ $manager->name }} ({{ $manager->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select class="form-input" name="status" required>
                            @foreach(['draft', 'published', 'completed', 'cancelled'] as $status)
                                <option value="{{ $status }}" {{ old('status', $event->status) === $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group" style="display: flex; align-items: center; gap: 0.75rem;">
                    <input type="checkbox" id="is_free_entry" name="is_free_entry" value="1" {{ old('is_free_entry', $event->is_free_entry) ? 'checked' : '' }}>
                    <label for="is_free_entry" class="form-label" style="margin: 0;">Free Entry Event (No payment required)</label>
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea class="form-input" name="description" rows="4">{{ old('description', $event->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Poster</label>
                    <input class="form-input" type="file" name="poster" accept="image/*">
                    @if($event->poster)
                        <div style="margin-top: 0.75rem;">
                            <img src="{{ asset('storage/' . $event->poster) }}" alt="Poster" style="max-width: 180px; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.2);">
                        </div>
                    @endif
                </div>

                <div class="form-group" id="packages-section">
                    <label class="form-label">Ticket Packages</label>
                    <div id="packages-container">
                        @php $oldPackages = old('packages', $event->packages->map(fn($p) => ['id' => $p->id, 'name' => $p->name, 'price' => $p->price, 'group_size' => $p->group_size, 'available_tickets' => $p->available_tickets, 'description' => $p->description, 'icon' => $p->icon])->toArray()); @endphp
                        @foreach($oldPackages as $i => $package)
                            <div class="package-item" style="border: 1px solid rgba(255,255,255,0.2); border-radius: 0.5rem; padding: 1rem; margin-bottom: 0.75rem;">
                                <input type="hidden" name="packages[{{ $i }}][id]" value="{{ $package['id'] ?? '' }}">
                                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.75rem;">
                                    <input class="form-input" name="packages[{{ $i }}][name]" value="{{ $package['name'] ?? '' }}" placeholder="Package name" required>
                                    <input class="form-input" name="packages[{{ $i }}][price]" value="{{ $package['price'] ?? 0 }}" type="number" min="0" step="1" placeholder="Price" required>
                                    <input class="form-input" name="packages[{{ $i }}][group_size]" value="{{ $package['group_size'] ?? 1 }}" type="number" min="1" placeholder="Group size" required>
                                    <input class="form-input" name="packages[{{ $i }}][available_tickets]" value="{{ $package['available_tickets'] ?? '' }}" type="number" min="1" placeholder="Available tickets (optional)">
                                    <input class="form-input" name="packages[{{ $i }}][icon]" value="{{ $package['icon'] ?? '' }}" placeholder="Icon">
                                    <textarea class="form-input" name="packages[{{ $i }}][description]" rows="2" placeholder="Description">{{ $package['description'] ?? '' }}</textarea>
                                </div>
                                <button type="button" class="remove-package" style="margin-top: 0.5rem; background: rgba(239,68,68,0.3); border: 1px solid rgba(239,68,68,0.5); color: #fff; border-radius: 0.25rem; padding: 0.35rem 0.75rem;">Remove</button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" id="add-package" style="background: rgba(34,197,94,0.3); border: 1px solid rgba(34,197,94,0.5); color: #fff; border-radius: 0.5rem; padding: 0.6rem 1rem;">Add Package</button>
                </div>

                <div style="margin-top: 1.5rem;">
                    <button type="submit" class="btn-primary">Update Event</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let packageIndex = document.querySelectorAll('.package-item').length;
        const packagesContainer = document.getElementById('packages-container');

        document.getElementById('add-package').addEventListener('click', function () {
            const wrapper = document.createElement('div');
            wrapper.className = 'package-item';
            wrapper.style.cssText = 'border: 1px solid rgba(255,255,255,0.2); border-radius: 0.5rem; padding: 1rem; margin-bottom: 0.75rem;';
            wrapper.innerHTML = `
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.75rem;">
                    <input class="form-input" name="packages[${packageIndex}][name]" placeholder="Package name" required>
                    <input class="form-input" name="packages[${packageIndex}][price]" type="number" min="0" step="1" placeholder="Price" required>
                    <input class="form-input" name="packages[${packageIndex}][group_size]" type="number" min="1" value="1" placeholder="Group size" required>
                    <input class="form-input" name="packages[${packageIndex}][available_tickets]" type="number" min="1" placeholder="Available tickets (optional)">
                    <input class="form-input" name="packages[${packageIndex}][icon]" placeholder="Icon">
                    <textarea class="form-input" name="packages[${packageIndex}][description]" rows="2" placeholder="Description"></textarea>
                </div>
                <button type="button" class="remove-package" style="margin-top: 0.5rem; background: rgba(239,68,68,0.3); border: 1px solid rgba(239,68,68,0.5); color: #fff; border-radius: 0.25rem; padding: 0.35rem 0.75rem;">Remove</button>
            `;
            packagesContainer.appendChild(wrapper);
            packageIndex++;
            updateRemoveButtons();
        });

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-package')) {
                e.target.closest('.package-item').remove();
                updateRemoveButtons();
            }
        });

        function updateRemoveButtons() {
            const removeButtons = document.querySelectorAll('.remove-package');
            const count = document.querySelectorAll('.package-item').length;
            removeButtons.forEach(btn => {
                btn.style.display = count > 1 ? 'inline-block' : 'none';
            });
        }

        function toggleFreeEntryMode() {
            const freeEntry = document.getElementById('is_free_entry').checked;
            const section = document.getElementById('packages-section');
            section.style.display = freeEntry ? 'none' : 'block';
        }

        document.getElementById('is_free_entry').addEventListener('change', toggleFreeEntryMode);
        updateRemoveButtons();
        toggleFreeEntryMode();
    </script>
</body>
</html>
