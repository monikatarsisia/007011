# FileServer.py
 
import sys
import socket
import select

HOST = '' 
SOCKET_LIST = []
RECV_BUFFER = 4096 
PORT = 9009	# Port Number
option = 'List of file available :\n(1)a.txt\n(2)b.txt\n(3)c.txt\nInput your choice : '

def chat_server():

    server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    server_socket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
    server_socket.bind((HOST, PORT))
    server_socket.listen(10)
 
    # add server socket object to the list of readable connections
    SOCKET_LIST.append(server_socket)
 
    print "Chat server started on port " + str(PORT)
 
    while 1:

        # get the list sockets which are ready to be read through select
        # 4th arg, time_out  = 0 : poll and never block
        ready_to_read,ready_to_write,in_error = select.select(SOCKET_LIST,[],[],0)    

        for sock in ready_to_read:
            # a new connection request recieved
            if sock == server_socket: 
                sockfd, addr = server_socket.accept()
                SOCKET_LIST.append(sockfd)
                print "Client (%s, %s) connected" % addr
                sockfd.send(option) 
		print "Option Sent to (%s, %s)" % addr
            
            # a message from a client, not a new connection
            else:
                # process data recieved from client, 
                try:
                    # receiving data from the socket.
                    data = sock.recv(RECV_BUFFER)
                    if data:
			# There is something in the socket
			if data == '1\n':
                            print "<" + str(sock.getpeername()) + "> Request For (1)\n"
			    print "Start Sending File (1)..."
			    sock.send("Start Sending File (1)...")
			    filename='./a.txt'
			    f = open(filename,'rb')
			    l = f.read(1024)
			    while (l):
				sock.send(l)
				print('Sent : ',repr(l))
				l = f.read(1024)
			    f.close()

			    print('Done Sending')
			    sock.send("endoffile")
			elif data == '2\n':
			    print "<" + str(sock.getpeername()) + "> Request For (2)\n"
			    print "Start Sending File (2)..."
			    sock.send("Start Sending File (2)...")
			    filename='./b.txt'
			    f = open(filename,'rb')
			    l = f.read(1024)
			    while (l):
				sock.send(l)
				print('Sent : ',repr(l))
				l = f.read(1024)
			    f.close()

			    print('Done Sending')
			    sock.send("endoffile")
			elif data == '3\n':
		            print "<" + str(sock.getpeername()) + "> Request For (3)\n"
			    print "Start Sending File (3)..."
			    sock.send("Start Sending File (3)...")
			    filename='./c.txt'
			    f = open(filename,'rb')
			    l = f.read(1024)
			    while (l):
				sock.send(l)
				print('Sent : ',repr(l))
				l = f.read(1024)
			    f.close()

			    print('Done Sending')
			    sock.send("endoffile")
			else:
			    continue
		    else:
		        # remove the socket that's broken    
		        if sock in SOCKET_LIST:
		            SOCKET_LIST.remove(sock)

	                # at this stage, no data means probably the connection has been broken
		        print "Client (%s, %s) is offline\n" % addr

                # exception
                except:
                    print "Client (%s, %s) is offline\n" % addr
                    continue

    server_socket.close()
 
if __name__ == "__main__":

    sys.exit(chat_server())  
