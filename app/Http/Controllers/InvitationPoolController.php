<?php

namespace App\Http\Controllers;

use App\InvitationPool;
use App\Survey;
use Illuminate\Http\Request;

class InvitationPoolController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Survey $survey)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Survey  $survey
     * @param  \App\InvitationPool  $invitationPool
     * @return \Illuminate\Http\Response
     */
    public function show(Survey $survey, InvitationPool $invitationPool)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Survey  $survey
     * @param  \App\InvitationPool  $invitationPool
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Survey $survey, InvitationPool $invitationPool)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Survey  $survey
     * @param  \App\InvitationPool  $invitationPool
     * @return \Illuminate\Http\Response
     */
    public function destroy(Survey $survey, InvitationPool $invitationPool)
    {
        //
    }
}
