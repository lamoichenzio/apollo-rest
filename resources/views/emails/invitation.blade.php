<html>
<body>
<h1>Apollo</h1>
<p>
    {{__('email.welcome')}}
    <br>{{__('email.click_link')}}<br>
</p>
<h3>{{$survey->name}}</h3>
<a href="{{$surveyUrl}}">{{$surveyUrl}}</a>
<p>{{__('email.confirm')}}</p>
<p>
    Password: <b>{{$password}}</b>
</p>
<br>
<small>{{__('email.regards')}}, Apollo Team</small>
</body>
</html>