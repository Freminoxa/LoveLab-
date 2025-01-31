import './bootstrap';
let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

document.addEventListener('DOMContentLoaded', function() {
    // Handle pricing category button clicks
    document.querySelectorAll('.pricing-category').forEach(button => {
        button.addEventListener('click', function() {
            const planType = this.closest('.plan').querySelector('h3').textContent; // Get plan name (IP, VIP, VVIP)
            const groupSize = parseInt(this.querySelector('h4').textContent.match(/\d+/)[0]); // Extract group size number

            // Call the function to show the booking form in a modal
            showBookingForm(planType, groupSize);
        });
    });
});

// Function to show the booking form in a modal
function showBookingForm(planType, groupSize) {
    // Create the modal HTML content
    let formHTML = `
    <div class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Booking for ${planType} (${groupSize} ${groupSize > 1 ? 'people' : 'person'})</h3>
            <form id="bookingForm" method="POST" action="/submit-booking">
                <input type="hidden" name="_token" value="${csrfToken}">
                <input type="hidden" name="plan_type" value="${planType}">
                <input type="hidden" name="group_size" value="${groupSize}">
                
                <div class="form-group">
                    <label>Team Lead Details:</label>
                    <input type="email" name="team_lead_email" placeholder="Team Lead Email" required>
                    <input type="text" name="team_lead_name" placeholder="Team Lead Name" required>
                    <input type="tel" name="team_lead_phone" placeholder="Team Lead Phone" required>
                </div>`;

    // Add additional members fields if group size > 1
    if (groupSize > 1) {
        formHTML += `<div class="members-container">`;
        for (let i = 1; i < groupSize; i++) {
            formHTML += `
                <div class="form-group member">
                    <label>Member ${i} Details:</label>
                    <input type="text" name="members[${i}][name]" placeholder="Member ${i} Name" required>
                    <input type="email" name="members[${i}][email]" placeholder="Member ${i} Email" required>
                </div>`;
        }
        formHTML += `</div>`;
    }

    formHTML += `
                    <button type="submit">Complete Booking</button>
                </form>
            </div>
        </div>
    `;

    // Insert the modal HTML into the DOM
    document.body.insertAdjacentHTML('beforeend', formHTML);

    // Add event listener to close the modal
    document.querySelector('.close').addEventListener('click', () => {
        document.querySelector('.modal').remove(); // Remove the modal from the DOM
    });
}
