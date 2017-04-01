<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2
    }

    th {
        background-color: #3F51B5;
        color: white;
    }

    input[type=text] {
        background-color: #3CBC8D;
        color: white;
    }

    input[type=submit] {
        background: #3498db;
        background-image: -webkit-linear-gradient(top, #3498db, #2980b9);
        background-image: -moz-linear-gradient(top, #3498db, #2980b9);
        background-image: -ms-linear-gradient(top, #3498db, #2980b9);
        background-image: -o-linear-gradient(top, #3498db, #2980b9);
        background-image: linear-gradient(to bottom, #3498db, #2980b9);
        -webkit-border-radius: 28;
        -moz-border-radius: 28;
        border-radius: 28px;
        font-family: Arial;
        color: #ffffff;
        font-size: 20px;
        padding: 10px 20px 10px 20px;
        text-decoration: none;
    }

    input[type=submit]:hover {
        background: #3cb0fd;
        background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);
        background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);
        background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);
        background-image: -o-linear-gradient(top, #3cb0fd, #3498db);
        background-image: linear-gradient(to bottom, #3cb0fd, #3498db);
        text-decoration: none;
    }
</style>


<html>
<body>
<?php
$result = mysqli_query($conn, "SELECT ID, name, email FROM students");

echo "<table>"; // start a table tag in the HTML
echo "
<tr><th>StudentID</th><th>Name</th><th>Email</th></tr>";

while ($row = mysqli_fetch_array($result)) {   //Creates a loop to loop through results
    echo "<tr><td>" . $row['ID'] . "</td><td>".$row['name'] . "</td><td>" . $row['email'] . "</td></tr>";  //$row['index'] the index here is a field name
}

echo "</table>"; //Close the table in HTML


?>


</body>


</html>

