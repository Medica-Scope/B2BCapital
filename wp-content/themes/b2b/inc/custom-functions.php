<?php
    /**
     * Functions which enhance the theme by hooking into WordPress
     *
     * @package b2b
     */

//    $notifications = new \B2B\APP\MODELS\FRONT\MODULES\B2b_Notification();
//    for ($i = 0; $i < 7; $i++) {
//        $notifications->send(13, 12, 'bidding', [ 'project_id' => '157' ]);
//    }


//    $ch = curl_init();
//
//    curl_setopt($ch, CURLOPT_URL, 'https://api.twilio.com/2010-04-01/Accounts/AC6fd8e3d3e4b54dcfbb681ebd0fec3cec/Messages.json');
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//    curl_setopt($ch, CURLOPT_POST, 1);
//    curl_setopt($ch, CURLOPT_USERPWD, 'AC6fd8e3d3e4b54dcfbb681ebd0fec3cec' . ':' . '859d2d5288fd109930458ae91f2b342f');
//
//    // Disabling SSL Certificate verification
//    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
//    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
//
//    $data = [
//        'To'   => '+2010169997000',
//        'From' => '+19894738633',
//        'Body' => 'test'
//    ];
//    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
//
//    $result = curl_exec($ch);
//    if (curl_errno($ch)) {
//        echo 'Error:' . curl_error($ch);
//    }
//    curl_close($ch);


var_dump(json_decode('{"code": 21211, "message": "The \'To\' number +2010169997000 is not a valid phone number.", "more_info": "https://www.twilio.com/docs/errors/21211", "status": 400}'));