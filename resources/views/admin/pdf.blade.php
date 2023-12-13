<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order PDF</title>
</head>
<body>

    <h1>Order Details</h1>

    <style>
        table {
        width: 60%; /* Set the table width to 50% of the parent container */
        margin: 0 auto; /* Center the table horizontally */
        border-collapse: collapse; /* Collapse the border spacing */
    }

    td {
        text-align: center; /* Center the content within each table cell */
        padding: 4px; /* Adjusted padding for better appearance */
        border: 1px solid #000; /* Add a border to the cells for better visibility */
    }
    </style>

    <div style="text-align: center;">
    <table border="1">
        <tr>
            <td>Customer Name:</td>
            <td><h3>{{$order->name}}</h3></td>
        </tr>
        <tr>
            <td>Customer Email:</td>
            <td><h3>{{$order->email}}</h3></td>
        </tr>
        <tr>
            <td>Customer Phone:</td>
            <td><h3>{{$order->phone}}</h3></td>
        </tr>
        <tr>
            <td>Customer Address:</td>
            <td><h3>{{$order->address}}</h3></td>
        </tr>
        <tr>
            <td>Customer ID:</td>
            <td><h3>{{$order->user_id}}</h3></td>
        </tr>
        <tr>
            <td>Product Name:</td>
            <td><h3>{{$order->product_title}}</h3></td>
        </tr>
        <tr>
            <td>Product Price:</td>
            <td><h3>{{$order->price}}</h3></td>
        </tr>
        <tr>
            <td>Product Quantity:</td>
            <td><h3>{{$order->quantity}}</h3></td>
        </tr>
        <tr>
            <td>Product Status:</td>
            <td><h3>{{$order->payment_status}}</h3></td>
        </tr>
        <tr>
            <td>Product ID:</td>
            <td><h3>{{$order->product_id}}</h3></td>
        </tr>
    </table>



    <br><br>
    <img height="159" width="159" src="product/{{$order->image}}" alt="">
    </div>
</body>

</html>
