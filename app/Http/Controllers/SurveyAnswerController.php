<?php

namespace App\Http\Controllers;

use App\Http\Requests\SurveyAnswerCreationRequest;
use App\Services\SurveyAnswerService;
use App\Survey;
use App\SurveyAnswer;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;

class SurveyAnswerController extends Controller
{
    protected $service;

    public function __construct(SurveyAnswerService $service)
    {
        $this->service = $service;
        $this->middleware('auth:api', ['except' => ['store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Survey $survey
     * @return \Illuminate\Http\Response
     */
    public function index(Survey $survey)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Survey $survey
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SurveyAnswerCreationRequest $request, Survey $survey)
    {
        if ($survey->secret) {
            //PRIVATE SURVEY LOGIN AND VERIFICATION
            $email = $request['email'];
            if (SurveyAnswer::where([
                        ['survey_id', $survey->id],
                        ['email', $email]]
                )->get()->count() > 0) {
                return response()->json(['error' => 'Survey already responded by the user'], 422);
            }

            $invitationPool = $survey->invitationPool;
            if (!$invitationPool->emails->contains('email', $email)) {
                return response()->json(['error' => 'User not allowed to access the survey'], Response::HTTP_UNAUTHORIZED);
            }

            $password = $request['password'];
            if (Crypt::decryptString($invitationPool->password) != $password) {
                return \response()->json(['error' => 'Wrong password'], 401);
            }
        }

        $surveyAnswer = new SurveyAnswer($request->all());
        $this->service->create($survey, $surveyAnswer, collect($request['answers']));
        return response()->json(['message' => 'created'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Survey $survey
     * @param \App\SurveyAnswer $surveyAnswer
     * @return \Illuminate\Http\Response
     */
    public function show(Survey $survey, SurveyAnswer $surveyAnswer)
    {
        //
    }

}
