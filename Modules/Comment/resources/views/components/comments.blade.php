<ul>
    @foreach($comments as $comment)
        <li class="comment-item @if($children) children @endif">
            <div class="comment-details">
                <div class="comment-user-date">
                    <span class="user-name"><a href="#">{{$comment->user->first_name . ' ' . $comment->user->last_name}}</a></span>
                    <span class="comment-date">{{Verta::instance($comment->created_at)->formatJalaliDate()}}</span>
                </div>
                <div class="comment-text">
                    <p>{{$comment->content}}</p>
                </div>
                <div class="reply mt-3">
                    <a href="#" class="reply-button mt-3">
                        <i class="bi bi-reply"></i>
                        پاسخ
                    </a>
                </div>
            </div>
        </li>
        @if($comment->children)
            @include('comment::components.comments' , ['comments' => $comment->children , 'children' => true])
        @endif
    @endforeach

</ul>

