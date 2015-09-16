# FileClient.py

import sys
import socket
import select
 
def chat_client():
    msg = " "

    if(len(sys.argv) < 3) :
        print 'Usage : python FileClient.py hostname port'
        sys.exit()

    host = sys.argv[1]
    port = int(sys.argv[2])
     
    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    s.settimeout(10)
     
    # connect to remote host
    try :
        s.connect((host, port))
    except :
        print 'Unable to connect'
        sys.exit()
     
    print 'Connected to server.'
     
    while 1:
        socket_list = [sys.stdin, s]
         
        # Get the list sockets which are readable
        ready_to_read,ready_to_write,in_error = select.select(socket_list , [], [])
         
        for sock in ready_to_read:             
            if sock == s:
                # incoming message from remote server, s
                data = sock.recv(4096)
                if not data :
                    print '\nDisconnected from chat server'
                    sys.exit()
                else :
                    if (msg == '1\n') or (msg == '2\n') or (msg == '3\n'): 
			with open('./received.txt', 'wb') as f:
			    print 'File received.txt Opened'
			    while 1:
				data = s.recv(1024)
				if data == "endoffile" :
				    break
				    break
				else :
    		                    print('Receiving Data...')
				    print('Data = ' + str(data))
				    # write data to a file
				    f.write(data)
			f.close()
			print('Successfully get the file')
			break

		    else:
			#print data
		        sys.stdout.write(data)
			sys.stdout.flush()     
            
            else :
                # user entered a message
                msg = sys.stdin.readline()
                s.send(msg)
		sys.stdout.flush()

if __name__ == "__main__":

    sys.exit(chat_client())
