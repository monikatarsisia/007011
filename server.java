// File Name server.java
// compile in cmd "java server <port>"

import java.net.*;
import java.io.*;

public class server extends Thread {
	
	private ServerSocket serverSocket;
	private static Socket server;
   
	public server (int port) throws IOException {
		serverSocket = new ServerSocket(port);
		serverSocket.setSoTimeout(30000);
	}

	public void run() {
		String msg = "";
	
		while (true) {
			try {
				System.out.println("Waiting for client on port " + serverSocket.getLocalPort() + "...");
				
				// Open connection
				server = serverSocket.accept();
				System.out.println("Just connected to " + server.getRemoteSocketAddress());
				DataInputStream in = new DataInputStream(server.getInputStream());
				System.out.println(in.readUTF());
				DataOutputStream out = new DataOutputStream(server.getOutputStream());
				out.writeUTF("Thank you for connecting to " + server.getLocalSocketAddress() + "\nPlease enter your message! Input '.close' to close this connection.");
				
				// accept message from client
				msg = in.readUTF();
				while (!(msg.equals(".close"))) {
					System.out.println("client " + server.getRemoteSocketAddress() + " said : " + msg);
					out.writeUTF("Message was sent");
					msg = in.readUTF();
				}
			
				try {
					server.close();
					break;
				} catch (Exception e) {}
			} catch(SocketTimeoutException s) {
				System.out.println("Socket timed out!");
				try {
					server.close();
					break;
				} catch (Exception e) {}
				break;
			}catch(IOException e) {
//				e.printStackTrace();
				System.out.println(server.getRemoteSocketAddress() + " disconnected.");
				break;
			}
		}
	}
   
	public static void main(String [] args) {
		
		int port = Integer.parseInt(args[0]);
		
		try {
			Thread t = new server(port);
			t.start();
		} catch(IOException e) {
			e.printStackTrace();
		}
	}
}
