<?php

namespace App\Http\Controllers\Admin\Ticket;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketAdmin;
use App\Http\Controllers\Controller;

class TicketAdminController extends Controller
{

    public function index(){
        $admins = User::where('user_type', '1')->get();
        return view('admin.ticket.admin.index', compact('admins'));
    }


    public function set(User $admin){

        $TicketAdmin = TicketAdmin::where('user_id', $admin->id)->first() ? TicketAdmin::where('user_id', $admin->id)->forceDelete() : TicketAdmin::create(['user_id' => $admin->id]);

        return redirect()->route('admin.ticket.admin.index')->with('toast-success',' تنظیمات با موفقیت انجام شد');

    }

    

}
