
<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>

    <style>
        /* -------- PAGE SETUP -------- */
        @page {
            size: A4;
            margin: 10mm;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #fff;
        }

        /* -------- INVOICE BOX -------- */
        .invoice-box {
            position: relative;
            width: 100%;
            min-height: 277mm; /* A4 height minus margins */
            padding: 10mm;
            border: 2px solid #000;
            box-sizing: border-box;
        }

        /* -------- HEADER -------- */
        .header {
            display: flex;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }

        .logo {
            width: 80px;
        }

        .logo img {
            width: 100%;
        }

        .brand {
            flex: 1;
            text-align: center;
        }

        .brand h2 {
            margin: 0;
            font-size: 22px;
            font-weight: bold;
        }

        .brand p {
            margin: 0;
            font-size: 14px;
        }

        /* -------- INFO -------- */
        .info {
            border: 1.5px solid #000;
            padding: 8px;
            margin-bottom: 10px;
            font-size: 14px;
        }

        /* -------- TABLE -------- */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        thead th {
            border: 1.5px solid #000;
            padding: 6px;
            background: #f2f2f2;
            text-align: center;
        }

        tbody td {
            border: 1px solid #000;
            padding: 6px;
        }

        .right {
            text-align: right;
        }

        .total-row td {
            font-weight: bold;
            background: #eaeaea;
        }

        /* -------- FOOTER -------- */
        .footer {
            position: absolute;
            bottom: 10mm;
            left: 10mm;
            right: 10mm;
            text-align: center;
            font-size: 13px;
            border-top: 1.5px solid #000;
            padding-top: 6px;
        }

        /* -------- PRINT -------- */
        @media print {
            body {
                background: #fff;
            }
            .invoice-box {
                page-break-inside: avoid;
            }
        }
    </style>

    
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

<div class="invoice-box">

    <!-- HEADER -->
    <div class="header">
        <div class="logo">
            <img src="{{ asset('assets/images/logo.png') }}" alt="logo">
        </div>

        <div class="brand">
            <h2>itieclothing</h2>
            <p>Sales Invoice</p>
        </div>
    </div>

    <!-- INFO -->
    <div class="info">
        <strong>Invoice No:</strong> {{ $sale->order_no }} <br>
        <strong>Date:</strong> {{ date('d-m-Y') }} <br>
        <strong>Customer:</strong> {{ $sale->customer_name }} <br>
        <strong>Mobile:</strong> {{ $sale->mob_no }}
    </div>

    <!-- ITEMS TABLE -->
    <table>
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Qty</th>
                <th>Size</th>
                <th>Color</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>
            @php $grandTotal = 0; @endphp

            @foreach($data as $item)
            <tr>
                <td>{{ $item->item_name }}</td>
                <td class="right">{{ $item->sale_qty }}</td>
                <td class="right">{{ $item->size }}</td>
                <td class="right">{{ $item->color }}</td>
                <td class="right">{{ number_format($item->price,2) }}</td>
                <td class="right">{{ number_format($item->total_amount,2) }}</td>
            </tr>

            @php $grandTotal += $item->total_amount; @endphp
            @endforeach

            <tr class="total-row">
                <td colspan="5" class="right">Grand Total</td>
                <td class="right">{{ number_format($grandTotal,2) }}</td>
            </tr>
        </tbody>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        Thank you for purchasing with <strong>itieclothing</strong> 🙏
    </div>

</div>

<script>
    window.print();
</script>

</body>
</html>

