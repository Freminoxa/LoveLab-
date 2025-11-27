<!-- Booking Modal -->
<div id="bookingModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.9); backdrop-filter: blur(10px); z-index: 9999; align-items: center; justify-content: center; padding: 1rem;">
    <div style="background: linear-gradient(135deg, #1e1e2e, #2d2d44); border-radius: 25px; max-width: 600px; width: 100%; max-height: 90vh; overflow-y: auto; border: 2px solid rgba(255,255,255,0.1); box-shadow: 0 20px 60px rgba(0,0,0,0.5);">
        <div style="position: sticky; top: 0; background: linear-gradient(135deg, #ff2e63, #764ba2); padding: 1.5rem; display: flex; justify-content: space-between; align-items: center; z-index: 10;">
            <h3 style="color: white; font-size: 1.8rem; font-weight: bold; margin: 0;">🎫 Book Your Ticket</h3>
            <button onclick="closeBookingModal()" style="background: none; border: none; color: white; font-size: 2rem; cursor: pointer; line-height: 1;">&times;</button>
        </div>
        
        <form id="bookingForm" method="POST" action="{{ route('submit.booking') }}" style="padding: 2rem;">
            @csrf
            <input type="hidden" name="event_id" id="event_id">
            <input type="hidden" name="package_id" id="package_id">
            <input type="hidden" name="group_size" id="group_size">
            <input type="hidden" name="price" id="price">

            <div style="background: linear-gradient(135deg, rgba(0,255,135,0.1), rgba(96,239,255,0.1)); border-radius: 15px; padding: 1.5rem; margin-bottom: 2rem; border: 1px solid rgba(255,255,255,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center; color: white;">
                    <span id="package_name" style="font-size: 1.2rem; font-weight: 600;"></span>
                    <span id="package_price" style="font-size: 1.8rem; font-weight: bold; background: linear-gradient(135deg, #00ff87, #60efff); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></span>
                </div>
            </div>

            <h4 style="color: #00ff87; font-size: 1.3rem; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-user-circle"></i> Your Information
            </h4>
            
            <div style="margin-bottom: 1rem;">
                <label style="display: block; color: rgba(255,255,255,0.8); margin-bottom: 0.5rem; font-weight: 500;">Mpesa Name</label>
                <input type="text" name="team_lead_name" required 
                       style="width: 100%; padding: 0.75rem; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.2); border-radius: 10px; color: white; font-size: 1rem;"
                       placeholder="Enter your mpesa name">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; color: rgba(255,255,255,0.8); margin-bottom: 0.5rem; font-weight: 500;">Email Address</label>
                <input type="email" name="team_lead_email" required 
                       style="width: 100%; padding: 0.75rem; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.2); border-radius: 10px; color: white; font-size: 1rem;"
                       placeholder="your@email.com">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; color: rgba(255,255,255,0.8); margin-bottom: 0.5rem; font-weight: 500;">Phone Number</label>
                <input type="tel" name="team_lead_phone" required 
                       style="width: 100%; padding: 0.75rem; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.2); border-radius: 10px; color: white; font-size: 1rem;"
                       placeholder="+254 7XX XXX XXX">
            </div>

            <div id="membersSection" style="display: none; margin-bottom: 1.5rem;">
                <h4 style="color: #60efff; font-size: 1.3rem; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-users"></i> Additional Members
                </h4>
                <div id="membersContainer"></div>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="button" onclick="closeBookingModal()" 
                        style="flex: 1; padding: 0.75rem; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 10px; color: white; font-weight: 500; cursor: pointer; transition: all 0.3s ease;"
                        onmouseover="this.style.background='rgba(255,255,255,0.2)'" 
                        onmouseout="this.style.background='rgba(255,255,255,0.1)'">Cancel</button>
                <button type="submit" 
                        style="flex: 2; padding: 0.75rem; background: linear-gradient(135deg, #ff2e63, #00ff87); border: none; border-radius: 10px; color: white; font-weight: bold; cursor: pointer; transition: all 0.3s ease;"
                        onmouseover="this.style.transform='translateY(-2px)'" 
                        onmouseout="this.style.transform='translateY(0)'">
                    <i class="fas fa-credit-card" style="margin-right: 0.5rem;"></i>Book Now
                </button>
            </div>
        </form>
    </div>
</div>
