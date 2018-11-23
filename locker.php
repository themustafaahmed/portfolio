<?php

    class Locker {

        public $filename;
        private $_lock;

        public function __construct($filename) {
            $this->filename = $filename;
        }

        /**
         * locks relevant file
         */
        public function lock() {
                touch($this->filename);
                $this->_lock = fopen($this->filename, 'r');
                flock($this->_lock, LOCK_EX);
        }

        /**
         * unlock above file
         */
        public function unlock() {
                flock($this->_lock, LOCK_UN);
        }

    }

    $locker = new Locker('locker.lock');
    echo "Waiting\n";
    $locker->lock();
    echo "Sleeping\n";
    sleep(30);
    echo "Done\n";
    $locker->unlock();

?>