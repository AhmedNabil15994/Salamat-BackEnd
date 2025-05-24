<?php

namespace Modules\User\ViewComposers\Clinic;

use Modules\User\Repositories\Clinic\UserRepository as User;
use Illuminate\View\View;
use Cache;

class ClinicUsersComposer
{
    public function __construct(User $user)
    {
        $this->user =  $user;
    }

    public function compose(View $view)
    {
        $view->with('users' , $this->user->getClinicUsers());
    }
}
