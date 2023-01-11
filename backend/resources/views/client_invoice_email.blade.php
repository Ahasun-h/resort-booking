<!DOCTYPE html>
<html>
    <head>
        <title>Confirm Email</title>

        <!-- BEGIN: Theme CSS-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
        <h1>Your booking confirmed</h1>
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
                    <td style="width: 100%">
                        <p>Email : {{ $booking->email }}</p>
                        <p>Number : {{ $booking->contact_number }}</p>
                        <p>Booking Date : {{ $booking->booking_date }}</p>
                        <p>Check Out Date : {{ $booking->check_out_date }}</p>
                    </td>
                </tr>
                <tr>
                    <td style="width: 100%">
                        <p>Resort Name : {{ $resort->name }}</p>
                        <p>Address : {{ $resort->address }}</p>
                        <p>Location : {{ $resort->location }}</p>
                    </td>
                </tr>
            </tbody>
        </table>

        <a href="{{ $booking->invoice }}" class="btn btn-sm btn-primary">Download Invoice</a>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>