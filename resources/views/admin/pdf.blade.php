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
    <img height="250" width="450" src="product/{{$order->image}}" alt="">
</body>

</html>
