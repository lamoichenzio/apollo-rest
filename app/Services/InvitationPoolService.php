<?php


namespace App\Services;


use App\Helpers\DataHelper;
use App\InvitationEmail;
use App\InvitationPool;
use App\Survey;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class InvitationPoolService
{

    /**
     * @param InvitationPool $pool
     * @param Survey $survey
     * @param Collection $emails
     * @return array
     */
    public function create(InvitationPool $pool, Survey $survey, Collection $emails)
    {
        DB::transaction(function () use ($survey, $emails, $pool) {
            $survey->invitationPool()->save($pool);
            $emails->each(function ($email) use ($pool) {
                $pool->emails()->save(new InvitationEmail(['email' => $email]));
            });
        });
        return DataHelper::creationDataResponse($pool);
    }

    /**
     * @param InvitationPool $pool
     * @param array $data
     * @param Collection|null $emails
     */
    public function update(InvitationPool $pool, array $data, Collection $emails = null)
    {
        DB::transaction(function () use ($emails, $data, $pool) {
            $pool->update($data);
            $emails->each(function ($email) use ($pool) {
                $pool->emails()->save(new InvitationEmail(['email' => $email]));
            });
        });
    }

    /**
     * @param InvitationPool $pool
     * @throws Exception
     */
    public function delete(InvitationPool $pool)
    {
        $pool->delete();
    }

}