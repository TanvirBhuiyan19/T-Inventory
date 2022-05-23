<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;
//use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Order;
use App\Models\OrderItem;

class orderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;
        
        $order = Order::with('customer')->where('id', $data['order_id'] )->first();
        $orderItems = OrderItem::with('product')->where('order_id', $order->id )->get();       
        $pdf = \PDF::loadView('order.invoice', compact('order','orderItems'));
        
        return $this->from(config('mail.from.address'), $data['appName'])
                ->view('mail.orderMail', compact('data'))
                ->subject('New Order' )
                ->attachData($pdf->output(), 'invoice.pdf', [
                    'mime' => 'application/pdf',
                ]);
                
    }



}
