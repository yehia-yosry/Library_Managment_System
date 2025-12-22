<!DOCTYPE html>
<html>

<head>
    <title>Replenishment Orders</title>
</head>

<body>
    <h1>Replenishment Orders</h1>

    <!-- Display success/error messages -->
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <!-- Display orders -->
    @if(count($orders) > 0)
        <table border="1" cellpadding="10">
            <tr>
                <th>Order ID</th>
                <th>ISBN</th>
                <th>Book Title</th>
                <th>Publisher</th>
                <th>Order Date</th>
                <th>Quantity Ordered</th>
                <th>Current Stock</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->ReplenishmentOrderID }}</td>
                    <td>{{ $order->ISBN }}</td>
                    <td>{{ $order->Title }}</td>
                    <td>{{ $order->PublisherName }}</td>
                    <td>{{ $order->OrderDate }}</td>
                    <td>{{ $order->Quantity }}</td>
                    <td>{{ $order->CurrentStock }}</td>
                    <td>{{ $order->Status }}</td>
                    <td>
                        @if($order->Status == 'Pending')
                            <form method="POST" action="{{ route('admin.orders.confirm', $order->ReplenishmentOrderID) }}"
                                style="display:inline;">
                                @csrf
                                <button type="submit" onclick="return confirm('Confirm this order?')">Confirm</button>
                            </form>
                        @else
                            <span style="color: green;">Confirmed</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    @else
        <p>No orders found.</p>
    @endif

    <br>
    <a href="{{ route('admin.dashboard') }}">Back to Dashboard</a>
</body>

</html>