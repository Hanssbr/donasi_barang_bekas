<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $item = Submission::with(['user', 'item'])->when($request->status, function ($query, $status){
            return $query->where('status', $status);
        })->orderBy('id', 'DESC')->get();

        return ResponseHelper::jsonResponseMethod(status: 'success', data:$item);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required',
            'message' => 'required',
        ]);

        $user = $request->user();

        $submission = new Submission();
        $submission->user_id = $user->id;
        $submission->item_id = $request->item_id;
        $submission->message = $request->message;
        $submission->status = 'pending';

        if($request->file('photo')){
            $photo = $request->file('photo');
            $photo->storeAs('public/photo', $photo->hashName());
            $submission->photo = $photo->hashName();
        }

        $submission->save();
        $submission = Submission::with(['user', 'item'])->find($submission->id);

        return ResponseHelper::jsonResponseMethod(data: $submission, status: 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $submission = Submission::with(['user', 'item'])->find($id);
        if(!$submission){
            return ResponseHelper::jsonResponseMethod(message: 'Product not found', status: 'error', errorCode: 404);
        }
        return ResponseHelper::jsonResponseMethod(data: $submission, status: 'success');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $submission = Submission::find($id);
        if(!$submission){
            return ResponseHelper::jsonResponseMethod(message: "Item Not Found.", status: 'error', errorCode : 404);
        }

        $submission->message = $request->message;
        $submission->status = $request->status;

        $submission->save();

        return ResponseHelper::jsonResponseMethod(data: $submission, status: 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $submission = Submission::find($id);
        if(!$submission){
            return ResponseHelper::jsonResponseMethod(message: 'Product not found', status: 'error', errorCode: 404);
        }
        $submission->delete();
        return ResponseHelper::jsonResponseMethod(message: 'Product successfully deleted', status: 'success');
    }
}
