<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Action extends Event
{
    use SerializesModels;

    /**
     * 触发事件的模块名
     *
     * @var
     */
    public $model;

    /**
     * 牵扯到的资源 id
     *
     * @var int
     */
    public $result_id;

    /**
     * 事件触发用户 id
     *
     * @var int
     */
    public $user_id;

    /**
     * 触发的事件
     *
     * @var
     */
    public $action;

    /**
     * 说明
     *
     * @var
     */
    public $description;

    /**
     * Create a new event instance.
     *
     * @param $model
     * @param int $result_id
     * @param int $user_id
     * @param $action
     * @param $description
     *
     */
    public function __construct($model, $result_id = 0, $user_id = 0, $action, $description)
    {
        $this->model = $model;
        $this->result_id = $result_id;
        $this->user_id = $user_id;
        $this->action = $action;
        $this->description = $description;

        return true;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
