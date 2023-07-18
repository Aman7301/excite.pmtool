<!DOCTYPE html>
<html>

<head>
    <title>Invoice</title>

</head>

<body>
    <img src="{{$logo}}" />
    <h4 style="display: inline;float: right;font-size: 18px;">Form no:{{ $form_no }} </h4>
    <p>{{ $excite }}</p>
    <h4 style="display: inline;">Owner Name: {{$owner_name}}</h4>
    <p style=" text-align: right;font-size: 18px;">Company Name: {{$company_name}}</p>
    <div>
        <p style="padding: 10px;font-size: 18px;">Company Address: {{$company_address}}</p>
        <p style="font-size: 18px;">Company detail: {{$company_detail}}</p>
    </div>
    <table border="1" style="border: 1px dark black;width: 100%;border-collapse: collapse;">
      <tr>
        <th>
            Srno.
        </th>
        <th>
         price
        </th>
        <th>
            Total
        </th>
      </tr>
      <!-- foreach( ) -->
    </table>
</body>

</html>