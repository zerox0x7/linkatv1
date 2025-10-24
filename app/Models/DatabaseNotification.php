<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification as NotificationModel;

class DatabaseNotification extends NotificationModel
{
    // هذا النموذج يرث من نموذج Laravel الأساسي للإشعارات
    // وتم إعادة تعريفه هنا لتسهيل التخصيص إذا لزم الأمر في المستقبل
} 