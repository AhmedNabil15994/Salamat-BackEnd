<?php

namespace Modules\User\ViewComposers\Dashboard;

use Modules\User\Repositories\Dashboard\UserRepository as User;
use Illuminate\View\View;
use Cache;

class UserComposer
{
    public function __construct(User $user)
    {
        $this->user =  $user;
    }

    public function compose(View $view)
    {
        $view->with('userCreated'   , $this->user->userCreatedStatistics());
        $view->with('countUsers'    , $this->user->countUsers());
        $view->with('users'         , $this->user->getAllUsers());
    }
}
