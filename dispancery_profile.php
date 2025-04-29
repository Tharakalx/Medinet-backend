<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dispensary Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 20px;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 200vh;
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
            padding top: 20px;
            
        }

        .profile-box {
            width: 100%;
            max-width: 800px;
            background-color: #ffffff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            margin-top: 100px;
        }

        .title {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .detail-item strong {
            color: #333;
        }

        .detail-item p {
            color: #555;
        }

        .form-input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        button {
            width: 150px;
            height: 40px;
            background-color: green;
            color: white;
            text-align: center;
            line-height: 40px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: darkgreen;
        }
        .main_countainer{
           
            display: flex;
            flex-direction: column;
            
        }
    </style>
</head>
<body>
    <div class ="main_Countainer">
    <div class="container">
        <div class="profile-box">
            <h2 class="title">Dispensary Details</h2>

            <!-- Section to display the fetched details -->
            <div id="detailsSection"></div>
        </div>
    </div>

    <script>
        // Function to get query parameter from URL
        function getQueryParam(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        // Get the dispensary_id from URL (e.g., 
        const dispensary_id = getQueryParam('dispensary_id');

        // If dispensary_id exists, fetch the data from backend
        if (dispensary_id) {
            fetch(`http://localhost/Medinet-backend/dispancery_profile.php?id=${dispensary_id}`)
                .then(response => response.json())  // Parse the JSON response
                .then(data => {
                    if (data.message) {
                        // Display error message if no dispensary found
                        document.getElementById('detailsSection').innerHTML = `<p>${data.message}</p>`;
                    } else {
                        // Display the dispensary details
                        document.getElementById('detailsSection').innerHTML = `
                            <div class="detail-item">
                                <strong>Dispensary ID:</strong>
                                <p>${data.id}</p>
                            </div>
                            <div class="detail-item">
                                <strong>Address:</strong>
                                <p>${data.address}</p>
                            </div>
                            <div class="detail-item">
                                <strong>City:</strong>
                                <p>${data.city}</p>
                            </div>
                            <div class="detail-item">
                                <strong>License Number:</strong>
                                <p>${data.license_number}</p>
                            </div>
                            <div class="detail-item">
                                <strong>Contact Number:</strong>
                                <p>${data.contact_number}</p>
                            </div>
                            <div class="detail-item">
                                <strong>Doctor ID:</strong>
                                <p>${data.doctor_id}</p>
                            </div>
                            <div class="detail-item">
                                <strong>Opening Time:</strong>
                                <p>${data.open_time}</p>
                            </div>
                            <div class="detail-item">
                                <strong>Closing Time:</strong>
                                <p>${data.close_time}</p>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error fetching dispensary details:', error);
                    document.getElementById('detailsSection').innerHTML = '<p>Error fetching data</p>';
                });
        } else {
            // If no dispensary_id is provided, display a message
            document.getElementById('detailsSection').innerHTML = '<p>No dispensary ID provided in URL.</p>';
        }
    </script>

<div>
    <div class="container">
        <div class="profile-box">
            <h2 class="title">Add Appointment</h2>

            <!-- Appointment Form -->
            <form id="appointmentForm">
                <input type="hidden" id="dispensary_id" value="1"> <!-- Hidden field for dispensary_id -->

                <div class="detail-item">
                    <strong>Doctor ID:</strong>
                    <input type="text" id="doctor_id" class="form-input" placeholder="Enter Doctor ID" required>
                </div>
                <div class="detail-item">
                    <strong>Patient ID:</strong>
                    <input type="text" id="patient_id" class="form-input" placeholder="Enter Patient ID" required>
                </div>
                <div class="detail-item">
                    <strong>Patient Number:</strong>
                    <input type="number" id="patient_number" class="form-input" placeholder="Enter Patient Number" required>
                </div>
                <div class="detail-item">
                    <strong>Date:</strong>
                    <input type="date" id="appointment_date" class="form-input" required>
                </div>
                <div class="detail-item">
                    <strong>Time Slot:</strong>
                    <input type="time" id="time_slot" class="form-input" required>
                </div>
                <div class="detail-item">
                    <strong>Status:</strong>
                    <select id="status" class="form-input" required>
                        <option value="Pending">Pending</option>
                        <option value="Completed">Completed</option>
                        <option value="Canceled">Canceled</option>
                    </select>
                </div>

                <button type="submit">Add Appointment</button>
            </form>
        </div>
    </div>

    <script>
        // Handle form submission and send appointment details to the backend
        document.getElementById('appointmentForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form from submitting normally

            // Collect form data
            const doctor_id = document.getElementById('doctor_id').value;
            const patient_id = document.getElementById('patient_id').value;
            const patient_number = document.getElementById('patient_number').value;
            const dispensary_id = document.getElementById('dispensary_id').value;
            const date = document.getElementById('appointment_date').value;
            const time_slot = document.getElementById('time_slot').value;
            const status = document.getElementById('status').value;

            // Send the appointment data to the backend
            fetch('http://localhost/Medinet-backend/add_appointment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    doctor_id,
                    patient_id,
                    patient_number,
                    dispensary_id,
                    date,
                    time_slot,
                    status
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Appointment added successfully!");
                    // Optionally reset the form or show a success message
                    document.getElementById('appointmentForm').reset();
                } else {
                    alert("Error adding appointment.");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Failed to add appointment.");
            });
        });
    </script>
    </div>
    </div>
</body>
</html>
