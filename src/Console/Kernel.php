<?php

namespace Ajifatur\FaturCMS\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Ajifatur\FaturCMS\Mails\MessageMail;
use Ajifatur\FaturCMS\Models\Email;
use App\User;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        parent::schedule($schedule);

        // Broadcast scheduled emails
        // Get email
        $email = Email::where('scheduled','!=',null)->get();
        // Loop email
        if(count($email)>0){
            // Get customer service
            $cs = User::where('role','=',role('cs'))->first();
            foreach($email as $key=>$data){
                // Get receivers
                $receivers = explode(",", $data->receiver_id);

                // Get user haven't received yet
                $users = User::where('is_admin','=',0)->where('status','=',1)->whereNotIn('id_user',$receivers)->limit(round(100/count($email)))->get();

                // Loop user
                if(count($users)>0){
                    foreach($users as $user){
                        // Run sending email task
                        $schedule->call(function() use ($user, $receivers, $data){
                            // Send email
                            Mail::to($user->email)->send(new MessageMail($cs->email, $user, $data->subject, htmlentities($data->content)));
                            
                            // Push receiver
                            array_push($receivers, $user->id_user);

                            // Update email
                            $data->receiver_id = implode(",", $receivers);
                            $data->save();
                        })->dailyAt($data->scheduled);
                    }
                }  
            }    
        }
    }
}
