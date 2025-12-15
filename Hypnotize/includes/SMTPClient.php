<?php
/*
    The Hypnotize Project is a Content Management System (CMS) that allows you to easily make your own webpage.

    Copyright (C) 2004-2025  Hypnotize

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.

    https://www.github.com/frebergguru/THP-Revamped
*/
class SMTPClient {
    private $host;
    private $port;
    private $username;
    private $password;
    private $encryption;
    private $timeout = 30;
    private $socket;

    public function __construct($host, $port, $username, $password, $encryption = 'tls') {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->encryption = $encryption;
    }

    private function getResponse() {
        $response = "";
        while (($line = fgets($this->socket, 515)) !== false) {
            $response .= $line;
            if (substr($line, 3, 1) == " ") break;
        }
        return $response;
    }

    private function sendCommand($command) {
        fputs($this->socket, $command . "\r\n");
        return $this->getResponse();
    }

    public function send($to, $from, $subject, $message) {
        $host = $this->host;
        $connected = false;

        // Try strict SSL if requested
        if ($this->encryption == 'ssl') {
            $ssl_host = 'ssl://' . $host;
            $this->socket = @fsockopen($ssl_host, $this->port, $errno, $errstr, $this->timeout);
            if ($this->socket) {
                $connected = true;
            }
        }

        // Fallback to plain TCP if SSL failed or not requested
        if (!$connected) {
            $this->socket = @fsockopen($host, $this->port, $errno, $errstr, $this->timeout);
        }

        if (!$this->socket) {
            throw new Exception("Error connecting to SMTP server: $errstr ($errno)");
        }

        $this->getResponse(); // Banner

        $this->sendCommand("EHLO " . gethostname());

        // Always try to enable TLS if configured as 'tls' OR if 'ssl' failed on port 587 (common misconfig fallback)
        if ($this->encryption == 'tls' || ($this->encryption == 'ssl' && !$connected)) {
            $this->sendCommand("STARTTLS");
            if (!stream_socket_enable_crypto($this->socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                 // Only throw if strictly requested 'tls', otherwise proceed (opportunistic)
                 if ($this->encryption == 'tls') {
                     throw new Exception("Failed to enable TLS encryption");
                 }
            }
            $this->sendCommand("EHLO " . gethostname());
        }

        if (!empty($this->username) && !empty($this->password)) {
            $this->sendCommand("AUTH LOGIN");
            $this->sendCommand(base64_encode($this->username));
            $this->sendCommand(base64_encode($this->password));
        }

        $this->sendCommand("MAIL FROM: <$from>");
        $this->sendCommand("RCPT TO: <$to>");
        $this->sendCommand("DATA");

        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
        $headers .= "From: $from\r\n";
        $headers .= "To: $to\r\n";
        $headers .= "Subject: $subject\r\n";

        $this->sendCommand($headers . "\r\n" . $message . "\r\n.");
        $this->sendCommand("QUIT");

        fclose($this->socket);
        return true;
    }
}
?>
