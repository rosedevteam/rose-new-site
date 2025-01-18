<?php

namespace Modules\Channel\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\traits\Upload;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Modules\Channel\Models\Channel;
use Modules\Channel\Models\Message;

class MessageController extends Controller
{
    use Upload;

    public function send(Request $request, Channel $channel)
    {
        try {
            $validData = $request->validate([
                'message_required' => 'nullable',
                'file' => 'nullable',
                'caption' => 'nullable',
                'voice' => 'nullable',
                'message' => 'required_if:message_required,==,true',
            ]);

            $filePath = null;
            $isFile = 0;
            $type = 'text';

            if ($validData['voice'] == 'true') {
                $mime = pathinfo($validData['file']->getClientOriginalName(), PATHINFO_EXTENSION);
                $type = 'voice';

                $filePath = '/uploads/' . $this->uploadFile($request['file'], $channel->id . '/voices');;
            } else {
                if (isset($validData['file'])) {
                    $mime = pathinfo($validData['file']->getClientOriginalName(), PATHINFO_EXTENSION);
                    $isFile = 1;
                    if (($mime == 'png') || ($mime == 'jpg') || ($mime == 'jpeg')) {
                        $type = 'image';
                        $folder = 'images';
                    } elseif (($mime == 'mp4') || ($mime == 'mpeg4')) {
                        $type = 'video';
                        $folder = 'videos';
                    } else {
                        $type = 'file';
                        $folder = 'files';
                    }

                    $filePath = '/uploads/' . $this->uploadFile($request['file'], $channel->id . "/$folder");
                }
            }
            $message = $channel->messages()->create([
                'user_id' => auth()->user()->id,
                'text' => $validData['message'],
                'views' => 0,
                'type' => $type
            ]);

            if (isset($validData['file'])) {
                $message->file()->create([
                    'path' => $filePath,
                    'caption' => $validData['caption'],
                    'mime_type' => $mime
                ]);
            }

            if (!isset($validData['caption'])) {
                $validData['caption'] = null;
            }


            if ($validData['voice'] == 'true') {
                $validData['voice'] = 1;
            } else {
                $validData['voice'] = 0;
            }


            return response()->json([
                'status' => 200,
                'isVoice' => $validData['voice'],
                'isFile' => $isFile,
                'file' => $filePath,
                'type' => $type,
                'caption' => $validData['caption'],
                'id' => $message->id,
                'voice' => $validData['voice'],
                'message' => $message->text,
                'avatar' => $channel->avatar,
                'date' => Verta::instance($message->created_at)->formatJalaliDate(),
                'user' => $message->user->first_name . ' ' . $message->user->last_name
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ]);
        }


    }

    public function updateMessage(Message $message, Request $request)
    {
        try {
            $message->update([
                'text' => $request->message
            ]);
            return response()->json([
                'status' => 200,
                'id' => $message->id,
                'message' => $message->text
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ]);
        }

    }

    public function delete(Message $message)
    {
        try {
            $message->delete();
            return response()->json([
                'status' => 200
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ]);
        }
    }
}
