<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use Illuminate\Http\Request;
use  App\Http\Requests\ToolStorageRequest;
use App\Models\ToolTag;
class ToolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tools = Tool::query();
        if($request->has('search') && !empty($request->search)){
            $search =  "%".$request->search."%";
            if($request->tagonly != "true"){
                $tools->join('tool_tags','tool_tags.tool_id', 'tools.id');
                $tools->where('tool_tags.tag', 'like', $search);
                $tools->orWhere('tools.name', 'like', $search);
                $tools->groupBy('tools.id');
                $tools->select('tools.*');
            }else{
                $tools->join('tool_tags','tool_tags.tool_id', 'tools.id');
                $tools->where('tool_tags.tag', 'like', $search);
                $tools->select('tools.*');
            }
        }
        return response()->json($tools->orderBy('tools.created_at', 'desc')->get(), 200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ToolStorageRequest $request)
    {
        try {
            $tool  = Tool::create($request->all());
            if($request->tags){
               foreach ($request->tags as $key => $value) {
                    ToolTag::create([
                        'tool_id' => $tool->id,
                        'tag' => $value
                    ]);
               }
            }
            return response()->json($tool, 201);
        } catch (\Exception $e) {
              return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tool  $tool
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $tool  = Tool::find($id);
            if($tool){
                $tool->fill($request->all());
                if($tool->save()){
                    return response()->json($tool, 200);
                }
            }else{
              return response()->json(['error' => 'Tool not found'], 404);
            }
        } catch (\Exception $e) {
              return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tool  $tool
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tool = Tool::find($id);

        if($tool){
            try {
                if($tool->delete()){
                    return response()->json([], 200);
                }
            }catch (\Exception $exception){
                return response()->json(['error' => $exception->getMessage()], 409);
            }
        }

        return response()->json(['error' => 'Tool not found', 'id'=>$id], 404);
    }
}
