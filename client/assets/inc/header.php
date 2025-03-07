<?php 


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <!--bootstrap-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.1.6/datatables.min.css" rel="stylesheet"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <!--style-->
    <link rel="stylesheet" href="assets/css/user-style.css">
    <!--icon logo-->
    <link rel="shortcut icon" href="assets/image/logo.jpg" type="image/x-icon">
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>.calendar-container {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.calendar-header {
    display: flex;
    justify-content: space-between;
    width: 100%;
    margin-bottom: 10px;
}

.calendar-days {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    grid-gap: 5px;
    width: 100%;
}

.calendar-day {
    background-color: #f9f9f9;
    padding: 10px;
    text-align: center;
    border-radius: 5px;
    cursor: pointer;
    min-height: 100px;
    position: relative;
}

.calendar-day:hover {
    background-color: #e0e0e0;
}

.calendar-day ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
    font-size: 12px;
}
</style>
    <title>Client</title>
</head>
<body>
    