<?php

namespace App\Http\Controllers;

use App\Http\Requests\questions\InputQuestionCreationRequest;
use App\Http\Requests\questions\InputQuestionUpdateRequest;
use App\Http\Resources\questions\InputQuestionResource;
use App\InputQuestion;
use App\QuestionGroup;
use App\Services\ImageFileService;
use App\Services\InputQuestionService;
use App\Survey;
use Illuminate\Http\JsonResponse;

class InputQuestionController extends Controller
{

    /**
     * @var InputQuestionService
     */
    protected $questionService;

    /**
     * InputQuestionController constructor.
     * @param InputQuestionService $service
     */
    public function __construct(InputQuestionService $service)
    {
        $this->questionService = $service;
        $this->middleware('auth:api');
    }

    /**
     * @param Survey $survey
     * @param QuestionGroup $questionGroup
     * @param InputQuestion $question
     * @return JsonResponse
     */
    public function show(Survey $survey, QuestionGroup $questionGroup, InputQuestion $question)
    {
        $question = $survey->questionGroups->find($questionGroup)->inputQuestions->find($question);
        if ($question) {
            return InputQuestionResource::make($question)->response();
        }
        return response()->json(['error' => 'Question not in Question Group'], 404);
    }

    /**
     * @param Survey $survey
     * @param QuestionGroup $questionGroup
     * @param InputQuestionCreationRequest $request
     * @return JsonResponse
     */
    public function create(Survey $survey, QuestionGroup $questionGroup, InputQuestionCreationRequest $request)
    {
        $question = new InputQuestion($request->all());
        $questionGroup = $survey->questionGroups->find($questionGroup);

        if ($image = $request['icon']) {
            $image = ImageFileService::createImageFile($image);
            $question->icon = $image->id;
        }

        $data = $this->questionService->create($questionGroup, $question);
        return response()->json($data, 201, ['Location' => $question->path()]);

    }

    /**
     * @param InputQuestionUpdateRequest $request
     * @param Survey $survey
     * @param QuestionGroup $questionGroup
     * @param InputQuestion $question
     * @return JsonResponse
     */
    public function update(InputQuestionUpdateRequest $request, Survey $survey, QuestionGroup $questionGroup, InputQuestion $question)
    {
        $question = $survey->questionGroups->find($questionGroup)->inputQuestions->find($question);
        if ($question) {
            if ($icon = $request['icon'] && $request['icon'] != 'delete') {
                $icon = ImageFileService::updateImageFile($question->icon, $icon);
                $question->icon = $icon->id;
            }
            $this->questionService->update($question, $request->all(), $request['icon'] == 'delete');
            return response()->json("", 204);
        }
        return response()->json(["error" => "Question not found"], 404);
    }

    /**
     * @param Survey $survey
     * @param QuestionGroup $questionGroup
     * @param InputQuestion $question
     * @return JsonResponse
     * @throws \Exception
     */
    public function delete(Survey $survey, QuestionGroup $questionGroup, InputQuestion $question)
    {
        $this->authorize('delete', $question);
        $question = $survey->questionGroups->find($questionGroup)->inputQuestions->find($question);
        if ($question) {
            $this->questionService->delete($question);
            return response()->json("", 204);
        }
        return response()->json(["error" => "Question not found"], 404);
    }
}
