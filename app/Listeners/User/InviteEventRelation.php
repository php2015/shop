<?php

namespace App\Listeners\User;

use App\Events\User\InviteEvent;
use App\Models\Invite;
use App\Models\User;
use Log;

class InviteEventRelation
{
    private static $list;

    private static $user;

    public function handle(InviteEvent $event)
    {
        try {
            self::$user = $event->user;
            $userList = User::all();
            self::getRelationList($userList, self::$user->parent_id, 0);

            foreach (self::$list as $key => $item) {
                $invite = new Invite;
                $invite->parent_id = $item['parent_id'];
                $invite->level = $item['level'];
                $invite->invite_time = time();
                self::$user->invite()->save($invite);
            }
        } catch(\Exception $e) {
        	Log::error($e->getMessage() . PHP_EOL);
        }
    }

    private static function getRelationList(&$data, int $parent_id, int $level)
    {
        foreach ($data as $item) {
            if ($item['id'] == $parent_id) {
                self::$list[] = [
                    'level' => ++$level,
                    'parent_id' => $item['id'],
                    'user_id' => self::$user->id,
                    'invite_time' => time()
                ];
                self::getRelationList($data, $item['parent_id'], $level);
            }
        }
    }
}
