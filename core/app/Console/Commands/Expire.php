<?php namespace App\Console\Commands;


use Illuminate\Console\Command;
use Mail;

use Sammy\AssetManage\Models\Asset;
use DB;

class Expire extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'expire';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Sending expire assets';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{

		$aa= Asset::with(['supplier'])->whereIn('id',function($query){
                    $query->select('asset_id')->from('asset_transaction');
                })
                ->select("*",DB::raw('DATEDIFF(warranty_to,CURDATE()) as diff'))
                ->where(DB::raw('DATEDIFF(warranty_to,CURDATE())'),'=',0)
                ->get();

		Mail::send('emails.expire', ['data'=>$aa], function ($message)
        {
        	$message->subject("Expire Assets");
        	$message->to('chathu.ad@gmail.com', 'Keriya')->subject('Expire Email');
        });

        $this->info('Mail sent.');
	}

}
