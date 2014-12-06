<?php

return array(
    /**
     *  Routes where params are not serialized in log
     *  Example routes with passwords
     */
    'noParamsLogRoutesNames' => array(
        'api.v1.users.login',
        'api.v1.user.subscribe',
        'api.v1.user.password.change',
    )
);
