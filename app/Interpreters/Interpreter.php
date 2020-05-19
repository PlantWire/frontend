<?php

namespace App\Interpreters;

interface Interpreter {
    public function parse(string $raw) : void;
    public function isValid() : bool;
    public function toJson() : string;
    public function run() : void;
}
