<?php
// set some variables
$host = "127.0.0.1";
$port = 5353;
// don't timeout!
set_time_limit(0);
// create socket
$socket = socket_create(AF_INET, SOCK_STREAM, 0);
// bind socket to port
$result = socket_bind($socket, $host, $port);
if(!$result)
{
	socket_close($socket);
	$socket = socket_create(AF_INET, SOCK_STREAM, 0);
	// bind socket to port
	$result = socket_bind($socket, $host, $port);
}

while (true)
{
	// start listening for connections
	$result = socket_listen($socket, 3);
	// accept incoming connections
	// spawn another socket to handle communication
	$spawn = socket_accept($socket);
	// read client input
	$input = socket_read($spawn, 1024);
	// clean up input string
	// $input = trim($input);
	echo "Client Message : ".$input;
	// reverse client input and send back
	$output = strrev($input) . "\n";
	socket_write($spawn, $output, strlen ($output));
	socket_close($spawn);
}
// close sockets
socket_close($socket);
?>