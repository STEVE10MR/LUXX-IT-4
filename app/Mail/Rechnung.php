<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Rechnung extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $email;
    public $products;
    public $total;
    public $date;
    public $order_id;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$email,$products,$total,$date,$order_id)
    {
        $this->name=$name;
        $this->email=$email;
        $this->products=$products;
        $this->total=$total;
        $this->date=$date;
        $this->order_id=$order_id;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.rechnung',['name'=>$this->name,'email'=>$this->email,'products'=>$this->products,'total'=>$this->total,'date'=>$this->date,'order_id'=>$this->order_id]);
    }
}
