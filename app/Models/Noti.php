<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Noti extends MyModel {

    protected $table = 'noti';
    public static $status_text = [
    	2 => 'the_delegate_is_coming_to_you_to_receive_the_donation',
    	3 => 'The_delegate_has_arrived_to_receive_the_donation',
    	4 => 'The_donation_was_received_by_the_delegate'
    ];
    


}
