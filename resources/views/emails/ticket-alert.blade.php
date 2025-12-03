<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }
        .email-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #ddd;
        }
        h2 {
            color: #e67e22;
            margin-bottom: 10px;
        }
        p {
            font-size: 15px;
            color: #333;
        }
        .label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }
        /* ================= Risk Colors ================ */
        .risk-badge {
            padding: 6px 12px;
            border-radius: 6px;
            color: white;
            font-weight: bold;
            display: inline-block;
        }
        .risk-low {
            background: #2ecc71;
        }
        .risk-medium {
            background: #f1c40f;
        }
        .risk-high {
            background: #e67e22;
        }
        .risk-critical {
            background: #c0392b;
        }
        /* description box */
        .desc-box {
            background: #fafafa;
            border-left: 4px solid #e67e22;
            padding: 12px;
            margin-top: 5px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="email-box">

    <h2>Hello ACRN Data Compliance Team, New Ticket Raised</h2>

    <p>A new ticket has been created in the system.</p>

    <p><span class="label">Ticket ID:</span> {{ $ticket->id }}</p>

    <p><span class="label">Title:</span> {{ $ticket->title }}</p>

    <!-- ================= RISK COLOR BADGE ================= -->
    <p>
        <span class="label">Risk Level:</span>
        <span class="risk-badge 
            @if($ticket->risk_level=='low') risk-low
            @elseif($ticket->risk_level=='medium') risk-medium
            @elseif($ticket->risk_level=='high') risk-high
            @else risk-critical
            @endif
        ">
            {{ ucfirst($ticket->risk_level) }}
        </span>
    </p>

    <p><span class="label">ROPA ID:</span> {{ $ticket->ropa_id }}</p>

    <p><span class="label">Description:</span></p>
    <div class="desc-box">
        {!! nl2br(e($ticket->description)) !!}
    </div>

    <br>

    <p>Please log in to the system to review this ticket.</p>

</div>

</body>
</html>
