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

if (! function_exists('cart'))
{
    /**
     * @return \App\Standards\Cart\Cart
     */
    function cart(): \App\Standards\Cart\Cart
    {
        return new \App\Standards\Cart\Cart();
    }
}
