<?php

namespace App\Http\Controllers\admin;

use App\ClassSchedule;
use App\GroupHour;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = GroupHour::all();
        $hours = ClassSchedule::all();
        $group_ids = GroupHour::pluck('id');
        $class_ids = ClassSchedule::pluck('group_hour_id');

        /*When a new group name is created, this will show it on the page*/
        $results = $group_ids->diff($class_ids);
        $result = $results->first();
        $group_name = GroupHour::find($result);

        return view('admin.cms.classhours', compact('hours', 'groups', 'group_name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ClassSchedule::create([
          'group_hour_id' => $request->group_hour_id,
          'description'=> $request->description,
            'time' => $request->time
        ]);

        flash('Update was successfully')->success();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $time = ClassSchedule::find($id);

        $time->description = $request->description;
        $time->time = $request->time;
        $time->save();

        flash('Update was successfully')->success();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = ClassSchedule::find($id);
        $row->delete();
        flash('Row was deleted successfully')->success();

        return redirect()->back();
    }

    public function updateGroupName(Request $request){

       $input = GroupHour::find($request->input('id'));

        $input->name = $request->input('group_name');
        $input->save();

        //return response()->json($group_name);

        flash('Name was updated successfully')->success();
    }

    public function delete(Request $request){

        $name = GroupHour::find($request->input('id'));

        $hours = ClassSchedule::where('group_hour_id', $name->id);

        if(!empty($hours)) {
            foreach ($hours as $hour) {
                $hour->delete();
            }
        }
        $name->delete();

        flash('Group was deleted successfully')->success();
    }

    public function createGroup(Request $request){
        //$name = $request->input('name');
        GroupHour::create($request->all());

        flash('Group was created successfully')->success();
    }
}
