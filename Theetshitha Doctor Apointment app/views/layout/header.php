<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Appointment System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<style>
    #nav{
        display: flex;
        align-items: center;
        justify-content: space-around;
        gap: 30px;
        height: 70px;
    }
    #nav li{
        list-style: none;
    }
    #nav a{
        text-decoration: none;
        color: white;
    }
</style>
</head>
<body class="bg-gray-100">
    <nav id="nav" class="bg-blue-500 text-white">
           
                <li><a href="../../index.php" class="text-2xl font-bold text-center hover:text-gray-200"> SaveLife Clinic</a></li>
                <li><a href="#" class="hover:text-gray-200">Home</a></li>
                <li><a href="../../views/appointments/index.php" class="hover:text-gray-200">Paitents List</a></li>
                <li><a href="../../views/appointments/create.php" class="hover:text-gray-200">Contact</a></li>
                <li><a href="../../views/appointments/create.php" class="hover:text-gray-200">Book Appointment</a></li>
                <li><a href="#" class="hover:text-gray-200">Login</a></li>
         

    </nav>
</body>
</html>