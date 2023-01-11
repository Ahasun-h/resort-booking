<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" href=" {{ asset('bootstrap/bootstrap.min.css') }} ">
    <style>
        @page {
            margin: 20px 20px;
            background-color: #fff;
        }
        table p{
            font-size: 14px;
            margin-bottom: 0px
        }
    </style>
</head>
<body style="background-color: #fff !important;">

<table style="width: 100%">
    <tbody>
    <tr>

        <td style="width: 100%">
            <div style="padding: 5px;border: 1px solid #000;">
                <p>Invoice NO : <strong class="text-primary">#{{ $booking->id }}</strong></p>
                <p>Date : <strong class="text-primary">{{ \Carbon\Carbon::parse($booking->created_at)->format('d/m/Y')}}</strong></p>
                <p>Bill Amount  : {{ $booking->bill }}</p>
            </div>
        </td>
    </tr>
    </tbody>
</table>
<table class="table" border="1" style="width: 100%;border-collapse: collapse;font-size:12px;text-align: left;margin-top: 18px;" >
    <tbody>
        <tr>
            <!-- Start Infromation -->
            <td style="width: 50%">
                <p>Email : {{ $booking->email }}</p>
                <p>Number : {{ $booking->contact_number }}</p>
                <p>Booking Date : {{ $booking->booking_date }}</p>
                <p>Check Out Date : {{ $booking->check_out_date }}</p>
            </td>
            <!-- End: Infromation -->

            <td style="width: 50%">
                <p>Resort Name : {{ $resort->name }}</p>
                <p>Address : {{ $resort->address }}</p>
                <p>Location : {{ $resort->location }}</p>
            </td>
        </tr>
    </tbody>
</table>









<script src="{{ asset('bootstrap/bootstrap.bundle.min.js') }} "></script>



</body>
</html>