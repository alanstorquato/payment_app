<?php

namespace App\Jobs;

use App\Services\SendAuthorizeTransactionMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TransactionMadeMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $sendAuthorizeTransactionMessage;


    public $backoff = 10;

    public $tries = 3;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->sendAuthorizeTransactionMessage = new SendAuthorizeTransactionMessage();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        return $this->sendAuthorizeTransactionMessage->sendMessage();
    }
}
