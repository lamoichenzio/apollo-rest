<?php

namespace App\Http\Controllers;

use App\Helpers\DataHelper;
use App\Http\Requests\InvitationPoolCreationRequest;
use App\Http\Requests\InvitationPoolUpdateRequest;
use App\Http\Resources\InvitationPoolResource;
use App\InvitationEmail;
use App\InvitationPool;
use App\Services\InvitationPoolService;
use App\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class InvitationPoolController extends Controller
{

    protected $service;

    public function __construct(InvitationPoolService $service)
    {
        $this->service = $service;
        $this->middleware('auth:api');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param InvitationPoolCreationRequest $request
     * @param \App\Survey $survey
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(InvitationPoolCreationRequest $request, Survey $survey)
    {
        $request['password'] = Crypt::encryptString($request['password']);
        $invitationPool = new InvitationPool($request->all());
        $message = $this->service->create($invitationPool, $survey, collect($request['emails']));
        return response()->json($message, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Survey $survey
     * @param \App\InvitationPool $invitationPool
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Survey $survey, InvitationPool $invitationPool)
    {
        return response()->json(InvitationPoolResource::make($invitationPool));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param InvitationPoolUpdateRequest $request
     * @param \App\Survey $survey
     * @param \App\InvitationPool $invitationPool
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(InvitationPoolUpdateRequest $request, Survey $survey, InvitationPool $invitationPool)
    {
        if ($request['password']) {
            $request['password'] = Crypt::encryptString($request['password']);
        }
        $this->service->update($invitationPool, $request->all(), collect($request['emails']));
        return response()->json("", 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Survey $survey
     * @param \App\InvitationPool $invitationPool
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Survey $survey, InvitationPool $invitationPool)
    {
        $this->service->delete($invitationPool);
        return response()->json("", 204);
    }

    /**
     * @param Request $request
     * @param Survey $survey
     * @param InvitationPool $invitationPool
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeEmail(Request $request, Survey $survey, InvitationPool $invitationPool)
    {
        $request->validate([
            'email' => 'required|email'
        ]);
        $invitationPool->emails()->save(new InvitationEmail(['email' => $request['email']]));
        return response()->json(DataHelper::creationDataResponse($invitationPool), 201);
    }

    /**
     * @param Request $request
     * @param Survey $survey
     * @param InvitationPool $invitationPool
     * @param InvitationEmail $email
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateEmail(Request $request, Survey $survey, InvitationPool $invitationPool, InvitationEmail $email)
    {
        $request->validate([
            'email' => 'required|email'
        ]);
        $email->update($request->all());
        return response()->json("", 204);
    }

    /**
     * @param Survey $survey
     * @param InvitationPool $invitationPool
     * @param InvitationEmail $email
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function deleteEmail(Survey $survey, InvitationPool $invitationPool, InvitationEmail $email)
    {
        $email->delete();
        return response()->json("", 204);
    }
}
