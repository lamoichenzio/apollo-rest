<html lang="en">
<body>
<h1>Apollo</h1>
<p>
    {{__('email.your_survey')}} <strong>{{$survey->name}}</strong> {{__('email.survey_activated')}}.
    @if($survey->end_date)
        {{__('email.survey_active_until', ['end_date' => $survey->end_date])}}
    @endif
</p>
<br>
<small>
    {{__('email.regards')}}, Apollo Team
</small>
</body>
</html>
