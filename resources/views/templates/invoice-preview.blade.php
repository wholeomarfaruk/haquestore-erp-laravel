
    <style>
       #invoice_container.invoice-container {
            width: 100%;
            padding: 20px;
            margin:0 auto;
            max-width: 800px;
        }

        #invoice_container .header-table,
        #invoice_container .info-table,
        #invoice_container .items-table,
        #invoice_container .total-table {
            width: 100%;
            border-collapse: collapse;
        }

        #invoice_container .header-table td {
            vertical-align: top;
        }

        #invoice_container .logo {
            width: 120px;
        }

        #invoice_container .company-details {
            text-align: right;
        }

        #invoice_container .company-details h2 {
            margin: 0;
            font-size: 20px;
        }

        #invoice_container .company-details p {
            margin: 2px 0;
        }

       #invoice_container  .invoice-title {
            margin-top: 10px;
            font-size: 22px;
            font-weight: bold;
            border-bottom: 2px solid #444;
            padding-bottom: 5px;
        }

        #invoice_container .info-table td {
            padding: 8px;
            border: 1px solid #ddd;
            vertical-align: top;
        }

        #invoice_container .items-table th,
        #invoice_container .items-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #invoice_container .items-table th {
            background-color: #f5f5f5;
            text-align: left;
        }

       #invoice_container  .total-table {
            margin-top: 10px;
            width: 40%;
            float: right;
        }

        #invoice_container .total-table td,
        #invoice_container .total-table th {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 16px;
        }

        #invoice_container .total-table tr td:first-child {
            font-weight: bold;
        }

        #invoice_container .footer {
            margin-top: 60px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }

        #invoice_container .text-xs {
            font-size: 10px;
        }

        #invoice_container .items-table tr td:first-child,
        #invoice_container .items-table tr th:first-child {
            width: 40%;
        }

        #invoice_container .items-table tr td:nth-child(2),
        #invoice_container .items-table tr th:nth-child(2) {
            width: 20%;
        }

        #invoice_container .items-table tr td:nth-child(3),
        #invoice_container .items-table tr th:nth-child(3) {
            width: 20%;
        }

       #invoice_container  .items-table tr td:last-child,
       #invoice_container  .items-table tr th:last-child {
            width: 20%;
        }

        #invoice_container .summary {
            width: 40%;
        }

       #invoice_container  .summary tr td:first-child,
        #invoice_container .summary tr th:first-child {
            width: 50%;
        }

        #invoice_container .summary tr td:last-child,
        #invoice_container .summary tr th:last-child {
            width: 50%;
        }

       #invoice_container  .trxn {
            width: 60%;
        }

       #invoice_container  .trxn tr td:first-child,
        #invoice_container .trxn tr th:first-child {
            width: 67%;
        }

        #invoice_container .trxn tr td:last-child,
       #invoice_container  .trxn tr th:last-child {
            width: 33%;
        }
    </style>

    <div id="invoice_container" class="invoice-container">

        <!-- Header -->
        <table class="header-table">
            <tr>
                <td>
                    <img style="height: 60px; width: auto;" src="{{ asset('storage/' . $company->logo) }}" class="logo"
                        alt="Logo">
                </td>
                <td class="company-details">
                    <h2>{{ $company->name }}</h2>
                    <p>{{ $company->address }}</p>
                    <p>{{ $company->secondary_phone ? $company->secondary_phone . ', ' : '' }} {{ $company->phone }}</p>
                    <p>{{ $company->email }}</p>
                </td>
            </tr>
        </table>

        <!-- Invoice Title -->
        <div class="invoice-title">INVOICE</div>

        <!-- Invoice & Customer Info -->
        <table class="info-table">
            <tr>
                <td width="50%">
                    <strong>Invoice No:</strong> {{ $invoice['invoice_id'] }} <br>
                    <strong>Date:</strong> {{ now()->format('d M Y h:i A') }}
                </td>
                <td width="50%">
                    <strong>Customer Name:</strong> {{ $customer?->name }} <br>
                    <strong>Phone:</strong> {{ $customer?->phone }} <br>
                    <strong>Address:</strong> {{ $customer?->address }}
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
                @foreach ($invoice['items'] as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['quantity'] . ' ' . $item['unit_name'] }}</td>
                        <td>Tk {{ number_format($item['price'], 2) }}</td>
                        <td>Tk {{ number_format($item['total'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <table class="total-table summary">
            <tr>
                <td>Total Amount</td>
                <td>Tk {{ number_format($invoice['total'], 2) }}</td>
            </tr>
            <tr>
                <td>Discount</td>
                <td>Tk {{ number_format($invoice['discount'], 2) }}</td>
            </tr>
            <tr style="background:#f5f5f5">
                <td >Grand Total</td>
                <td>Tk {{ number_format($invoice['grand_total'], 2) }}</td>
            </tr>
            <tr>
                <td>
                    Previous Due
                    <p style="font-size: 10px; line-height: 16px;">{{ $invoice['previous_invoice_id'] }}</p>

                </td>
                <td>Tk {{ number_format($invoice['previous_due'], 2) }}</td>
            </tr>
            <tr style="background:#f5f5f5">
                <td>
                    Payable Amount


                </td>
                <td>Tk {{ number_format($invoice['previous_due'] + $invoice['grand_total'], 2) }}</td>
            </tr>

            <tr>
                <td>Deposit Amount</td>
                <td>Tk {{ number_format($invoice['paid_amount'], 2) }}</td>
            </tr>
            <tr>
                <td>Due Amount</td>
                <td>Tk {{ number_format($invoice['due_amount'], 2) }}</td>
            </tr>
        </table>
        <!-- transection -->
        <table class="total-table trxn">
            <tr style="background:#f5f5f5">
                <th colspan="2">Transections</th>

            </tr>

            <tr style="background:#f5f5f5">
                <th>Trxn Date</th>
                <th>Deposit Amount</th>
            </tr>
            @if ($invoice['json_data'] != null)
                @php
                    $data = $invoice['json_data'];

                @endphp
                @if (isset($data['transections']) && count($data['transections']) > 0)
                    @foreach ($data['transections'] as $item)
                        <tr>
                            <td style="text-align: center;">{{ $item['date'] }}</td>
                            <td style="text-align: center;">Tk {{ number_format($item['amount'], 2) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="2">No Deposit trxn found</td>

                    </tr>

                @endif

            @endif



        </table>


        <div style="clear: both;"></div>

        <!-- Footer -->
        <div class="footer">
            {{ $company->description }}
        </div>

    </div>
