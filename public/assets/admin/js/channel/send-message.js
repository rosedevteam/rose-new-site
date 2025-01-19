let formSendMessage = $('.form-send-message');
let chatContainer = $('.chat-history-body');

formSendMessage.on('submit' , function (e) {
    e.preventDefault();
    let newMessageBox = $('.new-messages');
    let message = $('.form-send-message .message-text')
    let ticketId = $('#ticket_id').val()
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN' : $('#csrf').attr('content'),
            'Content-Type' : 'application/json'
        }
    });

    $.ajax({
        type: 'post',
        url: `ticket/reply/${ticketId}`,
        data: JSON.stringify({
           _method: 'post',
            message: message.val(),
        }),
        beforeSend : function () {
            newMessageBox.append(
                `<li class="chat-message">
                                <div class="d-flex overflow-hidden">
                                 <div class="user-avatar flex-shrink-0 me-3">
                                        <div class="flex-shrink-0 avatar"><span
                                                class="avatar-initial rounded-circle bg-label-success">من</span></div>
                                    </div>
                                    <div class="chat-message-wrapper flex-grow-1">
                                        <div class="chat-message-text">
                                            <p class="mb-0">${message.val()}</p>
                                        </div>
                                        <div class="text-muted mt-1 sending">
                                           <small><i class="bx bx-time"></i></small>
                                        </div>
                                    </div>
                                </div>
                            </li>`
            );
            message.val('')
        },
        complete: function (response) {
            let sentMessage = $('.new-messages .chat-message .d-flex .chat-message-wrapper .sending');
            sentMessage.removeClass('sending');
            sentMessage.html(
                `<small><i class="bx bx-check-double"></i></small>`
            );
            console.log(response)
        }
    })
})
