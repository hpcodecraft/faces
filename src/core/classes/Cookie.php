<?php

	class Cookie {
		private $namespace;
		public  $data;

		public function __construct( $namespace ) {
			$this->namespace = $namespace;
			$this->data = new \stdClass();
			$this->data->order = 'id';
			$this->data->category = 0;
      $this->save();
		}

		public function load() {
      if( isset( $_COOKIE[ $this->namespace ]  )) {
        $data = json_decode( stripslashes( $_COOKIE[ $this->namespace ] ));
        if( isset( $data->order )) $this->data->order = $data->order;
        if( isset( $data->category )) $this->data->category = $data->category;
      }
		}

		public function save() {
			setcookie( $this->namespace, json_encode( $this->data ), time()+60*60*24*30); // cookie for 30 days
		}

    public function getJSON() {
      return json_encode( $this->data );
    }
	}

?>