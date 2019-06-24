<?php

namespace App\Http\Controllers;

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
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  User $user
     * @return Response
     * @throws Throwable
     */
    public function update(Request $request, User $user)
    {
        $new_rules = [
            'email' => 'required|string|email|max:255|unique:users,email,'. $user->id. ',id',
            'employee_id' => 'nullable|min:3|unique:users,employee_id,'. $user->id .',id|alpha_num',
            'password' => 'nullable|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        ];

        //Need to change some rules, because we make update, not insert
        $rules = array_merge(User::rules(), $new_rules);

        //Validator will filter all provided data, and return only validated one
        $data = $request->validate($rules);

        //Handle checkbox
        $data['in_probation'] = $request->has('in_probation') && $request->get('in_probation');

//        $user =  DB::transaction(function () use ($user, $data) {
            $user->update($data);
//            $user->syncRoles($data['role']);
//
//            return $user;
//        });

//        flash('The '. $user->name . ' was edited successfully')->success();

        return auth()->user()->hasRole('manager')
            ? redirect()->route('users.index')
            : redirect()->route('users.edit', compact('user'));
    }
}
