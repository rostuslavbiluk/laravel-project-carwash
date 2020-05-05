@if(isset($notifications) && count($notifications)>0)
    <div class="notifications-w">
        @foreach($notifications as $notification)
            <div class="notifications-i" id="{{$notification->id}}">
                <div class="chat-head">
                    <div class="user-w with-status status-green">
                        <div class="user-name">
                            <h6 class="user-title">
                                {{$notification->data['message']}}
                            </h6>
                            <div class="user-role">
                                ID: {{$notification->data['id']}}
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-info" onclick="button_close_notification('{{$notification->id}}')">
                            Закрыть
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif