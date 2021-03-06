<?php

namespace App\Http\Controllers;

use App\City;
use App\Country;
use App\Profile;
use App\Role;
use App\State;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserProfile;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profiles = Profile::with( 'user')
                        ->orderByDesc('id')
                        ->paginate(5);
        return  view('admin.profiles.index', compact('profiles'));
    }

    public function trash()
    {
        $profiles = Profile::with( 'user')
                        ->orderByDesc('id')
                        ->onlyTrashed()
                        ->paginate(5);
        return  view('admin.profiles.trash', compact('profiles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $countries = Country::all();
        return  view('admin.profiles.create', compact('roles', 'countries', 'profile'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserProfile $request)
    {
//        dd($request->all());
        try {
            $path = null;
            if ($request->hasFile('thumbnail'))
            {
                $fileName =  time().$request->thumbnail->getClientOriginalName();
                $path = $request->thumbnail->storeAs('images/profile', $fileName);
            }

            $user = User::create([
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'status' => $request->status
            ]);

            if ($user) {
                $newProfile = [
                    'user_id' => $user->id,
                    'name' => $request->name,
                    'slug' => $request->slug,
                    'thumbnail' => $path,
                    'country_id' => $request->country_id,
                    'state_id' => $request->state_id,
                    'city_id' => $request->city_id,
                    'phone' => $request->phone,
                ];
                $profile = Profile::create($newProfile);
            }
            if  ( $user && $profile ) {
                return back()->with('success', 'Profile Added Successfully!');
            } else {
                return back()->with('error', 'Error Inserting Profile data');
            }
        } catch (\Exception $e){
            dd($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
//        dd($profile);
        $roles = Role::all();
        $countries = Country::all();
        return  view('admin.profiles.edit', compact('profile', 'roles', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        try {
            $path = null;
            if ($request->hasFile('thumbnail'))
            {
                $fileName =  time().$request->thumbnail->getClientOriginalName();
                $path = $request->thumbnail->storeAs('images/profile', $fileName);
                $profile->thumbnail = $path;
            }

            $userId = $profile->user_id;
            $profile = User::where('id', $userId)->update(['status' => $request->status]);

            $profile->name = $request->name;
//            $profile->slug = $request->slug;
            $profile->country_id = $request->country_id;
            $profile->state_id = $request->state_id;
            $profile->city_id = $request->city_id;
            $profile->phone = $request->phone;
            $saved = $profile->save();

            if  ($saved) {
                return back()->with('success', 'Profile Updated Successfully!');
            } else {
                return back()->with('error', 'Error Updating Profile');
            }
        } catch (\Exception $e){
            dd($e->getMessage());
        }
    }


    public function recoverProfile($slug)
    {
        $profile = Profile::withTrashed()->where(['slug' => $slug]);
        if ($profile->restore()) {
            $profile->update(['restore_at' => now()->toDateTimeString()]);
            return back()->with('success', 'Profile Successfully Restored!');
        }
        else
            return back()->with('error', 'Error Restoring Profile');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        if ($profile->forceDelete()) {
            Storage::delete($profile->thumbnail);
            return back()->with('success', 'Profile Deleted Successfully!');
        } else {
            return back()->with('error', 'Error Deleting Record!');
        }
    }

    public function remove(Profile $profile)
    {
        if ($profile->delete()) {
            return back()->with('success', 'Profile Trashed Successfully!');
        } else {
            return back()->with('error', 'Error Trashing Profiles!');
        }
    }

    public function getStates(Request $request, $id)
    {
        if ($request->ajax())
            return State::where('country_id', $id)->get();
        else
            return 0;
    }

    public function getCities(Request $request, $id)
    {
        if ($request->ajax())
            return City::where('state_id', $id)->get();
        else
            return 0;
    }
}
