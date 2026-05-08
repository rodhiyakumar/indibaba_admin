<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $order['id'] }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14pt;
            line-height: 1.6;
            margin: 20px;
            color: #000;
        }

        h2,
        h4,
        h5 {
            margin: 0 0 10px 0;
        }

        h5 {
            margin: 20px 0 0 0;
            font-size: 20px;
            font-weight: bold;
        }

        .mb-2 {
            margin-bottom: 10px;
        }

        .mb-3 {
            margin-bottom: 15px;
        }

        .mb-4 {
            margin-bottom: 20px;
        }

        .text-right {
            text-align: right;
        }

        .text-muted {
            color: #666;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 5px;
        }

        .badge-success {
            background: #28a745;
            color: #fff;
        }

        .badge-warning {
            background: #ffc107;
            color: #000;
        }

        .badge-primary {
            background: #007bff;
            color: #fff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 13pt;
            text-align: left;
        }

        table th {
            background: #f5f5f5;
        }

        .list-group {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .list-group-item {
            border: none;
            padding: 5px 0;
            font-size: 13pt;
        }

        .card {
            margin-bottom: 20px;
        }

        .card-header {
            font-weight: bold;
            padding: 8px;
            background: #f2f2f2;
            border-bottom: 1px solid #000;
        }

        .card-body {
            padding: 10px;
        }

        .total-row td {
            font-weight: bold;
            font-size: 14pt;
        }

        @media print {
            body {
                margin: 10mm;
            }
        }
    </style>
</head>
{{--  --}}

<body onload="window.print()">

    <!-- Company Info -->
    <div class="row">
        <div style="width:80%; float:left; height:111px;">
            <img src="{{ asset('assets/images/logo.png') }}" alt="" width="8%">
        </div>
        <div style="width:20%; float:left; text-align:right;">
            <h2>Niivrai</h2>
        </div>
    </div>
    <div class="row">
        <p style="width:80%; text-align:left;">77 glenmore greens sudama vihar kurla kingra jalandhar punjab 144001.
            Phone: +91 7719661001
        </p>
    </div>
    <hr>

    <div class="row mb-3">
        <div style="width:50%; float:left;">
            <strong>Shipping Address:</strong><br />
            <span>{{ $order['userOrderAddress']['name'] }}</span><br />
            <span>{{ $order['userOrderAddress']['addressLine1'] }}</span>
            <span>{{ $order['userOrderAddress']['addressLine2'] }}</span><br>
            <span>{{ $order['userOrderAddress']['city'] }}</span>
            <span>{{ $order['userOrderAddress']['state'] }}</span>
            <span>{{ $order['userOrderAddress']['country'] }}</span>
            <span>{{ $order['userOrderAddress']['pincode'] }}</span><br />
            <strong>Mobile:</strong> {{ $order['userOrderAddress']['mobile'] }}
            <br /><br />

            <strong>Invoice Number:</strong>
            <span>{{ $order['invoiceNumber'] }}</span><br />
            <strong>Invoice Date:</strong>
            <span>{{ $order['invoiceDate'] }}</span>

        </div>
        <div style="width:50%; float:right;" class="text-right">
            <strong>Order Number:</strong>
            <span>{{ $order['id'] }}</span><br />
            <strong>Order Date:</strong>
            <span>{{ $order['createdAt'] }}</span><br /><br /><br />
        </div>
    </div>
    <div style="clear:both;"></div>

    <!-- Products -->
    <h5>Products:</h5>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th width="120">Price</th>
                <th width="100">Qty</th>
                <th width="120">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order['cartDetails'] as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ number_format($item['price'], 2) }}</td>
                    <td>{{ $item['qty'] }}</td>
                    <td>{{ number_format($item['price'] * $item['qty'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totals -->
    <div class="row justify-content-end">
        <div style="width:20%; float:right; margin:30px 0 30px 0;">
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between">
                    <span>Shipping</span>
                    <strong>{{ number_format($order['shippingAmount'], 2) }}</strong>
                </li>
                @if (!empty($order['discountAmount']))
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Discount</span>
                        <strong>-{{ number_format($order['discountAmount'], 2) }}</strong>
                    </li>
                @endif
                <li class="list-group-item d-flex justify-content-between">
                    <span>Tax</span>
                    <strong>{{ number_format($order['taxAmount'], 2) }}</strong>
                </li>
                <li class="list-group-item d-flex justify-content-between" style="font-weight:bold;">
                    <span>Total</span>
                    <span class="text-success">{{ number_format($order['orderAmount'], 2) }}</span>
                </li>
            </ul>
        </div>
    </div>
    <div style="clear:both;"></div>

    <!-- Shipping Address -->
    {{-- <div class="card">
        <div class="card-header">Shipping Address</div>
        <div class="card-body">
            <strong>{{ $order['userOrderAddress']['name'] }}</strong><br />
            {{ $order['userOrderAddress']['addressLine1'] }} {{ $order['userOrderAddress']['addressLine2'] }}<br>
            {{ $order['userOrderAddress']['city'] }}, {{ $order['userOrderAddress']['state'] }} -
            {{ $order['userOrderAddress']['pincode'] }}<br>
        </div>
    </div> --}}



    <p style="margin-top: 30px;">© Copyright 2025 NIIVRAI APPARLES PRIVATE LIMITED. All rights reserved.</p>
</body>

</html>
