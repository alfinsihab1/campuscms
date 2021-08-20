<?php

namespace Ajifatur\FaturCMS\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Ajifatur\FaturCMS\Mails\MessageMail;
use Ajifatur\FaturCMS\Models\Email;
use App\Models\User;

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
        
		// Clear
        $schedule->command('clear-compiled')->daily();
        $schedule->command('cache:clear')->daily();
        $schedule->command('config:clear')->daily();
        $schedule->command('view:clear')->daily();

        // Broadcast scheduled emails
        // Get email
        $email = Email::join('users','email.sender','=','users.id_user')->where('scheduled','=',date('H:i'))->get();
        // Loop email
        if(count($email)>0){
            foreach($email as $key=>$data){
                // Check receivers
                if(count_penerima_email($data->receiver_id) < count_member_aktif()){
                    // Get receivers
                    $receivers = explode(",", $data->receiver_id);
					$receivers = array_filter($receivers);
                    $receivers_email = explode(", ", $data->receiver_email);
					$receivers_email = array_filter($receivers_email);

                    // Get user haven't received yet
                    $users = User::where('is_admin','=',0)->where('status','=',1)->whereNotIn('id_user',$receivers)->limit(100)->get();

                    // Loop user
                    if(count($users)>0){
                        foreach($users as $user){
                            // Run sending email task
                            $schedule->call(function() use ($user, &$receivers, &$receivers_email, $data){
                                // Send email
                                Mail::to($user->email)->send(new MessageMail($data->email, $user, $data->subject, html_entity_decode($data->content)));
                                
                                // Push receivers
                                array_push($receivers, $user->id_user);
                                array_push($receivers_email, $user->email);

                                // Update email
                                $data->receiver_id = implode(",", $receivers);
                                $data->receiver_email = implode(", ", $receivers_email);
                                $data->save();
                            })->dailyAt($data->scheduled);
                        }
                    }
                }
            }
        }
    }
}
