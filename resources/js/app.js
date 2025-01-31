import './bootstrap';
let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

document.addEventListener('DOMContentLoaded', function() {
    // Handle pricing category button clicks
    document.querySelectorAll('.pricing-category').forEach(button => {
        button.addEventListener('click', function() {
            const planType = this.closest('.plan').querySelector('h3').textContent;
            const categoryText = this.querySelector('h4').textContent;
            const priceText = this.querySelector('p').textContent; // Get the price text
            
            let groupSize;
            if (categoryText.toLowerCase().includes('single')) {
                groupSize = 1;
            } else if (categoryText.toLowerCase().includes('couple')) {
                groupSize = 2;
            } else {
                const match = categoryText.match(/\d+/);
                groupSize = match ? parseInt(match[0]) : 1;
            }
            
            showBookingForm(planType, groupSize, priceText, );
        });
    });
});

function showBookingForm(planType, groupSize, priceText) {
    let formHTML = `
    <div class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Booking for ${planType} (${groupSize} ${groupSize > 1 ? 'people' : 'person'})</h3>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <div class="price-info" style="text-align: center; margin-bottom: 20px; padding: 10px; background-color: #f8f8f8; border-radius: 4px;">
                    <strong>Package Price:</strong> ${priceText}
                </div>
                <form id="bookingForm" method="POST" action="/submit-booking">
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <input type="hidden" name="plan_type" value="${planType}">
                    <input type="hidden" name="group_size" value="${groupSize}">
                    <input type="hidden" name="price" value="${priceText}">
                    <div class="form-group">
                        <label>Team Lead Details:</label>
                        <input type="email" name="team_lead_email" placeholder="Team Lead Email" required>
                        <input type="text" name="team_lead_name" placeholder="Team Lead Name" required>
                        <input type="tel" name="team_lead_phone" placeholder="Team Lead Phone" required>
                    </div>`;

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
    </div>`;

    // Insert the modal HTML into the DOM
    document.body.insertAdjacentHTML('beforeend', formHTML);

    // Add event listener to close the modal
    document.querySelector('.close').addEventListener('click', () => {
        document.querySelector('.modal').remove();
    });
}
// Add form validation for M-Pesa code
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        const mpesaCode = this.querySelector('[name="mpesa_confirmation_code"]');
        if (mpesaCode && !/^[A-Z0-9]{10}$/.test(mpesaCode.value)) {
            e.preventDefault();
            alert('Please enter a valid 10-character M-Pesa confirmation code');
            mpesaCode.focus();
        }
    });
});