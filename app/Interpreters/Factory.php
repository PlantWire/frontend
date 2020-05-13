<?php

namespace App\Interpreters;

/**
 * Creates a new Packet interpreter based on the package type.
 */
class InterpreterFactory {

    /**
     * Instanciate a new Package Interpreter
     * @param  [string] $packageType package type as in the transmitted packet
     * @return [Interpreter]              The correct interpreter or a Default interpreter
     */
    public function make ($packageType) {
        $className = '\\App\\Interpreters\\' . $packageType;

        if (class_exists( $className )) {
            return new $className();
        } else {
          return new \App\Interpreters\DefaultInterpreter();
        }
    }
}
