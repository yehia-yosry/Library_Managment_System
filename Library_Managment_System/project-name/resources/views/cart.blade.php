@extends('layouts.app')

@section('content')
    <h1>Your Cart</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(count($items))
        <form method="post" action="{{ route('cart.update') }}">
            @csrf
            <table class="table">
                <thead><tr><th>Title</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th></th></tr></thead>
                <tbody>
                @foreach($items as $it)
                    <tr>
                        <td>{{ $it['title'] }}</td>
                        <td>${{ number_format($it['price'],2) }}</td>
                        <td><input type="number" name="qty[{{ $it['isbn'] }}]" value="{{ $it['qty'] }}" min="0" class="form-control" style="width:80px"></td>
                        <td>${{ number_format($it['price'] * $it['qty'],2) }}</td>
                        <td><a href="{{ route('cart.remove', $it['isbn']) }}" class="btn btn-danger btn-sm">Remove</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <button class="btn btn-secondary" type="submit">Update cart</button>
                </div>
                <div>
                    <strong>Total: ${{ number_format($total, 2) }}</strong>
                    <form method="post" action="{{ route('cart.checkout') }}" style="display:inline">
                        @csrf
                        <button class="btn btn-success" {{ $total <= 0 ? 'disabled' : '' }}>Checkout</button>
                    </form>
                </div>
            </div>
        </form>
    @else
        <p>Your cart is empty.</p>
    @endif

@endsection