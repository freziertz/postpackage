<?php
// 'src/Mail/WelcomeMail.php'

namespace Freziertz\PostPackage\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Freziertz\PostPackage\Models\Post;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function build()
    {
        return $this->view('postpackage::emails.welcome');
    }
}
