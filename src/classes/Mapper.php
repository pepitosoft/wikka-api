<?php
abstract class Mapper {
    protected $db;
    protected $settings;
    public function __construct($db, $settings) {
        $this->db = $db;
        $this->settings = $settings;
    }
}
