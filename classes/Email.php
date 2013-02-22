<?php

class Email {
  private $from;
  private $to;
  private $subject;
  private $body;
  private $headers;

  public function __construct( $from, $to, $subject, $body ) {
    $this->from = $from;
    $this->to = $to;
    $this->subject = mb_encode_mimeheader( $subject, 'UTF-8' );
    $this->body = $body;

    $this->headers = "From: ".$this->from."\r\n" .
        "Reply-To: ".$this->from. "\r\n" .
        'X-Mailer: PHP/'.phpversion()."\r\n" .
        "MIME-Version: 1.0\r\n" .
        "Content-Type: text/html; charset=utf-8\r\n" .
        "Content-Transfer-Encoding: 8bit\r\n\r\n";
  }

  public function send() {
    return mail( $this->to, $this->subject, $this->body, $this->headers );
  }
}