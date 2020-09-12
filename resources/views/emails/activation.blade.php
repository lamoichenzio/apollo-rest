<html lang="en">
<body>
<h1>Apollo</h1>
<p>
    Your survey <strong>{{$survey->name}}</strong> has been activated.
    @if($survey->end_date)
        And will be active until <strong>{{$survey->end_date}}</strong>!
    @endif
</p>
<br>
<small>
    Best regards, Apollo Team
</small>
</body>
</html>
