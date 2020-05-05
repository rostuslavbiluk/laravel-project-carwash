<?php

namespace App\Http\Controllers;

use App\Classes\Entity\User\UserInfo;
use App\Model\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NotifyOrder;
use App\Model\Order;
use Illuminate\Http\Request;
use Auth;

class NotificationController extends Controller
{
    public function create_notification_user()
    {
        // отправляем уведомление с помощью фасада "Notification"
        /*$order = Order::where('id', 210)->first();
        $user = User::where('id', 23)->get();
        $notify = new NotifyOrder($order);
        try {
            Notification::send($user, $notify);

        } catch (\Error|\ErrorException $e) {
            dump($e);
        }*/

        return 'ok';
    }

    public function get_notification_user(Request $request)
    {
        $user = (new UserInfo())->getModel();
        $notifications = $user->unreadNotifications();
        return view('ajax_blocks.notification', ['notifications' => $notifications]);
    }

    public function read_notification(Request $request)
    {
        $user = (new UserInfo())->getModel();
        $user->notifications->where('id', $request->input('notification_id'))->markAsRead();
        return $request->input('notification_id');
    }
}
