<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use Illuminate\Console\Command;

class MarkOverdueInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:mark-overdue-invoices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark overdue invoices';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $overdueInvoices=Invoice::where('status','pending')->where('due_date','<',now())->get();
        foreach($overdueInvoices as $invoice){
            $invoice->update(['status'=>'overdue']);
        }
        if($overdueInvoices->count() > 0){
            echo  'Marked ' . $overdueInvoices->count() . ' invoices as overdue';
        }
        else{
            echo 'No overdue invoices found';
        }
        return 0;
    }
}
