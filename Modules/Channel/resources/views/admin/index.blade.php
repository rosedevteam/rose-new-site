@extends('admin::layouts.main')

@push('css')

    <link rel="stylesheet" href="/assets/admin/vendor/libs/plyr/plyr.css">
    <link rel="stylesheet" href="/assets/admin/vendor/css/pages/app-chat.css">
    <link rel="stylesheet" href="/assets/admin/vendor/libs/sweetalert2/sweetalert2.css">
    <link rel="stylesheet" href="/assets/admin/vendor/libs/dropzone/dropzone.css">
@endpush

@section('content')
    <div class="content-wrapper">
        <div class="flex-grow-1 p-3y">
            <div class="app-chat card overflow-hidden">
                <div class="row g-0">

                    <!-- Chat & Contacts -->
                    <div class="col app-chat-contacts app-sidebar flex-grow-0 overflow-hidden border-end"
                         id="app-chat-contacts">
                        <div class="sidebar-body">
                            <!-- Chats -->
                            <ul class="list-unstyled chat-contact-list" id="chat-list">
                                <li class="chat-contact-list-item chat-contact-list-item-title">
                                    <h5 class="text-primary mb-0 secondary-font">کانال ها</h5>
                                </li>
                                <li class="chat-contact-list-item chat-list-item-0 d-none">
                                    <h6 class="text-muted mb-0">گفتگویی پیدا نشد</h6>
                                </li>
                                @foreach($channels as $channel)
                                    <li class="chat-contact-list-item" onclick="getChannel({{$channel->id}})">
                                        <a class="d-flex align-items-center">

                                            <div class="flex-shrink-0 avatar">

                                                @if($channel->avatar)
                                                    <img class="avatar-initial rounded-circle bg-label-success" alt=""
                                                         src="/uploads/{{$channel->avatar}}">
                                                @else
                                                    <span
                                                        class="avatar-initial rounded-circle bg-label-success">کانال</span>
                                                @endif

                                            </div>
                                            <div class="chat-contact-info flex-grow-1 ms-3">
                                                <h6 class="chat-contact-name text-truncate m-0">
                                                    {{$channel->title}}
                                                </h6>
                                                <p class="chat-contact-status text-truncate mb-0 text-muted">
                                                    {{$channel->description}}
                                                </p>
                                                @can('view-channel-members-count')
                                                    <p class="chat-contact-status text-truncate mb-0 text-muted">
                                                        {{$channel->users->count()}}
                                                        عضو
                                                    </p>
                                                @else
                                                    <p class="chat-contact-status text-truncate mb-0 text-muted">
                                                        189
                                                        عضو
                                                    </p>
                                                @endcan
                                                <small>
                                                    {{--                                            {{$ticket->department->title}}--}}
                                                    {{--                                            @if($ticket->is_seen == 0)--}}
                                                    {{--                                                <span class="badge bg-info">--}}
                                                    {{--                                                   جدید--}}
                                                    {{--                                                </span>--}}
                                                    {{--                                            @endif--}}
                                                    {{--                                            @if($ticket->replies->where('is_user' , 1)->where('is_seen' , 0)->count())--}}
                                                    {{--                                                <span class="badge badge-center rounded-pill bg-primary">--}}
                                                    {{--                                                    {{$ticket->replies->where('is_user' , 1)->where('is_seen' , 0)->count()}}--}}
                                                    {{--                                                </span>--}}
                                                    {{--                                            @endif--}}
                                                </small>
                                            </div>
                                            <small
                                                class="text-muted mb-auto">{{\Hekmatinasser\Verta\Verta::instance($channel->updated_at)->formatJalaliDate()}}</small>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                        </div>
                    </div>
                    <!-- /Chat contacts -->

                    <!-- Chat History -->
                    <div class="col app-chat-history bg-body">

                        <div class="chat-wrapper-ts">
                            <div class="d-lg-none">
                                @foreach($channels as $c)
                                    <li class="chat-contact-list-item" onclick="getChannel({{$c->id}})">
                                        <a class="d-flex align-items-center">

                                            <div class="flex-shrink-0 avatar">

                                                @if($c->avatar)
                                                    <img class="avatar-initial rounded-circle bg-label-success" alt=""
                                                         src="{{$c->avatar}}">
                                                @else
                                                    <span
                                                        class="avatar-initial rounded-circle bg-label-success">کانال</span>
                                                @endif

                                            </div>
                                            <div class="chat-contact-info flex-grow-1 ms-3">
                                                <h6 class="chat-contact-name text-truncate m-0">
                                                    {{$c->title}}
                                                </h6>
                                                <p class="chat-contact-status text-truncate mb-0 text-muted">
                                                    {{$c->description}}
                                                </p>
                                                @can('view-channel-members-count')
                                                    <p class="chat-contact-status text-truncate mb-0 text-muted">
                                                        {{$c->users->count()}}
                                                        عضو
                                                    </p>
                                                @else
                                                    <p class="chat-contact-status text-truncate mb-0 text-muted">
                                                        187
                                                        عضو
                                                    </p>
                                                @endcan
                                                <small>
                                                    {{--                                            {{$ticket->department->title}}--}}
                                                    {{--                                            @if($ticket->is_seen == 0)--}}
                                                    {{--                                                <span class="badge bg-info">--}}
                                                    {{--                                                   جدید--}}
                                                    {{--                                                </span>--}}
                                                    {{--                                            @endif--}}
                                                    {{--                                            @if($ticket->replies->where('is_user' , 1)->where('is_seen' , 0)->count())--}}
                                                    {{--                                                <span class="badge badge-center rounded-pill bg-primary">--}}
                                                    {{--                                                    {{$ticket->replies->where('is_user' , 1)->where('is_seen' , 0)->count()}}--}}
                                                    {{--                                                </span>--}}
                                                    {{--                                            @endif--}}
                                                </small>
                                            </div>
                                            <small
                                                class="text-muted mb-auto">{{\Hekmatinasser\Verta\Verta::instance($c->updated_at)->formatJalaliDate()}}</small>
                                        </a>
                                    </li>
                                @endforeach
                            </div>
                            <div class="alert alert-solid-dark mb-0 m-3" role="alert">
                                <h6 class="alert-heading mb-1"> {{auth()->user()->name()}}
                                    عزیز
                                    سلام، خدا قوت! </h6>
                                برای مشاهده پیام های کانال، روی یکی از کانال هایی که عضو هستید کلیک کنید...
                            </div>
                        </div>

                        <!-- Chat message form -->
                        <div class="chat-history-footer shadow-sm">

                            <form class="form-send-message d-flex justify-content-between align-items-center"
                                  method="post"
                                  data-form-mode="chat"
                                  enctype="multipart/form-data">
                                <input name="message"
                                       class="form-control autosize message-text message-input border-0 me-3 shadow-none"
                                       placeholder="پیام خود را اینجا بنویسید" autocomplete="off">
                                <input type="hidden" id="channel_id">
                                <div class="message-actions align-items-center ">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-paperclip bx-sm cursor-pointer mx-3" id="attach-file"
                                           data-bs-toggle="modal" data-bs-target="#uploadModal"></i>
                                        {{--upload modal--}}
                                        <div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title secondary-font" id="modalCenterTitle">
                                                            آپلود
                                                            فایل</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="fallback">
                                                            <input type="file" class="form-control" name="file1"
                                                                   id="file1">
                                                        </div>

                                                        <textarea name="file_caption" id="file_caption" cols="30"
                                                                  rows="5"
                                                                  placeholder="کپشن (دلخواه)"
                                                                  class="form-control mt-3"></textarea>

                                                        <div class="progress mt-5">
                                                            <div class="progress-bar progress-bar-striped bg-success"
                                                                 id="uploaderProgress" role="progressbar"
                                                                 aria-valuenow="0"
                                                                 aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button"
                                                                class="btn btn-label-secondary cancelUpload"
                                                                data-bs-dismiss="modal">
                                                            بستن
                                                        </button>
                                                        <button type="button" class="btn btn-primary"
                                                                onclick="sendFile()"
                                                                id="sendFileButton">ارسال
                                                            فایل
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="me-3 d-flex align-items-center recorder-box">
                                            <audio id="recorder" muted hidden></audio>
                                            <div class="d-flex align-items-center recorder-wrapper">
                                                <a type="button" id="start">
                                                    <i class="bx bx-microphone bx-sm"></i>
                                                </a>
                                                <div id="is-recording-text" class="mb-0" style="width: 50px;">
                                                    <div class="d-flex align-items-center">
                                                        <div class="display">
                                                            <span class="minutes">00</span>:<span
                                                                class="seconds">00</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a type="button" id="stop">
                                                    <i class="bx bx-stop bx-sm mx-3"></i>
                                                </a>
                                                <a type="button" id="trash">
                                                    <i class="bx bx-trash bx-sm mx-3 text-danger"></i>
                                                </a>
                                            </div>
                                            <div class="play-before-send w-100">
                                                <audio id="plyr-audio-player" controls></audio>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary d-flex send-msg-btn">
                                            <i class="bx bx-paper-plane me-md-1 me-0"></i>
                                            <span class="align-middle d-md-inline-block d-none">ارسال</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="edit-message-wrapper align-items-center" style="display: none">
                                    <div class="d-flex align-items-center">
                                        <div class="dismiss-edit">
                                            <a type="button" class="me-3" onclick="dismissEdit()">
                                                <i class='bx bx-x'></i>
                                            </a>
                                        </div>
                                        <button class="btn btn-primary d-flex edit-msg-btn" data-message-id="">
                                            <i class="bx bx-paper-plane me-md-1 me-0"></i>
                                            <span class="align-middle d-md-inline-block d-none">ویرایش</span>
                                        </button>
                                    </div>

                                </div>
                            </form>

                            <div id="end-of-chat"></div>
                        </div>
                    </div>
                    <!-- /Chat History -->
                    <!-- Share Project Modal -->
                    @can('view-channel-members-count')
                        <div class="modal fade" id="channelDetails" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-simple modal-enable-otp modal-dialog-centered">
                                <div class="modal-content p-3 p-md-5">
                                    <div class="modal-body">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        <div class="text-center mt-0 mt-md-n2">
                                            <h3 class="mb-2 secondary-font">جزئیات کانال</h3>
                                            <small id="channelDescription"></small>
                                        </div>
                                    </div>
                                    <h4 class="mb-4 pb-2" id="channelUsersCount"></h4>
                                    <ul class="p-0 m-0 overflow-auto h-px-500" id="channelUsersList">

                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endcan

                    <!--/ Share Project Modal -->
                    <div class="app-overlay"></div>

                </div>
            </div>
        </div>
    </div>
@stop

@push('script')
    <script src="/assets/admin/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.js"></script>
    <script src="/assets/admin/vendor/libs/dropzone/dropzone.js"></script>
    <!-- Vendors JS -->
    <script src="/assets/admin/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script src="/assets/admin/vendor/libs/plyr/plyr.js"></script>
    <script src="/assets/admin/js/extended-ui-media-player.js"></script>
    <script src="/assets/admin/vendor/libs/block-ui/block-ui.js"></script>
    <script src="/assets/admin/js/channel/channel.js"></script>
    {{--    <script src="/admin/assets/js/ticket/send-reply.js"></script>--}}
@endpush
