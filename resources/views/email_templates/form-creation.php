<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Form Created!</title>
</head>
<body>
    <h1>New Form Created on {{ date('Y-m-d H:i:s') }}</h1>

    <p>Hi there,</p>

    <p>A new form has been created on your application.</p>

    @if (isset($data['form_name']))
        <p><b>Form Name:</b> {{ $data['form_name'] }}</p>
    @endif

    <p>You can access the form details by logging into your application.</p>

    <p>Thanks,</p>
    <p>Your DFM Team</p>
</body>
</html>
