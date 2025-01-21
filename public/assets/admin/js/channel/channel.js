//get ticket details
$('.chat-history-footer').hide()
const minutes = document.querySelector('.minutes');
const seconds = document.querySelector('.seconds');

const adminPrefix = $("meta[name='admin-prefix']").attr("content");

let startTime;
let interval;

function start() {
    startTime = Date.now();
    interval = setInterval(updateDisplay, 10);
}

function stop() {
    clearInterval(interval);
}

function reset() {
    clearInterval(interval);
    minutes.textContent = '00';
    seconds.textContent = '00';
}

function updateDisplay() {
    const elapsedTime = Date.now() - startTime;
    const minutesValue = Math.floor(elapsedTime / 60000);
    const secondsValue = Math.floor((elapsedTime - (minutesValue * 60000)) / 1000);

    minutes.textContent = minutesValue < 10 ? '0' + minutesValue : minutesValue;
    seconds.textContent = secondsValue < 10 ? '0' + secondsValue : secondsValue;
}

class VoiceRecorder {
    constructor() {
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            console.log("getUserMedia supported")
        } else {
            console.log("getUserMedia is not supported on your browser!")
        }

        this.mediaRecorder
        this.stream
        this.blob
        this.chunks = []
        this.isRecording = false

        this.recorderRef = document.querySelector("#recorder")
        this.playerRef = document.querySelector("#plyr-audio-player")
        this.playerRefWrapper = document.querySelector(".play-before-send")
        this.startRef = document.querySelector("#start")
        this.stopRef = document.querySelector("#stop")
        this.trashRef = document.querySelector("#trash")
        this.isRecordingText = document.querySelector("#is-recording-text")
        this.sendMsg = document.querySelector(".send-msg-btn")
        this.messageBox = document.querySelector(".message-text")
        this.messageActions = document.querySelector(".message-actions")
        this.recorderBox = document.querySelector(".recorder-box")
        this.attachFile = document.querySelector('#attach-file')

        this.startRef.onclick = this.startRecording.bind(this)
        this.stopRef.onclick = this.stopRecording.bind(this)
        this.trashRef.onclick = this.trash.bind(this)

        this.stopRef.style.display = 'none';
        this.playerRefWrapper.style.display = 'none';
        this.trashRef.style.display = 'none';
        this.isRecordingText.style.display = 'none';
        this.constraints = {
            audio: true,
            video: false
        }

    }

    handleSuccess(stream) {
        this.stream = stream
        this.recorderRef.srcObject = this.stream
        this.mediaRecorder = new MediaRecorder(this.stream)
        this.mediaRecorder.ondataavailable = this.onMediaRecorderDataAvailable.bind(this)
        this.mediaRecorder.onstop = this.onMediaRecorderStop.bind(this)
        this.recorderRef.play()
        this.mediaRecorder.start()
    }

    handleError(error) {
        console.log("navigator.getUserMedia error: ", error)
    }

    onMediaRecorderDataAvailable(e) {
        this.chunks.push(e.data)
    }

    onMediaRecorderStop(e) {
        const blob = new Blob(this.chunks, {'type': 'audio/ogg; codecs=opus'})
        const audioURL = window.URL.createObjectURL(blob)
        this.playerRef.src = audioURL
        this.chunks = []
        this.stream.getAudioTracks().forEach(track => track.stop())
        this.stream = null
        this.blob = blob;
    }

    startRecording() {
        start()
        if (this.isRecording) return
        this.isRecording = true
        this.startRef.innerHTML = ''
        this.isRecordingText.style.display = 'block'
        this.playerRef.src = ''
        this.playerRefWrapper.style.display = 'none'
        this.stopRef.style.display = 'contents'
        this.trashRef.style.display = 'contents'
        this.messageBox.style.display = 'none'
        this.recorderBox.classList.add('w-100')
        this.messageActions.classList.add('w-100')
        this.sendMsg.setAttribute('disabled', true)
        this.attachFile.style.display = 'none';
        navigator.mediaDevices
            .getUserMedia(this.constraints)
            .then(this.handleSuccess.bind(this))
            .catch(this.handleError.bind(this))
    }

    stopRecording() {
        stop()
        if (!this.isRecording) return
        this.isRecording = false
        this.startRef.innerHTML = '<i class="bx bx-microphone bx-sm"></i>'
        this.playerRefWrapper.style.display = 'block'
        this.isRecordingText.style.display = 'none'
        this.sendMsg.removeAttribute('disabled')
        this.recorderRef.pause()
        this.mediaRecorder.stop()
        this.stopRef.style.display = 'none'
    }

    trash() {
        reset()
        this.blob = null;
        this.isRecording = false
        this.recorderRef.pause()
        this.attachFile.style.display = 'block';
        this.messageBox.style.display = 'block'
        if (this.mediaRecorder != null) {
            this.mediaRecorder.stop()
            if (this.stream != null) {
                this.stream.getAudioTracks().forEach(track => track.stop())

            }
        }

        this.stream = null
        this.chunks = []
        this.startRef.innerHTML = '<i class="bx bx-microphone bx-sm"></i>'
        this.playerRefWrapper.style.display = 'none'
        this.stopRef.style.display = 'none'
        this.trashRef.style.display = 'none'
        this.isRecordingText.style.display = 'none'
        this.recorderBox.classList.remove('w-100')
        this.messageActions.classList.remove('w-100')
        this.playerRef.src = ''
        this.sendMsg.removeAttribute('disabled')
    }

    exportBlob() {
        return this.blob
    }

}

window.voiceRecorder = new VoiceRecorder()
// active li
let chatContactListItems = [].slice.call(
    document.querySelectorAll('.chat-contact-list-item:not(.chat-contact-list-item-title)')
)
// Select chat or contact
chatContactListItems.forEach(chatContactListItem => {
    // Bind click event to each chat contact list item
    chatContactListItem.addEventListener('click', e => {
        // Remove active class from chat contact list item
        chatContactListItems.forEach(chatContactListItem => {
            chatContactListItem.classList.remove('active');
        });
        // Add active class to current chat contact list item
        e.currentTarget.classList.add('active');
    });
});

let channelMessagesPage = 1;
function getChannel(id) {
    channelMessagesPage = 1;
    const getChannelRequest = axios.create();
    getChannelRequest.interceptors.request.use(function (config) {
        // Spinner
        $('.app-chat-history').block({
            message:
                '<div class="sk-wave mx-auto"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div>',
            timeout: 1000,
            css: {
                backgroundColor: 'transparent',
                border: '0'
            },
            overlayCSS: {
                opacity: 0.5
            }
        });
        return config
    });

    getChannelRequest.get(`/${adminPrefix}/channels/get/${id}`, {
        params: {
            page : channelMessagesPage
        }
    })
        .then(function (response) {
            // transfer user to end of chat section after sending message
            $('#sendFileButton').attr('onclick', `sendFile(${id})`)
            let chatHistory = '';
            let file = '';
            let badge = 'کانال';
            if (response.data.channel.avatar != null) {
                badge = `<img class="avatar-initial rounded-circle bg-label-success" src="${response.data.channel.avatar}">`;
            }
            if (response.data.messages.data != null) {
                for (const message of response.data.messages.data.reverse()) {
                    let caption = '';
                    if (message.has_file == true) {
                        if (message.file.has_caption == true) {
                            caption = `<p class="mt-1 mb-0 p-2">${message.file.caption}</p>`
                        }
                        if (message.type == 'image') {
                            file = `
                            <div class="chat-message-text p-0" data-reply-id="${message.id}">
                                <a href="${message.file.path}" target="_blank">
                                     <img src="${message.file.path}" class="w-100">
                                </a>
                                 ${caption}
                            </div>
                                    <div class="text-end text-muted mt-1">
                                            <small>${message.date}</small>
                                        </div>
                                        <a href="javascript:void(0);" onclick="removeMessage(${message.id})" style="right: -1.5rem;"  class="edit-message text-dark">
                                        <i class="bx bx-trash"></i>
                                        </a>
`
                        } else if (message.type == 'voice') {
                            file = `
                            <div class="chat-message-text" data-reply-id="${message.id}">
                                    <audio controls>
                                        <source src="${message.file.path}">
                                    </audio>
                                    ${caption}
                            </div>
 <div class="text-end text-muted mt-1">
                                            <small>${message.date}</small>
                                        </div>

                                           <a href="javascript:void(0);" onclick="removeMessage(${message.id})" style="right: -1.5rem;"  class="edit-message text-dark">
                                        <i class="bx bx-trash"></i>
                                        </a>

`
                        } else if (message.type == 'video') {
                            file = `
                                <div class="chat-message-text p-0" data-reply-id="${message.id}">
                                    <video controls width="100%">
                                        <source src="${message.file.path}">
                                    </video>
                                    ${caption}
                                </div>
                                    <div class="text-end text-muted mt-1">
                                            <small>${message.date}</small>
                                        </div>
                                           <a href="javascript:void(0);" onclick="removeMessage(${message.id})" style="right: -1.5rem;"  class="edit-message text-dark">
                                        <i class="bx bx-trash"></i>
                                        </a>
`
                        } else if (message.type == 'file') {
                            file = `
                        <div class="chat-message-text" data-reply-id="${message.id}">
                            <a href="${message.file.path}" class="btn btn-primary" target="_blank">
                            دانلود فایل
                            <i class="bx bx-download ms-2"></i>
                            </a>
                            ${caption}
                        </div>
                                <div class="text-end text-muted mt-1">
                                            <small>${message.date}</small>
                                        </div>
                                           <a href="javascript:void(0);" onclick="removeMessage(${message.id})" style="right: -1.5rem;"  class="edit-message text-dark">
                                        <i class="bx bx-trash"></i>
                                        </a>
`
                        }


                        chatHistory += ` <li class="chat-message chat-message-right " data-reply-id="${message.id}">
                                <div class="d-flex" style="max-width: 50%">

                                    <div class="chat-message-wrapper flex-grow-1 position-relative">
                                            ${file}
                                    </div>
                                       <div class="user-avatar flex-shrink-0 ms-3">
                                        <div class="flex-shrink-0 avatar"><span
                                                class="avatar-initial rounded-circle bg-label-success">${badge}</span></div>
                                    </div>
                                </div>
                            </li>`

                    } else {
                        chatHistory += ` <li class="chat-message chat-message-right" data-reply-id="${message.id}">
                                <div class="d-flex">

                                    <div class="chat-message-wrapper flex-grow-1 position-relative">
                                        <div class="chat-message-text">
                                             <p class="m-0">${message.message}</p>
                                        </div>
                                        <div class="text-end text-muted mt-1">
                                            <small>${message.date}</small>
                                        </div>
                                         <form action="" method="post" id="editMessage${message.id}">
                                            <input type="hidden" name="_token" value="${$('#csrf').attr('content')}">
                                            <input type="hidden" name="_method" value="patch">
                                        </form>
                                        <div class="d-flex">
                                           <a href="javascript:void(0);" onclick="removeMessage(${message.id})" style="right: -1.5rem;"  class="edit-message text-dark">
                                        <i class="bx bx-trash"></i>
                                        </a>
                                        <a href="javascript:void(0);" onclick="showUpdateBox(${message.id})"  class="edit-message text-dark">
                                        <i class="bx bx-pencil"></i>
                                        </a>
</div>
                                    </div>
                                     <div class="user-avatar flex-shrink-0 ms-3">
                                        <div class="flex-shrink-0 avatar"><span
                                                class="avatar-initial rounded-circle bg-label-success">${badge}</span></div>
                                    </div>
                                </div>
                            </li>`
                    }


                }
            }
            $('.chat-wrapper-ts').html(`
                <div class="chat-history-wrapper">
                    <div class="chat-history-header border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex overflow-hidden align-items-center">
                                <i class="bx bx-menu bx-sm cursor-pointer d-lg-none d-block me-2" data-bs-toggle="sidebar"  data-target="#app-chat-contacts"></i>
                                <div class="flex-shrink-0 avatar" data-bs-toggle="modal" id="channelDetailsButton" data-bs-target="#channelDetails" onclick="showChannelDetails(${response.data.channel.id})">
                                    <img src="${response.data.channel.avatar}" alt="">
                                </div>
                                <div class="chat-contact-info flex-grow-1 ms-3">
                                    <h6 class="m-0">${response.data.channel.title}</h6>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="chat-history-body bg-body" onscroll="loadMoreMessages($(this) , ${response.data.pages})">
                        <ul class="list-unstyled chat-history mb-0">

                            ${chatHistory}
                            <div class="new-messages">

                            </div>
                        </ul>
                    </div>

                </div>
`);
            $('.chat-history-footer').show();
            $('#channel_id').val(id)

            //scroll to bottom of messages
            $(".chat-history-body").animate({ scrollTop: $(".chat-history-body")[0].scrollHeight}, 100);
        })

}

function loadMoreMessages(e , pages) {
    let channelId = $('#channel_id').val()
    if (channelMessagesPage != pages) {
        if (e.scrollTop() === 0) {
            channelMessagesPage++
            const getChannelMessagesListRequest = axios.create();
            // before ajax request this section clear the message input value
            getChannelMessagesListRequest.interceptors.request.use(function (config) {
                $('.app-chat-history').block({
                    message:
                        '<div class="sk-wave mx-auto"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div>',
                    timeout: 1000,
                    css: {
                        backgroundColor: 'transparent',
                        border: '0'
                    },
                    overlayCSS: {
                        opacity: 0.5
                    }
                });
                return config
            });
            getChannelMessagesListRequest.get(`/${adminPrefix}/channels/get/${channelId}`, {
                params: {
                    page: channelMessagesPage
                }
            })
                .then(function (response) {
                    let scrollAfterLoadItem = e.children().children(':first');
                    let chatHistory = '';
                    let file = '';
                    let badge = 'کانال';
                    if (response.data.channel.avatar != null) {
                        badge = `<img class="avatar-initial rounded-circle bg-label-success" src="${response.data.channel.avatar}">`;
                    }
                    if (response.data.messages.data != null) {
                        for (const message of response.data.messages.data.reverse()) {
                            let caption = '';
                            if (message.has_file == true) {
                                if (message.file.has_caption == true) {
                                    caption = `<p class="mt-1 mb-0 p-2">${message.file.caption}</p>`
                                }
                                if (message.type == 'image') {
                                    file = `
                            <div class="chat-message-text p-0" data-reply-id="${message.id}">
                                <a href="${message.file.path}" target="_blank">
                                     <img src="${message.file.path}" class="w-100">
                                </a>
                                 ${caption}
                            </div>
                                    <div class="text-end text-muted mt-1">
                                            <small>${message.date}</small>
                                        </div>
                                        <a href="javascript:void(0);" onclick="removeMessage(${message.id})" style="right: -1.5rem;"  class="edit-message text-dark">
                                        <i class="bx bx-trash"></i>
                                        </a>
`
                                } else if (message.type == 'voice') {
                                    file = `
                            <div class="chat-message-text" data-reply-id="${message.id}">
                                    <audio controls>
                                        <source src="${message.file.path}">
                                    </audio>
                                    ${caption}
                            </div>
 <div class="text-end text-muted mt-1">
                                            <small>${message.date}</small>
                                        </div>

                                           <a href="javascript:void(0);" onclick="removeMessage(${message.id})" style="right: -1.5rem;"  class="edit-message text-dark">
                                        <i class="bx bx-trash"></i>
                                        </a>

`
                                } else if (message.type == 'video') {
                                    file = `
                                <div class="chat-message-text p-0" data-reply-id="${message.id}">
                                    <video controls width="100%">
                                        <source src="${message.file.path}">
                                    </video>
                                    ${caption}
                                </div>
                                    <div class="text-end text-muted mt-1">
                                            <small>${message.date}</small>
                                        </div>
                                           <a href="javascript:void(0);" onclick="removeMessage(${message.id})" style="right: -1.5rem;"  class="edit-message text-dark">
                                        <i class="bx bx-trash"></i>
                                        </a>
`
                                } else if (message.type == 'file') {
                                    file = `
                        <div class="chat-message-text" data-reply-id="${message.id}">
                            <a href="${message.file.path}" class="btn btn-primary" target="_blank">
                            دانلود فایل
                            <i class="bx bx-download ms-2"></i>
                            </a>
                            ${caption}
                        </div>
                                <div class="text-end text-muted mt-1">
                                            <small>${message.date}</small>
                                        </div>
                                           <a href="javascript:void(0);" onclick="removeMessage(${message.id})" style="right: -1.5rem;"  class="edit-message text-dark">
                                        <i class="bx bx-trash"></i>
                                        </a>
`
                                }


                                chatHistory += ` <li class="chat-message chat-message-right " data-reply-id="${message.id}">
                                <div class="d-flex" style="max-width: 50%">

                                    <div class="chat-message-wrapper flex-grow-1 position-relative">
                                            ${file}
                                    </div>
                                       <div class="user-avatar flex-shrink-0 ms-3">
                                        <div class="flex-shrink-0 avatar"><span
                                                class="avatar-initial rounded-circle bg-label-success">${badge}</span></div>
                                    </div>
                                </div>
                            </li>`

                            } else {
                                chatHistory += ` <li class="chat-message chat-message-right" data-reply-id="${message.id}">
                                <div class="d-flex">

                                    <div class="chat-message-wrapper flex-grow-1 position-relative">
                                        <div class="chat-message-text">
                                             <p class="m-0">${message.message}</p>
                                        </div>
                                        <div class="text-end text-muted mt-1">
                                            <small>${message.date}</small>
                                        </div>
                                         <form action="" method="post" id="editMessage${message.id}">
                                            <input type="hidden" name="_token" value="${$('#csrf').attr('content')}">
                                            <input type="hidden" name="_method" value="patch">
                                        </form>
                                        <div class="d-flex">
                                           <a href="javascript:void(0);" onclick="removeMessage(${message.id})" style="right: -1.5rem;"  class="edit-message text-dark">
                                        <i class="bx bx-trash"></i>
                                        </a>
                                        <a href="javascript:void(0);" onclick="showUpdateBox(${message.id})"  class="edit-message text-dark">
                                        <i class="bx bx-pencil"></i>
                                        </a>
</div>
                                    </div>
                                     <div class="user-avatar flex-shrink-0 ms-3">
                                        <div class="flex-shrink-0 avatar"><span
                                                class="avatar-initial rounded-circle bg-label-success">${badge}</span></div>
                                    </div>
                                </div>
                            </li>`
                            }


                        }
                    }
                    $('.chat-history-body .list-unstyled').prepend(`${chatHistory}`);
                    $('.chat-history-footer').show();
                    e.animate({ scrollTop: scrollAfterLoadItem.offset().top - 300}, 100)
                })
        }
    }

}


let formSendMessage = $('.form-send-message');
let chatContainer = $('.chat-history-body');
//send message
formSendMessage.on('submit', function (e) {
    e.preventDefault();
    //we have 2 form modes : chat is default mode and edit mode activates when user wants to update a message
    let formMode = formSendMessage.attr('data-form-mode')
    //checks form mode
    if (formMode === 'chat') {
        //create form data to send it to server
        let formData = new FormData();
        // new messages will show in this section
        let newMessageBox = $('.new-messages');
        // get user message input
        let message = $('.form-send-message .message-text')

        formData.append('message_required', true)

        // append user message to form data
        formData.append('message', message.val());
        //get ticket id
        let channelId = $('#channel_id').val()
        // set voice variable to false : if user wants to send voice message this variable changes to true
        let voice = false
        // if user wants to send voice message this variable fills with recorded file
        let file = ''
        // append voice variable to form data
        formData.append('voice', voice);

        // if user record voice message this section will run
        if (window.voiceRecorder.exportBlob() != null) {

            // set message input to null
            message.val('')
            // set voice variable to true
            voice = true;
            // get recorder file
            file = window.voiceRecorder.exportBlob()
            // append recorded file to form data
            formData.append('file', file, 'record.ogg');
            // append voice variable to form data
            formData.append('voice', voice);
            formData.append('message_required', false)
            formData.append('caption', '')
        }

        let csrf = $('#csrf').attr('content')
        //before ajax request this section clear the message input value
        axios.interceptors.request.use(function (config) {
            message.val('')
            return config
        });
        // send ajax request to server and show result in chat section
        axios.post(`channel/post/${channelId}`, formData)
            .then(function (response) {
                // if server request was successful
                if (response.data.status == 200) {
                    // if request was not voice
                    if (voice == false) {
                        voice = false
                        // append new message to chat and show it to user
                        newMessageBox.append(
                            `<li class="chat-message chat-message-right" data-reply-id="${response.data.id}">
                                <div class="d-flex ">
                                    <div class="chat-message-wrapper position-relative flex-grow-1">
                                        <div class="chat-message-text">
                                            <p class="mb-0">${response.data.message}</p>
                                        </div>
                                        <div class="d-flex">
                                        <div class="text-muted mt-1 sending">
                                           <small><i class="bx bx-time"></i></small>

                                        </div>
                                        <div class="text-end text-muted mt-1 ms-2">
                                            <small> ${response.data.date}</small>
                                        </div>
                                        </div>
                                        <form action="ticket/reply/edit/${response.data.id}" method="post" id="editMessage${response.data.id}">
                                            <input type="hidden" name="_token" value="${$('#csrf').attr('content')}">
                                            <input type="hidden" name="_method" value="patch">
                                        </form>
                                        <a href="javascript:void(0);" onclick="removeMessage(${response.data.id})" style="right: -1.5rem;"  class="edit-message text-dark">
                                             <i class="bx bx-trash"></i>
                                        </a>
                                        <a href="javascript:void(0);" onclick="showUpdateBox(${response.data.id})"  class="edit-message text-dark">
                                             <i class="bx bx-pencil"></i>
                                        </a>
                                    </div>
                                        <div class="user-avatar flex-shrink-0 ms-3">
                                        <div class="flex-shrink-0 avatar">
                                        <img class="avatar-initial rounded-circle bg-label-success" src="${response.data.avatar}">
                                        </div>
                                    </div>
                                </div>
                            </li>`
                        );
                        // set message input to null after sending message
                        message.val('')
                        // transfer user to end of chat section after sending message
                        let chatHistoryBody = document.querySelector('.chat-history-body');
                        chatHistoryBody.scrollTo(0, chatHistoryBody.scrollHeight);
                    }
                    // if user wants to send voice message
                    if (voice == true) {
                        // get recorded url to show it in chat after user send a voice message
                        audioSrc = window.URL.createObjectURL(file)
                        console.log(audioSrc)

                        // stop recording after send
                        window.voiceRecorder.stopRecording()
                        // remove voice message
                        window.voiceRecorder.trash()
                        // append new voice message to chat and show it to user
                        newMessageBox.append(
                            `<li class="chat-message chat-message-right">
                                <div class="d-flex">

                                    <div class="chat-message-wrapper flex-grow-1 position-relative">
                                        <div class="chat-message-text">
                                            <audio controls class="rose-audio">
                                            <source src="${audioSrc}">
                                        </audio>
                                        </div>
                                        <div class="text-muted mt-1 sending">
                                           <small><i class="bx bx-time"></i></small>
                                        </div>

                                         <div class="d-flex">
                                           <a href="javascript:void(0);" onclick="removeMessage(${response.data.id})" class="edit-message text-dark">
                                        <i class="bx bx-trash"></i>
                                        </a>
                                         </div>
                                    </div>
<div class="user-avatar flex-shrink-0 ms-3">
                                        <div class="flex-shrink-0 avatar">
                                        <img class="avatar-initial rounded-circle bg-label-success" src="${response.data.avatar}">
                                        </div>
                                    </div>
                                </div>
                            </li>`
                        );
                        $(".chat-history-body").animate({ scrollTop: $(".chat-history-body")[0].scrollHeight}, 100);
                    }
                    let sentMessage = $('.new-messages .chat-message .d-flex .chat-message-wrapper .sending');
                    sentMessage.removeClass('sending');
                    sentMessage.html(
                        `<small><i class="bx bx-check-double"></i></small>`
                    );
                    voice = false
                }
            });
    } else { //if user wants to edit a message
        // submit form after edit message
        let editMessageBtn = $('.edit-msg-btn');
        // message input
        let messageBox = $('.form-send-message .message-text');
        // setup ajax request
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('#csrf').attr('content'),
                'Content-Type': 'application/json'
            }
        });

        $.ajax({
            type: 'patch',
            data: JSON.stringify({
                id: editMessageBtn.attr('data-message-id'),
                message: messageBox.val()
            }),
            url: `ticket/reply/edit/${editMessageBtn.attr('data-message-id')}`,
            complete: function (response) {
                if (response.responseJSON.status == 200) {
                    let chatMessageBox = $(`li[data-reply-id="${response.responseJSON.id}"] .chat-message-text p`);
                    chatMessageBox.html(response.responseJSON.message)
                    dismissEdit()
                }
            }
        })
    }
})

// prepare input for update message
function showUpdateBox(id) {
    //change form mode to edit
    formSendMessage.attr('data-form-mode', 'edit')
    // get message text
    let chatMessageBox = $(`li[data-reply-id="${id}"] .chat-message-text p`);
    // input message
    let messageBox = $('.form-send-message .message-text');
    // dismiss edit btn
    let dismissEditWrapper = $('.dismiss-edit ');

    let editMessageWrapper = $('.edit-message-wrapper');
    // message action buttons
    let MessageActions = $('.message-actions');
    // form submit button
    let editMessageBtn = $('.edit-msg-btn');
    // fill message input with chatMessageBox value
    messageBox.val(chatMessageBox.text())
    // show dismiss button
    dismissEditWrapper.show()
    // show edit box
    editMessageWrapper.show()
    // hide message actions: like voice and file
    MessageActions.hide()
    // set reply id
    editMessageBtn.attr('data-message-id', id)
    messageBox.focus();
}

// dismiss edit box
function dismissEdit() {
    formSendMessage.attr('data-form-mode', 'chat')
    let messageBox = $('.form-send-message .message-text');
    let dismissEdit = $('.dismiss-edit ');
    let editMessageWrapper = $('.edit-message-wrapper');
    let MessageActions = $('.message-actions');
    messageBox.val('')
    dismissEdit.hide()
    editMessageWrapper.hide()
    MessageActions.show()
}

// remove message
function removeMessage(id) {
    let chatMessageBox = $(`li[data-reply-id="${id}"]`);

    Swal.fire({
        title: 'حذف پیام',
        text: "در صورت حذف، پیام دیگر قابل بازیابی نخواهد بود",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'حذف',
        cancelButtonText: 'انصراف',
        customClass: {
            confirmButton: 'btn btn-primary me-3',
            cancelButton: 'btn btn-label-secondary'
        },
        buttonsStyling: false
    }).then(function (result) {
        if (result.value) {
            axios.delete(`channel/message/delete/${id}`)
                .then(function (response) {
                    if (response.data.status == 200) {
                        chatMessageBox.remove()
                    } else {
                        Swal.fire({
                            title: 'خطا',
                            text: response.data.message,
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            },
                            confirmButtonText: 'باشه'
                        });
                    }
                })

        }
    });
}

//file upload
function sendFile(id) {

    var file = document.querySelector('#file1').files[0];
    let caption = $('#file_caption').val()
    var formdata = new FormData();

    formdata.append("file", file);
    formdata.append('voice', false)
    formdata.append('message', '')
    formdata.append('message_required', false)
    formdata.append('caption', caption)

    axios.post(`channel/post/${id}`, formdata, {
        onUploadProgress: progressHandler
    })
        .then(function (response) {
            let newMessageBox = $('.new-messages');
            // close modal
            let caption = $('#file_caption').val('')
            $('#uploadModal').modal('toggle');
            // clear upload progress bar
            $('#uploaderProgress').css('width', 0 + '%')
            $('#uploaderProgress').text(0 + '%')
            // clear file input
            $('#file1').val('')

            let sendBtn = $('#sendFileButton');
            sendBtn.removeAttr('disabled')
            if (response.data.status == 200) {

                if (response.data.caption != null) {
                    caption = `
                    <p class="mt-1 mb-0 p-2 text-start ">${response.data.caption}</p>
                    `
                } else {
                    caption = ''
                }

                if (response.data.type == 'image') {
                    file = `
                            <div class="chat-message-text p-0" data-reply-id="${response.data.id}">
                                <a href="${response.data.file}" target="_blank">
                                     <img src="${response.data.file}" class="w-100">
                                </a>
                                 ${caption}
                            </div>
                                    <div class="text-end text-muted mt-1">
                                            <small>${response.data.date}</small>
                                        </div>
`
                } else if (response.data.type == 'video') {
                    file = `
                                <div class="chat-message-text p-0" data-reply-id="${response.data.id}">
                                    <video controls width="100%">
                                        <source src="${response.data.file}">
                                    </video>
                                    ${caption}
                                </div>
                                    <div class="text-end text-muted mt-1">
                                            <small>${response.data.date}</small>
                                        </div>
`
                } else if (response.data.type == 'file') {
                    file = `
                        <div class="chat-message-text" data-reply-id="${response.data.id}">
                            <a href="${response.data.file}" class="btn btn-primary" target="_blank">
                            دانلود فایل
                            <i class="bx bx-download ms-2"></i>
                            </a>
                            ${caption}
                        </div>
                                <div class="text-end text-muted mt-1">
                                            <small>${response.data.date}</small>
                                        </div>
`
                }
                newMessageBox.append(
                    `<li class="chat-message chat-message-right" data-reply-id="${response.data.id}">
                        <div class="d-flex" style="max-width: 50%;">
                        <div class="chat-message-wrapper flex-grow-1 position-relative">
                            <div class="text-end text-muted mt-1 d-flex flex-column">
                                ${file}
                            </div>
                                <a href="javascript:void(0);" onclick="removeMessage(${response.data.id})" class="edit-message text-dark">
                                <i class="bx bx-trash"></i>
                                </a>
                            </div>
                            <div class="user-avatar flex-shrink-0 ms-3">
                                        <div class="flex-shrink-0 avatar">
                                        <img class="avatar-initial rounded-circle bg-label-success" src="${response.data.avatar}">
                                </div>
                        </div>
                    </li>`
                );

                // transfer user to end of chat section after sending message
                let chatHistoryBody = document.querySelector('.chat-history-body');
                chatHistoryBody.scrollTo(0, chatHistoryBody.scrollHeight);
            }
        })
}

function progressHandler(event) {
    let sendBtn = $('#sendFileButton');
    sendBtn.attr('disabled', 'disabled')
    var percent = Math.round((event.loaded / event.total) * 100);
    $('#uploaderProgress').css('width', percent + '%')
    $('#uploaderProgress').text(percent + '%')
}

$('.cancelUpload').on('click', function () {
    let sendBtn = $('#sendFileButton');
    sendBtn.removeAttr('disabled')
    let caption = $('#file_caption').val('')
    $('#uploaderProgress').css('width', 0 + '%')
    $('#uploaderProgress').text(0 + '%')
    $('#file1').val('')
})

let channelUsersPage = 1;

function showChannelDetails(id) {
    channelUsersPage = 1;
    $('#channelUsersList').empty()

    const showChannelDetailsRequest = axios.create();

    //before ajax request this section clear the message input value
    showChannelDetailsRequest.interceptors.request.use(function (config) {
        $.blockUI({
            message:
                '<div class="d-flex justify-content-center"><p class="mb-0">لطفا صبر کنید ...</p> <div class="sk-wave m-0 ms-2"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div> </div>',
            timeout: 1000,
            css: {
                backgroundColor: 'transparent',
                color: '#fff',
                border: '0',
                width: '80%'
            },
            overlayCSS: {
                opacity: 0.5
            }
        });
        return config
    });
    showChannelDetailsRequest.get(`/${adminPrefix}/channel/get/users/${id}`, {
        params: {
            page: channelUsersPage
        }
    })
        .then(function (response) {
            $('#channelUsersCount').text(
                `${response.data.count} عضو`
            );
            $('#channelDescription').text(
                `${response.data.description} `
            );

            for (const user of response.data.users.data) {
                $('#channelUsersList').append(`
                 <li class="d-flex mb-3"><div class="d-flex justify-content-between flex-grow-1"><div class="me-2"><p class="mb-0">${user.name} ${user.lastname}</p><p class="mb-0 text-muted">${user.phone}</p></div><div class="actions"><a role="button" class="text-danger me-3" onclick="removeUserFromChannel(${user.id} , $(this))" title="حذف کاربر از کانال"><i class="bx bx-trash"></i></a></div></div></li>
                `)
            }
        })
}

function removeUserFromChannel(userId, e) {
    let channelId = $('#channel_id').val();

    const removeUserFromChannelRequest = axios.create()

    removeUserFromChannelRequest.interceptors.request.use(function (config) {
        $.blockUI({
            message:
                '<div class="d-flex justify-content-center"><p class="mb-0">لطفا صبر کنید ...</p> <div class="sk-wave m-0 ms-2"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div> </div>',
            timeout: 1000,
            css: {
                backgroundColor: 'transparent',
                color: '#fff',
                border: '0',
                width: '80%'
            },
            overlayCSS: {
                opacity: 0.5
            }
        });
        return config
    });

    removeUserFromChannelRequest.delete(`channel/delete/user/${channelId}/${userId}`)
        .then(function (response) {
            $('#channelUsersCount').text(
                `${response.data.count} عضو`
            );
            e.parent().parent().parent().remove()
        })
        .catch(function (response) {
            Swal.fire({
                title: 'خطا',
                text: "مشکلی در حذف کاربر به وجود آمده است",
                icon: 'warning',
                showCancelButton: false,
                confirmButtonText: 'باشه',
                customClass: {
                    confirmButton: 'btn btn-primary me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            })
        })
}

var channelDetails = document.getElementById('channelDetails')
channelDetails.addEventListener('hidden.bs.modal', function (event) {
    $('#channelUsersList').empty()
})

$('#channelUsersList').on('scroll', function () {
    let channelId = $('#channel_id').val()
    if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
        channelUsersPage++
        const getChannelUsersListRequest = axios.create();
        // before ajax request this section clear the message input value
        getChannelUsersListRequest.interceptors.request.use(function (config) {
            $.blockUI({
                message:
                    '<div class="d-flex justify-content-center"><p class="mb-0">لطفا صبر کنید ...</p> <div class="sk-wave m-0 ms-2"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div> </div>',
                timeout: 1000,
                css: {
                    backgroundColor: 'transparent',
                    color: '#fff',
                    border: '0',
                    width: '80%'
                },
                overlayCSS: {
                    opacity: 0.5
                }
            });
            return config
        });
        getChannelUsersListRequest.get(`/channel/get/users/${channelId}`, {
            params: {
                page: channelUsersPage
            }
        })
            .then(function (response) {
                for (const user of response.data.users.data) {
                    $('#channelUsersList').append(`
                 <li class="d-flex mb-3"><div class="d-flex justify-content-between flex-grow-1"><div class="me-2"><p class="mb-0">${user.name} ${user.lastname}</p><p class="mb-0 text-muted">${user.phone}</p></div><div class="actions"><a role="button" class="text-danger me-3" onclick="removeUserFromChannel(${user.id} , $(this))" title="حذف کاربر از کانال"><i class="bx bx-trash"></i></a></div></div></li>
                `)
                }
            })
    }
});

// on click of chatHistoryHeaderMenu, Remove data-overlay attribute from chatSidebarLeftClose to resolve overlay overlapping issue for two sidebar
let chatHistoryHeaderMenu = document.querySelector(".chat-history-header [data-target='#app-chat-contacts']"),
    chatSidebarLeftClose = document.querySelector('.app-chat-sidebar-left .close-sidebar');
chatHistoryHeaderMenu.addEventListener('click', e => {
    chatSidebarLeftClose.removeAttribute('data-overlay');
});
// }
