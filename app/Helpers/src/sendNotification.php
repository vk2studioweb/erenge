<?php 

if(!function_exists('insertNotification')){
    function insertNotification($message, $title = null, $type = null, $icon = null, $userIds = null)
    {
        
        if(empty($message)){
            return false;
        }

        if (!empty($userId) && is_array($userIds)) {
            $notifiedUsers = $userIds;
        } else {
            $notifiedUsers = \App\Models\Admin\Usuarios::where('status', 1)
            ->where('delete', 0)
            ->get()
            ->pluck('id_login_user');
        }

        foreach ($notifiedUsers as $notifiedUser){
            $insertData[] = [
                'title' => $title ?? 'Notificação',
                'message' => $message,
                'icon' => $icon ?? 'information-circle',
                'type' => $type ?? 'info',
                'id_user' => $notifiedUser
            ];
        }

        try {
            \App\Models\Admin\Notification::insert($insertData);
        } catch (\Throwable $th) {
            \Log::error($th);
            return false;
        }

        return true;
    }
}