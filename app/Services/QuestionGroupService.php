<?php


namespace App\Services;


use App\Helpers\DataHelper;
use App\QuestionGroup;
use App\Survey;

class QuestionGroupService
{
    /**
     * @param Survey $survey
     * @param QuestionGroup $questionGroup
     * @return array
     */
    public function create(Survey $survey, QuestionGroup $questionGroup)
    {
        $survey->questionGroups()->save($questionGroup);
        return DataHelper::creationDataResponse($questionGroup);
    }

    /**
     * @param QuestionGroup $questionGroup
     * @param array $data
     */
    public function update(QuestionGroup $questionGroup, array $data)
    {
        $questionGroup->update($data);
    }

    /**
     * @param QuestionGroup $questionGroup
     * @throws \Exception
     */
    public function delete(QuestionGroup $questionGroup)
    {
        $questionGroup->delete();
    }

//    /**
//     * @param Survey $survey
//     * @return array
//     */
//    public function getQuestionGroupLinks(Survey $survey)
//    {
//
//        $link = QuestionGroup::where('survey_id', $survey->id)->get()->map(function ($questionGroup) {
//            return $questionGroup->path();
//        });
//        return DataHelper::listDataResponse($link);
//    }

    /**
     * @param Survey $survey
     * @param int|null $pagSize
     * @param string|null $title
     * @param string|null $order
     * @param string|null $orderDir
     * @return mixed
     */
    public function getQuestionGroups(Survey $survey, int $pagSize = null, string $title = null,
                                      string $order = null, string $orderDir = null)
    {
        $params = ['survey_id' => $survey->id];

        if ($title) {
            array_push($params, ['title', 'like', '%' . $title . '%']);
        }

        $query = QuestionGroup::where($params);

        if ($order && $orderDir) {
            $query = $query->orderBy($order, $orderDir);
        }
        if ($pagSize) {
            return $query->paginate($pagSize)->withQueryString();
        }
        return $query->get();
    }

}