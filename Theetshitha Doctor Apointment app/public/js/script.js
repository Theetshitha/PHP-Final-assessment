// Submit form using AJAX
document.getElementById('appointmentForm').addEventListener('submit', function(event) {
    event.preventDefault();

    // Validate form data (simple validation for demonstration)
    var patientName = document.getElementById('patientName').value.trim();
    var patientAge = document.getElementById('patientAge').value.trim();
    var reason = document.getElementById('reason').value.trim();
    var contactNo = document.getElementById('contactNo').value.trim();
    var dateTime = document.getElementById('dateTime').value.trim();

    if (patientName === '' || patientAge === '' || reason === '' || contactNo === '' || dateTime === '') {
        alert('Please fill in all fields.');
        return;
    }

    // Validate date and time (ensure future date)
    var now = new Date();
    var selectedDateTime = new Date(dateTime);
    if (selectedDateTime <= now) {
        alert('Please select a future date and time.');
        return;
    }

    // Serialize form data
    var formData = new FormData();
    formData.append('patientName', patientName);
    formData.append('patientAge', patientAge);
    formData.append('reason', reason);
    formData.append('contactNo', contactNo);
    formData.append('dateTime', dateTime);

    // Send AJAX request
    fetch('../../controllers/submit_form.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Appointment booked successfully!');
            // Optionally redirect or update UI
            window.location.href = '../../views/appointments/index.php'; // Redirect to appointments list page
        } else {
            alert(data.message); // Show error message from server
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error booking appointment. Please try again.');
    });
});

/// Delete appointment using AJAX
function deleteAppointment(id) {
    if (confirm("Are you sure you want to delete this appointment?")) {
        // Send AJAX request
        fetch('../../views/appointments/delete.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: id })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                // Optionally update UI (remove appointment from list)
                location.reload(); // Refresh the page to update the list
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting appointment.');
        });
    }
}
