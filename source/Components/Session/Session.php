<?php

namespace Components\Session;

use stdClass;

class Session
{
    use SessionTrait;

    /** @var stdClass */
    private $data;

    public function __construct()
    {
        if (!session_id())
            session_start();

        $this->data = (object) $_SESSION;
    }

    /**
     * @return bool
     */
    public function destroy(): bool
    {
        return session_destroy();
    }
}
