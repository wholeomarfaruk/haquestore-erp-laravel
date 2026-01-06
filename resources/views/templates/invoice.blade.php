<!-- resources/views/invoices/pdf.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_id }}</title>

    <style>

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #333;
        }

        .container {
            width: 100%;
            padding: 20px;
        }

        .header-table,
        .info-table,
        .items-table,
        .total-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: top;
        }

        .logo {
            width: 120px;
        }

        .company-details {
            text-align: right;
        }

        .company-details h2 {
            margin: 0;
            font-size: 20px;
        }

        .company-details p {
            margin: 2px 0;
        }

        .invoice-title {
            margin-top: 10px;
            font-size: 22px;
            font-weight: bold;
            border-bottom: 2px solid #444;
            padding-bottom: 5px;
        }

        .info-table td {
            padding: 8px;
            border: 1px solid #ddd;
            vertical-align: top;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .items-table th {
            background-color: #f5f5f5;
            text-align: left;
        }

        .total-table {
            margin-top: 10px;
            width: 40%;
            float: right;
        }

        .total-table td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 10px;
        }

        .total-table tr td:first-child {
            font-weight: bold;
        }

        .footer {
            margin-top: 60px;
            text-align: center;
            font-size: 11px;
            color: #777;
        }
        .text-xs {
            font-size: 10px;
        }
    </style>
</head>

<body>
<div class="container">

    <!-- Header -->
    <table class="header-table">
        <tr>
            <td>
                <img style="max-height: 60px; width: auto;" src="{{ public_path('storage/'.$company->logo) }}" class="logo" alt="Logo">
            </td>
            <td class="company-details">
                <h2>{{ $company->name }}</h2>
                <p>{{ $company->address }}</p>
                <p> {{ $company->phone ? 'Phone: ' . $company->phone : '' }}</p>
                <p>{{ $company->email ? 'Email: ' . $company->email : '' }}</p>
            </td>
        </tr>
    </table>

    <!-- Invoice Title -->
    <div class="invoice-title">INVOICE</div>

    <!-- Invoice & Customer Info -->
    <table class="info-table">
        <tr>
            <td width="50%">
                <strong>Invoice No:</strong> {{ $invoice->invoice_id }} <br>
                <strong>Date:</strong> {{ $invoice->updated_at->format('d M Y h:i A') }}
            </td>
            <td width="50%">
                <strong>Customer Name:</strong> {{ $invoice?->customer?->name }} <br>
                <strong>Phone:</strong> {{ $invoice?->customer?->phone }} <br>
                <strong>Address:</strong> {{ $invoice?->customer?->address }}
            </td>
        </tr>
    </table>

    <!-- Items -->
    <h3 style="margin-top: 20px;">Invoice Items</h3>
    <table class="items-table">
        <thead>
        <tr>
            <th width="40%">Item</th>
            <th width="15%">Qty</th>
            <th width="20%">Price</th>
            <th width="25%">Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($invoice->items as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->unit_qty.' '.$item->unit_name }}</td>
                <td>Tk {{ number_format($item->regular_price, 2) }}</td>
                <td>Tk {{ number_format($item->total, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Totals -->
    <table class="total-table">
        <tr>
            <td>Total Amount</td>
            <td>Tk {{ number_format($invoice->total, 2) }}</td>
        </tr>
        <tr>
            <td>Discount</td>
            <td>Tk {{ number_format($invoice->discount, 2) }}</td>
        </tr>
        <tr style="background:#f5f5f5">
            <td>Grand Total</td>
            <td>Tk {{ number_format($invoice->grand_total, 2) }}</td>
        </tr>
        <tr>
            <td>
                Previous Due
                <p class="text-xs">{{ $invoice?->previous_invoice_id }}</p>

            </td>
            <td>Tk {{ number_format($invoice->previous_due, 2) }}</td>
        </tr>
   <tr style="background:#f5f5f5">
            <td>
                Payable Amount


            </td>
            <td>Tk {{ number_format(($invoice->previous_due+$invoice->grand_total), 2) }}</td>
        </tr>
        <tr>
            <td>Deposit Amount</td>
            <td>Tk {{ number_format($invoice->paid_amount, 2) }}</td>
        </tr>
        <tr>
            <td>Due Amount</td>
            <td>Tk {{ number_format($invoice->due_amount, 2) }}</td>
        </tr>
    </table>

    <div style="clear: both;"></div>

    <!-- Footer -->
    <div class="footer">
        Thank you for your business! <br>
        This is a computer-generated invoice.
    </div>

</div>
</body>
</html>
