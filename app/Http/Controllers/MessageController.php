<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function Message(Request $request) {
        $validator = Validator::make($request->all(), [
            'contenue' => ['required', 'string', 'min:4', ],
            'userId' => ['required','integer',],
            
        ]); 

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        
        $message = new Message([
            'contenue' => $request->contenue,
             'userId' => $request->userId ,
             ]);
    
        // Gérer l'upload de l'image
        
        $message->save();
    
        return response()->json([
            "status" => true,
            "message" => "utilisateur inscrit avec succes ",
            'message'=>$message
        ],200);
    }
    public function ListMessage(Request $request)
    {
        $message=Message::all();
        return response()->json([compact('message') ],200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }
}
