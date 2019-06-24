<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return Response
     */
    public function edit(User $user)
    {
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUser $request
     * @param User $user
     * @return Response
     */
    public function update(UpdateUser $request, User $user)
    {
        //Validator will filter all provided data, and return only validated one
//        $data = $request->validate($rules);

        //Handle checkbox
//        $data['in_probation'] = $request->has('in_probation') && $request->get('in_probation');

//        $user =  DB::transaction(function () use ($user, $data) {

        $data = $request->validated();
        $user->update($data);
//            $user->syncRoles($data['role']);
//
//            return $user;
//        });

//        flash('The '. $user->name . ' was edited successfully')->success();

        return redirect()->route('profile.edit', compact('user'));
    }
}
