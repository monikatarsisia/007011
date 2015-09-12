// File Name client.java
// compile in cmd "java client <ip> <port>"

import java.net.*;
import java.io.*;
import java.util.Scanner;

public class client {

	private static Socket client;
	
	public static void main(String [] args) {
		
		String serverName = args[0];
		int port = Integer.parseInt(args[1]);
		Scanner input = new Scanner(System.in);
		String msg = "";
		String msgS = "";
	 
		try {
			// open connection
			System.out.println("Connecting to " + serverName + " on port " + port);
			client = new Socket(serverName, port);
			System.out.println("Just connected to " + client.getRemoteSocketAddress());
			OutputStream outToServer = client.getOutputStream();
			DataOutputStream out = new DataOutputStream(outToServer);
			out.writeUTF("Hello from " + client.getLocalSocketAddress());
			InputStream inFromServer = client.getInputStream();
			DataInputStream in = new DataInputStream(inFromServer);
			System.out.println("Server says " + in.readUTF());
			
			// send message to server
			System.out.print("Input your message : ");
			msg = input.nextLine(); // user input message
			while (!(msg.equals(".close"))) {
				out.writeUTF(msg);
				msgS = in.readUTF();
				System.out.println(":: " + msgS);
				System.out.print("Input your message : ");
				msg = input.nextLine(); // user input message
			} 
			
			client.close();
		  
		}catch(IOException e) {
			e.printStackTrace();
		}
	}
}
