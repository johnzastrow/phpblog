---
title: Sending files over SFTP in an automated fashion
author: John C. Zastrow
type: post
date: 2008-07-06T01:21:15+00:00
url: /2008/07/05/sending-files-over-sftp-in-an-automated-fashion/
categories:
  - Linux

---
The exerpts below describe how to use SFTP to transfer files from one  
machine to another in automated fashion, such as using shell scripts. I  
needed to do this as part of a back up script.

Use the ssh authorized_keys functionality instead of trying to pass in  
a username and password. Create a key on the client side using  
ssh-keygen (it will have to be nonpassworded if you want this to be  
fully automated) and copy the public key to the target user&#8217;s  
authorized_keys file on the ssh/sftp server. For extra security, an  
option (&#8220;from&#8221;) is available to limit the use of that key to  
connections coming from your client server. This will give ssh or sftp  
access to anyone who comes from the client server with the right  
private key (no worse than having a name and password hardcoded in a  
script). See the SSH docs for more detail.

Set that up and you&#8217;ll be past the authentication issues. Then check  
out the -b option of sftp to give it a batch file with sftp commands to  
automatically execute:

sftp -b batchfile targetuser@targethost

Now, you have to configure the server ahead of time to consider the source trusted. Use the following steps to make that happen:

create the keys for the origin account, i.e. the account that performs the copy:

$ cd ~/.ssh

$ ssh-keygen -t dsa

You are asked for a passphrase, do not enter a passphrase, type <ret> for empty passphrase.

verify the creation of the 2 files:

~/.ssh/id_dsa

~/.ssh/id_dsa.pub

copy ~/.ssh/id_dsa.pub to the destination node

login into the destination node and verify if file ~/.ssh/authorized_keys is already present, if not do:

$ cd ~/.ssh

$ mv id\_dsa.pub authorized\_keys

Verify ~/.ssh/authorized\_keys and add/replace id\_dsa.pub as needed.

Then, run your sftp with a -b extension. This will put it in batch mode  
and allow it to draw its commands from a text, or batchfile. You need  
to specify the batch filename after -b.

&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;-

Example 2 

Log in to your account on the front-end node (the client machine). Here  
we describe the machine you want to login TO as the client (compute  
node). In the example below we are using root, but you should likely  
use a standard user name. Go to the .ssh directory of your home  
directory. If it isn’t there, you may create one with the command

mkdir ~/.ssh

In the examples below, you should conceptually replace /root/ with /home/youruser/.ssh.

Create an rsa key pair by executing ssh-keygen with the 

&#8220;rsa&#8221; option:

ssh-keygen -t rsa

The ssh-keygen program will respond with:

Generating a public/private rsa key pair.

Enter file in which to save the key (/root/.ssh/id_rsa):

Type the Enter key to accept the default value:

[Enter]

The ssh-keygen program will respond with:

Created directory &#8216;/root/.ssh&#8217;.

Enter passphrase (empty for no passphrase):

Type the Enter key to accept the default value:

[Enter]

The ssh-keygen program will respond with:

Enter same passphrase again:

Type the Enter key again:

[Enter]

The ssh-keygen program will respond with:

Your identification has been saved in /root/.ssh/id_rsa.

Your public key has been saved in /root/.ssh/id_rsa.pub.

The key fingerprint is:

[fingerprint] root@[hostname]

Create the ssh directory for each compute node&#8217;s root 

account (on the first use of ssh the system automatically

creates the ssh directory for you).

Login to a compute node. Type:

ssh root@[compute node address]

Enter the root password.

Check if a .ssh directory exists. Type:

ls -la

If there is no .ssh directory listed, type:

mkdir .ssh

ls -la

chmod go-rwx .ssh

ls -la

The .ssh listing should look like:

drwx&#8212;&#8212; 2 root root 4096 [date & time] .ssh

The .ssh directory is now only accessible by the user root.

Log out of the compute node. Type:

logout

Use sftp (secure ftp) to copy the generated rsa public key

to each compute node&#8217;s root account secure shell directory

as the file authorized_keys. Type:

sftp root@[compute node address]

If prompted to continue connecting, type:

yes

Log in with the root password for that compute node.

You will get the sftp prompt:

sftp>

Change to the secure shell directory. Type:

cd .ssh

Copy the rsa public key to the compute node. Type:

put /root/.ssh/id\_rsa.pub authorized\_keys

Exit sftp. Type:

exit

Repeat this procedure for each compute node.

To test that the secure automatic login is working 

properly from the front-end node, type:

ssh root@[compute node address]

The system should log you in without prompting for a 

password.

Log out of the compute node. Type:

logout

Also copy the rsa public key to the authorized_keys file on

the front-end node. Type:

cp /root/.ssh/id\_rsa.pub /root/.ssh/authorized\_keys

root on the front-end node can now securely access all nodes 

in the cluster without having to enter a password.</ret>