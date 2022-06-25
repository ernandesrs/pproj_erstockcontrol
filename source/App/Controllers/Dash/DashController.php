<?php

namespace App\Controllers\Dash;

use App\Controllers\Controller;
use App\Models\Auth;
use Components\Router\Router;
use stdClass;

class DashController extends Controller
{
    /** @var stdClass */
    protected $settings;
    /**
     * @param Router $router
     */
    public function __construct($router)
    {
        if (!(new Auth())->isLogged()) {
            $router->redirect("auth.login");
            return;
        }

        parent::__contruct($router);

        $this->settings = $this->getSettings();
        $this->view->addData(["dash_settings" => $this->settings]);
    }

    /**
     * @return stdClass
     */
    protected function getSettings(): stdClass
    {
        $loggedId = (new Auth())->logged()->id;
        $dashSettingsPath = CONF_BASE_DIR . "/storage/dash_settings.json";

        if (!file_exists($dashSettingsPath)) {
            $dashSettings = [
                $loggedId => [
                    "theme" => [
                        "dark_mode" => false
                    ],
                    "listings" => [
                        "limit_items" => 12,
                        "order_create_date" => "desc",
                    ],
                ],
            ];

            file_put_contents($dashSettingsPath, json_encode($dashSettings));
        }

        $dashSettings = json_decode(file_get_contents($dashSettingsPath));

        foreach ($dashSettings as $key => $dsetting)
            if ($key == $loggedId)
                return $dsetting;

        return null;
    }
}
