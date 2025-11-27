#!/bin/bash

# Quick Fix Script for Tiko Iko On
# This will fix the most critical issues immediately

echo "🚀 Quick Fix for Tiko Iko On"
echo "============================"

# 1. Update branding in key files
echo "Updating branding..."

# Manager Dashboard
sed -i 's/LoveLab/Tiko Iko On/g' resources/views/manager/dashboard.blade.php 2>/dev/null

# Layout
sed -i 's/LoveLab/Tiko Iko On/g' resources/views/layout.blade.php 2>/dev/null

# Payment
sed -i 's/LoveLab/Tiko Iko On/g' resources/views/payment.blade.php 2>/dev/null

# Admin pages
sed -i 's/LoveLab/Tiko Iko On/g' resources/views/admin/dashboard.blade.php 2>/dev/null
sed -i 's/LoveLab/Tiko Iko On/g' resources/views/admin/events/index.blade.php 2>/dev/null

echo "✅ Branding updated"

# 2. Clear caches
echo "Clearing caches..."
php artisan config:clear
php artisan route:clear  
php artisan view:clear
php artisan cache:clear 2>/dev/null

echo "✅ Caches cleared"

# 3. Check migration status
echo ""
echo "📊 Current Migration Status:"
php artisan migrate:status

echo ""
echo "⚠️  IMPORTANT: Fix the empty migrations before running 'php artisan migrate'"
echo ""
echo "Files to fix:"
echo "- database/migrations/2025_09_13_175434_add_event_id_to_bookings_table.php"
echo "- database/migrations/2025_09_13_200350_add_till_number_to_events_table.php" 
echo "- database/migrations/2025_09_13_204940_add_poster_to_events_table.php"
echo "- database/migrations/2025_09_18_213818_add_event_and_package_to_bookings_table.php"
echo "- database/migrations/2025_09_18_213819_add_status_to_events_table.php"
echo "- database/migrations/2025_09_18_213819_update_packages_table.php"
echo ""
echo "Use the code from the 'Fixed Migration Files' artifact"
echo ""
echo "✨ Quick fixes applied! Now fix the migrations and run 'php artisan migrate'"