<?php

if (! function_exists('user'))
{
    /**
     * @return \App\Data\Users\UserData
     */
    function user(): \App\Data\Users\UserData
    {
        return \App\Data\Users\UserData::fromModel(request()->user());
    }
}
