<?php

namespace App\Http\Controllers\Network;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRequest;

class InteractionController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a suggestion of all users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $user = auth()->user(); 
        $sentRequests = $user->sentRequest()->pluck('reciever_user_id')->toArray();
        $recieveRequests = $user->recieveRequest()->where('status',0)->get();
        $userSuggestions = User::get()->except([$user->id]);
        $userSuggestions = $userSuggestions->except($sentRequests);
        $userSuggestions = $userSuggestions->except($user->recieveRequest()->pluck('sender_user_id')->toArray());
        /*user conneciton*/
        $userConnections = $user->recieveRequest()->where('status',1)->get()->merge($user->sentRequest()->where('status',1)->get());

        /*end*/
        
        return view('home',compact('userSuggestions','sentRequests','recieveRequests','userConnections'));
    }
    /**
     * create connection request.
     *
     * @return \Illuminate\Http\Response
     */
    public function sentConnection(Request $request)
    {
        //create connection request
        UserRequest::create(['sender_user_id'=>auth()->user()->id,'reciever_user_id'=>$request->userId,'status'=>0]);
        return response()->json();
    }
    /**
     * check sent request.
     *
     * @return \Illuminate\Http\Response
     */
    public function sentRequest()
    {
        //check auth user has how many request sent
        $requestSents = auth()->user()->sentRequest()->where('status',0)->with('recieverUser')->get();
        return response()->json(['success'=>$requestSents]);
    }
    /**
     * check suggestion.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSuggestion()
    {
        $user = auth()->user();
        $sentRequests = $user->sentRequest()->pluck('reciever_user_id')->toArray();
        $userSuggestions = User::get()->except([$user->id]);
        $userSuggestions = $userSuggestions->except($sentRequests);
        return response()->json(['success'=>$userSuggestions]);
    }
    /**
     * with draw request.
     *
     * @return \Illuminate\Http\Response
     */
    public function withDrawConnect(Request $request)
    {
        $user = auth()->user();
        $userSuggestions = $user->sentRequest()->where('reciever_user_id',$request->reciever_user_id)->first()->delete();
        return response()->json();
    }
    /**
     * get all recieve request.
     *
     * @return \Illuminate\Http\Response
     */
    public function recieveRequest(Request $request)
    {   
        $user = auth()->user();
        $recieveRequests = $user->recieveRequest()->with('senderUser')->where('status',0)->get();
        return response()->json(['success'=>$recieveRequests]);
    }
    /**
     * Accept request.
     *
     * @return \Illuminate\Http\Response
     */
    public function acceptConnect(Request $request)
    {
        $user = auth()->user();
        $acceptRequest = $user->recieveRequest()->where('sender_user_id',$request->sender_user_id)->first();
        $acceptRequest->update(['status'=>1]);
        $check = $user->sentRequest()->where('reciever_user_id',$request->sender_user_id)->first();
        if (isset($check)) {
            $check->delete();
        }
    }
    /**
     * Get all connection.
     *
     * @return \Illuminate\Http\Response
     */
    public function getConnection()
    {   
        $user = auth()->user();
        $userConnections = $user->recieveRequest()->where('status',1)->get()->merge($user->sentRequest()->where('status',1)->get());
        $senderIds = array();
        $recieverIds = array();
        foreach ($userConnections as $key => $conn) {
            $userIds[] = $conn['sender_user_id'];
            $recieverIds[] = $conn['reciever_user_id'];
        }
        $userIds = array_merge($userIds,$recieverIds);
        $connections = User::whereIn('id',$userIds)->get()->unique()->except($user->id);
        
        return response()->json(['success'=>$connections]);
    }
     /**
     * remove connection
     *
     * @return \Illuminate\Http\Response
     */
    public function removeConnect(Request $request)
    {   
        $user = auth()->user();
        $reciever = $user->recieveRequest()->where('sender_user_id',$request->connection_id)->where('status',1)->first();
        $sender = $user->sentRequest()->where('reciever_user_id',$request->connection_id)->where('status',1)->first();
        if(isset($reciever)){
            $reciever->delete();
        }
        if(isset($sender)){
            $sender->delete();
        }
    }
    /**
     * common connection
     *
     * @return \Illuminate\Http\Response
     */
    public function commonConnection(Request $request)
    {
        /* connection of connection user*/
        $user = User::where('id',$request->connection_id)->first();
        $userConnections = $user->recieveRequest()->where('status',1)->get()->merge($user->sentRequest()->where('status',1)->get());
        
        $senderIds = array();
        $recieverIds = array();
        foreach ($userConnections as $key => $conn) {
            $userIds[] = $conn['sender_user_id'];
            $recieverIds[] = $conn['reciever_user_id'];
        }
        $userIds = array_merge($userIds,$recieverIds);
        $userId = array($user->id);
        $connectionsIds = array_diff($userIds, $userId);
        //dd($connectionsIds);
    
        /* connection of auth user*/
                
        $connection = User::where('id',auth()->user()->id)->first();
        
        $ConnectionConnections = $connection->recieveRequest()->where('status',1)->get()->merge($connection->sentRequest()->where('status',1)->get());

        $ConnectionSenderIds = array();
        $ConnectionRecieverIds = array();
        foreach ($ConnectionConnections as $key => $conn) {
            $ConnectionSenderIds[] = $conn['sender_user_id'];
            $ConnectionRecieverIds[] = $conn['reciever_user_id'];
        }
        $ConnectionUserIds = array_merge($ConnectionSenderIds,$ConnectionRecieverIds);
        
        $connectionUserId = array($connection->id);
        $connectionConnectionsIds = array_diff($ConnectionUserIds, $connectionUserId);
        
        /*mutual connection*/
        $mutual = array_intersect($connectionsIds , $connectionConnectionsIds);
        $commonUsers = User::whereIn('id',$mutual)->get();
        return response()->json(['success'=>$commonUsers,'user'=>$user]);
        /*end*/
    }
}
