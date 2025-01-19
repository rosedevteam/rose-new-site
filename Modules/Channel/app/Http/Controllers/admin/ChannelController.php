<?php

namespace Modules\Channel\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Traits\SEOTools;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Modules\Channel\Models\Channel;
use Modules\Product\Models\Product;
use Modules\User\Models\User;

class ChannelController extends Controller
{
    //todo fix channel module , send message,file,voice etc
    use SEOTools;

    public function index()
    {
        $channels = Channel::orderBy('updated_at')->get();
        return view('channel::admin.index', compact('channels'));
    }


    public function create()
    {
        $products = Product::all();
        return view('channel::admin.create', compact('products'));
    }


    public function store(Request $request)
    {
        // validation for post request
        $validData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'products' => 'required',
            'avatar' => 'nullable|mimes:png,jpeg,jpg',
            'json' => 'nullable'
        ]);



        // set avatar variable to null if avatar input is empty and does not exist in $validData
        $channelAvatar = null;
        if (isset($validData['avatar'])) {
            //upload channel avatar : uploader() function in app/http/Helpers.php
            $channelAvatar = "/images/channels/" . uploader($request, 'avatar', 'images/channels');
        }

        //create new channel with data
        $channel = Channel::create([
            'title' => $validData['title'],
            'description' => $validData['description'],
            'avatar' => $channelAvatar,
        ]);

        $channel->products()->attach($validData['products']);

        // select users from Successful orders with product ids that we have
        if ($validData['products'][0] != 'all') {
            //iterate product to get successful orders
            foreach ($validData['products'] as $item) {
                //get product by id
                $product = Product::where('id', $item)->first();
                //get successful orders
                $orders = $product->orders->where('status', 'completed');
                //iterate successful orders and make an array of users that have successful order on this product
                foreach ($orders as $order) {
                    $users[] = $order->user->id;
                }
            }

            // make array unique
            $users = array_unique($users);
            // attach users to channel
            $channel->users()->attach($users);
        } else {
            // attach all users to channel

            //get all user ids
            $users = User::pluck('id');
            //attach all users to channel
            $channel->users()->attach($users);
        }

        //import telegram chat export to channel
        if (isset($validData['json'])) {
            // upload json file
            $jsonFileName = uploader($request, 'json', 'channels/json');

            // get file path
            $path = public_path('channels/json/') . $jsonFileName;

            //decode json file
            $jsonMessages = json_decode(file_get_contents($path), true);

            //iterate uploaded json file
            foreach ($jsonMessages['messages'] as $jsonMessage) {
                if ($jsonMessage['type'] != 'service') {

                    //if message type was photo this "if" will run
                    if (isset($jsonMessage['photo'])) {
                        // create new channel message : type = photo
                        $message = $channel->messages()->create([
                            'text' => $jsonMessage['text'],
                            'created_at' => $jsonMessage['date'],
                            'type' => 'image'
                        ]);
                        //create new record in "channel_files" table
                        $message->file()->create([
                            'path' => '/channels/' . $jsonMessage['photo'],
                        ]);

                    } elseif (isset($jsonMessage['file'])) {  //if message type was file this "if" will run

                        //if message type was file and "media_type" was "voice_message" this "if" will run
                        if ((isset($jsonMessage['media_type'])) && ($jsonMessage['media_type'] == 'voice_message')) {

                            // create new channel message : type = voice
                            $message = $channel->messages()->create([
                                'text' => $jsonMessage['text'],
                                'created_at' => $jsonMessage['date'],
                                'type' => 'voice'
                            ]);

                            $message->file()->create([
                                'path' => '/channels/' . $jsonMessage['file'],
                                'caption' => $jsonMessage['text'],
                                'duration' => $jsonMessage['duration_seconds'],
                            ]);
                        } elseif (isset($jsonMessage['media_type']) && ($jsonMessage['media_type'] == 'video_file')) {

                            // create new channel message : type = video
                            $message = $channel->messages()->create([
                                'text' => $jsonMessage['text'],
                                'created_at' => $jsonMessage['date'],
                                'type' => 'video',
                            ]);

                            //if message type was file and "media_type" was "video_file" this "if" will run
                            $message->file()->create([
                                'path' => '/channels/' . $jsonMessage['file'],
                                'caption' => $jsonMessage['text'],
                                'duration' => $jsonMessage['duration_seconds'],
                            ]);
                        } else {
                            // create new channel message : type = file
                            $message = $channel->messages()->create([
                                'text' => $jsonMessage['text'],
                                'created_at' => $jsonMessage['date'],
                                'type' => 'file'
                            ]);

                            $message->file()->create([
                                'path' => '/channels/' . $jsonMessage['file'],
                            ]);


                        }

                    } else {
                        // create new channel message : type = text
                        $channel->messages()->create([
                            'text' => $jsonMessage['text'],
                            'created_at' => $jsonMessage['date'],
                            'type' => 'text'
                        ]);
                    }


                }

            }
        }

        alert()->success('کانال با موفقیت اضافه شد');
        return back();


    }


    public function get(Channel $channel , Request $request)
    {
        $messages = null;

        if ($channel->messages->count()) {
            foreach ($channel->messages as $message) {
                $hasFile = false;
                $filePath = null;
                $fileDuration = null;
                $fileHasCaption = false;
                $fileCaption = null;
                if (!is_null($message->file)) {
                    $hasFile = true;
                    $filePath = $message->file->path;
                    $fileDuration = $message->file->duration;
                    if ($message->file->caption != null) {
                        $fileHasCaption = true;
                        $fileCaption = $message->file->caption;
                    }
                }

                $messages[] = [
                    'id' => $message->id,
                    'has_file' => $hasFile,
                    'type' => $message->type,
                    'message' => $message->text,
                    'file' => [
                        'has_caption' => $fileHasCaption,
                        'path' => $filePath,
                        'duration' => $fileDuration,
                        'caption' => $fileCaption
                    ],
                    'views' => $message->views,
                    'user' => $message->user->first_name . ' ' . $message->user->last_name,
                    'date' => Verta::instance($message->created_at)->formatJalaliDate(),
                    'created_at' => $message->created_at
                ];
            }

        }

        $messagesCollection = collect($messages)
            ->sortByDesc('id')
            ->paginate(10 , null , $request->page);


        return response()->json([
            'channel' => [
                'id' => $channel->id,
                'avatar' => $channel->avatar,
                'title' => $channel->title,
                'desc' => $channel->description,
                'users' => $channel->users->count(),
            ],
            'messages' => $messagesCollection,
            'pages' => $messagesCollection->lastPage()
        ]);

    }

    // Get users
    public function getUsers(Channel $channel , Request $request)
    {
        // get users specified field
        $users = $channel->users->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->first_name,
                'lastname' => $item->last_name,
                'phone' => $item->phone
            ];
        });

        return response()->json([
            'page' => $request->page,
            'count' => $channel->users->count(),
            'description' => $channel->description,
            'users' => $users->paginate(50 , null , $request->page)
        ]);
    }

    public function deleteUser(Channel $channel , User $user)
    {
        try {
            $channel->users()->detach($user->id);
            return response()->json([
                'status' => 200,
                'count' => $channel->users->count()
            ]);
        }catch (\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'status' => 500,
                'message' => $ex->getMessage()
            ]);
        }

    }
}
