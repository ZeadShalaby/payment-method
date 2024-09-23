<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Events\testEvent;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    use ResponseTrait;
    //
    public function index(Request $request)
    {
        $user = User::find(1);
        try {
            event(new testEvent($user));
            return $this->returnSuccessMessage("done Event");
        } catch (\Exception $ex) {
            return $this->returnError('E001', $ex->getMessage());
        }
    }
}
