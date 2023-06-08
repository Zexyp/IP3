<?php

enum Role {
    const ADMIN = 0;
    const EMPLOYEE = 1;
    const OUTCOMMING = 2;
    const INCOMMING = 3;
    const RESPONDER = 4;

    public static function toString($value): string {
        switch ($value) {
            case self::ADMIN: return "Administrátor";
            case self::EMPLOYEE: return "Zaměstnanec";
            case self::OUTCOMMING: return "Svoz";
            case self::INCOMMING: return "Dovoz";
            case self::RESPONDER: return "Respondent";
            default: return "N/A";
        }
    }
}
