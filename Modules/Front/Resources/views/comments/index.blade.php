<div class="container">
    <div class="comments">
        @auth()
        @include("front::comments.create", ["commentable" => $course])
        @else
            <div class="comment-main">
                <div class="ct-header">
                    <p>برای ثبت دیدگاه باید ابتدا <a href="{{ route("auth.login-register") }}">وارد سایت</a> شوید</p>
                </div>
            </div>
        @endauth
        <div class="comments-list">
            @auth()
              @include("front::comments.reply", ["commentable" => $course])
            @endauth
            @foreach($commentable->approvedComments()->latest()->get() as $comment)
                <ul class="comment-list-ul">
                    @auth
                    <div class="div-btn-answer">
                        <button class="btn-answer" onclick="setCommentId({{ $comment->id }})">پاسخ به دیدگاه</button>
                    </div>
                    @endauth
                    <li class="is-comment">
                        <div class="comment-header">
                            <div class="comment-header-avatar">
                                <img src="{{ $comment->user->thumb }}" alt="{{ $comment->user->name }}">
                            </div>
                            <div class="comment-header-detail">
                                <div class="comment-header-name">کاربر : {{ $comment->user->name }}</div>
                                <div class="comment-header-date">{{  \Morilog\Jalali\Jalalian::fromCarbon($comment->created_at)->ago() }}</div>
                            </div>
                        </div>
                        <div class="comment-content">
                            <p>
                                {{ $comment->body }}
                            </p>
                        </div>
                    </li>
                    @foreach($comment->comments as $reply)
                        <li class="is-answer">
                            <div class="comment-header">
                                <div class="comment-header-avatar">
                                    <img src="{{ $reply->user->thumb }}">
                                </div>
                                <div class="comment-header-detail">
                                    <div class="comment-header-name">{{ $reply->user->name }}</div>
                                    <div class="comment-header-date">{{  \Morilog\Jalali\Jalalian::fromCarbon($reply->created_at)->ago() }}</div>
                                </div>
                            </div>
                            <div class="comment-content">
                                <p>
                                    {{ $reply->body }}
                                </p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endforeach
        </div>
    </div>
</div>
