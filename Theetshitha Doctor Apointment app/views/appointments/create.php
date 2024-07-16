<?php include '../layout/header.php'; ?>

<div class="container mx-auto mt-8">
    <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4 text-center">Book Appointment</h2>
        <form id="appointmentForm" class="space-y-4">
            <div>
                <label for="patientName" class="block text-sm font-medium text-gray-700">Patient Name</label>
                <input type="text" id="patientName" name="patientName" placeholder="Enter patient's name"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div>
                <label for="patientAge" class="block text-sm font-medium text-gray-700">Patient Age</label>
                <input type="number" id="patientAge" name="patientAge" placeholder="Enter patient's age"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div>
                <label for="reason" class="block text-sm font-medium text-gray-700">Reason for Consultation</label>
                <textarea id="reason" name="reason" rows="3" placeholder="Enter reason for consultation"
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"></textarea>
            </div>
            <div>
                <label for="contactNo" class="block text-sm font-medium text-gray-700">Contact Number</label>
                <input type="text" id="contactNo" name="contactNo" placeholder="Enter contact number"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div>
                <label for="dateTime" class="block text-sm font-medium text-gray-700">Date & Time</label>
                <input type="datetime-local" id="dateTime" name="dateTime"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div class="text-center">
                <button type="submit" class="bg-blue-500 text-white py-2 px-6 rounded-lg inline-block hover:bg-blue-600">Submit</button>
            </div>
        </form>
    </div>
</div>

<div class="container mx-auto mt-8">
    <a href="./index.php">View Patient Appointment Slot List</a>
</div>
<script src="../../public/js/script.js"></script>

<?php include '../layout/footer.php';?>
